---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\DiInterface'
---
# Interface **Phalcon\DiInterface**

*implements* [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/diinterface.zep)

## Metode

abstraksi umum **set** (*campuran* $name, *campuran* $definition, [*campuran* $shared])

...

abstraksi umum **setShared** (*campuran* $name, *campuran* $definition)

...

abstraksi umum **hapus** (*campuran* $name)

...

abstraksi umum**mencoba** (*campuran* $name, *campuran* $definition, [*mixed* $shared])

...

abstraksi umum **dapatkan** (*campuran* $name, [*campuran* $parameters])

...

abstraksi umum **getShared** (*mixed* $name, [*mixed* $parameters])

...

abstract public **setRaw** (*mixed* $name, [Phalcon\Di\ServiceInterface](Phalcon_Di_ServiceInterface) $rawDefinition)

...

abstraksi umum **getMentah** (*dicampur* $name)

...

abstraksi umum **getLayanan** (*dicampur* $name)

...

abstraksi umum **has** (*mixed* $name)

...

abstraksi umum **wasFreshInstance** ()

...

abstraksi umum **getServices** ()

...

abstract public static **setDefault** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

...

abstraksi umum statik**getDefault** ()

...

publik static **reset** ()

...

abstract public **offsetExists** (*mixed* $offset) inherited from [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php)

...

abstract public **offsetGet** (*mixed* $offset) inherited from [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php)

...

abstract public **offsetSet** (*mixed* $offset, *mixed* $value) inherited from [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php)

...

abstract public **offsetUnset** (*mixed* $offset) inherited from [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php)

...