---
layout: article
language: 'fr-fr'
version: '4.0'
title: 'Phalcon\Annotations\AdapterInterface'
---
# Interface **Phalcon\Annotations\AdapterInterface**

[Source sur GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/adapterinterface.zep)

Cette interface doit être implémentée par les cartes Phalcon\Annotations

## Méthodes

abstract public **setReader** ([Phalcon\Annotations\ReaderInterface](Phalcon_Annotations_ReaderInterface) $reader)

Définit le parser pour les annotations

abstract public **getReader** ()

Renvoie le lecteur de l’annotation

abstract public **get** (*string|object* $className)

Analyse ou récupère toutes les annotations trouvées dans une classe

abstract public **getMethods** (*string* $className)

Retourne les annotations retrouve dans toutes les méthodes de la classe

abstract public **getMethod** (*string* $className, *string* $methodName)

Retourne les annotations trouvées dans une méthode spécifique

abstract public **getProperties** (*string* $className)

Retourne les annotations retrouve dans toutes les méthodes de la classe

abstract public **getProperty** (*string* $className, *string* $propertyName)

Retourne les annotations trouve dans une propriété spécifique