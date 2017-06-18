Class **Phalcon\\Assets\\Inline**
=================================

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/assets/inline.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Represents an inline asset

.. code-block:: php

    <?php

    $inline = new \Phalcon\Assets\Inline("js", "alert('hello world');");



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



public  **setType** (*mixed* $type)

Sets the inline's type



public  **setFilter** (*mixed* $filter)

Sets if the resource must be filtered or not



public  **setAttributes** (*array* $attributes)

Sets extra HTML attributes



