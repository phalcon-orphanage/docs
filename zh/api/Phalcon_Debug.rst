Class **Phalcon\\Debug**
========================

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/debug.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Provides debug capabilities to Phalcon applications


Methods
-------

public  **setUri** (*unknown* $uri)

Change the base URI for static resources



public  **setShowBackTrace** (*unknown* $showBackTrace)

Sets if files the exception's backtrace must be showed



public  **setShowFiles** (*unknown* $showFiles)

Set if files part of the backtrace must be shown in the output



public  **setShowFileFragment** (*unknown* $showFileFragment)

Sets if files must be completely opened and showed in the output or just the fragment related to the exception



public  **listen** ([*unknown* $exceptions], [*unknown* $lowSeverity])

Listen for uncaught exceptions and unsilent notices or warnings



public  **listenExceptions** ()

Listen for uncaught exceptions



public  **listenLowSeverity** ()

Listen for unsilent notices or warnings



public  **halt** ()

Halts the request showing a backtrace



public  **debugVar** (*unknown* $varz, [*unknown* $key])

Adds a variable to the debug output



public  **clearVars** ()

Clears are variables added previously



protected  **_escapeString** (*unknown* $value)

Escapes a string with htmlentities



protected  **_getArrayDump** (*array* $argument, [*unknown* $n])

Produces a recursive representation of an array



protected  **_getVarDump** (*unknown* $variable)

Produces an string representation of a variable



public  **getMajorVersion** ()

Returns the major framework's version



public  **getVersion** ()

Generates a link to the current version documentation



public  **getCssSources** ()

Returns the css sources



public  **getJsSources** ()

Returns the javascript sources



final protected  **showTraceItem** (*unknown* $n, *array* $trace)

Shows a backtrace item



public  **onUncaughtLowSeverity** (*unknown* $severity, *unknown* $message, *unknown* $file, *unknown* $line)

Throws an exception when a notice or warning is raised



public  **onUncaughtException** (*Exception* $exception)

Handles uncaught exceptions



