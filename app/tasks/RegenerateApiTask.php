<?php

namespace Docs\Cli\Tasks;

use Phalcon\CLI\Task as PhTask;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use FilesystemIterator;
use Exception;

use Dariuszp\CliProgressBar as CliProgressBar;

use Docs\ClassLink;

/**
 * RegenerateApiTask
 */
class RegenerateApiTask extends PhTask
{
    /**
     * @var array
     */
    protected $docs = [];

    /**
     * @var array
     */
    protected $classDocs = [];

    protected $phalconFolder = APP_PATH . '/storage/repo/ext';

    public function mainAction()
    {
        $language = 'en';
        $version  = $this->config->get('app')->get('version');

        $this->scanSources();

        $classes = [];
        foreach (get_declared_classes() as $className) {
            if (!preg_match('#^Phalcon\\\\#', $className)) {
                continue;
            }
            $classes[] = $className;
        }

        foreach (get_declared_interfaces() as $interfaceName) {
            if (!preg_match('#^Phalcon\\\\#', $interfaceName)) {
                continue;
            }
            $classes[] = $interfaceName;
        }

        // Exception class docs
        $this->docs['Exception'] = [
    '__construct'      => '/**
 * Exception constructor
 *
 * @param string \$message
 * @param int \$code
 * @param Exception \$previous
*/',
    'getMessage'       => '/**
 * Gets the Exception message
 *
 * @return string
*/',
    'getCode'          => '/**
 * Gets the Exception code
 *
 * @return int
*/',
    'getLine'          => '/**
 * Gets the line in which the exception occurred
 *
 * @return int
*/',
    'getFile'          => '/**
 * Gets the file in which the exception occurred
 *
 * @return string
*/',
    'getTrace'         => '/**
 * Gets the stack trace
 *
 * @return array
*/',
    'getTraceAsString' => '/**
 * Gets the stack trace as a string
 *
 * @return Exception
*/',
    '__clone'          => '/**
 * Clone the exception
 *
 * @return Exception
*/',
    'getPrevious'      => '/**
 * Returns previous Exception
 *
 * @return Exception
*/',
    '__toString'       => '/**
 * String representation of the exception
 *
 * @return string
*/',
        ];

        sort($classes);
        $indexClasses    = [];
        $indexInterfaces = [];

        echo 'Generating API documentation...' . PHP_EOL;
        $steps = count($classes);
        $bar   = new CliProgressBar($steps);
        $bar
            ->setColorToGreen()
            ->display();

        foreach ($classes as $className) {
            $realClassName   = $className;
            $simpleClassName = str_replace('\\', '_', $className);
            $reflector       = new \ReflectionClass($className);
            $typeClass       = 'public';

            if ($reflector->isAbstract()) {
                $typeClass = 'abstract';
            }
            if ($reflector->isFinal()) {
                $typeClass = 'final';
            }
            if ($reflector->isInterface()) {
                $typeClass         = '';
                $indexInterfaces[] = '   ' . $simpleClassName . PHP_EOL;
            } else {
                $indexClasses[] = '   ' . $simpleClassName . PHP_EOL;
            }

            $nsClassName = str_replace('\\', '\\\\', $className);
            if ($reflector->isInterface()) {
                $title = 'Interface **' . $nsClassName . '**';
            } else {
                $classPrefix = 'Class';
                if (strtolower($typeClass) != 'public') {
                    $classPrefix = ucfirst(strtolower($typeClass)) . ' class';
                }
                $title = $classPrefix . ' **' . $nsClassName . '**';
            }

            $parentClass   = $reflector->getParentClass();
            $extendsString = '';
            if ($parentClass) {
                $extendsName = $parentClass->name;
                $classLink = new ClassLink($extendsName);
                if (class_exists($extendsName)) {
                    $parentClassReflector = new \ReflectionClass($extendsName);
                    $prefix = 'class';
                    if ($parentClassReflector->isAbstract()) {
                        $prefix = 'abstract class';
                    }
                    $extendsString .= PHP_EOL . '*extends* ' . $prefix . ' ' . $classLink->get() . PHP_EOL;
                } else {
                    $extendsString .= PHP_EOL . '*extends* ' . $classLink->get() . PHP_EOL;
                }
            }

            $interfaceNames   = $reflector->getInterfaceNames();
            $implementsString = '';
            // Generate the interfaces part
            if (count($interfaceNames)) {
                $implements = [];
                foreach ($interfaceNames as $interfaceName) {
                    $classLink = new ClassLink($interfaceName);
                    $implements[] = $classLink->get();
                }
                $implementsString .= PHP_EOL . '*implements* '
                                   . join(', ', $implements) . PHP_EOL;
            }

            $githubLink       = 'https://github.com/phalcon/cphalcon/blob/master/'
                              . str_replace('\\', '/', strtolower($className)) . '.zep';
            $classDescription = '';
            if (isset($this->classDocs[$realClassName])) {
                $ret               = $this->getPhpDoc(
                    $this->classDocs[$realClassName],
                    $className,
                    $realClassName
                );
                $classDescription .= $ret['description'] . PHP_EOL . PHP_EOL;
            }

            $constants       = $reflector->getConstants();
            $constantsString = '';
            if (count($constants)) {
                $constantsString .= '## Constants' . PHP_EOL;
                foreach ($constants as $name => $constant) {
                    $type = gettype($constant);
                    $constantsString .= '*' . $type
                                      . '* **' . $name . '**'
                                      . PHP_EOL . PHP_EOL;
                }
            }

            $methods       = $reflector->getMethods();
            $methodsString = '';
            if (count($methods)) {
                $methodsString .= '## Methods' . PHP_EOL;
                foreach ($methods as $method) {
                    /** @var $method \ReflectionMethod */
                    $docClassName = str_replace(
                        '\\',
                        '_',
                        $method->getDeclaringClass()->name
                    );
                    if (isset($this->docs[$docClassName])) {
                        $docMethods = $this->docs[$docClassName];
                    } else {
                        $docMethods = [];
                    }

                    if (isset($docMethods[$method->name])) {
                        $ret = $this->getPhpDoc($docMethods[$method->name], $className);
                    } else {
                        $ret = [];
                    }
                    $methodsString .= implode(
                        ' ',
                            \Reflection::getModifierNames($method->getModifiers())
                    ) . ' ';
                    if (isset($ret['return'])) {
                        $returnTypes = explode('|', $ret['return']);
                        foreach ($returnTypes as $i => $returnType) {
                            $classLink = new ClassLink($returnType);
                            $returnTypes[$i] = $classLink->get();
                        }
                        $methodsString .= implode(' | ', $returnTypes);
                    }
                    $methodsString .= ' **' . $method->name . '** (';
                    $cp = [];
                    foreach ($method->getParameters() as $parameter) {
                        $name = '$' . $parameter->name;
                        if (isset($ret['parameters'][$name])) {
                            $parameterType = $ret['parameters'][$name];
                        } elseif (!is_null($parameter->getClass())) {
                            $parameterType = $parameter->getClass()->name;
                        } elseif ($parameter->isArray()) {
                            $parameterType = 'array';
                        } else {
                            $parameterType = 'mixed';
                        }
                        $parameterTypes = explode('|', $parameterType);
                        foreach ($parameterTypes as $i => $parameterType) {
                            $classLink = new ClassLink($parameterType);
                            $parameterTypes[$i] = $classLink->get();
                        }
                        $parameterTypes = implode(' | ', $parameterTypes) . ' ' . $name;
                        if ($parameter->isOptional()) {
                            $parameterTypes = '[' . $parameterTypes . ']';
                        }
                        $cp[] = $parameterTypes;
                    }

                    $methodsString .= join(', ', $cp) . ')';
                    if ($simpleClassName != $docClassName) {
                        $className = $method->getDeclaringClass()->name;
                        $classLink = new ClassLink($className);
                        $methodsString .= ' inherited from ' . $classLink->get();
                    }

                    $methodsString .= PHP_EOL . PHP_EOL;
                    if (isset($ret['description'])) {
                        foreach (explode("\n", $ret['description']) as $dline) {
                            $methodsString .= '' . $dline . "\n";
                        }
                    } else {
                        $methodsString .= "...\n";
                    }
                    $methodsString .= PHP_EOL . PHP_EOL;
                }
            }

            $fileName = sprintf(
                '%s/docs/%s/api/%s.md',
                APP_PATH,
                'en',
                $simpleClassName
            );

            $contents = $this->viewSimple->render(
                'include/api',
                [
                    'title'            => $title,
                    'extendsString'    => $extendsString,
                    'implementsString' => $implementsString,
                    'githubLink'       => $githubLink,
                    'classDescription' => $classDescription,
                    'constantsString'  => $constantsString,
                    'methodsString'    => $methodsString,
                ]
            );

            $contents = str_replace(
                ['[[language]]', '[[version]]'],
                [$language, $version],
                $contents
            );

            file_put_contents($fileName, $contents);
            $bar->progress();
        }

        $bar->end();
    }


    private function scanSources()
    {
        echo 'Scanning folders...' . PHP_EOL;
        
        $recursiveDirectoryIterator = new RecursiveDirectoryIterator(
            $this->phalconFolder,
            FilesystemIterator::SKIP_DOTS
        );

        /** @var $iterator RecursiveDirectoryIterator[] */
        $iterator = new RecursiveIteratorIterator($recursiveDirectoryIterator);

        $steps = count($iterator);
        $bar   = new CliProgressBar($steps);
        $bar
            ->setColorToGreen()
            ->display();
        foreach ($iterator as $item) {
            if ($item->getExtension() !== 'c' ||
                strpos($item->getPathname(), 'kernel') !== false) {
                continue;
            }

            $this->parseDocs($item->getPathname());
            $bar->progress();
        }

        $bar->end();
    }

    /**
     * Parse docs from file
     *
     * @param string $file
     */
    private function parseDocs($file)
    {
        $firstDoc       = true;
        $openComment    = false;
        $nextLineMethod = false;
        $comment        = '';

        $lines = file($file);

        foreach ($lines as $line) {
            if (trim($line) == '/**') {
                $openComment = true;
            }

            if ($openComment === true) {
                $comment .= $line;
            } else {
                if ($nextLineMethod === true) {
                    if (preg_match('/^PHP_(DOC_)?METHOD\(([a-zA-Z0-9\_]+), (.*)\)/', $line, $matches)) {
                        $this->docs[$matches[2]][$matches[3]] = $comment;
                        $className                            = $matches[2];
                    } else {
                        if ($firstDoc === true) {
                            $classDoc = $comment;
                            $firstDoc = false;
                            $comment  = '';
                        }
                    }

                    $nextLineMethod = false;
                } else {
                    $comment = '';
                }
            }

            if ($openComment === true) {
                if (trim($line) == '*/') {
                    $openComment    = false;
                    $nextLineMethod = true;
                }
            }

            if (preg_match('/^PHALCON_INIT_CLASS\(([a-zA-Z0-9\_]+)\)/', $line, $matches)) {
                $className = $matches[1];
            }
        }

        if (isset($classDoc)) {
            if (!isset($className)) {
                $fileName = str_replace($this->phalconFolder, '', $file);
                $fileName = str_replace('.c', '', $fileName);

                $parts = [];

                foreach (explode(DIRECTORY_SEPARATOR, $fileName) as $part) {
                    $parts[] = ucfirst($part);
                }

                $className = 'Phalcon\\' . join('\\', $parts);
            } else {
                $className = str_replace('_', '\\', $className);
            }

            //echo $className, PHP_EOL;

            if (!isset($this->classDocs[$className])) {
                if (class_exists($className) || interface_exists($className)) {
                    $this->classDocs[$className] = $classDoc;
                }
            }
        }

        ksort($this->docs);
        ksort($this->classDocs);

    }

    /**
     * @param string      $phpdoc
     * @param string      $className
     * @param null|string $realClassName
     *
     * @return array
     */
    public function getPhpDoc(string $phpdoc, string $className, string $realClassName = null): array
    {
        $ret         = [];
        $lines       = [];
        $description = '';

        $phpdoc = trim($phpdoc);
        $phpdoc = str_replace("\r", '', $phpdoc);

        foreach (explode("\n", $phpdoc) as $line) {
            $line = preg_replace("#^/\*\*#", '', $line);
            $line = str_replace("*/", '', $line);
            $line = preg_replace("#^[ \t]+\*#", '', $line);
            $line = str_replace("*\/", "*/", $line);

            $tline = trim($line);

            if ($className !== $tline) {
                $lines[] = $line;
            }
        }

        $rc = str_replace('\\\\', '\\', $realClassName);

        $numberBlock = -1;
        $insideCode  = false;
        $codeBlocks  = [];

        foreach ($lines as $line) {
            if (strpos($line, '<code') !== false) {
                $numberBlock++;
                $insideCode = true;
            }

            if (strpos($line, '</code') !== false) {
                $insideCode = false;
            }

            if ($insideCode == false) {
                $line = str_replace('</code>', '```', $line);

                if (trim($line) != $rc) {
                    if (preg_match('/@([a-z0-9]+)/', $line, $matches)) {
                        $content = trim(str_replace($matches[0], '', $line));

                        if ($matches[1] == 'param') {
                            $parts = preg_split("/[ \t]+/", $content);

                            if (count($parts) == 2) {
                                $name = '$' . str_replace('$', '', $parts[1]);
                                $ret['parameters'][$name] = trim($parts[0]);
                            } else {
                                // throw new Exception(
                                //     'Failed proccessing parameters in ' . $className . '::' . $methodName
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
                    $line = str_replace('<code>', '', $line);

                    $codeBlocks[$numberBlock] = $line . "\n";

                    $description .= '%%' . $numberBlock . '%%';
                } else {
                    $codeBlocks[$numberBlock] .= $line . "\n";
                }
            }
        }

        foreach ($codeBlocks as $n => $cc) {
            $c         = '';
            $firstLine = true;
            $p         = explode("\n", $cc);

            foreach ($p as $pp) {
                if ($firstLine) {
                    if (substr(ltrim($pp), 0, 1) != '[') {
                        if (!preg_match('#^<?php#', ltrim($pp))) {
                            if (count($p) == 1) {
                                $c .= '<?php ';
                            } else {
                                $c .= '<?php' . PHP_EOL . PHP_EOL;
                            }
                        }
                    }

                    $firstLine = false;
                }

                $pp = preg_replace("#^\s#", '', $pp);

                if (count($p) != 1) {
                    if ($pp === '') {
                        $c .= PHP_EOL;
                    } else {
                        $c .= '' . $pp . PHP_EOL;
                    }
                } else {
                    $c .= $pp . PHP_EOL;
                }
            }

            $c .= PHP_EOL;

            $codeBlocks[$n] = rtrim($c);
        }

        $description = str_replace('<p>', '', $description);
        $description = str_replace('</p>', PHP_EOL . PHP_EOL, $description);

        $c = $description;
        $c = str_replace('\\', '\\\\', $c);
        $c = trim(str_replace("\t", '', $c));

        foreach ($codeBlocks as $n => $cc) {
            if (preg_match("#\[[a-z]+\]#", $cc)) {
                $type = 'ini';
            } else {
                $type = 'php';
            }

            $c = str_replace(
                '%%' . $n . '%%',
                PHP_EOL . PHP_EOL .
                '```' . $type . PHP_EOL .
                $cc . PHP_EOL . PHP_EOL,
                $c
            );
        }

        $final     = '';
        $blankLine = false;

        $lines = explode("\n", $c);

        foreach ($lines as $line) {
            if (trim($line) === '') {
                if ($blankLine == false) {
                    $final .= $line . "\n";
                    $blankLine = true;
                }
            } else {
                $final .= $line . "\n";
                $blankLine = false;
            }
        }

        $ret['description'] = $final;

        return $ret;
    }
}
