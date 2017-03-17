<?php

namespace Docs;

use Phalcon\Mvc\User\Component;

/**
 * Class Docs
 *
 * @package Docs
 *
 * @property \Phalcon\Config $config
 */
class Utils extends Component
{
    /**
     * Checks an object or an array if an element exists. If yes it returns
     * the value of the element, otherwise the $default value
     *
     * This method uses 'return' statements when the conditions are met in
     * order to speed things up.
     *
     * @param object|array $data
     * @param string       $element
     * @param string       $default
     *
     * @return string
     */
    public function fetch($data, $element, $default = '')
    {
        if (true === is_object($data) && true === isset($data->$element)) {
            return $data->$element;
        } elseif (true === is_array($data) && true === isset($data[$element])) {
            return $data[$element];
        }

        return $default;
    }

    /**
     * @param $lang
     *
     * @return string
     */
    public function getDocsUrl($lang)
    {
        $return    = 'en';
        $languages = $this->config->get('doc_languages')->toArray();

        if (true !== empty($lang)) {
            if (true === array_key_exists($lang, $languages)) {
                $return = $lang;
            }
        }

        return sprintf('https://docs.phalconphp.com/%s/latest', $return);
    }

    /**
     * Returns an asset with the CDN and the version
     *
     * @param string $asset
     *
     * @return string
     */
    public function getAsset($asset)
    {
        $cdnUrl    = $this->config->get('app')->get('staticUrl', '/');
        $version   = $this->config->get('app')->get('version', '');
        $pathInfo  = pathinfo($asset);
        $dirName   = $pathInfo['dirname'];
        $fileName  = $pathInfo['filename'];
        $extension = $pathInfo['extension'];


        return sprintf(
            '%s%s/%s.%s.%s',
            $cdnUrl,
            $dirName,
            $fileName,
            $version,
            $extension
        );
    }

    /**
     * Returns the CDN URL
     *
     * @param string $resource
     *
     * @return string
     */
    public function getCdnUrl($resource = '')
    {
        return $this->config->get('app')->get('staticUrl', '/') . $resource;
    }

    /**
     * Is the CDN local or not
     *
     * @return bool
     */
    public function isCdnLocal()
    {
        return boolval('/' === $this->getCdnUrl());
    }

    /**
     * Converts milliseconds to human readable format
     *
     * @param float $microseconds
     * @param int   $precision
     *
     * @return string
     */
    public function timeToHuman($microseconds, $precision = 3)
    {
        $units = ['μs', 'ns', 'ms', 's'];
        $micro = max($microseconds, 0);
        $pow   = 0;
        if (1000 < $micro) {
            $pow    = floor(($micro ? log($micro) : 0) / log(1000));
            $pow    = min($pow, count($units) - 1);
            $micro /= (1 << (10 * $pow));
        }
        return round($micro, $precision) . ' ' . $units[$pow];
    }

    /**
     * Converts bytes to a human readable format
     *
     * @param int $bytes
     * @param int $precision
     *
     * @return string
     */
    public function bytesToHuman($bytes, $precision = 2)
    {
        $units  = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
        $bytes  = max($bytes, 0);
        $pow    = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow    = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
