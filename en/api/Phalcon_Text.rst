Class **Phalcon\\Text**
=======================

Provides utilities when working with strings


Constants
---------

*integer* **RANDOM_ALNUM**

*integer* **RANDOM_ALPHA**

*integer* **RANDOM_HEXDEC**

*integer* **RANDOM_NUMERIC**

*integer* **RANDOM_NOZERO**

Methods
---------

public static *string*  **camelize** (*string* $str)

Converts strings to camelize style 

.. code-block:: php

    <?php

    echo Phalcon\Text::camelize('coco_bongo'); //CocoBongo




public static *string*  **uncamelize** (*string* $str)

Uncamelize strings which are camelized 

.. code-block:: php

    <?php

    echo Phalcon\Text::camelize('CocoBongo'); //coco_bongo




public static *string*  **increment** (*string* $str, [*string* $separator])

Adds a number to a string or increment that number if it already is defined 

.. code-block:: php

    <?php

    echo Phalcon\Text::increment("a"); // "a_1"
      echo Phalcon\Text::increment("a_1"); // "a_2"




public static *string*  **random** (*int* $type, [*int* $length])

Generates a random string based on the given type. Type is one of the RANDOM_* constants 

.. code-block:: php

    <?php

    echo Phalcon\Text::random(Phalcon\Text::RANDOM_ALNUM); //"aloiwkqz"




public static *boolean*  **startsWith** (*string* $str, *string* $start, [*boolean* $ignoreCase])

Check if a string starts with a given string 

.. code-block:: php

    <?php

    echo Phalcon\Text::startsWith("Hello", "He"); // true
      echo Phalcon\Text::startsWith("Hello", "he"); // false
      echo Phalcon\Text::startsWith("Hello", "he", false); // true




public static *boolean*  **endsWith** (*string* $str, *string* $end, [*boolean* $ignoreCase])

Check if a string ends with a given string 

.. code-block:: php

    <?php

    echo Phalcon\Text::endsWith("Hello", "llo"); // true
      echo Phalcon\Text::endsWith("Hello", "LLO"); // false
      echo Phalcon\Text::endsWith("Hello", "LLO", false); // true




public static *string*  **lower** (*string* $str)

Lowecases a string, this function make use of the mbstring extension if available



public static *string*  **upper** (*string* $str)

Uppercases a string, this function make use of the mbstring extension if available



