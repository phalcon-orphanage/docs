---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Debug'
---
# Class **Phalcon\Debug**

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/debug.zep)

Proporciona capacidades de depuración para aplicaciones Phalcon

## Métodos

public **setUri** (*mixed* $uri)

Cambiar el URI base para recursos estáticos

public **setShowBackTrace** (*mixed* $showBackTrace)

Establece si los archivos deben mostrar la traza inversa de la excepción

public **setShowFiles** (*mixed* $showFiles)

Establezca si los archivos que forman parte de la traza inversa se deben mostrar en la salida

public **setShowFileFragment** (*mixed* $showFileFragment)

Establece si los archivos deben estar completamente abiertos y se muestran en la salida o solo el fragmento relacionado con la excepción

public **listen** ([*mixed* $exceptions], [*mixed* $lowSeverity])

Escuche las excepciones no detectadas y avisos o advertencias insensibles

public **listenExceptions** ()

Escuche las excepciones no detectadas

public **listenLowSeverity** ()

Escucha notificaciones sonoras o advertencias

public **halt** ()

Detiene la solicitud mostrando una traza inversa

public **debugVar** (*mixed* $varz, [*mixed* $key])

Agrega una variable a la salida de depuración

public **clearVars** ()

Anula las variables añadidas previamente

protected **_escapeString** (*mixed* $value)

Escapa una cadena con htmlentities

protected **_getArrayDump** (*array* $argument, [*mixed* $n])

Produce una representación recursiva de una matriz

protected **_getVarDump** (*mixed* $variable)

Produce una representación de cadena de una variable

public **getMajorVersion** ()

Returns the major framework's version

public **getVersion** ()

Genera un enlace a la documentación de la versión actual

public **getCssSources** ()

Devuelve las fuentes css

public **getJsSources** ()

Devuelve las fuentes javascript

final protected **showTraceItem** (*mixed* $n, *array* $trace)

Muestra un elemento de seguimiento

public **onUncaughtLowSeverity** (*mixed* $severity, *mixed* $message, *mixed* $file, *mixed* $line, *mixed* $context)

Produce una excepción cuando aparece una notificación o advertencia

public **onUncaughtException** ([Exception](https://php.net/manual/en/class.exception.php) $exception)

Maneja las excepciones no detectadas