# Clase **Phalcon\\Annotations\\Reader**

*implements* [Phalcon\Annotations\ReaderInterface](/[[language]]/[[version]]/api/Phalcon_Annotations_ReaderInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/annotations/reader.zep" class="btn btn-default btn-sm">Código fuente en GitHub</a>

Analiza los docblocks para devolver un arreglo con las anotaciones encontradas

## Métodos

public **parse** (*mixed* $className)

Lee las anotaciones de la clase dockblocks, sus métodos y/o propiedades

public static **parseDocBlock** (*mixed* $docBlock, [*mixed* $file], [*mixed* $line])

Procesa un bloque doc en crudo regresando las anotaciones encontradas