%{acl_35d27b8250bff15a9954c9f91a0bb3c9}%
========================
%{acl_2a30f41cd27cd899f81c88a54afd85cd|`Access Control Lists`_}%

%{acl_e52970115d496c048249a820a58b136a}%

%{acl_77f422ae2f33689becc2fff60ab01380}%
---------------
%{acl_71605548bf520a6eff06143df6854839|:doc:`Phalcon\\Acl <../api/Phalcon_Acl>`}%

.. code-block:: php

    <?php $acl = new \Phalcon\Acl\Adapter\Memory();


%{acl_53882344e1e60a232a7ae2ffce30b5fc|:doc:`Phalcon\\Acl <../api/Phalcon_Acl>`}%

.. code-block:: php

    <?php

    // {%acl_a2b321754df456f64c5e1ab2fbd3bb6d%}
    $acl->setDefaultAction(Phalcon\Acl::DENY);


%{acl_af39885efdd670a4d3409f86d065352b}%
-----------------------
%{acl_123734cf6682f2bc6aa51eb25eff5c38|:doc:`Phalcon\\Acl\\Role <../api/Phalcon_Acl_Role>`}%

.. code-block:: php

    <?php

    // {%acl_21e051ef1d092d0b1a5ddec0bef33b9c%}
    $roleAdmins = new \Phalcon\Acl\Role("Administrators", "Super-User role");
    $roleGuests = new \Phalcon\Acl\Role("Guests");

    // {%acl_e497d9691f5d8e2fc5cb41d685a2145a%}
    $acl->addRole($roleGuests);

    // {%acl_bb6b83d94014dcfdfaa487d4e35babd4%}
    $acl->addRole("Designers");


%{acl_b280833c0715b119a7989f7d286b737f}%

%{acl_647e8a84d61a2443e8d863a01727bdb8}%
----------------
%{acl_44815dee9a04e5f25832fdf831999b6f|:doc:`Phalcon\\Acl\\Resource <../api/Phalcon_Acl_Resource>`}%

.. code-block:: php

    <?php

    // {%acl_f274c5592fac24c04d7113d3844cbdd9%}
    $customersResource = new \Phalcon\Acl\Resource("Customers");

    // {%acl_bc727b5dce45b9c2738dbf9fa8f93676%}
    $acl->addResource($customersResource, "search");
    $acl->addResource($customersResource, array("create", "update"));


%{acl_39f1b51bee0b3e71aa72bd338104fca6}%
------------------------
%{acl_ed44085894ac59a68ac1ca5315ff73f1}%

.. code-block:: php

    <?php

    // {%acl_4b17262ed636f44d00c8e917dacad39e%}
    $acl->allow("Guests", "Customers", "search");
    $acl->allow("Guests", "Customers", "create");
    $acl->deny("Guests", "Customers", "update");


%{acl_ce64c2a97332ea72b17dda609ac2f361}%

%{acl_a5b93a112061fdc9876d21f96101e20e}%
---------------
%{acl_9f89b2d7a704bda130e600b7aef4063e}%

.. code-block:: php

    <?php

    // {%acl_ce3445ff79c3445a6db89250e0049b3f%}
    $acl->isAllowed("Guests", "Customers", "edit");   //{%acl_0b2da28a441d04619e64bdbd1693747c%}
    $acl->isAllowed("Guests", "Customers", "search"); //{%acl_691d9ca32d3773a83b41f05322d4c409%}
    $acl->isAllowed("Guests", "Customers", "create"); //{%acl_691d9ca32d3773a83b41f05322d4c409%}


%{acl_8a27d9b40bc8d803daea548f997357b7}%
-----------------
%{acl_419fbe2d0531c90e20470119e454dd77|:doc:`Phalcon\\Acl\\Role <../api/Phalcon_Acl_Role>`}%

.. code-block:: php

    <?php

    // {%acl_21e051ef1d092d0b1a5ddec0bef33b9c%}
    $roleAdmins = new \Phalcon\Acl\Role("Administrators", "Super-User role");
    $roleGuests = new \Phalcon\Acl\Role("Guests");

    // {%acl_e497d9691f5d8e2fc5cb41d685a2145a%}
    $acl->addRole($roleGuests);

    // {%acl_088f8b957b4a2224e07d2d0ae5382ffd%}
    $acl->addRole($roleAdmins, $roleGuests);


%{acl_12624f31b9a5c9d94c4533f8f8b52c42}%
---------------------
%{acl_0d5458e2758bbbb7f55b22ae4a1826b2|:doc:`Phalcon\\Acl <../api/Phalcon_Acl>`}%

.. code-block:: php

    <?php

    //{%acl_c55dd0db3e994683568f64d1ea2842d3%}
    if (!file_exists("app/security/acl.data")) {

        $acl = new \Phalcon\Acl\Adapter\Memory();

        //{%acl_6767be5450af756eddedcce3ca428b19%}

        // {%acl_42e15baacf37e48c8b6b0fc3d685343a%}
        file_put_contents("app/security/acl.data", serialize($acl));

    } else {

         //{%acl_6f3131205fcad5ed8c2c9a9d1dd15f19%}
         $acl = unserialize(file_get_contents("app/security/acl.data"));
    }

    // {%acl_2d332db098013fb168ecca2f52d5d3b1%}
    if ($acl->isAllowed("Guests", "Customers", "edit")) {
        echo "Access granted!";
    } else {
        echo "Access denied :(";
    }


%{acl_5ec3a4b22225d07937424121b51b1319}%
----------
%{acl_fda3b0872c136bf2722ea7748b2db904|:doc:`Phalcon\\Acl <../api/Phalcon_Acl>`|:doc:`EventsManager <events>`}%

+----------------------+------------------------------------------------------------+---------------------+
| Event Name           | Triggered                                                  | Can stop operation? |
+======================+============================================================+=====================+
| beforeCheckAccess    | Triggered before checking if a role/resource has access    | Yes                 |
+----------------------+------------------------------------------------------------+---------------------+
| afterCheckAccess     | Triggered after checking if a role/resource has access     | No                  |
+----------------------+------------------------------------------------------------+---------------------+


%{acl_4eb434eb37be7b4a57c178fa4af88c76}%

.. code-block:: php

    <?php

    //{%acl_41b79f8cf8c0967be09fcf51a7674d17%}
    $eventsManager = new Phalcon\Events\Manager();

    //{%acl_858f186aeef8329bf7131c4abdfb4c4a%}
    $eventsManager->attach("acl", function($event, $acl) {
        if ($event->getType() == 'beforeCheckAccess') {
             echo   $acl->getActiveRole(),
                    $acl->getActiveResource(),
                    $acl->getActiveAccess();
        }
    });

    $acl = new \Phalcon\Acl\Adapter\Memory();

    //{%acl_cfa3b815c7d6f73ea6e0098449910686%}
    //...

    //{%acl_51961227af6de88a757992584152f3e7%}
    $acl->setEventsManager($eventManagers);


%{acl_206bd6266ccc781d8844f3db2de5d557}%
------------------------------
%{acl_5c9687621eeedf30792938d48fea3cdf|:doc:`Phalcon\\Acl\\AdapterInterface <../api/Phalcon_Acl_AdapterInterface>`}%

