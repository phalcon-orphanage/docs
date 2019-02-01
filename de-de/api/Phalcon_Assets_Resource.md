---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Assets\Resource'
---
# Class **Phalcon\Assets\Resource**

*implements* [Phalcon\Assets\ResourceInterface](Phalcon_Assets_ResourceInterface)

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/resource.zep)

Stellt Asset Ressourcen dar

```php
<?php

$resource = new \Phalcon\Assets\Resource("js", "javascripts/jquery.js");

```

## Methoden

public **getType** ()

public **getPath** ()

public **getLocal** ()

public **getFilter** ()

public **getAttributes** ()

public **getSourcePath** ()

...

public **getTargetPath** ()

...

public **getTargetUri** ()

...

public **__construct** (*string* $type, *string* $path, [*boolean* $local], [*boolean* $filter], [*array* $attributes])

Phalcon\Assets\Resource constructor

public **setType** (*mixed* $type)

Setzt den Ressourcentyp

public **setPath** (*mixed* $path)

Setzt den Ressourcenpfad

public **setLocal** (*mixed* $local)

Legt fest, ob die Ressource lokal oder extern ist

public **setFilter** (*mixed* $filter)

Legt fest, ob die Ressource gefiltert werden muss oder nicht

public **setAttributes** (*array* $attributes)

Sets extra HTML attributes

public **setTargetUri** (*mixed* $targetUri)

Sets a target uri for the generated HTML

public **setSourcePath** (*mixed* $sourcePath)

Legt den Quellpfad der Ressource fest

public **setTargetPath** (*mixed* $targetPath)

Legt den Zielpfad der Ressource fest

public **getContent** ([*mixed* $basePath])

Gibt den Inhalt der Ressource als Zeichenkette zurück, optional kann ein Basispfad festgelegt werden wo sich die Ressource befindet

public **getRealTargetUri** ()

Gibt die eigentlichen Ziel-Uri für den generierten HTML-Code zurück

public **getRealSourcePath** ([*mixed* $basePath])

Gibt den kompletten Pfad zurück, wo sich die Ressource befindet

public **getRealTargetPath** ([*mixed* $basePath])

Gibt den kompletten Pfad zurück, wo die Ressource geschrieben werden muss

public **getResourceKey** ()

Gibt den Ressourcenschlüssel zurück.