Class **Phalcon\\Text**
=======================

Provides utilities when working with strings that contain underscores and camel case notations.

Methods
---------

public static *string*  **camelize** (*string* $str)

Provides a similar functionality as ucwords_ but uses the underscore as a separator instead of a space to separate words.

.. code-block:: php

    <?php Phalcon_Text::camelize('coco_bongo'); //CocoBongo


public static **string** **uncamelize** (string $str)

Opposite of **camelize**

.. code-block:: php

    <?php

    echo Phalcon\Text::uncamelize('CocoBongo'); //coco_bongo

.. _ucwords: http://php.net/manual/en/function.ucwords.php

