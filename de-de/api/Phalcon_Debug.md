* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Debug'

* * *

# Class **Phalcon\Debug**

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/debug.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Provides debug capabilities to Phalcon applications

## Methods

public **setUri** (*mixed* $uri)

Change the base URI for static resources

public **setShowBackTrace** (*mixed* $showBackTrace)

Sets if files the exception's backtrace must be showed

public **setShowFiles** (*mixed* $showFiles)

Set if files part of the backtrace must be shown in the output

public **setShowFileFragment** (*mixed* $showFileFragment)

Sets if files must be completely opened and showed in the output or just the fragment related to the exception

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

Returns the css sources

public **getJsSources** ()

Returns the javascript sources

final protected **showTraceItem** (*mixed* $n, *array* $trace)

Shows a backtrace item

public **onUncaughtLowSeverity** (*mixed* $severity, *mixed* $message, *mixed* $file, *mixed* $line, *mixed* $context)

Throws an exception when a notice or warning is raised

public **onUncaughtException** ([Exception](https://php.net/manual/en/class.exception.php) $exception)

Handles uncaught exceptions