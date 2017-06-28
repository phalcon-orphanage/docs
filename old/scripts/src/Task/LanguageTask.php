<?php

namespace PhalconDocs\Task;

use Exception;
use Phalcon\Cli\Task;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class LanguageTask extends Task
{
    public function createAction()
    {
        if (!$this->dispatcher->hasParam(0)) {
            throw new Exception(
                "Language code required"
            );
        }

        $languageCode = $this->dispatcher->getParam(0);

        if (!preg_match("/^[a-z]{2}$/", $languageCode)) {
            throw new Exception(
                "Language code is not valid"
            );
        }

        if (file_exists($languageCode) && is_dir($languageCode)) {
            throw new Exception(
                "Language already exists"
            );
        }



        echo "Creating '" . $languageCode . "'..." . PHP_EOL . PHP_EOL;

        mkdir($languageCode, 0755);

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(
                "en",
                RecursiveDirectoryIterator::SKIP_DOTS
            ),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $item) {
            if (preg_match("/^en\/_build/", $item->getPathName())) {
                continue;
            }

            $path = $languageCode . "/" . $iterator->getSubPathName();

            if ($item->isDir()) {
                mkdir($path);
            } else {
                copy($item, $path);
            }
        }



        $indexRstPath = $languageCode . "/index.rst";

        $indexRstContents = file_get_contents($indexRstPath);

        $indexRstContents = str_replace(
            "https://docs.phalconphp.com/en/",
            "https://docs.phalconphp.com/" . $languageCode . "/",
            $indexRstContents
        );

        file_put_contents(
            $indexRstPath,
            $indexRstContents
        );



        $confPyPath = $languageCode . "/conf.py";

        $confPyContents = file_get_contents($confPyPath);

        $confPyContents = str_replace(
            [
                "language = 'en'",
                "html_favicon = 'en/_static/favicon.ico'",
                "html_static_path = ['../en/_static']",
            ],
            [
                "language = '" . $languageCode . "'",
                "html_favicon = '" . $languageCode . "/_static/favicon.ico'",
                "html_static_path = ['../" . $languageCode . "/_static']",
            ],
            $confPyContents
        );

        file_put_contents(
            $confPyPath,
            $confPyContents
        );



        $languagesConfigPath = "scripts/config/languages.json";

        $languagesConfigContents = file_get_contents($languagesConfigPath);

        $languages = json_decode($languagesConfigContents);

        $languages[] = $languageCode;

        sort($languages);

        $languagesConfigContents = json_encode($languages, JSON_PRETTY_PRINT);

        file_put_contents($languagesConfigPath, $languagesConfigContents);



        echo "Language files successfully created!" . PHP_EOL . PHP_EOL;

        echo "Files changed:" . PHP_EOL . PHP_EOL;
        echo "    " . $languageCode . "/" . PHP_EOL;
        echo "    " . $languagesConfigPath . PHP_EOL;

        echo PHP_EOL;

        echo "Don't forget to update the README." . PHP_EOL;

        echo PHP_EOL;
    }
}
