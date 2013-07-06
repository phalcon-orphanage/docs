Class **Phalcon\\Mvc\\View\\Engine\\Volt\\Compiler**
====================================================

*implements* :doc:`Phalcon\\DI\\InjectionAwareInterface <Phalcon_DI_InjectionAwareInterface>`

This class reads and compiles Volt templates into PHP plain code  

.. code-block:: php

    <?php

    $compiler = new \Phalcon\Mvc\View\Engine\Volt\Compiler();
    
    $compiler->compile('views/partials/header.volt');
    
    require $compiler->getCompiledTemplatePath();



Methods
---------

public  **__construct** ([:doc:`Phalcon\\Mvc\\ViewInterface <Phalcon_Mvc_ViewInterface>` $view])





public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)

Sets the dependency injector



public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** ()

Returns the internal dependency injector



public  **setOptions** (*array* $options)

Sets the compiler options



public  **setOption** (*string* $option, *string* $value)

Sets a single compiler option



public *string*  **getOption** (*string* $option)

Returns a compiler's option



public *array*  **getOptions** ()

Returns the compiler options



public *mixed*  **fireExtensionEvent** (*string* $name, [*array* $arguments])

Fires an event to registered extensions



public :doc:`Phalcon\\Mvc\\View\\Engine\\Volt\\Compiler <Phalcon_Mvc_View_Engine_Volt_Compiler>`  **addExtension** (*object* $extension)

Registers a Volt's extension



public *array*  **getExtensions** ()

Returns the list of extensions registered in Volt



public :doc:`Phalcon\\Mvc\\View\\Engine\\Volt\\Compiler <Phalcon_Mvc_View_Engine_Volt_Compiler>`  **addFunction** (*string* $name, *Closure|string* $definition)

Register a new function in the compiler



public *array*  **getFunctions** ()

Register the user registered functions



public :doc:`Phalcon\\Mvc\\View\\Engine\\Volt\\Compiler <Phalcon_Mvc_View_Engine_Volt_Compiler>`  **addFilter** (*string* $name, *Closure|string* $definition)

Register a new filter in the compiler



public *array*  **getFilters** ()

Register the user registered filters



public  **setUniquePrefix** (*string* $prefix)

Set a unique prefix to be used as prefix for compiled variables



public *string*  **getUniquePrefix** ()

Return a unique prefix to be used as prefix for compiled variables and contexts



public *string*  **attributeReader** (*array* $expr)

Resolves attribute reading



public *string*  **functionCall** (*array* $expr)

Resolves function intermediate code into PHP function calls



public *string*  **resolveTest** (*array* $test, *string* $left)

Resolves filter intermediate code into a valid PHP expression



protected *string*  **resolveFilter** ()

Resolves filter intermediate code into PHP function calls



public *string*  **expression** (*array* $expr)

Resolves an expression node in an AST volt tree



protected *string|array*  **_statementListOrExtends** ()

Compiles a block of statements



public *string*  **compileForeach** (*array* $statement, [*boolean* $extendsMode])

Compiles a 'foreach' intermediate code representation into plain PHP code



public *string*  **compileForElse** ()

Generates a 'forelse' PHP code



public *string*  **compileIf** (*array* $statement, [*boolean* $extendsMode])

Compiles a 'if' statement returning PHP code



public *string*  **compileElseIf** (*array* $statement)

Compiles a 'elseif' statement returning PHP code



public *string*  **compileCache** (*array* $statement, [*boolean* $extendsMode])

Compiles a 'cache' statement returning PHP code



public *string*  **compileEcho** (*array* $statement)

Compiles a '{{' '}}' statement returning PHP code



public *string*  **compileInclude** (*array* $statement)

Compiles a 'include' statement returning PHP code



public *string*  **compileSet** (*array* $statement)

Compiles a 'set' statement returning PHP code



public *string*  **compileDo** (*array* $statement)

Compiles a 'do' statement returning PHP code



public *string*  **compileReturn** (*array* $statement)

Compiles a 'return' statement returning PHP code



public *string*  **compileAutoEscape** (*array* $statement, *boolean* $extendsMode)

Compiles a 'autoescape' statement returning PHP code



public *string*  **compileMacro** (*array* $statement, *boolean* $extendsMode)

Compiles macros



public *string*  **compileCall** ()

Compiles calls to macros



protected *string*  **_statementList** ()

Traverses a statement list compiling each of its nodes



protected *string*  **_compileSource** ()

Compiles a Volt source code returning a PHP plain version



public *string*  **compileString** (*string* $viewCode, [*boolean* $extendsMode])

Compiles a template into a string 

.. code-block:: php

    <?php

     echo $compiler->compileString('{{ "hello world" }}');




public *string|array*  **compileFile** (*string* $path, *string* $compiledPath, [*boolean* $extendsMode])

Compiles a template into a file forcing the destination path 

.. code-block:: php

    <?php

    $compiler->compile('views/layouts/main.volt', 'views/layouts/main.volt.php');




public *string|array*  **compile** (*string* $templatePath, [*boolean* $extendsMode])

Compiles a template into a file applying the compiler options This method does not return the compiled path if the template was not compiled 

.. code-block:: php

    <?php

    $compiler->compile('views/layouts/main.volt');
    require $compiler->getCompiledTemplatePath();




public *string*  **getTemplatePath** ()

Returns the path that is currently being compiled



public *string*  **getCompiledTemplatePath** ()

Returns the path to the last compiled template



public *array*  **parse** (*string* $viewCode)

Parses a Volt template returning its intermediate representation 

.. code-block:: php

    <?php

    print_r($compiler->parse('{{ 3 + 2 }}'));




