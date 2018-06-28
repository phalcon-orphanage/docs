# Interfaz **Phalcon\\Annotations\\ReaderInterface**

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/annotations/readerinterface.zep" class="btn btn-default btn-sm">Código fuente en GitHub</a>

## Métodos

abstract public **parse** (*mixed* $className)

Lee las anotaciones de la clase dockblocks, sus métodos y/o propiedades

abstract public static **parseDocBlock** (*mixed* $docBlock, [*mixed* $file], [*mixed* $line])

Procesa un bloque doc en bruto regresando las anotaciones encontradas