---
layout: article
language: 'en'
version: '4.0'
title: 'Phalcon\Annotations\Collection'
---
# Class **Phalcon\Annotations\Collection**

*implements* [Iterator](https://php.net/manual/en/class.iterator.php), [Traversable](https://php.net/manual/en/class.traversable.php), [Countable](https://php.net/manual/en/class.countable.php)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/annotations/collection.zep" class="btn btn-default btn-sm">Source on GitHub</a>

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

## Methods

public **__construct** ([*array* $reflectionData])

Phalcon\Annotations\Collection constructor

public **count** ()

Returns the number of annotations in the collection

public **rewind** ()

Rewinds the internal iterator

public [Phalcon\Annotations\Annotation](Phalcon_Annotations_Annotation) **current** ()

Returns the current annotation in the iterator

public **key** ()

Returns the current position/key in the iterator

public **next** ()

Moves the internal iteration pointer to the next position

public **valid** ()

Check if the current annotation in the iterator is valid

public **getAnnotations** ()

Returns the internal annotations as an array

public **get** (*string* $name)

Returns the first annotation that match a name

public **getAll** (*string* $name)

Returns all the annotations that match a name

public **has** (*string* $name)

Check if an annotation exists in a collection