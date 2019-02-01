---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Annotations\Collection'
---
# Class **Phalcon\Annotations\Collection**

*implements* [Iterator](https://php.net/manual/en/class.iterator.php), [Traversable](https://php.net/manual/en/class.traversable.php), [Countable](https://php.net/manual/en/class.countable.php)

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/collection.zep)

Represents a collection of annotations. This class allows to traverse a group of annotations easily

```php
<?php

//Traverse annotations
foreach ($classAnnotations as $annotation) {
    echo "Name=", $annotation->getName(), PHP_EOL;
}

//Check if the annotations has a specific
var_dump($classAnnotations->has("Cacheable"));

//Get an specific annotation in the collection
$annotation = $classAnnotations->get("Cacheable");

```

## Methoden

public **__construct** ([*array* $reflectionData])

Phalcon\Annotations\Collection constructor

public **count** ()

Liefert die Anzahl der Anmerkungen in der Sammlung

public **rewind** ()

Rewinds the internal iterator

public [Phalcon\Annotations\Annotation](Phalcon_Annotations_Annotation) **current** ()

Gibt die aktuelle Anmerkung im Iterator zurück

public **key** ()

Gibt die aktuellen Position/Schlüssel im Iterator zurück

public **next** ()

Bewegt sich der internen Iteration-Zeiger auf die nächste position

public **valid** ()

Überprüft, ob die aktuelle Anmerkung im Iterator gültig ist

public **getAnnotations** ()

Returns the internal annotations as an array

public **get** (*string* $name)

Returns the first annotation that match a name

public **getAll** (*string* $name)

Returns all the annotations that match a name

public **has** (*string* $name)

Überprüft, ob eine Anmerkung in einer Auflistung vorhanden ist