<?php

/**
 * This scripts generates the restructuredText for the class API.
 *
 * Change the CPHALCON_DIR constant to point to the dev/ directory in the Phalcon source code
 *
 * php scripts/gen-api.php
 */

define('CPHALCON_DIR', '/home/threedot/cphalcon/ext/');

require_once 'lib/API/Generator.php';

$api = new API_Generator(CPHALCON_DIR);

$classDocs = $api->getClassDocs();
$docs = $api->getDocs();
$classes = $api->getRuntimeClasses();

foreach($classes as $className) {
    $code = '<?php' . PHP_EOL;

	$realClassName = $className;

	$simpleClassName = str_replace("\\", "_", $className);

	$reflector = new ReflectionClass($className);

    $namespace = explode('\\', $className);
    $className = array_pop($namespace);
    
    if (count($namespace)) {
        $code .= PHP_EOL . 'namespace ' . implode($namespace, '\\') . ';' . PHP_EOL . PHP_EOL;
    }
    
    if(isset($classDocs[$simpleClassName])){
        $code .= $api->extractComment($classDocs[$simpleClassName]) . PHP_EOL;
	}
    
	if ($reflector->isInterface() == true) {
		$code .= 'interface ';
	} else {
        $typeClass = '';
        if ($reflector->isAbstract() == true) {
            $typeClass = 'abstract ';
        }
        if ($reflector->isFinal() == true) {
            $typeClass = 'final ';
        }
    
		$code .= $typeClass . 'class ';
	}
    
    $code .= $className . ' ';
    
    $extends = $reflector->getParentClass();
	if($extends){
		$extendsName = $extends->name;
        $code .= 'extends ' . $extendsName . ' ';
	}

	//Generate the interfaces part
    $implements	= $reflector->getInterfaceNames();
	if(count($implements)){
		$code .= 'implements ' . join(', ', $implements) . PHP_EOL;
	}

    $code .= '{' . PHP_EOL;

    $constants = $reflector->getConstants();
	if(count($constants)){
		foreach($constants as $name => $constant){
            $code .= '/** @type ' . gettype($constant) . ' */' . PHP_EOL;
            $code .= 'const ' . $name . ' = ' . $constant . ';' . PHP_EOL . PHP_EOL;
		}
	}

    $methods = $reflector->getMethods();
	if(count($methods)){
		foreach($methods as $method) {
			$docClassName = str_replace("\\", "_", $method->getDeclaringClass()->name);
			if (isset($docs[$docClassName])) {
				$docMethods = $docs[$docClassName];
			} else {
				$docMethods = array();
			}

			if(isset($docMethods[$method->name])){
                $code .= $api->extractComment($docMethods[$method->name]) . PHP_EOL;
			}

            $modifierNames = Reflection::getModifierNames($method->getModifiers());
            
            foreach ($modifierNames as $modKey=>$modifierName) {
                if ($modifierName === 'abstract' && $reflector->isInterface()) {
                    unset($modifierNames[$modKey]);
                }
            }
            
			$code .= implode(' ', $modifierNames) . ' function ';
			$code .= $method->name . '(';

			$cp = array();
			foreach($method->getParameters() as $parameter){
                $cp[] = '$' . $parameter->name;
			}
			$code .= join(', ', $cp) . ')' . ($reflector->isInterface() ? ';' : ' {}') . PHP_EOL . PHP_EOL;
		}
	}

    $code .= '}';
    
    $path = explode('_', $simpleClassName);
    $fileName = array_pop($path);
    $baseFolder = 'classdoc/' . implode('/', $path);
    
    if (!file_exists($baseFolder)) {
        mkdir($baseFolder, 0744, true);
    }
	file_put_contents($baseFolder . '/' . $fileName . '.php', $code);
}


