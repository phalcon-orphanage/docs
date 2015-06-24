Class **Phalcon\\Mvc\\View\\Engine\\Volt\\Compiler**
====================================================

*implements* :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`

This class reads and compiles Volt templates into PHP plain code  

.. code-block:: php

    <?php

    $compiler = new \Phalcon\Mvc\View\Engine\Volt\Compiler();
    
    $compiler->compile('views/partials/header.volt');
    
    require $compiler->getCompiledTemplatePath();



Methods
-------

public  **__construct** ([*unknown* $view])





public  **setDI** (*unknown* $dependencyInjector)

Sets the dependency injector



public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** ()

Returns the internal dependency injector



public  **setOptions** (*unknown* $options)

Sets the compiler options



public  **setOption** (*unknown* $option, *unknown* $value)

Sets a single compiler option



public *string*  **getOption** (*unknown* $option)

Returns a compiler's option



public *array*  **getOptions** ()

Returns the compiler options



final public *mixed*  **fireExtensionEvent** (*unknown* $name, [*unknown* $arguments])

Fires an event to registered extensions



public :doc:`Phalcon\\Mvc\\View\\Engine\\Volt\\Compiler <Phalcon_Mvc_View_Engine_Volt_Compiler>`  **addExtension** (*unknown* $extension)

Registers a Volt's extension



public *array*  **getExtensions** ()

Returns the list of extensions registered in Volt



public :doc:`Phalcon\\Mvc\\View\\Engine\\Volt\\Compiler <Phalcon_Mvc_View_Engine_Volt_Compiler>`  **addFunction** (*unknown* $name, *unknown* $definition)

Register a new function in the compiler



public *array*  **getFunctions** ()

Register the user registered functions



public :doc:`Phalcon\\Mvc\\View\\Engine\\Volt\\Compiler <Phalcon_Mvc_View_Engine_Volt_Compiler>`  **addFilter** (*unknown* $name, *unknown* $definition)

Register a new filter in the compiler



public *array*  **getFilters** ()

Register the user registered filters



public :doc:`Phalcon\\Mvc\\View\\Engine\\Volt\\Compiler <Phalcon_Mvc_View_Engine_Volt_Compiler>`  **setUniquePrefix** (*unknown* $prefix)

Set a unique prefix to be used as prefix for compiled variables



public *string*  **getUniquePrefix** ()

Return a unique prefix to be used as prefix for compiled variables and contexts



public *string*  **attributeReader** (*unknown* $expr)

Resolves attribute reading



public *string*  **functionCall** (*unknown* $expr)

Resolves function intermediate code into PHP function calls



public *string*  **resolveTest** (*unknown* $test, *unknown* $left)

Resolves filter intermediate code into a valid PHP expression



final protected *string*  **resolveFilter** (*unknown* $filter, *unknown* $left)

Resolves filter intermediate code into PHP function calls



final public *string*  **expression** (*unknown* $expr)

Resolves an expression node in an AST volt tree



final protected *string|array*  **_statementListOrExtends** (*unknown* $statements)

Compiles a block of statements



public *string*  **compileForeach** (*unknown* $statement, [*unknown* $extendsMode])

Compiles a "foreach" intermediate code representation into plain PHP code



public *string*  **compileForElse** ()

Generates a 'forelse' PHP code



public *string*  **compileIf** (*unknown* $statement, [*unknown* $extendsMode])

Compiles a 'if' statement returning PHP code



public *string*  **compileElseIf** (*unknown* $statement)

Compiles a "elseif" statement returning PHP code



public *string*  **compileCache** (*unknown* $statement, [*unknown* $extendsMode])

Compiles a "cache" statement returning PHP code



public *string*  **compileSet** (*unknown* $statement)

Compiles a "set" statement returning PHP code



public *string*  **compileDo** (*unknown* $statement)

Compiles a "do" statement returning PHP code



public *string*  **compileReturn** (*unknown* $statement)

Compiles a "return" statement returning PHP code



public *string*  **compileAutoEscape** (*unknown* $statement, *unknown* $extendsMode)

Compiles a "autoescape" statement returning PHP code



public *string*  **compileEcho** (*unknown* $statement)

Compiles a '{{' '}}' statement returning PHP code



public *string*  **compileInclude** (*unknown* $statement)

Compiles a 'include' statement returning PHP code



public *string*  **compileMacro** (*unknown* $statement, *unknown* $extendsMode)

Compiles macros



public *string*  **compileCall** (*unknown* $statement, *unknown* $extendsMode)

Compiles calls to macros



final protected *string*  **_statementList** (*unknown* $statements, [*unknown* $extendsMode])

Traverses a statement list compiling each of its nodes



protected *string*  **_compileSource** (*unknown* $viewCode, [*unknown* $extendsMode])

Compiles a Volt source code returning a PHP plain version



public *string*  **compileString** (*unknown* $viewCode, [*unknown* $extendsMode])

Compiles a template into a string 

.. code-block:: php

    <?php

     echo $compiler->compileString('{{ "hello world" }}');




public *string|array*  **compileFile** (*unknown* $path, *unknown* $compiledPath, [*unknown* $extendsMode])

Compiles a template into a file forcing the destination path 

.. code-block:: php

    <?php

    $compiler->compile('views/layouts/main.volt', 'views/layouts/main.volt.php');




public *string|array*  **compile** (*unknown* $templatePath, [*unknown* $extendsMode])

Compiles a template into a file applying the compiler options This method does not return the compiled path if the template was not compiled 

.. code-block:: php

    <?php

    $compiler->compile('views/layouts/main.volt');
    require $compiler->getCompiledTemplatePath();




public *string*  **getTemplatePath** ()

Returns the path that is currently being compiled



public *string*  **getCompiledTemplatePath** ()

Returns the path to the last compiled template



public *array*  **parse** (*unknown* $viewCode)

Parses a Volt template returning its intermediate representation 

.. code-block:: php

    <?php

    print_r($compiler->parse('{{ 3 + 2 }}'));




