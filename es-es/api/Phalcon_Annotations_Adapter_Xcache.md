* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Annotations\Adapter\Xcache'

* * *

# Class **Phalcon\Annotations\Adapter\Xcache**

*extends* abstract class [Phalcon\Annotations\Adapter](/4.0/en/api/Phalcon_Annotations_Adapter)

*implements* [Phalcon\Annotations\AdapterInterface](/4.0/en/api/Phalcon_Annotations_AdapterInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/annotations/adapter/xcache.zep" class="btn btn-default btn-sm">Código fuente en GitHub</a>

Almacena las anotaciones analizadas en XCache. Este adaptador es adecuado para producción

```php
<?php

$annotations = new \Phalcon\Annotations\Adapter\Xcache();

```

## Métodos

public [Phalcon\Annotations\Reflection](/4.0/en/api/Phalcon_Annotations_Reflection) **read** (*string* $key)

Lee las anotaciones analizadas desde el XCache

public **write** (*mixed* $key, [Phalcon\Annotations\Reflection](/4.0/en/api/Phalcon_Annotations_Reflection) $data)

Escribe la anotaciones analizadas en el XCache

public **setReader** ([Phalcon\Annotations\ReaderInterface](/4.0/en/api/Phalcon_Annotations_ReaderInterface) $reader) inherited from [Phalcon\Annotations\Adapter](/4.0/en/api/Phalcon_Annotations_Adapter)

Establece el analizador de anotaciones

public **getReader** () inherited from [Phalcon\Annotations\Adapter](/4.0/en/api/Phalcon_Annotations_Adapter)

Devuelve el lector de anotaciones

public **get** (*string* | *object* $className) inherited from [Phalcon\Annotations\Adapter](/4.0/en/api/Phalcon_Annotations_Adapter)

Analiza o recupera todas las anotaciones encontradas una clase

public **getMethods** (*mixed* $className) inherited from [Phalcon\Annotations\Adapter](/4.0/en/api/Phalcon_Annotations_Adapter)

Devuelve las anotaciones encontradas en los métodos de la clase

public **getMethod** (*mixed* $className, *mixed* $methodName) inherited from [Phalcon\Annotations\Adapter](/4.0/en/api/Phalcon_Annotations_Adapter)

Devuelve las anotaciones encontradas un método específico

public **getProperties** (*mixed* $className) inherited from [Phalcon\Annotations\Adapter](/4.0/en/api/Phalcon_Annotations_Adapter)

Devuelve las anotaciones encontradas en los métodos de la clase

public **getProperty** (*mixed* $className, *mixed* $propertyName) inherited from [Phalcon\Annotations\Adapter](/4.0/en/api/Phalcon_Annotations_Adapter)

Devuelve las anotaciones que se encuentran en una propiedad específica