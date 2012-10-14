Class **Phalcon\\Mvc\\View\\Engine\\Volt\\Compiler**
====================================================

This class reads and compiles volt templates into PHP plain code


Methods
---------

protected  **_functionCall** ()

Resolves function intermediate code into PHP function calls



protected  **_filter** ()

Resolves filter intermediate code into PHP function calls



public  **_expression** (*array* $expr)

Resolves an expression node in an AST volt tree



protected *string*  **_statementList** ()

Traverses a statement list compiling each of its nodes



public  **compile** (*string* $path, *string* $compiledPath)

Compiles a template into a file



public  **parse** (*unknown* $viewCode)

...


