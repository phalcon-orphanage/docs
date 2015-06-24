Class **Phalcon\\Version**
==========================

This class allows to get the installed version of the framework


Constants
---------

*integer* **VERSION_MAJOR**

*integer* **VERSION_MEDIUM**

*integer* **VERSION_MINOR**

*integer* **VERSION_SPECIAL**

*integer* **VERSION_SPECIAL_NUMBER**

Methods
-------

protected static  **_getVersion** ()

Area where the version number is set. The format is as follows: ABBCCDE A - Major version B - Med version (two digits) C - Min version (two digits) D - Special release: 1 = Alpha, 2 = Beta, 3 = RC, 4 = Stable E - Special release version i.e. RC1, Beta2 etc.



final protected static *string*  **_getSpecial** (*unknown* $special)

Translates a number to a special release If Special release = 1 this function will return ALPHA



public static *string*  **get** ()

Returns the active version (string) 

.. code-block:: php

    <?php

     echo Phalcon\Version::get();




public static *string*  **getId** ()

Returns the numeric active version 

.. code-block:: php

    <?php

     echo Phalcon\Version::getId();




public static *string*  **getPart** (*unknown* $part)

Returns a specific part of the version. If the wrong parameter is passed it will return the full version 

.. code-block:: php

    <?php

     echo Phalcon\Version::getPart(Phalcon\Version::VERSION_MAJOR);




