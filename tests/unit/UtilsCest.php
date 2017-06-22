<?php

use Docs\Utils;
use Phalcon\Config;

class UtilsCest
{
    /** @var Config */
    private $config = null;

    /** @var array */
    private $configArray = [];

    /** @var Utils */
    private $utils = null;

    public function _before(UnitTester $I)
    {
        $fileName = APP_PATH . '/app/config/config.php';
        $this->configArray = require_once($fileName);

        $this->config = new Config($this->configArray);
        $this->utils  = new Utils();
    }

    public function checkLocalAsset(UnitTester $I)
    {
        $version   = $this->config->get('app')->get('version', '');
        $expected = "js/something.{$version}.js";
        $I->assertEquals(
            $expected,
            $this->utils->getAsset($this->config,'js/something.js')
        );
    }

    public function checkTest(UnitTester $I)
    {
        $assets = new Phalcon\Assets\Manager();
        $assets
            ->collection('abc')
            ->addCss('//netdna.bootstrap.com/font-awesome/4.1.0/css/font-awesome.css', false);

        $I->assertEquals(
            $expected,
            $this->utils->getAsset($this->config,'js/something.js')
        );
    }
}
