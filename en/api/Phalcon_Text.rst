Class **Phalcon\\Text**
=======================

Provides utilities when working with strings


Methods
---------

*string* public static **camelize** (*string* $str)

Converts strings to camelize style 

.. code-block:: php

    <?php

    Phalcon\Text::camelize('coco_bongo'); //CocoBongo




*string* public static **uncamelize** (*string* $str)

Uncamelize strings which are camelized 

.. code-block:: php

    <?php

    Phalcon\Text::uncamelize('CocoBongo'); //coco_bongo




