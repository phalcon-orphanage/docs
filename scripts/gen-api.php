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

$index = 'API Indice
-----------------

.. toctree::
   :maxdepth: 1'.PHP_EOL.PHP_EOL;

$api = new API_Generator(CPHALCON_DIR);

$classDocs = $api->getClassDocs();
$docs = $api->getDocs();
$classes = $api->getRuntimeClasses();

$indexClasses = array();
$indexInterfaces = array();
foreach($classes as $className){

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
		'type'			=> $typeClass,
		'description'	=> $realClassName,
		'extends'		=> $reflector->getParentClass(),
		'implements'	=> $reflector->getInterfaceNames(),
		'constants'     => $reflector->getConstants(),
		'methods'		=> $reflector->getMethods()
	);

	if ($reflector->isInterface() == true) {
		$indexInterfaces[] = '   '.$simpleClassName.PHP_EOL;
	} else {
		$indexClasses[] = '   '.$simpleClassName.PHP_EOL;
	}

	$nsClassName = str_replace("\\", "\\\\", $className);

	if ($reflector->isInterface() == true) {
		$code = 'Interface **'.$nsClassName.'**'.PHP_EOL;
		$code.= str_repeat("=", strlen($nsClassName)+14).PHP_EOL.PHP_EOL;
	} else {
		$code = 'Class **'.$nsClassName.'**'.PHP_EOL;
		$code.= str_repeat("=", strlen($nsClassName)+10).PHP_EOL.PHP_EOL;
	}

	if($documentationData['extends']){
		$extendsName = $documentationData['extends']->name;
		if(strpos($extendsName, 'Phalcon')!==false){
			$extendsPath =  str_replace("\\", "_", $extendsName);
			$extendsName =  str_replace("\\", "\\\\", $extendsName);
			$code.='*extends* :doc:`'.$extendsName.' <'.$extendsPath.'>`'.PHP_EOL.PHP_EOL;
		} else {
			$code.='*extends* '.$extendsName.PHP_EOL.PHP_EOL;
		}
	}

	//Generate the interfaces part
	if(count($documentationData['implements'])){
		$implements = array();
		foreach($documentationData['implements'] as $interfaceName){
			if(strpos($interfaceName, 'Phalcon')!==false){
				$interfacePath =  str_replace("\\", "_", $interfaceName);
				$interfaceName =  str_replace("\\", "\\\\", $interfaceName);
				$implements[] = ':doc:`'.$interfaceName.' <'.$interfacePath.'>`';
			} else {
				$implements[] = $interfaceName;
			}
		}
		$code.='*implements* '.join(', ', $implements).PHP_EOL.PHP_EOL;
	}

	if(isset($classDocs[$simpleClassName])){
		$ret = $api->getPhpDoc($classDocs[$simpleClassName], $className, null, $realClassName);
		$code.= $ret['description'].PHP_EOL.PHP_EOL;
	}

	if(count($documentationData['constants'])){
		$code.='Constants'.PHP_EOL;
		$code.='---------'.PHP_EOL.PHP_EOL;
		foreach($documentationData['constants'] as $name => $constant){
			$code.= '*'.gettype($constant).'* **'.$name.'**'.PHP_EOL.PHP_EOL;
		}
	}

	if(count($documentationData['methods'])){

		$code.='Methods'.PHP_EOL;
		$code.='---------'.PHP_EOL.PHP_EOL;
		foreach($documentationData['methods'] as $method){

			$docClassName = str_replace("\\", "_", $method->getDeclaringClass()->name);
			if (isset($docs[$docClassName])) {
				$docMethods = $docs[$docClassName];
			} else {
				$docMethods = array();
			}

			if(isset($docMethods[$method->name])){
				$ret = $api->getPhpDoc($docMethods[$method->name], $className, $method->name, null);
			} else {
				$ret = array();
			}

			$code.= implode(' ', Reflection::getModifierNames($method->getModifiers())).' ';

			if(isset($ret['return'])){
				if(preg_match('/^(Phalcon[a-zA-Z\\\\]+)/', $ret['return'], $matches)){
					$extendsPath =  str_replace("\\", "_", $matches[1]);
					$extendsName =  str_replace("\\", "\\\\", $matches[1]);
					$code.= str_replace($matches[1], ':doc:`'.$extendsName.' <'.$extendsPath.'>` ', $ret['return']);
				} else {
					$code.= '*'.$ret['return'].'* ';
				}
			}

			$code.=' **'.$method->name.'** (';

			$cp = array();
			foreach($method->getParameters() as $parameter){
				$name = '$'.$parameter->name;
				if(isset($ret['parameters'][$name])){
					if(strpos($ret['parameters'][$name], 'Phalcon')!==false){
						$parameterPath =  str_replace("\\", "_", $ret['parameters'][$name]);
						$parameterName =  str_replace("\\", "\\\\", $ret['parameters'][$name]);
						$cp[] = ':doc:`'.$parameterName.' <'.$parameterPath.'>` '.$name;
					} else {
						$cp[] = '*'.$ret['parameters'][$name].'* '.$name;
					}
				} else {
					$cp[] = '*unknown* '.$name;
				}
			}
			$code.=join(', ', $cp).')';

			if($simpleClassName!=$docClassName){
				$code.=' inherited from '.str_replace("\\", "\\\\", $method->getDeclaringClass()->name);
			}

			$code.=PHP_EOL.PHP_EOL;

			if(isset($ret['description'])){
				foreach(explode("\n", $ret['description']) as $dline){
					$code.="".$dline."\n";
				}
			} else {
				$code.="...\n";
			}
			$code.=PHP_EOL.PHP_EOL;

		}

	}

	file_put_contents('en/api/'.$simpleClassName.'.rst', $code);
}

file_put_contents('en/api/index.rst', $index.join('', $indexClasses).join('', $indexInterfaces));

