---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Debug'
---
# Class **Phalcon\Debug**

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/debug.zep)

Bietet Debug-Funktionen für Phalcon Anwendungen

## Methoden

public **setUri** (*mixed* $uri)

Änderung der Basis-URI für statische Ressourcen

public **setShowBackTrace** (*mixed* $showBackTrace)

Legt fest, ob das Ausnahme Backtrace angezeigt werden muss

public **setShowFiles** (*mixed* $showFiles)

Stellen Sie ein, ob Dateien Bestandteil der Backtrace-Ausgabe sein müssen

public **setShowFileFragment** (*mixed* $showFileFragment)

Legt fest, ob Dateien vollständig geöffnet werden und in der Ausgabe angezeigt müssen oder nur das Fragment, welches im Zusammenhang mit der Ausnahme stand

public **listen** ([*mixed* $exceptions], [*mixed* $lowSeverity])

Listen for uncaught exceptions and unsilent notices or warnings

public **listenExceptions** ()

Listen for uncaught exceptions

public **listenLowSeverity** ()

Listen for unsilent notices or warnings

public **halt** ()

Halts the request showing a backtrace

public **debugVar** (*mixed* $varz, [*mixed* $key])

Adds a variable to the debug output

public **clearVars** ()

Clears are variables added previously

protected **_escapeString** (*mixed* $value)

Escapes a string with htmlentities

protected **_getArrayDump** (*array* $argument, [*mixed* $n])

Produces a recursive representation of an array

protected **_getVarDump** (*mixed* $variable)

Produces an string representation of a variable

public **getMajorVersion** ()

Returns the major framework's version

public **getVersion** ()

Generates a link to the current version documentation

public **getCssSources** ()

Gibt die Css-Quellen zurück

public **getJsSources** ()

Gibt die Javascript-Quellen zurück

final protected **showTraceItem** (*mixed* $n, *array* $trace)

Zeigt ein Backtrace-Element an

public **onUncaughtLowSeverity** (*mixed* $severity, *mixed* $message, *mixed* $file, *mixed* $line, *mixed* $context)

Löst eine Ausnahme aus, wenn ein Hinweis oder eine Warnung ausgelöst wird

public **onUncaughtException** ([Exception](https://php.net/manual/en/class.exception.php) $exception)

Behandelt eine nicht abgefangene Ausnahme