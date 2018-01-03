# Clase **Phalcon\\Annotations\\Adapter\\Files**

*extiende* abstract class [Phalcon\Annotations\Adapter](/en/3.2/api/Phalcon_Annotations_Adapter)

*implementa* [Phalcon\Annotations\AdapterInterface](/en/3.2/api/Phalcon_Annotations_AdapterInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/annotations/adapter/files.zep" class="btn btn-default btn-sm">Código fuente en GitHub</a>

Guarda las anotaciones analizadas en los archivos. Este adaptador es adecuado para producción

```php
<?php

use Phalcon\Annotations\Adapter\Files;

$annotations = new Files(
    [
        "annotationsDir" => "app/cache/annotations/",
    ]
);

```

## Métodos

public **__construct** ([*array* $options])

Constructor de Phalcon\\Annotations\\Adapter\\Files

public [Phalcon\Annotations\Reflection](/en/3.2/api/Phalcon_Annotations_Reflection) **read** (*string* $key)

Lee las anotaciones analizadas desde archivos

public **write** (*mixed* $key, [Phalcon\Annotations\Reflection](/en/3.2/api/Phalcon_Annotations_Reflection) $data)

Escribe las anotaciones analizadas en archivos

public **setReader** ([Phalcon\Annotations\ReaderInterface](/en/3.2/api/Phalcon_Annotations_ReaderInterface) $reader) heredado de [Phalcon\Annotations\Adapter](/en/3.2/api/Phalcon_Annotations_Adapter)

Establece el analizador de anotaciones

public **getReader** () heredado de [Phalcon\Annotations\Adapter](/en/3.2/api/Phalcon_Annotations_Adapter)

Devuelve el lector de anotaciones

public **get** (*string* | *object* $className) heredado de [Phalcon\Annotations\Adapter](/en/3.2/api/Phalcon_Annotations_Adapter)

Analiza o recupera todas las anotaciones encontradas una clase

public **getMethods** (*mixed* $className) heredado de [Phalcon\Annotations\Adapter](/en/3.2/api/Phalcon_Annotations_Adapter)

Devuelve las anotaciones encontradas en todos los métodos de la clase

public **getMethod** (*mixed* $className, *mixed* $methodName) heredado de [Phalcon\Annotations\Adapter](/en/3.2/api/Phalcon_Annotations_Adapter)

Devuelve las anotaciones encontradas un método específico

public **getProperties** (*mixed* $className) heredado de [Phalcon\Annotations\Adapter](/en/3.2/api/Phalcon_Annotations_Adapter)

Devuelve las anotaciones encontradas en todos los métodos de la clase

public **getProperty** (*mixed* $className, *mixed* $propertyName) heredado de [Phalcon\Annotations\Adapter](/en/3.2/api/Phalcon_Annotations_Adapter)

Devuelve las anotaciones que se encuentran en una propiedad específica