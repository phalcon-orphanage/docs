Class **Phalcon\\Mvc\\Collection\\Manager**
===========================================

This components controls the initialization of models, keeping record of relations between the different models of the application.  A CollectionManager is injected to a model via a Dependency Injector Container such as Phalcon\\DI.  

.. code-block:: php

    <?php

     $dependencyInjector = new Phalcon\DI();
    
     $dependencyInjector->set('collectionManager', function(){
          return new Phalcon\Mvc\Collection\Manager();
     });
    
     $robot = new Robots($dependencyInjector);



Methods
---------

public  **__construct** ()

Phalcon\\Mvc\\Collection\\Manager constructor



public  **isInitialized** (*unknown* $collection)

...


public  **initialize** ()

...


