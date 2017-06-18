# Interface **Phalcon\\DiInterface**

*implements* [ArrayAccess](http://php.net/manual/en/class.arrayaccess.php)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/diinterface.zep" class="btn btn-default btn-sm">Source on GitHub</a>

## Methods
abstract public  **set** (*mixed* $name, *mixed* $definition, [*mixed* $shared])

...


abstract public  **setShared** (*mixed* $name, *mixed* $definition)

...


abstract public  **remove** (*mixed* $name)

...


abstract public  **attempt** (*mixed* $name, *mixed* $definition, [*mixed* $shared])

...


abstract public  **get** (*mixed* $name, [*mixed* $parameters])

...


abstract public  **getShared** (*mixed* $name, [*mixed* $parameters])

...


abstract public  **setRaw** (*mixed* $name, [Phalcon\Di\ServiceInterface](/en/3.1.2/api/Phalcon_Di_ServiceInterface) $rawDefinition)

...


abstract public  **getRaw** (*mixed* $name)

...


abstract public  **getService** (*mixed* $name)

...


abstract public  **has** (*mixed* $name)

...


abstract public  **wasFreshInstance** ()

...


abstract public  **getServices** ()

...


abstract public static  **setDefault** ([Phalcon\DiInterface](/en/3.1.2/api/Phalcon_DiInterface) $dependencyInjector)

...


abstract public static  **getDefault** ()

...


abstract public static  **reset** ()

...


abstract public  **offsetExists** (*mixed* $offset) inherited from [ArrayAccess](http://php.net/manual/en/class.arrayaccess.php)

...


abstract public  **offsetGet** (*mixed* $offset) inherited from [ArrayAccess](http://php.net/manual/en/class.arrayaccess.php)

...


abstract public  **offsetSet** (*mixed* $offset, *mixed* $value) inherited from [ArrayAccess](http://php.net/manual/en/class.arrayaccess.php)

...


abstract public  **offsetUnset** (*mixed* $offset) inherited from [ArrayAccess](http://php.net/manual/en/class.arrayaccess.php)

...


