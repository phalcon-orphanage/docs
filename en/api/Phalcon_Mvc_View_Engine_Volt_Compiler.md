---
layout: article
language: 'en'
version: '4.0'
title: 'Phalcon\Mvc\View\Engine\Volt\Compiler'
---
# Class **Phalcon\Mvc\View\Engine\Volt\Compiler**

*implements* [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/mvc/view/engine/volt/compiler.zep" class="btn btn-default btn-sm">Source on GitHub</a>

This class reads and compiles Volt templates into PHP plain code

```php
<?php

$compiler = new \Phalcon\Mvc\View\Engine\Volt\Compiler();

$compiler->compile("views/partials/header.volt");

require $compiler->getCompiledTemplatePath();

```


## Methods
public  **__construct** ([[Phalcon\Mvc\ViewBaseInterface](Phalcon_Mvc_ViewBaseInterface) $view])





public  **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Sets the dependency injector



public  **getDI** ()

Returns the internal dependency injector



public  **setOptions** (*array* $options)

Sets the compiler options



public  **setOption** (*string* $option, *mixed* $value)

Sets a single compiler option



public *string* **getOption** (*string* $option)

Returns a compiler's option



public  **getOptions** ()

Returns the compiler options



final public *mixed* **fireExtensionEvent** (*string* $name, [*array* $arguments])

Fires an event to registered extensions



public  **addExtension** (*mixed* $extension)

Registers a Volt's extension



public  **getExtensions** ()

Returns the list of extensions registered in Volt



public  **addFunction** (*mixed* $name, *mixed* $definition)

Register a new function in the compiler



public  **getFunctions** ()

Register the user registered functions



public  **addFilter** (*mixed* $name, *mixed* $definition)

Register a new filter in the compiler



public  **getFilters** ()

Register the user registered filters



public  **setUniquePrefix** (*mixed* $prefix)

Set a unique prefix to be used as prefix for compiled variables



public  **getUniquePrefix** ()

Return a unique prefix to be used as prefix for compiled variables and contexts



public  **attributeReader** (*array* $expr)

Resolves attribute reading



public  **functionCall** (*array* $expr)

Resolves function intermediate code into PHP function calls



public  **resolveTest** (*array* $test, *mixed* $left)

Resolves filter intermediate code into a valid PHP expression



final protected  **resolveFilter** (*array* $filter, *mixed* $left)

Resolves filter intermediate code into PHP function calls



final public  **expression** (*array* $expr)

Resolves an expression node in an AST volt tree



final protected *string* | *array* **_statementListOrExtends** (*array* $statements)

Compiles a block of statements



public  **compileForeach** (*array* $statement, [*mixed* $extendsMode])

Compiles a "foreach" intermediate code representation into plain PHP code



public  **compileForElse** ()

Generates a 'forelse' PHP code



public  **compileIf** (*array* $statement, [*mixed* $extendsMode])

Compiles a 'if' statement returning PHP code



public  **compileElseIf** (*array* $statement)

Compiles a "elseif" statement returning PHP code



public  **compileCache** (*array* $statement, [*mixed* $extendsMode])

Compiles a "cache" statement returning PHP code



public  **compileSet** (*array* $statement)

Compiles a "set" statement returning PHP code



public  **compileDo** (*array* $statement)

Compiles a "do" statement returning PHP code



public  **compileReturn** (*array* $statement)

Compiles a "return" statement returning PHP code



public  **compileAutoEscape** (*array* $statement, *mixed* $extendsMode)

Compiles a "autoescape" statement returning PHP code



public *string* **compileEcho** (*array* $statement)

Compiles a '{{' '}}' statement returning PHP code



public  **compileInclude** (*array* $statement)

Compiles a 'include' statement returning PHP code



public  **compileMacro** (*array* $statement, *mixed* $extendsMode)

Compiles macros



public *string* **compileCall** (*array* $statement, *boolean* $extendsMode)

Compiles calls to macros



final protected  **_statementList** (*array* $statements, [*mixed* $extendsMode])

Traverses a statement list compiling each of its nodes



protected  **_compileSource** (*mixed* $viewCode, [*mixed* $extendsMode])

Compiles a Volt source code returning a PHP plain version



public  **compileString** (*mixed* $viewCode, [*mixed* $extendsMode])

Compiles a template into a string

```php
<?php

echo $compiler->compileString('{{ "hello world" }}');

```



public *string* | *array* **compileFile** (*string* $path, *string* $compiledPath, [*boolean* $extendsMode])

Compiles a template into a file forcing the destination path

```php
<?php

$compiler->compile("views/layouts/main.volt", "views/layouts/main.volt.php");

```



public  **compile** (*mixed* $templatePath, [*mixed* $extendsMode])

Compiles a template into a file applying the compiler options
This method does not return the compiled path if the template was not compiled

```php
<?php

$compiler->compile("views/layouts/main.volt");

require $compiler->getCompiledTemplatePath();

```



public  **getTemplatePath** ()

Returns the path that is currently being compiled



public  **getCompiledTemplatePath** ()

Returns the path to the last compiled template



public *array* **parse** (*string* $viewCode)

Parses a Volt template returning its intermediate representation

```php
<?php

print_r(
    $compiler->parse("{% raw %}{{ 3 + 2 }}{% endraw %}")
);

```



protected  **getFinalPath** (*mixed* $path)

Gets the final path with VIEW



