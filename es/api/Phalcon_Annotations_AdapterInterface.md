# Interfaz **Phalcon\\Annotations\\AdapterInterface**

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/annotations/adapterinterface.zep" class="btn btn-default btn-sm">Código fuente en GitHub</a>

Adaptadores de Phalcon\Annotations debe implementar esta interfaz

## Métodos

abstract public **setReader** ([Phalcon\Annotations\ReaderInterface](/en/3.2/api/Phalcon_Annotations_ReaderInterface) $reader)

Establece el analizador de anotaciones

abstract public **getReader** ()

Devuelve el lector de anotaciones

abstract public **get** (*string|object* $className)

Analiza o recupera todas las anotaciones encontradas en una clase

abstract public **getMethods** (*string* $className)

Devuelve las anotaciones encontradas en todos los métodos de la clase

abstract public **getMethod** (*string* $className, *string* $methodName)

Devuelve las anotaciones encontradas en un método específico

abstract public **getProperties** (*string* $className)

Recupera las anotaciones encontradas en todos los métodos de la clase

abstract public **getProperty** (*string* $className, *string* $propertyName)

Devuelve las anotaciones encontradas en un propiedad específica