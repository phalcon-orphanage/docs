<?php

require __DIR__ . '/bootstrap.php';

use Phalcon\Docs\RstTableFixer;

class Docs
{
    private $baseDir;
    private $translations;
    private $originals;
    
    public function updateLang($lang)
    {
        $directory = __DIR__ . '/transifex/base-rst/en';
        chdir($directory);
        $recursiveDirectoryIterator = new RecursiveDirectoryIterator('.', FilesystemIterator::SKIP_DOTS);

        /** @var $iterator RecursiveDirectoryIterator[] */
        $iterator = new RecursiveIteratorIterator($recursiveDirectoryIterator);

        foreach ($iterator as $item) {
            if ($item->getExtension() == 'rst') {
                $path = $item->getPathname();
                $output = $this->processFile($path);

                $rstPath = realpath($this->baseDir . '/' . $lang . '/' . dirname($path));
                @mkdir($rstPath, 0777, true);

                $updatePath = realpath($rstPath . '/' . basename($path));
                echo $updatePath, PHP_EOL;
                
                $rstTableFixer = new RstTableFixer();
                $output = $rstTableFixer->fix($output);
                file_put_contents($updatePath, $output);
            }
        }
    }

    public function processFile($path)
    {
        $output = '';
        foreach (file($path) as $line) {
            if (preg_match_all('/%{(.+?)}%/u', $line, $matches, PREG_SET_ORDER)) {
                foreach ($matches as $match) {
                    $keys = explode('|', $match[1]);
    //                var_dump($keys);
                    $key = rtrim($keys[0], '\\');

                    if (isset($this->translations[$key])) {
                        $translation = $this->translations[$key];
                    } else {
                        $translation = $this->originals[$key];
    //                    $translation = $match[0];
                        echo "Error: '$key' is not found in '$path'", PHP_EOL;
                    }

                    // replace placeholders
                    foreach ($keys as $num => $val) {
                        if ($num === 0) continue;
                        // replace '\' with '\\'
                        $val = preg_replace('/\\\\/u', '\\\\\\\\', $val);
                        $translation = preg_replace(
                            '/:' . $num . ':/u', $val, $translation
                        );
                    }
                    
                    $line = str_replace($match[0], $translation, $line);
                }
                
                $output .= $line;
            } else {
                $output .= $line;
            }
        }
        
        return $output;
    }

    public function run($lang)
    {
        $this->baseDir = __DIR__;
        $jsonFile = $this->baseDir . '/transifex/strings/' . $lang . '.json';
        
        if (! file_exists($jsonFile)) {
            echo 'No such file: ' . $jsonFile, PHP_EOL;
            exit(1);
        }
        
        $json = file_get_contents($jsonFile);
        $this->translations = json_decode($json, true);
        
        $enJsonFile = $this->baseDir . '/transifex/strings/en.json';
        $enJson = file_get_contents($enJsonFile);
        $this->originals = json_decode($enJson, true);
        
        $this->updateLang($lang);
    }
}


if ($argc === 1) {
    echo 'Usage', PHP_EOL;
    echo '  php update-rst.php <lang>', PHP_EOL;
    echo '    eg, php update-rst.php ja', PHP_EOL;
    exit;
}

$lang = $argv[1];

$d = new Docs();
$d->run($lang);
