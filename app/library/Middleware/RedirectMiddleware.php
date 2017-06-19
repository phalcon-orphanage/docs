<?php

namespace Docs\Middleware;

use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
 * Class RedirectMiddleware
 *
 * @property \Docs\Utils              $utils
 * @property \Phalcon\Mvc\View\Simple $viewSimple
 *
 * @package Website\Middleware
 */
class RedirectMiddleware implements MiddlewareInterface
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
        $uri      = $application->request->getURI();
        $redirect = '';

        /**
         * If the version is 'latest' send the request to the latest version
         */
        $latestVersion = $application->config->get('app')->get('version');
        $version       = $application->registry->version;
        $language      = $application->registry->language;

        if ('latest' === $version) {
            $redirectUri = str_replace('/latest', '/' . $latestVersion, $uri);

            $application->response->redirect($redirectUri);
            $application->response->send();

            return false;
        }

        if (true !== empty($redirect)) {
            $application->response->redirect($redirect);
            $application->response->send();

            return false;
        }

        return true;
    }
}
