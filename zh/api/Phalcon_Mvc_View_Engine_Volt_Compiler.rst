Class **Phalcon\\Mvc\\View\\Engine\\Volt\\Compiler**
====================================================

This class reads and compiles volt templates into PHP plain code


Methods
---------

public  **setDI** (*unknown* $di)

...


public  **getDI** ()

...


protected  **_functionCall** ()

Resolves function intermediate code into PHP function calls



protected  **_filter** ()

Resolves filter intermediate code into PHP function calls



public  **_expression** (*array* $expr, *bool* $extendsMode, *bool* $prependDollar)

Resolves an expression node in an AST volt tree



protected *string*  **_statementList** ()

Traverses a statement list compiling each of its nodes



protected *string*  **_compileSource** ()

Compiles a Volt source code returning a PHP plain version



public *string*  **compileString** (*string* $viewCode, *boolean* $extendsMode)

Compiles a template in a string



public  **compile** (*string* $path, *string* $compiledPath)

Compiles a template into a file



public *array*  **parse** (*string* $viewCode)

Parses a Volt template returning its intermediate representation



