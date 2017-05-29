<?php

namespace Docs\Controllers;

use Docs\Cli\Tasks\RegenerateApiTask;
use Phalcon\Cache\BackendInterface;
use Phalcon\Config;
use Phalcon\Mvc\Controller as PhController;
use Phalcon\Mvc\View\Simple;

/**
 * Class DocsController
 *
 * @package Docs\Controllers
 *
 * @property Config           $config
 * @property BackendInterface $cacheData
 * @property \ParsedownExtra  $parsedown
 * @property Simple           $viewSimple
 */
class DocsController extends PhController
{
    public function redirectAction()
    {
        return $this->response->redirect($this->getVersion('/en/'));
    }

    public function mainAction($language = null, $version = null, $page = '')
    {
        if (empty($language)) {
            return $this->response->redirect($this->getVersion('/en/'));
        }

        $language = $this->getLanguage($language);

        if (empty($version)) {
            return $this->response->redirect(
                $this->getVersion('/' . $language . '/')
            );
        }

        $language = ($language) ?: 'en';
        $version  = ($version)  ?: $this->getVersion();
        $page     = ($page)     ?: 'introduction';

        $contents = $this->viewSimple->render(
            'index/index',
            [
                'language' => $language,
                'version'  => $version,
                'sidebar'  => $this->getDocument($language, 'sidebar'),
                'article'  => $this->getDocument($language, $page),
                'menu'     => $this->getDocument($language, $page . '-menu'),
            ]
        );
        $this->response->setContent($contents);

        return $this->response;

    }

    /**
     * @param string $language
     * @param string $fileName
     *
     * @return string
     */
    private function getDocument($language, $fileName)
    {
        $key = sprintf('%s.%s.cache', $fileName,$language);
        if ('production' === $this->config->get('app')->get('env') &&
            true === $this->cacheData->exists($key)) {
            return $this->cacheData->get($key);
        } else {
            $pageName = sprintf(
                '%s/docs/%s/%s.md',
                APP_PATH,
                $language,
                $fileName
            );
            $apiFileName = sprintf(
                '%s/docs/%s/api/%s.md',
                APP_PATH,
                $language,
                $fileName
            );

            $data = '';
            if (file_exists($pageName)) {
                $data = file_get_contents($pageName);
            } elseif (file_exists($apiFileName)) {
                $data = file_get_contents($apiFileName);
            }

            if (!empty($data)) {

                $namespaces = $this->getNamespaces();
                $from = array_keys($namespaces);
                $to   = array_values($namespaces);

                /**
                 * API links
                 */
                $data = str_replace($from, $to, $data);

                /**
                 * Language and version
                 */
                $data = str_replace(
                    [
                        '[[language]]',
                        '[[version]]',
                        '0#', '1#', '2#', '3#', '4#',
                        '5#', '6#', '7#', '8#', '9#',
                        '0`', '1`', '2`', '3`', '4`',
                        '5`', '6`', '7`', '8`', '9`',
                    ],
                    [
                        $language,
                        $this->getVersion(),
                        '#', '#', '#', '#', '#',
                        '#', '#', '#', '#', '#',
                        '`', '`', '`', '`', '`',
                        '`', '`', '`', '`', '`',
                    ],
                    $data
                );
                $data = $this->parsedown->text($data);
                $this->cacheData->save($key, $data);
            }

            return $data;
        }
    }

    /**
     * Check the available languages and return either that or 'en'
     *
     * @param string $language
     *
     * @return string
     */
    private function getLanguage($language)
    {
       $languages = $this->config->get('languages', ['en' => 'English']);

       if (!array_key_exists($language, $languages)) {
           return 'en';
       } else {
           return $language;
       }
    }

    /**
     * Gets all the namespaces so that API URLs are generated properly
     *
     * @return array|mixed|null
     */
    private function getNamespaces()
    {
        $key = 'namespaces.cache';
        if ('production' === $this->config->get('app')->get('env') &&
            true === $this->cacheData->exists($key)) {
            return $this->cacheData->get($key);
        } else {
            $namespaces = [];
            $template   = '[%s](/[[language]]/[[version]]/api/%s)';

            $data = get_declared_classes();
            foreach ($data as $name) {
                if (substr($name, 0, 8) === 'Phalcon\\') {
                    $apiName = str_replace('\\', '_', $name);
                    $namespaces["`$name`"] = sprintf($template, $name, $apiName);
                }
            }

            $data = get_declared_interfaces();
            foreach ($data as $name) {
                if (substr($name, 0, 8) === 'Phalcon\\') {
                    $apiName = str_replace('\\', '_', $name);
                    $namespaces["`$name`"] = sprintf($template, $name, $apiName);
                }
            }

            $this->cacheData->save($key, $namespaces);

            return $namespaces;
        }
    }

    /**
     * Returns the current version string with its prefix if applicable
     *
     * @param string $stub
     *
     * @return string
     */
    private function getVersion($stub = '')
    {
        return $stub . $this->config->get('app')->get('version');
    }
}
