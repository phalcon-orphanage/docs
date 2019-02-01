---
layout: article
language: 'fr-fr'
version: '4.0'
title: 'Phalcon\Annotations\Adapter'
---
# Abstract class **Phalcon\Annotations\Adapter**

*implements* [Phalcon\Annotations\AdapterInterface](Phalcon_Annotations_AdapterInterface)

[Source sur GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/adapter.zep)

This is the base class for Phalcon\Annotations adapters

## Méthodes

public **setReader** ([Phalcon\Annotations\ReaderInterface](Phalcon_Annotations_ReaderInterface) $reader)

Définit le parser pour les annotations

public **getReader** ()

Renvoie le lecteur de l’annotation

public **get** (*string* | *object* $className)

Analyse ou récupère toutes les annotations trouvées dans une classe

public **getMethods** (*mixed* $className)

Retourne les annotations trouvées dans toutes les méthodes de cette classe

public **getMethod** (*mixed* $className, *mixed* $methodName)

Retourne les annotations trouvées dans une méthode spécifique

public **getProperties** (*mixed* $className)

Retourne les annotations trouvées dans toutes les méthodes de cette classe

public **getProperty** (*mixed* $className, *mixed* $propertyName)

Retourne les annotations trouve dans une propriété spécifique