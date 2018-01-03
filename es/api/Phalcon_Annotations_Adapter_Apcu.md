# Clase **Phalcon\\Annotations\\Adapter\\Apcu**

*extiende* abstract class [Phalcon\Annotations\Adapter](/en/3.2/api/Phalcon_Annotations_Adapter)

*implementa* [Phalcon\Annotations\AdapterInterface](/en/3.2/api/Phalcon_Annotations_AdapterInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/annotations/adapter/apcu.zep" class="btn btn-default btn-sm">Codigo fuente en GitHub</a>

Guarda las anotaciones analizadas en APCu. Este adaptador es adecuado para producción

```php
<?php

use Phalcon\Annotations\Adapter\Apcu;

$annotations = new Apcu();

```

## Métodos

public **__construct** ([*array* $options])

Constructor de Phalcon\\Annotations\\Adapter\\Apcu

public **read** (*mixed* $key)

Lee anotaciones analizadas desde APCu

public **write** (*mixed* $key, [Phalcon\Annotations\Reflection](/en/3.2/api/Phalcon_Annotations_Reflection) $data)

Escribe anotaciones analizadas en APCu

public **setReader** ([Phalcon\Annotations\ReaderInterface](/en/3.2/api/Phalcon_Annotations_ReaderInterface) $reader) inherited from [Phalcon\Annotations\Adapter](/en/3.2/api/Phalcon_Annotations_Adapter)

Establece el analizador de anotaciones

public **getReader** () inherited from [Phalcon\Annotations\Adapter](/en/3.2/api/Phalcon_Annotations_Adapter)

Devuelve el lector de anotaciones

public **get** (*string* | *object* $className) inherited from [Phalcon\Annotations\Adapter](/en/3.2/api/Phalcon_Annotations_Adapter)

Analiza o recupera todas las anotaciones encontradas una clase

public **getMethods** (*mixed* $className) inherited from [Phalcon\Annotations\Adapter](/en/3.2/api/Phalcon_Annotations_Adapter)

Devuelve las anotaciones encontradas en todos los métodos de la clase

public **getMethod** (*mixed* $className, *mixed* $methodName) inherited from [Phalcon\Annotations\Adapter](/en/3.2/api/Phalcon_Annotations_Adapter)

Devuelve las anotaciones encontradas un método específico

public **getProperties** (*mixed* $className) inherited from [Phalcon\Annotations\Adapter](/en/3.2/api/Phalcon_Annotations_Adapter)

Devuelve las anotaciones encontradas en todos los métodos de la clase

public **getProperty** (*mixed* $className, *mixed* $propertyName) inherited from [Phalcon\Annotations\Adapter](/en/3.2/api/Phalcon_Annotations_Adapter)

Devuelve las anotaciones que se encuentran en una propiedad específica