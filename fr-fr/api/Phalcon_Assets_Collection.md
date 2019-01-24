---
layout: article
language: 'fr-fr'
version: '4.0'
title: 'Phalcon\Assets\Collection'
---
# Class **Phalcon\Assets\Collection**

*implements* [Countable](https://php.net/manual/en/class.countable.php), [Iterator](https://php.net/manual/en/class.iterator.php), [Traversable](https://php.net/manual/en/class.traversable.php)

[Source sur GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/collection.zep)

Représente une collection de ressources

## Méthodes

public **getPrefix** ()

...

public **getLocal** ()

...

public **getResources** ()

...

public **getCodes** ()

...

public **getPosition** ()

...

public **getFilters** ()

...

public **getAttributes** ()

...

public **getJoin** ()

...

public **getTargetUri** ()

...

public **getTargetPath** ()

...

public **getTargetLocal** ()

...

public **getSourcePath** ()

...

public **__construct** ()

Phalcon\Assets\Collection constructor

public **add** ([Phalcon\Assets\Resource](Phalcon_Assets_Resource) $resource)

Adds a resource to the collection

public **addInline** ([Phalcon\Assets\Inline](Phalcon_Assets_Inline) $code)

Adds an inline code to the collection

public **has** ([Phalcon\Assets\ResourceInterface](Phalcon_Assets_ResourceInterface) $resource)

Vérifie ce que la ressource est ajoutée à la collection.

```php
<?php

use Phalcon\Assets\Resource;
use Phalcon\Assets\Collection;

$collection = new Collection();

$resource = new Resource("js", "js/jquery.js");
$resource->has($resource); // true

```

public **addCss** (*mixed* $path, [*mixed* $local], [*mixed* $filter], [*mixed* $attributes])

Ajoute un CSS de ressources à la collecte

public **addInlineCss** (*mixed* $content, [*mixed* $filter], [*mixed* $attributes])

Adds an inline CSS to the collection

public [Phalcon\Assets\Collection](Phalcon_Assets_Collection) **addJs** (*string* $path, [*boolean* $local], [*boolean* $filter], [*array* $attributes])

Adds a javascript resource to the collection

public **addInlineJs** (*mixed* $content, [*mixed* $filter], [*mixed* $attributes])

Ajoute une ligne de javascript pour la collection

public **count** ()

Returns the number of elements in the form

public **rewind** ()

Rewinds the internal iterator

public **current** ()

Retourne la ressource dans l'itérateur

public *int* **key** ()

Returns the current position/key in the iterator

public **next** ()

Moves the internal iteration pointer to the next position

public **valid** ()

Check if the current element in the iterator is valid

public **setTargetPath** (*mixed* $targetPath)

Définit le chemin cible du fichier pour la sortie filtrée/jointe

public **setSourcePath** (*mixed* $sourcePath)

Définit un chemin source de base pour toutes les ressources de cette collection

public **setTargetUri** (*mixed* $targetUri)

Définit un uri cible pour le code HTML généré

public **setPrefix** (*mixed* $prefix)

Définit un préfixe commun pour toutes les ressources

public **setLocal** (*mixed* $local)

Définit si la collection utilise des ressources locales par défaut

public **setAttributes** (*array* $attributes)

Sets extra HTML attributes

public **setFilters** (*array* $filters)

Sets an array of filters in the collection

public **setTargetLocal** (*mixed* $targetLocal)

Sets the target local

public **join** (*mixed* $join)

Sets if all filtered resources in the collection must be joined in a single result file

public **getRealTargetPath** (*mixed* $basePath)

Returns the complete location where the joined/filtered collection must be written

public **addFilter** ([Phalcon\Assets\FilterInterface](Phalcon_Assets_FilterInterface) $filter)

Adds a filter to the collection

final protected **addResource** ([Phalcon\Assets\ResourceInterface](Phalcon_Assets_ResourceInterface) $resource)

Adds a resource or inline-code to the collection