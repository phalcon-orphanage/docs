<?php

namespace Website\Middleware;

use Phalcon\Mvc\Micro;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
 * Class NotFoundMiddleware
 *
 * @property \Website\Utils           $utils
 * @property \Phalcon\Mvc\View\Simple $viewSimple
 *
 * @package Website\Middleware
 */
class NotFoundMiddleware extends Plugin implements MiddlewareInterface
{
    /**
     * If the endpoint has not been found, redirect to the 404
     *
     * @return bool
     */
    public function beforeNotFound()
    {
        $language = $this->registry->language;
        $redirect= sprintf('/%s/404', $language);

        $this->response->redirect($redirect);
        $this->response->send();

        return false;
    }

    /**
     * Call me
     *
     * @param Micro $application
     *
     * @return bool
     */
    public function call(Micro $application)
    {
        return true;
    }
}
