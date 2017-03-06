<?php

namespace Docs\Controllers;

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
                'content'  => $this->getDocument($language, $page),
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
            $fileName = sprintf(
                '%s/docs/%s/%s.md',
                APP_PATH,
                $language,
                $fileName
            );

            $data = file_get_contents($fileName);
            $data = str_replace(
                '[[version]]',
                $this->getVersion(),
                $data
            );
            $data = $this->parsedown->text($data);
//            $data = $this->parsedown->render($data);
            $this->cacheData->save($key, $data);

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
