* * *

layout: default language: 'en' version: '3.4' title: 'Phalcon\Annotations\ReaderInterface'

* * *

# Interface **Phalcon\Annotations\ReaderInterface**

<a href="https://github.com/phalcon/cphalcon/tree/v3.4.0/phalcon/annotations/readerinterface.zep" class="btn btn-default btn-sm">Código fuente en GitHub</a>

## Métodos

abstract public **parse** (*mixed* $className)

Lee las anotaciones de la clase dockblocks, sus métodos y/o propiedades

abstract public static **parseDocBlock** (*mixed* $docBlock, [*mixed* $file], [*mixed* $line])

Procesa un bloque doc en bruto regresando las anotaciones encontradas