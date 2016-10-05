<?php

namespace PhalconDocs;

use RecursiveDirectoryIterator;
use FilesystemIterator;
use RecursiveIteratorIterator;
use Exception;

/**
 * Class ApiGenerator
 */
class ApiGenerator
{
    /**
     * @var array
     */
    protected $docs = [];

    /**
     * @var array
     */
    protected $classDocs = [];



    /**
     * @param $directory
     */
    public function __construct($directory)
    {
        $this->scanSources($directory);
    }



    /**
     * @param $directory
     */
    protected function scanSources($directory)
    {
        $recursiveDirectoryIterator = new RecursiveDirectoryIterator(
            $directory,
            FilesystemIterator::SKIP_DOTS
        );

        /** @var $iterator RecursiveDirectoryIterator[] */
        $iterator = new RecursiveIteratorIterator($recursiveDirectoryIterator);

        foreach ($iterator as $item) {
            if ($item->getExtension() !== "c") {
                continue;
            }

            if (strpos($item->getPathname(), "kernel") !== false) {
                continue;
            }

            $this->parseDocs(
                $item->getPathname()
            );
        }
    }

    /**
     * Parse docs from file
     *
     * @param $file
     */
    protected function parseDocs($file)
    {
        $firstDoc       = true;
        $openComment    = false;
        $nextLineMethod = false;
        $comment        = "";

        $lines = file($file);

        foreach ($lines as $line) {
            if (trim($line) == "/**") {
                $openComment = true;
            }

            if ($openComment === true) {
                $comment .= $line;
            } else {
                if ($nextLineMethod === true) {
                    if (preg_match("/^PHP_(DOC_)?METHOD\(([a-zA-Z0-9\_]+), (.*)\)/", $line, $matches)) {
                        $this->docs[$matches[2]][$matches[3]] = $comment;
                        $className                            = $matches[2];
                    } else {
                        if ($firstDoc === true) {
                            $classDoc = $comment;
                            $firstDoc = false;
                            $comment  = "";
                        }
                    }

                    $nextLineMethod = false;
                } else {
                    $comment = "";
                }
            }

            if ($openComment === true) {
                if (trim($line) == "*/") {
                    $openComment    = false;
                    $nextLineMethod = true;
                }
            }

            if (preg_match("/^PHALCON_INIT_CLASS\(([a-zA-Z0-9\_]+)\)/", $line, $matches)) {
                $className = $matches[1];
            }
        }

        if (isset($classDoc)) {
            if (!isset($className)) {
                $fileName = str_replace(CPHALCON_DIR, "", $file);
                $fileName = str_replace(".c", "", $fileName);

                $parts = [];

                foreach (explode(DIRECTORY_SEPARATOR, $fileName) as $part) {
                    $parts[] = ucfirst($part);
                }

                $className = "Phalcon\\" . join("\\", $parts);
            } else {
                $className = str_replace("_", "\\", $className);
            }

            //echo $className, PHP_EOL;

            if (!isset($this->classDocs[$className])) {
                if (class_exists($className) || interface_exists($className)) {
                    $this->classDocs[$className] = $classDoc;
                }
            }
        }
    }

    /**
     * @return array
     */
    public function getDocs()
    {
        return $this->docs;
    }

    /**
     * @return array
     */
    public function getClassDocs()
    {
        return $this->classDocs;
    }

    /**
     * @param      $phpdoc
     * @param      $className
     * @param null $realClassName
     *
     * @return array
     */
    public function getPhpDoc($phpdoc, $className, $realClassName = null)
    {
        $ret         = [];
        $lines       = [];
        $description = "";

        $phpdoc = trim($phpdoc);
        $phpdoc = str_replace("\r", "", $phpdoc);

        foreach (explode("\n", $phpdoc) as $line) {
            $line = preg_replace("#^/\*\*#", "", $line);
            $line = str_replace("*/", "", $line);
            $line = preg_replace("#^[ \t]+\*#", "", $line);
            $line = str_replace("*\/", "*/", $line);

            $tline = trim($line);

            if ($className !== $tline) {
                $lines[] = $line;
            }
        }

        $rc = str_replace("\\\\", "\\", $realClassName);

        $numberBlock = -1;
        $insideCode  = false;
        $codeBlocks  = [];

        foreach ($lines as $line) {
            if (strpos($line, "<code") !== false) {
                $numberBlock++;
                $insideCode = true;
            }

            if (strpos($line, "</code") !== false) {
                $insideCode = false;
            }

            if ($insideCode == false) {
                $line = str_replace("</code>", "", $line);

                if (trim($line) != $rc) {
                    if (preg_match("/@([a-z0-9]+)/", $line, $matches)) {
                        $content = trim(str_replace($matches[0], "", $line));

                        if ($matches[1] == "param") {
                            $parts = preg_split("/[ \t]+/", $content);

                            if (count($parts) == 2) {
                                $name = "$" . str_replace("$", "", $parts[1]);
                                $ret["parameters"][$name] = trim($parts[0]);
                            } else {
                                // throw new Exception(
                                //     "Failed proccessing parameters in " . $className . "::" . $methodName
                                // );
                            }
                        } else {
                            $ret[$matches[1]] = $content;
                        }
                    } else {
                        $description .= ltrim($line) . "\n";
                    }
                }
            } else {
                if (!isset($codeBlocks[$numberBlock])) {
                    $line = str_replace("<code>", "", $line);

                    $codeBlocks[$numberBlock] = $line . "\n";

                    $description .= "%%" . $numberBlock . "%%";
                } else {
                    $codeBlocks[$numberBlock] .= $line . "\n";
                }
            }
        }

        foreach ($codeBlocks as $n => $cc) {
            $c         = "";
            $firstLine = true;
            $p         = explode("\n", $cc);

            foreach ($p as $pp) {
                if ($firstLine) {
                    if (substr(ltrim($pp), 0, 1) != "[") {
                        if (!preg_match("#^<?php#", ltrim($pp))) {
                            if (count($p) == 1) {
                                $c .= "    <?php ";
                            } else {
                                $c .= "    <?php" . PHP_EOL . PHP_EOL;
                            }
                        }
                    }

                    $firstLine = false;
                }

                $pp = preg_replace("#^\s#", "", $pp);

                if (count($p) != 1) {
                    if ($pp === "") {
                        $c .= PHP_EOL;
                    } else {
                        $c .= "    " . $pp . PHP_EOL;
                    }
                } else {
                    $c .= $pp . PHP_EOL;
                }
            }

            $c .= PHP_EOL;

            $codeBlocks[$n] = rtrim($c);
        }

        $description = str_replace("<p>", "", $description);
        $description = str_replace("</p>", PHP_EOL . PHP_EOL, $description);

        $c = $description;
        $c = str_replace("\\", "\\\\", $c);
        $c = trim(str_replace("\t", "", $c));

        foreach ($codeBlocks as $n => $cc) {
            if (preg_match("#\[[a-z]+\]#", $cc)) {
                $type = "ini";
            } else {
                $type = "php";
            }

            $c = str_replace(
                "%%" . $n . "%%",
                PHP_EOL . PHP_EOL . ".. code-block:: " . $type . PHP_EOL . PHP_EOL . $cc . PHP_EOL . PHP_EOL,
                $c
            );
        }

        $final     = "";
        $blankLine = false;

        $lines = explode("\n", $c);

        foreach ($lines as $line) {
            if (trim($line) === "") {
                if ($blankLine == false) {
                    $final .= $line . "\n";
                    $blankLine = true;
                }
            } else {
                $final .= $line . "\n";
                $blankLine = false;
            }
        }

        $ret["description"] = $final;

        return $ret;
    }
}
