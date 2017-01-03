Class **Phalcon\\Acl\\Adapter\\Memory**
=======================================

*extends* abstract class :doc:`Phalcon\\Acl\\Adapter <Phalcon_Acl_Adapter>`

*implements* :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`, :doc:`Phalcon\\Acl\\AdapterInterface <Phalcon_Acl_AdapterInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/acl/adapter/memory.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

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



public  **addRole** (*RoleInterface* | *string* $role, [*array* | *string* $accessInherits])

Adds a role to the ACL list. Second parameter allows inheriting access data from other existing role Example: 

.. code-block:: php

    <?php

     	$acl->addRole(new Phalcon\Acl\Role('administrator'), 'consultant');
     	$acl->addRole('administrator', 'consultant');




public  **addInherit** (*mixed* $roleName, *mixed* $roleToInherit)

Do a role inherit from another existing role



public  **isRole** (*mixed* $roleName)

Check whether role exist in the roles list



public  **isResource** (*mixed* $resourceName)

Check whether resource exist in the resources list



public  **addResource** (:doc:`Phalcon\\Acl\\Resource <Phalcon_Acl_Resource>` | *string* $resourceValue, *array* | *string* $accessList)

Adds a resource to the ACL list Access names can be a particular action, by example search, update, delete, etc or a list of them Example: 

.. code-block:: php

    <?php

     //Add a resource to the the list allowing access to an action
     $acl->addResource(new Phalcon\Acl\Resource('customers'), 'search');
     $acl->addResource('customers', 'search');
    
     //Add a resource  with an access list
     $acl->addResource(new Phalcon\Acl\Resource('customers'), array('create', 'search'));
     $acl->addResource('customers', array('create', 'search'));




public  **addResourceAccess** (*mixed* $resourceName, *array* | *string* $accessList)

Adds access to resources



public  **dropResourceAccess** (*mixed* $resourceName, *array* | *string* $accessList)

Removes an access from a resource



protected  **_allowOrDeny** (*mixed* $roleName, *mixed* $resourceName, *mixed* $access, *mixed* $action, [*mixed* $func])

Checks if a role has access to a resource



public  **allow** (*mixed* $roleName, *mixed* $resourceName, *mixed* $access, [*mixed* $func])

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




public  **deny** (*mixed* $roleName, *mixed* $resourceName, *mixed* $access, [*mixed* $func])

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




public  **isAllowed** (*mixed* $roleName, *mixed* $resourceName, *mixed* $access, [*array* $parameters])

Check whether a role is allowed to access an action from a resource 

.. code-block:: php

    <?php

     //Does andres have access to the customers resource to create?
     $acl->isAllowed('andres', 'Products', 'create');
    
     //Do guests have access to any resource to edit?
     $acl->isAllowed('guests', '*', 'edit');




public  **setNoArgumentsDefaultAction** (*mixed* $defaultAccess)

Sets the default access level (Phalcon\\Acl::ALLOW or Phalcon\\Acl::DENY) for no arguments provided in isAllowed action if there exists func for accessKey



public  **getNoArgumentsDefaultAction** ()

Returns the default ACL access level for no arguments provided in isAllowed action if there exists func for accessKey



public  **getRoles** ()

Return an array with every role registered in the list



public  **getResources** ()

Return an array with every resource registered in the list



public  **getActiveRole** () inherited from :doc:`Phalcon\\Acl\\Adapter <Phalcon_Acl_Adapter>`

Role which the list is checking if it's allowed to certain resource/access



public  **getActiveResource** () inherited from :doc:`Phalcon\\Acl\\Adapter <Phalcon_Acl_Adapter>`

Resource which the list is checking if some role can access it



public  **getActiveAccess** () inherited from :doc:`Phalcon\\Acl\\Adapter <Phalcon_Acl_Adapter>`

Active access which the list is checking if some role can access it



public  **setEventsManager** (:doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>` $eventsManager) inherited from :doc:`Phalcon\\Acl\\Adapter <Phalcon_Acl_Adapter>`

Sets the events manager



public  **getEventsManager** () inherited from :doc:`Phalcon\\Acl\\Adapter <Phalcon_Acl_Adapter>`

Returns the internal event manager



public  **setDefaultAction** (*mixed* $defaultAccess) inherited from :doc:`Phalcon\\Acl\\Adapter <Phalcon_Acl_Adapter>`

Sets the default access level (Phalcon\\Acl::ALLOW or Phalcon\\Acl::DENY)



public  **getDefaultAction** () inherited from :doc:`Phalcon\\Acl\\Adapter <Phalcon_Acl_Adapter>`

Returns the default ACL access level



