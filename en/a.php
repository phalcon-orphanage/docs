<?php

$r = new ReflectionClass('Phalcon\Tag');

$helpers = array();
foreach($r->getMethods() as $method){
	if($method->isPublic()){
		$helpers['Phalcon\\\\Tag::'.$method->name] = Phalcon\Text::uncamelize($method->name);
	}
}

$kLength = null;
$vLength = null;
foreach($helpers as $key => $value){
	if($kLength===null){
		$kLength = strlen($key);
	} else {
		if($kLength<strlen($key)){
			$kLength = strlen($key);
		}
	}

	if($vLength===null){
		$vLength = strlen($value);
	} else {
		if($vLength<strlen($value)){
			$vLength = strlen($value);
		}
	}
}

foreach($helpers as $key => $value){
	echo '| ', $key, str_repeat(' ', $kLength-strlen($key)), ' | ', $value, str_repeat(' ', $vLength-strlen($value)), '|', PHP_EOL;
	echo '+', str_repeat('-', $kLength+2), '+', str_repeat('-', $vLength+1), '+', PHP_EOL;
}