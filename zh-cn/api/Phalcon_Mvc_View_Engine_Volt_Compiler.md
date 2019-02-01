---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Mvc\View\Engine\Volt\Compiler'
---
# Class **Phalcon\Mvc\View\Engine\Volt\Compiler**

*implements* [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/view/engine/volt/compiler.zep)

此类读取，并将 Volt 模板编译为 PHP 纯代码

```php
<?php

$compiler = new \Phalcon\Mvc\View\Engine\Volt\Compiler();

$compiler->compile("views/partials/header.volt");

require $compiler->getCompiledTemplatePath();

```

## 方法

public **__construct** ([[Phalcon\Mvc\ViewBaseInterface](Phalcon_Mvc_ViewBaseInterface) $view])

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

设置依赖注入器

public **getDI** ()

返回内部依赖注入器

public **setOptions** (*array* $options)

设置编译器选项

public **setOption** (*string* $option, *mixed* $value)

设置单个编译器选项

public *string* **getOption** (*string* $option)

返回一个编译器选项

public **getOptions** ()

返回的编译器选项

final public *mixed* **fireExtensionEvent** (*string* $name, [*array* $arguments])

Fires an event to registered extensions

public **addExtension** (*mixed* $extension)

注册Volt延伸

public **getExtensions** ()

返回Volt在其中注册的扩展的列表

public **addFunction** (*mixed* $name, *mixed* $definition)

在编译器中注册一个新的函数

public **getFunctions** ()

注册用户注册功能

public **addFilter** (*mixed* $name, *mixed* $definition)

在编译器中注册一个新的筛选器

public **getFilters** ()

注册用户注册筛选器

public **setUniquePrefix** (*mixed* $prefix)

设置要用于编译变量作为前缀的唯一前缀

public **getUniquePrefix** ()

返回唯一的前缀，以作为前缀用于编译的变量和上下文

public **attributeReader** (*array* $expr)

解析属性阅读

public **functionCall** (*array* $expr)

解析函数中间代码进入 PHP 函数调用

public **resolveTest** (*array* $test, *mixed* $left)

解析为一个有效的 PHP 表达式筛选中间代码

final protected **resolveFilter** (*array* $filter, *mixed* $left)

解析筛选中间代码进入 PHP 函数调用

final public **expression** (*array* $expr)

解析表达式节点Volt AST 树中

final protected *string* | *array* **_statementListOrExtends** (*array* $statements)

编译一个语句块

public **compileForeach** (*array* $statement, [*mixed* $extendsMode])

编译成纯 PHP 代码"foreach"中间代码表示

public **compileForElse** ()

生成一个 'forelse' PHP 代码

public **compileIf** (*array* $statement, [*mixed* $extendsMode])

编译 if 语句，返回 PHP 代码

public **compileElseIf** (*array* $statement)

编译"elseif"语句，返回 PHP 代码

public **compileCache** (*array* $statement, [*mixed* $extendsMode])

编译"cache"语句，返回 PHP 代码

public **compileSet** (*array* $statement)

编译"set"的语句，返回 PHP 代码

public **compileDo** (*array* $statement)

编译"do"的语句，返回 PHP 代码

public **compileReturn** (*array* $statement)

编译"return"的语句，返回 PHP 代码

public **compileAutoEscape** (*array* $statement, *mixed* $extendsMode)

"Autoescape"的语句，返回 PHP 代码编译

public *string* **compileEcho** (*array* $statement)

编译一 '{{' '}}' 的语句，返回 PHP 代码

public **compileInclude** (*array* $statement)

编译'include' 的语句，返回 PHP 代码

public **compileMacro** (*array* $statement, *mixed* $extendsMode)

编写宏

public *string* **compileCall** (*array* $statement, *boolean* $extendsMode)

编译对宏的调用

final protected **_statementList** (*array* $statements, [*mixed* $extendsMode])

遍历编译每个节点的语句列表

protected **_compileSource** (*mixed* $viewCode, [*mixed* $extendsMode])

将返回一个 PHP 的普通版本的Volt 源代码编译

public **compileString** (*mixed* $viewCode, [*mixed* $extendsMode])

将模板编译成一个字符串

```php
<?php

echo $compiler->compileString('{{ "hello world" }}');

```

public *string* | *array* **compileFile** (*string* $path, *string* $compiledPath, [*boolean* $extendsMode])

将模板编译成迫使目标路径的文件

```php
<?php

$compiler->compile("views/layouts/main.volt", "views/layouts/main.volt.php");

```

public **compile** (*mixed* $templatePath, [*mixed* $extendsMode])

模板编译文件以应用此方法不返回的已编译的路径，如果模板不编译的编译器选项

```php
<?php

$compiler->compile("views/layouts/main.volt");

require $compiler->getCompiledTemplatePath();

```

public **getTemplatePath** ()

返回当前正在编译的路径

public **getCompiledTemplatePath** ()

返回到上次编译后的模板的路径

public *array* **parse** (*string* $viewCode)

分析Volt 模板返回其中间表示形式

```php
<?php

print_r(
    $compiler->parse("{% raw %}{{ 3 + 2 }}{% endraw %}")
);

```

protected **getFinalPath** (*mixed* $path)

获取与视图的最终路径