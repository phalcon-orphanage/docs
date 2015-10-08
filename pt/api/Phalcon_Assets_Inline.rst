Class **Phalcon\\Assets\\Inline**
=================================

Represents an inline asset  

.. code-block:: php

    <?php

     $inline = new \Phalcon\Assets\Inline('js', 'alert("hello world");');



Methods
-------

public  **getType** ()

...


public  **getContent** ()

...


public  **getFilter** ()

...


public  **getAttributes** ()

...


public  **__construct** (*string* $type, *string* $content, [*boolean* $filter], [*array* $attributes])

Phalcon\\Assets\\Inline constructor



public  **setType** (*unknown* $type)

Sets the inline's type



public  **setFilter** (*unknown* $filter)

Sets if the resource must be filtered or not



public  **setAttributes** (*unknown* $attributes)

Sets extra HTML attributes



