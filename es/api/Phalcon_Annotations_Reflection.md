# Clase **Phalcon\\Annotations\\Reflection**

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/annotations/reflection.zep" class="btn btn-default btn-sm">Código fuente en GitHub</a>

Permite manipular la reflexión de las anotaciones en una forma Orientada a Objectos

```php
<?php

use Phalcon\Annotations\Reader;
use Phalcon\Annotations\Reflection;

// Analizar las anotaciones en una clase
$reader = new Reader();
$parsing = $reader->parse("MyComponent");

// Crear la Reflexión 
$reflection = new Reflection($parsing);

// Obtener las anotaciones en la clase docblock
$classAnnotations = $reflection->getClassAnnotations();

```

## Métodos

public **__construct** ([*array* $reflectionData])

Constructor de Phalcon\\Annotations\\Reflection

public **getClassAnnotations** ()

Devuelve las anotaciones encontradas en la clase docblock

public **getMethodsAnnotations** ()

Devuelve las anotaciones encontradas en los métodos de docblocks

public **getPropertiesAnnotations** ()

Devuelve las anotaciones encontradas en las propiedades de docblocks

public *array* **getReflectionData** ()

Devuelve las definiciones intermedias usadas en el análisis para construir la reflexión

public static *array data* **__set_state** (*mixed* $data)

Restaura el estado de la exportación de una variable Phalcon\\Annotations\\Reflection