Unit testing
============
Writing proper tests can assist in writing better software. If you set up proper test cases you can elimitate most 
functional bugs and better maintain your software.

Integrating PHPunit with phalcon
--------------------------------
If you don't already have phpunit installed, you can do it by using the following composer command:

.. code-block:: bash

  composer require phpunit/phpunit


or by manually adding it to composer.json:

.. code-block:: json

  {
      "require-dev": {
          "phpunit/phpunit": "3.7.*"
      }
  }


Or if you don't have composer you can install phpunit via pear:

.. code-block:: bash

  pear config-set auto_discover 1
  pear install pear.phpunit.de/PHPUnit
