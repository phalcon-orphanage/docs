---
layout: article
language: 'fr-fr'
version: '4.0'
title: 'Phalcon\Annotations\Adapter\Files'
---
# Class **Phalcon\Annotations\Adapter\Files**

*extends* abstract class [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

*implements* [Phalcon\Annotations\AdapterInterface](Phalcon_Annotations_AdapterInterface)

[Source sur GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/adapter/files.zep)

Stores the parsed annotations in files. This adapter is suitable for production

```php
<?php

use Phalcon\Annotations\Adapter\Files;

$annotations = new Files(
    [
        "annotationsDir" => "app/cache/annotations/",
    ]
);

```

## Méthodes

public **__construct** ([*array* $options])

Phalcon\Annotations\Adapter\Files constructor

public [Phalcon\Annotations\Reflection](Phalcon_Annotations_Reflection) **read** (*string* $key)

Reads parsed annotations from files

public **write** (*mixed* $key, [Phalcon\Annotations\Reflection](Phalcon_Annotations_Reflection) $data)

Écrit analysé les annotations de fichiers

public **setReader** ([Phalcon\Annotations\ReaderInterface](Phalcon_Annotations_ReaderInterface) $reader) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Définit le parser pour les annotations

public **getReader** () inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Renvoie le lecteur de l’annotation

public **get** (*string* | *object* $className) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Analyse ou récupère toutes les annotations trouvées dans une classe

public **getMethods** (*mixed* $className) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Retourne les annotations trouvées dans toutes les méthodes de cette classe

public **getMethod** (*mixed* $className, *mixed* $methodName) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Retourne les annotations trouvées dans une méthode spécifique

public **getProperties** (*mixed* $className) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Retourne les annotations trouvées dans toutes les méthodes de cette classe

public **getProperty** (*mixed* $className, *mixed* $propertyName) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Retourne les annotations trouve dans une propriété spécifique