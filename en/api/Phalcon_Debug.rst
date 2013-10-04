Class **Phalcon\\Debug**
========================

Provides debug capabilities to Phalcon applications


Methods
---------

public :doc:`Phalcon\\Debug <Phalcon_Debug>`  **setUri** (*string* $uri)

Change the base URI for static resources



public :doc:`Phalcon\\Debug <Phalcon_Debug>`  **setShowBackTrace** (*boolean* $showBackTrace)

Sets if files the exception's backtrace must be showed



public :doc:`Phalcon\\Debug <Phalcon_Debug>`  **setShowFiles** (*boolean* $showFiles)

Set if files part of the backtrace must be shown in the output



public :doc:`Phalcon\\Debug <Phalcon_Debug>`  **setShowFileFragment** (*boolean* $showFileFragment)

Sets if files must be completely opened and showed in the output or just the fragment related to the exception



public :doc:`Phalcon\\Debug <Phalcon_Debug>`  **listen** ([*boolean* $exceptions], [*boolean* $lowSeverity])

Listen for uncaught exceptions and unsilent notices or warnings



public :doc:`Phalcon\\Debug <Phalcon_Debug>`  **listenExceptions** ()

Listen for uncaught exceptions



public :doc:`Phalcon\\Debug <Phalcon_Debug>`  **listenLowSeverity** ()

Listen for unsilent notices or warnings



public :doc:`Phalcon\\Debug <Phalcon_Debug>`  **debugVar** (*mixed* $var, [*string* $key])

Adds a variable to the debug output



public :doc:`Phalcon\\Debug <Phalcon_Debug>`  **clearVars** ()

Clears are variables added previously



protected *string*  **_escapeString** ()

Escapes a string with htmlentities



protected *string*  **_getArrayDump** ()

Produces a recursive representation of an array



protected *string*  **_getVarDump** ()

Produces an string representation of a variable



public *string*  **getMajorVersion** ()

Returns the major framework's version



public *string*  **getVersion** ()

Generates a link to the current version documentation



public *string*  **getCssSources** ()

Returns the css sources



public *string*  **getJsSources** ()

Returns the javascript sources



protected  **showTraceItem** ()

Shows a backtrace item



public *boolean*  **onUncaughtException** (*\Exception* $exception)

Handles uncaught exceptions



public *string*  **getCharset** ()

Returns the character set used to display the HTML



public *\Phalcon\Debug*  **setCharset** (*string* $charset)

Sets the character set used to display the HTML



public *int*  **getLinesBeforeContext** ()

Returns the number of lines deplayed before the error line



public *\Phalcon\Debug*  **setLinesBeforeContext** (*int* $lines)

Sets the number of lines deplayed before the error line



public *int*  **getLinesAfterContext** ()

Returns the number of lines deplayed after the error line



public *\Phalcon\Debug*  **setLinesAfterContext** (*int* $lines)

Sets the number of lines deplayed after the error line



