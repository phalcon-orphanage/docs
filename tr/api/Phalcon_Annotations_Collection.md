# Class **Phalcon\\Annotations\\Collection**

*uygulamalar* [yineleyici](http://php.net/manual/en/class.iterator.php), [Traversable](http://php.net/manual/en/class.traversable.php), [sayılabilir](http://php.net/manual/en/class.countable.php)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/annotations/collection.zep" class="btn btn-default btn-sm">Source on GitHub</a>

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

Phalcon\\Annotations\\Collection constructor

public **count** ()

Returns the number of annotations in the collection

herkese açık **geri sarma** ()

Rewinds the internal iterator

herkese açık [Phalcon\Açıklamalar\açıklama](/en/3.2/api/Phalcon_Annotations_Annotation) **geçerli** ()

Returns the current annotation in the iterator

herkese açık **anahtar** ()

Returns the current position/key in the iterator

herkese açık **sonraki** ()

Moves the internal iteration pointer to the next position

herkese açık **geçerli** ()

Check if the current annotation in the iterator is valid

herkese açık ** Açıklamaları al** ()

Returns the internal annotations as an array

herkese açık **al** (*dizi* $isim)

Returns the first annotation that match a name

herkese açık **Hepsini al** (*dizi* $isim)

Returns all the annotations that match a name

herkese açık **var** (*dizi* $isim)

Check if an annotation exists in a collection