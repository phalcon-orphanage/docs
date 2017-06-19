<?php

namespace Docs\Middleware;

use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
 * Class EnvironmentMiddleware
 *
 * @package Docs\Middleware
 */
class EnvironmentMiddleware implements MiddlewareInterface
{
    /**
     * Call me
     *
     * @param Micro $application
     *
     * @return bool
     */
    public function call(Micro $application)
    {
        /**
         * This is where we calculate what language we need to work with
         * and what slug has been requested
         */
        $latestVersion = $application->config->get('app')->get('version');
        $params        = $application->router->getParams();
        $language      = $this->getLang($application, 'en');
        $version       = $params['v'] ?? $latestVersion;
        $page          = $params['p'] ?? 'introduction';

        /**
         * These are needed for all pages
         */
        $application->registry->language = $language;
        $application->registry->version  = $version;
        $application->registry->page     = $page;

        return true;
    }

    /**
     * Language auto detect
     *
     * @param Micro  $application
     * @param string $default
     *
     * @return string
     */
    protected function getLang(Micro $application, $default = 'en')
    {
        $params = $application->router->getParams();
        $lang   = $application->utils->fetch($params, 'language', '');

        if (true === empty($lang) && true === $application->request->hasQuery('_url')) {
            if ($query = $application->request->getQuery('_url')) {
                $lang = mb_strtolower(explode('/', ltrim($query, '/'))[0]);
            }
        }

        $languages = $application->config->languages;
        if (true === empty($lang) || false === $languages->offsetExists($lang)) {
            foreach ($application->request->getLanguages() as $httpLang) {
                $httpLang = mb_strtolower(substr($httpLang['language'], 0, 2));
                if (true === $languages->offsetExists($httpLang)) {
                    return $httpLang;
                }
            }

            return $default;
        }

        return $lang;
    }
}
