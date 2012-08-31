Class **Phalcon\\Session**
==========================

Phalcon\\Session   Session client-server persistent state data management. This component  allows you to separate your session data between application or modules.  With this, it's possible to use the same index to refer a variable  but they can be in different applications.   

.. code-block:: php

    <?php

    
     $session = new Phalcon\Session\Adapter\Files(array(
        'uniqueId' => 'my-private-app'
     ));
    
     $session->start();
    
     $session->set('var', 'some-value');
    
     echo $session->get('var');
     





Methods
---------

**__construct** (*unknown* **$options**)

**start** ()

**setOptions** (*array* **$options**)

**getOptions** ()

**get** (*string* **$index**)

**set** (*string* **$index**, *string* **$value**)

**has** (*string* **$index**)

**remove** (*string* **$index**)

*string* **getId** ()

**isStarted** ()

**destroy** ()

