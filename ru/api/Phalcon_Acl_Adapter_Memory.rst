Class **Phalcon\\Acl\\Adapter\\Memory**
=======================================

*extends* class :doc:`Phalcon\\Acl\\Adapter <Phalcon_Acl_Adapter>`

Manages ACL lists in memory  

.. code-block:: php

    <?php

    $acl = new \Phalcon\Acl\Adapter\Memory();
    
    $acl->setDefaultAction(Phalcon\Acl::DENY);
    
    //Register roles
    $roles = array(
    	'users' => new \Phalcon\Acl\Role('Users'),
    	'guests' => new \Phalcon\Acl\Role('Guests')
    );
    foreach ($roles as $role) {
    	$acl->addRole($role);
    }
    
    //Private area resources
    $privateResources = array(
    	'companies' => array('index', 'search', 'new', 'edit', 'save', 'create', 'delete'),
    	'products' => array('index', 'search', 'new', 'edit', 'save', 'create', 'delete'),
    	'invoices' => array('index', 'profile')
    );
    foreach ($privateResources as $resource => $actions) {
    	$acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
    }
    
    //Public area resources
    $publicResources = array(
    	'index' => array('index'),
    	'about' => array('index'),
    	'session' => array('index', 'register', 'start', 'end'),
    	'contact' => array('index', 'send')
    );
    foreach ($publicResources as $resource => $actions) {
    	$acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
    }
    
    //Grant access to public areas to both users and guests
    foreach ($roles as $role){
    	foreach ($publicResources as $resource => $actions) {
    		$acl->allow($role->getName(), $resource, '*');
    	}
    }
    
    //Grant access to private area to role Users
    foreach ($privateResources as $resource => $actions) {
     		foreach ($actions as $action) {
    		$acl->allow('Users', $resource, $action);
    	}
    }



Methods
-------

public  **__construct** ()

Phalcon\\Acl\\Adapter\\Memory constructor



public *boolean*  **addRole** (*unknown* $role, [*unknown* $accessInherits])

Adds a role to the ACL list. Second parameter allows inheriting access data from other existing role Example: 

.. code-block:: php

    <?php

     	$acl->addRole(new Phalcon\Acl\Role('administrator'), 'consultant');
     	$acl->addRole('administrator', 'consultant');




public  **addInherit** (*unknown* $roleName, *unknown* $roleToInherit)

Do a role inherit from another existing role



public *boolean*  **isRole** (*unknown* $roleName)

Check whether role exist in the roles list



public *boolean*  **isResource** (*unknown* $resourceName)

Check whether resource exist in the resources list



public *boolean*  **addResource** (*unknown* $resourceValue, *unknown* $accessList)

Adds a resource to the ACL list Access names can be a particular action, by example search, update, delete, etc or a list of them Example: 

.. code-block:: php

    <?php

     //Add a resource to the the list allowing access to an action
     $acl->addResource(new Phalcon\Acl\Resource('customers'), 'search');
     $acl->addResource('customers', 'search');
    
     //Add a resource  with an access list
     $acl->addResource(new Phalcon\Acl\Resource('customers'), array('create', 'search'));
     $acl->addResource('customers', array('create', 'search'));




public *boolean*  **addResourceAccess** (*unknown* $resourceName, *unknown* $accessList)

Adds access to resources



public  **dropResourceAccess** (*unknown* $resourceName, *unknown* $accessList)

Removes an access from a resource



protected  **_allowOrDeny** (*unknown* $roleName, *unknown* $resourceName, *unknown* $access, *unknown* $action)

Checks if a role has access to a resource



public  **allow** (*unknown* $roleName, *unknown* $resourceName, *unknown* $access)

Allow access to a role on a resource You can use '*' as wildcard Example: 

.. code-block:: php

    <?php

     //Allow access to guests to search on customers
     $acl->allow('guests', 'customers', 'search');
    
     //Allow access to guests to search or create on customers
     $acl->allow('guests', 'customers', array('search', 'create'));
    
     //Allow access to any role to browse on products
     $acl->allow('*', 'products', 'browse');
    
     //Allow access to any role to browse on any resource
     $acl->allow('*', '*', 'browse');




public *boolean*  **deny** (*unknown* $roleName, *unknown* $resourceName, *unknown* $access)

Deny access to a role on a resource You can use '*' as wildcard Example: 

.. code-block:: php

    <?php

     //Deny access to guests to search on customers
     $acl->deny('guests', 'customers', 'search');
    
     //Deny access to guests to search or create on customers
     $acl->deny('guests', 'customers', array('search', 'create'));
    
     //Deny access to any role to browse on products
     $acl->deny('*', 'products', 'browse');
    
     //Deny access to any role to browse on any resource
     $acl->deny('*', '*', 'browse');




public *boolean*  **isAllowed** (*unknown* $roleName, *unknown* $resourceName, *unknown* $access)

Check whether a role is allowed to access an action from a resource 

.. code-block:: php

    <?php

     //Does andres have access to the customers resource to create?
     $acl->isAllowed('andres', 'Products', 'create');
    
     //Do guests have access to any resource to edit?
     $acl->isAllowed('guests', '*', 'edit');




public :doc:`Phalcon\\Acl\\Role <Phalcon_Acl_Role>` [] **getRoles** ()

Return an array with every role registered in the list



public :doc:`Phalcon\\Acl\\Resource <Phalcon_Acl_Resource>` [] **getResources** ()

Return an array with every resource registered in the list



public  **getActiveRole** () inherited from Phalcon\\Acl\\Adapter

Role which the list is checking if it's allowed to certain resource/access



public  **getActiveResource** () inherited from Phalcon\\Acl\\Adapter

Resource which the list is checking if some role can access it



public  **getActiveAccess** () inherited from Phalcon\\Acl\\Adapter

Active access which the list is checking if some role can access it



public  **setEventsManager** (*unknown* $eventsManager) inherited from Phalcon\\Acl\\Adapter

Sets the events manager



public :doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>`  **getEventsManager** () inherited from Phalcon\\Acl\\Adapter

Returns the internal event manager



public  **setDefaultAction** (*unknown* $defaultAccess) inherited from Phalcon\\Acl\\Adapter

Sets the default access level (Phalcon\\Acl::ALLOW or Phalcon\\Acl::DENY)



public *int*  **getDefaultAction** () inherited from Phalcon\\Acl\\Adapter

Returns the default ACL access level



