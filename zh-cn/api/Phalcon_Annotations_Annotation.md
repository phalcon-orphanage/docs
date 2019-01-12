* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Annotations\Annotation'

* * *

# Class **Phalcon\Annotations\Annotation**

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/annotations/annotation.zep" class="btn btn-default btn-sm">源码在GitHub</a>

Represents a single annotation in an annotations collection

## 方法

public **__construct** (*array* $reflectionData)

Phalcon\Annotations\Annotation constructor

public **getName** ()

Returns the annotation's name

public *mixed* **getExpression** (*array* $expr)

Resolves an annotation expression

public *array* **getExprArguments** ()

Returns the expression arguments without resolving

public *array* **getArguments** ()

Returns the expression arguments

public **numberArguments** ()

Returns the number of arguments that the annotation has

public *mixed* **getArgument** (*int* | *string* $position)

Returns an argument in a specific position

public *boolean* **hasArgument** (*int* | *string* $position)

Returns an argument in a specific position

public *mixed* **getNamedArgument** (*mixed* $name)

Returns a named argument

public *mixed* **getNamedParameter** (*mixed* $name)

Returns a named parameter