---
layout: article
language: 'en'
version: '4.0'
title: 'Phalcon\Annotations\Annotation'
---
# Class **Phalcon\Annotations\Annotation**

[Source on Github](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/annotation.zep)

Representa una sola anotación en una colección de anotaciones

## Métodos

public **__construct** (*array* $reflectionData)

Phalcon\Annotations\Annotation constructor

public **getName** ()

Devuelve el nombre de la anotación

public *mixed* **getExpression** (*array* $expr)

Resuelve una expresión de anotación

public *array* **getExprArguments** ()

Devuelve los argumentos de la expresión sin resolver

public *array* **getArguments** ()

Devuelve los argumentos de la expresión

public **numberArguments** ()

Devuelve el número de argumentos que tiene la anotación

public *mixed* **getArgument** (*int* | *string* $position)

Devuelve un argumento en una posición específica

public *boolean* **hasArgument** (*int* | *string* $position)

Devuelve un argumento en una posición específica

public *mixed* **getNamedArgument** (*mixed* $name)

Devuelve el argumento nombrado

public *mixed* **getNamedParameter** (*mixed* $name)

Devuelve el parámetro nombrado