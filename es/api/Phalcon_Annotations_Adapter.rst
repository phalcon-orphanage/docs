Abstract class **Phalcon\\Annotations\\Adapter**
================================================

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/annotations/adapter.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

This is the base class for Phalcon\\Annotations adapters


Methods
-------

public  **setReader** (*unknown* $reader)

Sets the annotations parser



public  **getReader** ()

Returns the annotation reader



public  **get** (*string|object* $className)

Parses or retrieves all the annotations found in a class



public  **getMethods** (*unknown* $className)

Returns the annotations found in all the class' methods



public  **getMethod** (*unknown* $className, *unknown* $methodName)

Returns the annotations found in a specific method



public  **getProperties** (*unknown* $className)

Returns the annotations found in all the class' methods



public  **getProperty** (*unknown* $className, *unknown* $propertyName)

Returns the annotations found in a specific property



