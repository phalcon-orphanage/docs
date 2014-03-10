%{acl_35d27b8250bff15a9954c9f91a0bb3c9}%
========================
%{acl_adbc41ed0c0c423bf90223c0372e0f78|`Access Control Lists`_}%

%{acl_e52970115d496c048249a820a58b136a}%

%{acl_77f422ae2f33689becc2fff60ab01380}%
---------------
%{acl_82cdf253f5974cfd72e9a832b0ef83a1|:doc:`Phalcon\\Acl <../api/Phalcon_Acl>`}%

.. code-block:: php

    <?php $acl = new \Phalcon\Acl\Adapter\Memory();


%{acl_9ca054c0d303ac1dad25b7beb76c86c7|:doc:`Phalcon\\Acl <../api/Phalcon_Acl>`}%

.. code-block:: php

    <?php

    // {%acl_a2b321754df456f64c5e1ab2fbd3bb6d%}
    $acl->setDefaultAction(Phalcon\Acl::DENY);


%{acl_af39885efdd670a4d3409f86d065352b}%
-----------------------
%{acl_d8b6c24974ec49a7de0931969dbb69c6|:doc:`Phalcon\\Acl\\Role <../api/Phalcon_Acl_Role>`}%

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
%{acl_d0b887d6f2f2316bdcfb3388a5fb7d18|:doc:`Phalcon\\Acl\\Resource <../api/Phalcon_Acl_Resource>`}%

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
%{acl_80a17801e24f2a52b7979f12557663d5|:doc:`Phalcon\\Acl\\Role <../api/Phalcon_Acl_Role>`}%

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
%{acl_67f68b730ec4de1a0cfadeeff91bb0aa|:doc:`Phalcon\\Acl <../api/Phalcon_Acl>`}%

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
%{acl_b7d11adb78dba3c9e8fcc5b19fa49d62|:doc:`Phalcon\\Acl <../api/Phalcon_Acl>`|:doc:`EventsManager <events>`}%

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
%{acl_3f41296882bcc0cbef74b4d784e02dab|:doc:`Phalcon\\Acl\\AdapterInterface <../api/Phalcon_Acl_AdapterInterface>`}%

