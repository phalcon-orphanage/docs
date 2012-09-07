Class **Phalcon\\Version**
==================================================

Provides the current version of the framework. This is useful in a number of
ways such as upgrade scripts, enabling features based on the version of the
framework etc.


Methods
---------

*string* public **get** ()

Returns the version literal of the framework.

.. code-block:: php

    <?php

    echo Phalcon\Version::get(); // 0.5.0 BETA 2

*string* public **getId** ()

Returns the version id of the framework. Although this is a number, it is
returned back as a string, in order to preserve the zeros where necessary. The
version id can be calculated as such

+--------------------+-------------------------------------------------------------------+
| Version            | Description                                                       |
+--------------------+-------------------------------------------------------------------+
| Major version      | One digit, can be 0                                               |
| Medium version     | Two digits. If the version is less than 10, it is prefixed with 0 |
| Minimum version    | Two digits. If the version is less than 10, it is prefixed with 0 |
| Special            | One digit. 1 = 'ALPHA', 2 = 'BETA', 3 = 'RC', 4 = '' (Stable)     |
| Special subversion | One digit, can be 0                                               |
+--------------------+-------------------------------------------------------------------+

.. code-block:: php

    <?php

    // Framework version 0.5.0 BETA 2
    // 0.05.00 2 = Beta, 2 = special subversion
    echo Phalcon\Version::get(); // 0050022

    // Framework version 0.4.5
    // 0.04.05 4 = Stable, 0 = no special subversion
    echo Phalcon\Version::get(); // 0040540

    // Framework version 0.5.1 ALPHA 4
    // 0.05.01 1 = Alpha, 4 = special subversion
    echo Phalcon\Version::get(); // 0050114

    // Framework version 0.5.4 RC 3
    // 0.05.04 3 = RC, 3 = no special subversion
    echo Phalcon\Version::get(); // 0050434




