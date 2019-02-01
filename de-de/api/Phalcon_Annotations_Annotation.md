---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Annotations\Annotation'
---
# Class **Phalcon\Annotations\Annotation**

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/annotation.zep)

Represents a single annotation in an annotations collection

## Methoden

public **__construct** (*array* $reflectionData)

Phalcon\Annotations\Annotation constructor

public **getName** ()

Gibt den Anmerkungs-Namen zurück

public *mixed* **getExpression** (*array* $expr)

Resolves an annotation expression

public *array* **getExprArguments** ()

Returns the expression arguments without resolving

public *array* **getArguments** ()

Returns the expression arguments

public **numberArguments** ()

Returns the number of arguments that the annotation has

public *mixed* **getArgument** (*int* | *string* $position)

Gibt ein Argument in einer bestimmten Position zurück

public *boolean* **hasArgument** (*int* | *string* $position)

Gibt ein Argument in einer bestimmten Position zurück

public *mixed* **getNamedArgument** (*mixed* $name)

Gibt ein benanntes Argument zurück

public *mixed* **getNamedParameter** (*mixed* $name)

Gibt einen benannten Parameter zurück