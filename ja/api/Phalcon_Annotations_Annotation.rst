Class **Phalcon\\Annotations\\Annotation**
==========================================

Represents a single annotation in an annotations collection


Methods
---------

public  **__construct** (*array* $reflectionData)

Phalcon\\Annotations\\Annotation constructor



public *string*  **getName** ()

Returns the annotation's name



public *mixed*  **getExpression** (*array* $expr)

Resolves an annotation expression



public *array*  **getExprArguments** ()

Returns the expression arguments without resolving



public *array*  **getArguments** ()

Returns the expression arguments



public *int*  **numberArguments** ()

Returns the number of arguments that the annotation has



public *mixed*  **getArgument** (*unknown* $position)

Returns an argument in a specific position



public *bool*  **hasArgument** (*unknown* $position)

Checks if the annotation has a specific argument



public *mixed*  **getNamedArgument** (*unknown* $position)

Returns a named argument



public *mixed*  **getNamedParameter** (*unknown* $position)

Returns a named argument (deprecated)



public *boolean*  **hasNamedArgument** (*unknown* $position)

Checks if the annotation has a specific named argument



