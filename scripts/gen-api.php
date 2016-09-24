<?php

/**
 * This scripts generates the restructuredText for the class API.
 *
 * Change the CPHALCON_DIR constant to point to the ext/ directory in the Phalcon source code
 *
 * php scripts/gen-api.php
 */

if (!extension_loaded('phalcon')) {
    throw new Exception("Phalcon extension is required");
}

defined('CPHALCON_DIR') || define('CPHALCON_DIR', getenv('CPHALCON_DIR'));

if (!CPHALCON_DIR) {
    throw new Exception("Need to set CPHALCON_DIR. Fox example: 'export CPHALCON_DIR=/Users/gutierrezandresfelipe/cphalcon/ext/'");
}

if (!file_exists(CPHALCON_DIR)) {
    throw new Exception("CPHALCON directory does not exist");
}

$languages = array('en', 'es', 'fr', 'id', 'ja', 'pl', 'pt', 'ru', 'uk', 'zh');



require 'src/ApiGenerator.php';



$di = new \Phalcon\DI();

$view = new \Phalcon\Mvc\View\Simple();

$volt = new \Phalcon\Mvc\View\Engine\Volt($view, $di);

$volt->setOptions(
    [
        "compiledPath"      => "scripts/compiled-views/",
        "compiledExtension" => ".compiled",
    ]
);

$compiler = $volt->getCompiler();

$compiler->addFunction("str_repeat", "str_repeat");

$view->registerEngines(
    [
        ".volt" => $volt,
    ]
);

$view->setDI($di);

// A trailing directory separator is required
$view->setViewsDir("scripts/views/");



$api = new ApiGenerator(CPHALCON_DIR);

$classDocs = $api->getClassDocs();
$docs      = $api->getDocs();

$classes = array();
foreach (get_declared_classes() as $className) {
    if (!preg_match('#^Phalcon#', $className)) {
        continue;
    }
    $classes[] = $className;
}

foreach (get_declared_interfaces() as $className) {
    if (!preg_match('#^Phalcon#', $className)) {
        continue;
    }
    $classes[] = $className;
}

//Exception class docs
$docs['Exception'] = array(
    '__construct'      => '/**
 * Exception constructor
 *
 * @param string $message
 * @param int $code
 * @param Exception $previous
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
);

sort($classes);

$indexClasses    = array();
$indexInterfaces = array();
foreach ($classes as $className) {

    $realClassName = $className;

    $simpleClassName = str_replace("\\", "_", $className);

    $reflector = new ReflectionClass($className);

    $documentationData = array();

    $typeClass = 'public';
    if ($reflector->isAbstract() == true) {
        $typeClass = 'abstract';
    }

    if ($reflector->isFinal() == true) {
        $typeClass = 'final';
    }

    if ($reflector->isInterface() == true) {
        $typeClass = '';
    }

    $documentationData = array(
        'type'        => $typeClass,
        'description' => $realClassName,
        'extends'     => $reflector->getParentClass(),
        'implements'  => $reflector->getInterfaceNames(),
        'constants'   => $reflector->getConstants(),
        'methods'     => $reflector->getMethods()
    );

    if ($reflector->isInterface() == true) {
        $indexInterfaces[] = '   ' . $simpleClassName . PHP_EOL;
    } else {
        $indexClasses[] = '   ' . $simpleClassName . PHP_EOL;
    }

    $nsClassName = str_replace("\\", "\\\\", $className);

    if ($reflector->isInterface() == true) {
        $title = 'Interface **' . $nsClassName . '**';
    } else {

        $classPrefix = 'Class';
        if (strtolower($typeClass) != 'public') {
            $classPrefix = ucfirst(strtolower($typeClass)) . ' class';
        }

        $title = $classPrefix . ' **' . $nsClassName . '**';
    }

    $extendsString = "";

    if ($documentationData['extends']) {
        $extendsName = $documentationData['extends']->name;
        if (strpos($extendsName, 'Phalcon') !== false) {
            if (class_exists($extendsName)) {
                $extendsClass = $extendsName;
                $extendsPath  = str_replace("\\", "_", $extendsName);
                $extendsName  = str_replace("\\", "\\\\", $extendsName);
                $reflector    = new ReflectionClass($extendsClass);

                $prefix = 'class';
                if ($reflector->isAbstract() == true) {
                    $prefix = 'abstract class';
                }

                $extendsString
                    .= PHP_EOL . '*extends* ' . $prefix . ' :doc:`' . $extendsName . ' <' . $extendsPath . '>`' . PHP_EOL;
            } else {
                $extendsString .= PHP_EOL . '*extends* ' . $extendsName . PHP_EOL;
            }
        } else {
            $extendsString .= PHP_EOL . '*extends* ' . $extendsName . PHP_EOL;
        }
    }

    $implementsString = "";

    //Generate the interfaces part
    if (count($documentationData['implements'])) {
        $implements = array();
        foreach ($documentationData['implements'] as $interfaceName) {
            if (strpos($interfaceName, 'Phalcon') !== false) {
                if (interface_exists($interfaceName)) {
                    $interfacePath = str_replace("\\", "_", $interfaceName);
                    $interfaceName = str_replace("\\", "\\\\", $interfaceName);
                    $implements[]  = ':doc:`' . $interfaceName . ' <' . $interfacePath . '>`';
                } else {
                    $implements[] = str_replace("\\", "\\\\", $interfaceName);
                }
            } else {
                $implements[] = $interfaceName;
            }
        }
        $implementsString .= PHP_EOL . '*implements* ' . join(', ', $implements) . PHP_EOL;
    }

    $githubLink = 'https://github.com/phalcon/cphalcon/blob/master/' . str_replace("\\", "/", strtolower($className)) . '.zep';

    $classDescription = "";

    if (isset($classDocs[$realClassName])) {
        $ret = $api->getPhpDoc($classDocs[$realClassName], $className, $realClassName);
        $classDescription .= $ret['description'] . PHP_EOL . PHP_EOL;
    }

    $constantsString = "";

    if (count($documentationData['constants'])) {
        $constantsString .= 'Constants' . PHP_EOL;
        $constantsString .= '---------' . PHP_EOL . PHP_EOL;
        foreach ($documentationData['constants'] as $name => $constant) {
            $constantsString .= '*' . gettype($constant) . '* **' . $name . '**' . PHP_EOL . PHP_EOL;
        }
    }

    $methodsString = "";

    if (count($documentationData['methods'])) {

        $methodsString .= 'Methods' . PHP_EOL;
        $methodsString .= '-------' . PHP_EOL . PHP_EOL;
        foreach ($documentationData['methods'] as $method) {

            /** @var $method ReflectionMethod */

            $docClassName = str_replace("\\", "_", $method->getDeclaringClass()->name);
            if (isset($docs[$docClassName])) {
                $docMethods = $docs[$docClassName];
            } else {
                $docMethods = array();
            }

            if (isset($docMethods[$method->name])) {
                $ret = $api->getPhpDoc($docMethods[$method->name], $className);
            } else {
                $ret = array();
            }

            $methodsString .= implode(' ', Reflection::getModifierNames($method->getModifiers())) . ' ';

            if (isset($ret['return'])) {
                if (preg_match('/^(\\\\?Phalcon[a-zA-Z0-9\\\\]+)/', $ret['return'], $matches)) {
                    if (class_exists($matches[0]) || interface_exists($matches[0])) {
                        $extendsPath = preg_replace('/^\\\\/', '', $matches[1]);
                        $extendsPath = str_replace("\\", "_", $extendsPath);
                        $extendsName = preg_replace('/^\\\\/', '', $matches[1]);
                        $extendsName = str_replace("\\", "\\\\", $extendsName);
                        $methodsString .= str_replace(
                            $matches[1],
                            ':doc:`' . $extendsName . ' <' . $extendsPath . '>` ',
                            $ret['return']
                        );
                    } else {
                        $extendsName = str_replace("\\", "\\\\", $ret['return']);
                        $methodsString .= '*' . $extendsName . '* ';
                    }

                } else {
                    $methodsString .= '*' . $ret['return'] . '* ';
                }
            }

            $methodsString .= ' **' . $method->name . '** (';

            $cp = array();
            foreach ($method->getParameters() as $parameter) {
                $name = '$' . $parameter->name;
                if (isset($ret['parameters'][$name])) {
                    $parameterType = $ret['parameters'][$name];
                } else if (!is_null($parameter->getClass())) {
                    $parameterType = $parameter->getClass()->name;
                } else if ($parameter->isArray()) {
                    $parameterType = 'array';
                } else {
                    $parameterType = 'mixed';
                }
                if (strpos($parameterType, 'Phalcon') !== false) {
                    if (class_exists($parameterType) || interface_exists($parameterType)) {
                        $parameterPath = preg_replace('/^\\\\/', '', $parameterType);
                        $parameterPath = str_replace("\\", "_", $parameterPath);
                        $parameterName = preg_replace('/^\\\\/', '', $parameterType);
                        $parameterName = str_replace("\\", "\\\\", $parameterName);
                        if (!$parameter->isOptional()) {
                            $cp[] = ':doc:`' . $parameterName . ' <' . $parameterPath . '>` ' . $name;
                        } else {
                            $cp[] = '[:doc:`' . $parameterName . ' <' . $parameterPath . '>` ' . $name . ']';
                        }
                    } else {
                        $parameterName = str_replace("\\", "\\\\", $parameterType);
                        if (!$parameter->isOptional()) {
                            $cp[] = '*' . $parameterName . '* ' . $name;
                        } else {
                            $cp[] = '[*' . $parameterName . '* ' . $name . ']';
                        }
                    }
                } else {
                    if (!$parameter->isOptional()) {
                        $cp[] = '*' . $parameterType . '* ' . $name;
                    } else {
                        $cp[] = '[*' . $parameterType . '* ' . $name . ']';
                    }
                }
            }
            $methodsString .= join(', ', $cp) . ')';

            if ($simpleClassName != $docClassName) {
                $methodsString .= ' inherited from ' . str_replace("\\", "\\\\", $method->getDeclaringClass()->name);
            }

            $methodsString .= PHP_EOL . PHP_EOL;

            if (isset($ret['description'])) {
                foreach (explode("\n", $ret['description']) as $dline) {
                    $methodsString .= "" . $dline . "\n";
                }
            } else {
                $methodsString .= "...\n";
            }
            $methodsString .= PHP_EOL . PHP_EOL;

        }

    }

    foreach ($languages as $lang) {
        @mkdir($lang . '/api/');

        file_put_contents(
            $lang . '/api/' . $simpleClassName . '.rst',
            $view->render(
                "class",
                [
                    "title"            => $title,
                    "extendsString"    => $extendsString,
                    "implementsString" => $implementsString,
                    "githubLink"       => $githubLink,
                    "classDescription" => $classDescription,
                    "constantsString"  => $constantsString,
                    "methodsString"    => $methodsString,
                ]
            )
        );
    }
}

foreach ($languages as $lang) {
    file_put_contents(
        $lang . '/api/index.rst',
        $view->render(
            "index",
            [
                "classes"    => $indexClasses,
                "interfaces" => $indexInterfaces,
            ]
        )
    );
}
