# Class **Phalcon\\Debug\\Dump**

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/debug/dump.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Dumps information about a variable(s)

```php
<?php

$foo = 123;

echo (new \Phalcon\Debug\Dump())->variable($foo, "foo");

```

```php
<?php

$foo = "string";
$bar = ["key" => "value"];
$baz = new stdClass();

echo (new \Phalcon\Debug\Dump())->variables($foo, $bar, $baz);

```


## Methods
public  **getDetailed** ()

...


public  **setDetailed** (*mixed* $detailed)

...


public  **__construct** ([*array* $styles], [*mixed* $detailed])

Phalcon\\Debug\\Dump constructor



public  **all** ()

Alias of variables() method



protected  **getStyle** (*mixed* $type)

Get style for type



public  **setStyles** ([*array* $styles])

Set styles for vars type



public  **one** (*mixed* $variable, [*mixed* $name])

Alias of variable() method



protected  **output** (*mixed* $variable, [*mixed* $name], [*mixed* $tab])

Prepare an HTML string of information about a single variable.



public  **variable** (*mixed* $variable, [*mixed* $name])

Returns an HTML string of information about a single variable.

```php
<?php

echo (new \Phalcon\Debug\Dump())->variable($foo, "foo");

```



public  **variables** ()

Returns an HTML string of debugging information about any number of
variables, each wrapped in a "pre" tag.

```php
<?php

$foo = "string";
$bar = ["key" => "value"];
$baz = new stdClass();

echo (new \Phalcon\Debug\Dump())->variables($foo, $bar, $baz);

```



public  **toJson** (*mixed* $variable)

Returns an JSON string of information about a single variable.

```php
<?php

$foo = [
    "key" => "value",
];

echo (new \Phalcon\Debug\Dump())->toJson($foo);

$foo = new stdClass();
$foo->bar = "buz";

echo (new \Phalcon\Debug\Dump())->toJson($foo);

```



