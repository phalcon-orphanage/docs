<?php

namespace Docs\Controllers;

use Docs\Cli\Tasks\RegenerateApiTask;
use Phalcon\Cache\BackendInterface;
use Phalcon\Mvc\Controller as PhController;

/**
 * Class DocsController
 *
 * @package Docs\Controllers
 *
 * @property BackendInterface $cacheData
 * @property \ParsedownExtra  $parsedown
 */
class DocsController extends PhController
{
    public function redirectAction()
    {
        return $this->response->redirect('/en/3.0.4');
    }

    public function mainAction($language = null, $version = null, $page = '')
    {
        if (empty($language)) {
            return $this->response->redirect('/en/3.0.4');
        }

        $language = $this->getLanguage($language);

        if (empty($version)) {
            return $this->response->redirect(
                sprintf('/%s/%s', $language, '3.0.4')
            );
        }

        $language = (empty($language)) ?: 'en';
        $version  = ($version)         ?: '3.0.4';
        $page     = ($page)            ?: 'introduction';

        $contents = $this->viewSimple->render(
            'index/index',
            [
                'language' => $language,
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
                $data = str_replace(
                    '[[version]]',
                    $this->getVersion(),
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

    private function getVersion()
    {
        return '3.0.4';
    }
}
