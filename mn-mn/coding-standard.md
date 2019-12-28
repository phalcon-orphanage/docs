---
layout: default
language: 'en'
version: '4.0'
title: 'Coding Standard'
keywords: 'coding standard, zephir'
---

# Phalcon Coding Standard

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

Last update: 2019-07-04

Phalcon is written in [Zephir](https://zephir-lang.com), a language that the Phalcon Team invented and is actively developing. Therefore, there are no established coding standards that developers can follow, should they wish to.

In this document we outline the coding standard that Phalcon is using for editing Zephir files. The coding standard is a variant of [PSR-12](https://www.php-fig.org/psr/psr-12/) developed by [PHP-FIG](https://www.php-fig.org/)

## Files

- Files must use only UTF-8 without BOM.
- File names must be named StudlyCaps.
- All files must use the Unix LF (linefeed) line ending.
- All files must end with a single blank line.
- Folders are also named StudlyCaps and the folder/subfolder tree follows the namespace of the class.

```php
phalcon/Acl/Adapter/Memory.zep
```

```php
namespace Phalcon\Acl\Adapter;

use Phalcon\Acl\Adapter;

class Memory extends Adapter
{

}
```

- Code must use 4 spaces for indenting, not tabs.
- Lines should be 80 characters or less. The hard limit on line length is 120 characters.
- There must be one blank line after the namespace declaration, and there must be one blank line after the block of use declarations.
- There must not be trailing whitespace at the end of non-blank lines.
- Blank lines may be added to improve readability and to indicate related blocks of code.
- There must not be more than one statement per line.

## Classes

- Class names must be declared in StudlyCaps.
- Opening braces for classes must go on the next line, and closing braces must go on the next line after the body.
- Abstract classes must be prefixed by `Abstract`
- Interfaces must be suffixed by `Interface`

### Constants

- Class constants must be declared in all upper case with underscore separators.
- Class constants must appear at the top of the class.
- Class constants must be sorted alphabetically by constant name.

```php
namespace Phalcon\Acl;

class Enum
{
    const ALLOW = 1;
    const DENY  = 0;
}
```

### Properties

- Class properties must be declared in camelCase.
- Class properties must be sorted alphabetically based on name.
- Whenever possible, properties must have a default value.
- Whenever possible, properties must have a docblock that defines their type with the `@var` declaration.
- Properties must not be prefixed with underscore `_`. The only exception is if the property name is a reserved keyword such as `default`, `namespace` etc.

```php
namespace Phalcon\Acl\Adapter;

use Phalcon\Acl\Adapter;

class Memory extends Adapter
{
    /**
     * Returns latest key used to acquire access
     *
     * @var string | null
     */
    protected activeKey = "" { get };
}
```

### Methods

- Method names must be declared in camelCase.
- Methods must be sorted alphabetically and based on their visibility. The order is `public`, `protected` and `private`. `__construct` if defined must be at the top of the class.
- Method names must not be prefixed with underscore `_`.
- All methods must have a return type. If the method does not return anything it should be marked `void`
- Opening braces for methods must go on the next line, and closing braces must go on the next line after the body.
- Visibility must be declared on all properties and methods; `abstract` and `final` must be declared before the visibility; `static` must be declared after the visibility.

```php
abstract public function getElement() -> var;

final public function getElement() -> var;

public static function getElement() -> var;
```

- Control structure keywords must have one space after them; method and function calls must not.
- Opening braces for control structures must go on the same line, and closing braces must go on the next line after the body.
- Control structures such as `if` must not have parentheses around the conditional, unless it is a complex one.

```php
if typeof variable === "array" {

}
```

### Method Arguments

- In the argument list, there must not be a space before each comma, and there must be one space after each comma.
- Each method must have its type declared before it
- Method arguments with default values must go at the end of the argument list.

```php
public function setElement(string! name, var value) -> void;
```

- Argument lists MAY be split across multiple lines, where each subsequent line is indented once. When doing so, the first item in the list must be on the next line, and there must be only one argument per line.

### PHP Files

PHP files such as tests must follow [PSR-12](https://www.php-fig.org/psr/psr-12/).