# Clase abstracta **Phalcon\\Annotations\\Adapter**

*implements* [Phalcon\Annotations\AdapterInterface](/[[language]]/[[version]]/api/Phalcon_Annotations_AdapterInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/annotations/adapter.zep" class="btn btn-default btn-sm">Código fuente en GitHub</a>

Esta es la clase base para los adaptadores Phalcon\\Annotations

## Métodos

public **setReader** ([Phalcon\Annotations\ReaderInterface](/[[language]]/[[version]]/api/Phalcon_Annotations_ReaderInterface) $reader)

Establece el analizador de anotaciones

public **getReader** ()

Devuelve el lector de anotaciones

public **get** (*string* | *object* $className)

Analiza o recupera todas las anotaciones encontradas una clase

public **getMethods** (*mixed* $className)

Devuelve las anotaciones encontradas en los métodos de la clase

public **getMethod** (*mixed* $className, *mixed* $methodName)

Devuelve las anotaciones encontradas un método específico

public **getProperties** (*mixed* $className)

Devuelve las anotaciones encontradas en todos los métodos de la clase

public **getProperty** (*mixed* $className, *mixed* $propertyName)

Devuelve las anotaciones que se encuentran en una propiedad específica