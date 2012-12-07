Class **Phalcon\\Mvc\\Collection\\Manager**
===========================================

<<<<<<< HEAD
=======
This components controls the initialization of models, keeping record of relations between the different models of the application.  A CollectionManager is injected to a model via a Dependency Injector Container such as Phalcon\\DI.  

.. code-block:: php

    <?php

     $dependencyInjector = new Phalcon\DI();
    
     $dependencyInjector->set('collectionManager', function(){
          return new Phalcon\Mvc\Collection\Manager();
     });
    
     $robot = new Robots($dependencyInjector);



>>>>>>> 0.7.0
Methods
---------

public  **__construct** ()

<<<<<<< HEAD
...
=======
Phalcon\\Mvc\\Collection\\Manager constructor

>>>>>>> 0.7.0


public  **isInitialized** (*unknown* $collection)

...


public  **initialize** ()

...


