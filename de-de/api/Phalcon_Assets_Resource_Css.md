---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Assets\Resource\Css'
---
# Class **Phalcon\Assets\Resource\Css**

*extends* class [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

*implements* [Phalcon\Assets\ResourceInterface](Phalcon_Assets_ResourceInterface)

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/resource/css.zep)

Represents CSS resources

## Methoden

public **__construct** (*string* $path, [*boolean* $local], [*boolean* $filter], [*array* $attributes])

public **getType** () inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

public **getPath** () inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

public **getLocal** () inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

public **getFilter** () inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

public **getAttributes** () inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

public **getSourcePath** () inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

...

public **getTargetPath** () inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

...

public **getTargetUri** () inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

...

public **setType** (*mixed* $type) inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

Setzt den Ressourcentyp

public **setPath** (*mixed* $path) inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

Setzt den Ressourcenpfad

public **setLocal** (*mixed* $local) inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

Legt fest, ob die Ressource lokal oder extern ist

public **setFilter** (*mixed* $filter) inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

Legt fest, ob die Ressource gefiltert werden muss oder nicht

public **setAttributes** (*array* $attributes) inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

Sets extra HTML attributes

public **setTargetUri** (*mixed* $targetUri) inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

Sets a target uri for the generated HTML

public **setSourcePath** (*mixed* $sourcePath) inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

Legt den Quellpfad der Ressource fest

public **setTargetPath** (*mixed* $targetPath) inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

Legt den Zielpfad der Ressource fest

public **getContent** ([*mixed* $basePath]) inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

Gibt den Inhalt der Ressource als Zeichenkette zurück, optional kann ein Basispfad festgelegt werden wo sich die Ressource befindet

public **getRealTargetUri** () inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

Gibt die eigentlichen Ziel-Uri für den generierten HTML-Code zurück

public **getRealSourcePath** ([*mixed* $basePath]) inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

Gibt den kompletten Pfad zurück, wo sich die Ressource befindet

public **getRealTargetPath** ([*mixed* $basePath]) inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

Gibt den kompletten Pfad zurück, wo die Ressource geschrieben werden muss

public **getResourceKey** () inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

Gibt den Ressourcenschlüssel zurück.