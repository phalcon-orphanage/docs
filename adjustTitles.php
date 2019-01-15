<?php

$version = '4.0';
$folder  = __DIR__ . '/';

$template = "---
layout: article
language: '%s'
version: '%s'
---
";


foreach (glob($folder . '*', GLOB_ONLYDIR) as $langFile) {
    // Folders
    $lang = str_replace($folder, '', $langFile);
    echo $lang . PHP_EOL;

    // Files inside each language folder
    if ('en' !== $lang) {
        foreach (glob($langFile . '/*') as $trFile) {
            correctDoc($template, $trFile, $lang, $version);
        }
        foreach (glob($langFile . '/api/*') as $trFile) {
            correctDoc($template, $trFile, $lang, $version, $folder);
        }
    }
}

function correctDoc($template, $trFile, $lang, $version, $folder = '')
{
    echo $trFile, " - ", $lang, " - ", $version, PHP_EOL;

    $header  = sprintf($template, $lang, $version);
    $data    = file_get_contents($trFile);

    /**
     * if the first line is * * * remove it
     */
    if ("* * *\n" === substr($data, 0, 6)) {
        $first  = substr($data, 6);
        $second = substr($first, strpos($first, "* * *\n") + 6);

        $output = $header . $second;
        file_put_contents($trFile, $output );

    }

    /**
     * API Title
     */
    if ('' !== $folder) {

        $script  = str_replace(
            [
                $folder,
                'api/',
                $lang , '/',
                '.md',
                '.html',
            ],
            [
                '',
                '',
                '',
                '',
                '',
            ],
            $trFile
        );
        echo $script . PHP_EOL;
        echo $folder . PHP_EOL;
        $data    = file_get_contents($trFile);
        $lines   = file($trFile);

        /**
         * Check the title
         */
        if ('title' !== substr($lines[4], 0, 5)) {
            $v = "version: '" . $version . "'\n";
            $t = $v . "title: '" . str_replace('_', '\\', $script) . "'\n";
            $data = str_replace($v, $t, $data);
            file_put_contents($trFile, $data);
        }
    }
}