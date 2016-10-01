<?php

/**
 * This scripts generates the restructuredText for the class API.
 *
 * Change the CPHALCON_DIR constant to point to the ext/ directory in the Phalcon source code
 *
 * php scripts/gen-api.php
 */

if (!extension_loaded("phalcon")) {
    throw new Exception(
        "Phalcon extension is required"
    );
}

defined("CPHALCON_DIR") || define("CPHALCON_DIR", getenv("CPHALCON_DIR"));

if (!CPHALCON_DIR) {
    throw new Exception(
        "Need to set CPHALCON_DIR. Fox example: 'export CPHALCON_DIR=/Users/gutierrezandresfelipe/cphalcon/ext/'"
    );
}

if (!file_exists(CPHALCON_DIR)) {
    throw new Exception(
        "CPHALCON directory does not exist"
    );
}



$languagesConfigPath = "scripts/config/languages.json";

$languagesConfigContents = file_get_contents($languagesConfigPath);

$languages = json_decode($languagesConfigContents);



/**
 * Register the autoloader and tell it to register the tasks directory
 */
$loader = new \Phalcon\Loader();

$loader->registerNamespaces(
    [
        "PhalconDocs" => __DIR__ . "/src/",
    ]
);

$loader->register();



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



$api = new \PhalconDocs\ApiGenerator(CPHALCON_DIR);

$classDocs = $api->getClassDocs();
$docs      = $api->getDocs();

$classes = [];

foreach (get_declared_classes() as $className) {
    if (!preg_match("#^Phalcon\\\\#", $className)) {
        continue;
    }

    $classes[] = $className;
}

foreach (get_declared_interfaces() as $interfaceName) {
    if (!preg_match("#^Phalcon\\\\#", $interfaceName)) {
        continue;
    }

    $classes[] = $interfaceName;
}

//Exception class docs
$docs["Exception"] = [
    "__construct"      => "/**
 * Exception constructor
 *
 * @param string \$message
 * @param int \$code
 * @param Exception \$previous
*/",
    "getMessage"       => "/**
 * Gets the Exception message
 *
 * @return string
*/",
    "getCode"          => "/**
 * Gets the Exception code
 *
 * @return int
*/",
    "getLine"          => "/**
 * Gets the line in which the exception occurred
 *
 * @return int
*/",
    "getFile"          => "/**
 * Gets the file in which the exception occurred
 *
 * @return string
*/",
    "getTrace"         => "/**
 * Gets the stack trace
 *
 * @return array
*/",
    "getTraceAsString" => "/**
 * Gets the stack trace as a string
 *
 * @return Exception
*/",
    "__clone"          => "/**
 * Clone the exception
 *
 * @return Exception
*/",
    "getPrevious"      => "/**
 * Returns previous Exception
 *
 * @return Exception
*/",
    "__toString"       => "/**
 * String representation of the exception
 *
 * @return string
*/",
];

sort($classes);

$indexClasses    = [];
$indexInterfaces = [];

foreach ($languages as $lang) {
    $folder = $lang . "/api/";

    if (file_exists($folder) && is_dir($folder)) {
        continue;
    }

    mkdir($folder);
}

foreach ($classes as $className) {
    $realClassName = $className;

    $simpleClassName = str_replace("\\", "_", $className);

    $reflector = new ReflectionClass($className);

    $typeClass = "public";

    if ($reflector->isAbstract()) {
        $typeClass = "abstract";
    }

    if ($reflector->isFinal()) {
        $typeClass = "final";
    }

    if ($reflector->isInterface()) {
        $typeClass = "";
    }



    if ($reflector->isInterface()) {
        $indexInterfaces[] = "   " . $simpleClassName . PHP_EOL;
    } else {
        $indexClasses[] = "   " . $simpleClassName . PHP_EOL;
    }



    $nsClassName = str_replace("\\", "\\\\", $className);

    if ($reflector->isInterface()) {
        $title = "Interface **" . $nsClassName . "**";
    } else {
        $classPrefix = "Class";

        if (strtolower($typeClass) != "public") {
            $classPrefix = ucfirst(strtolower($typeClass)) . " class";
        }

        $title = $classPrefix . " **" . $nsClassName . "**";
    }



    $parentClass = $reflector->getParentClass();

    $extendsString = "";

    if ($parentClass) {
        $extendsName = $parentClass->name;

        $classLink = new \PhalconDocs\ClassLink($extendsName);

        if (class_exists($extendsName)) {
            $parentClassReflector = new ReflectionClass($extendsName);

            $prefix = "class";

            if ($parentClassReflector->isAbstract()) {
                $prefix = "abstract class";
            }

            $extendsString .= PHP_EOL . "*extends* " . $prefix . " " . $classLink->get() . PHP_EOL;
        } else {
            $extendsString .= PHP_EOL . "*extends* " . $classLink->get() . PHP_EOL;
        }
    }



    $interfaceNames = $reflector->getInterfaceNames();

    $implementsString = "";

    //Generate the interfaces part
    if (count($interfaceNames)) {
        $implements = [];

        foreach ($interfaceNames as $interfaceName) {
            $classLink = new \PhalconDocs\ClassLink($interfaceName);

            $implements[] = $classLink->get();
        }

        $implementsString .= PHP_EOL . "*implements* " . join(", ", $implements) . PHP_EOL;
    }



    $githubLink = "https://github.com/phalcon/cphalcon/blob/master/" . str_replace("\\", "/", strtolower($className)) . ".zep";



    $classDescription = "";

    if (isset($classDocs[$realClassName])) {
        $ret = $api->getPhpDoc($classDocs[$realClassName], $className, $realClassName);

        $classDescription .= $ret["description"] . PHP_EOL . PHP_EOL;
    }



    $constants = $reflector->getConstants();

    $constantsString = "";

    if (count($constants)) {
        $constantsString .= "Constants" . PHP_EOL;
        $constantsString .= "---------" . PHP_EOL . PHP_EOL;

        foreach ($constants as $name => $constant) {
            $type = gettype($constant);

            $constantsString .= "*" . $type . "* **" . $name . "**" . PHP_EOL . PHP_EOL;
        }
    }



    $methods = $reflector->getMethods();

    $methodsString = "";

    if (count($methods)) {
        $methodsString .= "Methods" . PHP_EOL;
        $methodsString .= "-------" . PHP_EOL . PHP_EOL;

        foreach ($methods as $method) {
            /** @var $method ReflectionMethod */

            $docClassName = str_replace("\\", "_", $method->getDeclaringClass()->name);

            if (isset($docs[$docClassName])) {
                $docMethods = $docs[$docClassName];
            } else {
                $docMethods = [];
            }

            if (isset($docMethods[$method->name])) {
                $ret = $api->getPhpDoc($docMethods[$method->name], $className);
            } else {
                $ret = [];
            }

            $methodsString .= implode(" ", Reflection::getModifierNames($method->getModifiers())) . " ";

            if (isset($ret["return"])) {
                $returnTypes = explode("|", $ret["return"]);

                foreach ($returnTypes as $i => $returnType) {
                    $classLink = new \PhalconDocs\ClassLink($returnType);

                    $returnTypes[$i] = $classLink->get();
                }

                $methodsString .= implode(" | ", $returnTypes);
            }

            $methodsString .= " **" . $method->name . "** (";

            $cp = [];

            foreach ($method->getParameters() as $parameter) {
                $name = "$" . $parameter->name;

                if (isset($ret["parameters"][$name])) {
                    $parameterType = $ret["parameters"][$name];
                } elseif (!is_null($parameter->getClass())) {
                    $parameterType = $parameter->getClass()->name;
                } elseif ($parameter->isArray()) {
                    $parameterType = "array";
                } else {
                    $parameterType = "mixed";
                }

                $parameterTypes = explode("|", $parameterType);

                foreach ($parameterTypes as $i => $parameterType) {
                    $classLink = new \PhalconDocs\ClassLink($parameterType);

                    $parameterTypes[$i] = $classLink->get();
                }

                $parameterTypes = implode(" | ", $parameterTypes) . " " . $name;

                if ($parameter->isOptional()) {
                    $parameterTypes = "[" . $parameterTypes . "]";
                }

                $cp[] = $parameterTypes;
            }

            $methodsString .= join(", ", $cp) . ")";

            if ($simpleClassName != $docClassName) {
                $className = $method->getDeclaringClass()->name;

                $classLink = new \PhalconDocs\ClassLink($className);

                $methodsString .= " inherited from " . $classLink->get();
            }

            $methodsString .= PHP_EOL . PHP_EOL;

            if (isset($ret["description"])) {
                foreach (explode("\n", $ret["description"]) as $dline) {
                    $methodsString .= "" . $dline . "\n";
                }
            } else {
                $methodsString .= "...\n";
            }

            $methodsString .= PHP_EOL . PHP_EOL;
        }
    }

    foreach ($languages as $lang) {
        file_put_contents(
            $lang . "/api/" . $simpleClassName . ".rst",
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
        $lang . "/api/index.rst",
        $view->render(
            "index",
            [
                "classes"    => $indexClasses,
                "interfaces" => $indexInterfaces,
            ]
        )
    );
}
