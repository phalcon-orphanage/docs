Class **Phalcon\\Acl\\Adapter\\Memory**
=======================================

*extends* :doc:`Phalcon\\Acl <Phalcon_Acl>`

Manages ACL lists in memory 

.. code-block:: php

    <?php

    $acl = new Phalcon\Acl\Adapter\Memory();
    
    $acl->setDefaultAction(Phalcon\Acl::DENY);
    
    //Register roles
    $roles = array(
    	'users' => new Phalcon\Acl\Role('Users'),
    	'guests' => new Phalcon\Acl\Role('Guests')
    );
    foreach($roles as $role){
    	$acl->addRole($role);
    }
    
    //Private area resources
      $privateResources = array(
    	'companies' => array('index', 'search', 'new', 'edit', 'save', 'create', 'delete'),
    	'products' => array('index', 'search', 'new', 'edit', 'save', 'create', 'delete'),
    	'invoices' => array('index', 'profile')
    );
    foreach($privateResources as $resource => $actions){
    	$acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
    }
    
    //Private area resources
    $publicResources = array(
    	'index' => array('index'),
    	'about' => array('index'),
    	'session' => array('index', 'register', 'start', 'end'),
    	'contact' => array('index', 'send')
    );
      foreach($publicResources as $resource => $actions){
    	$acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
    }
    
      //Grant access to public areas to both users and guests
    foreach($roles as $role){
    	foreach($publicResources as $resource => $actions){
    		$acl->allow($role->getName(), $resource, '*');
    	}
    }
    
    //Grant acess to private area to role Users
      foreach($privateResources as $resource => $actions){
     		foreach($actions as $action){
    		$acl->allow('Users', $resource, $action);
    	}
    }



Constants
---------

*integer* **ALLOW**

*integer* **DENY**

Methods
---------

public  **__construct** ()

...


public  **setDefaultAction** (*int* $defaultAccess)

Sets the default access level (Phalcon\\Acl::ALLOW or Phalcon\\Acl::DENY)



public  **getDefaultAction** ()

Returns the default ACL access level



public *boolean*  **addRole** (*string* $roleObject, *array* $accessInherits)

Adds a role to the ACL list. Second parameter lets to inherit access data from other existing role Example: 

.. code-block:: php

    <?php

     $acl->addRole(new Phalcon\Acl\Role('administrator'), 'consultant');
     $acl->addRole('administrator', 'consultant');




public  **addInherit** (*string* $roleName, *string* $roleToInherit)

Do a role inherit from another existing role



public *boolean*  **isRole** (*string* $roleName)

Check whether role exist in the roles list



public *boolean*  **isResource** (*string* $resourceName)

Check whether resource exist in the resources list



public *boolean*  **addResource** (:doc:`Phalcon\\Acl\\Resource <Phalcon_Acl_Resource>` $resource, *unknown* $accessList)

Adds a resource to the ACL list Access names can be a particular action, by example search, update, delete, etc or a list of them Example: 

.. code-block:: php

    <?php

     //Add a resource to the the list allowing access to an action
     $acl->addResource(new Phalcon\Acl\Resource('customers'), 'search');
     $acl->addResource('customers', 'search');
    
     //Add a resource  with an access list
     $acl->addResource(new Phalcon\Acl\Resource('customers'), array('create', 'search'));
     $acl->addResource('customers', array('create', 'search'));




public  **addResourceAccess** (*string* $resourceName, *mixed* $accessList)

Adds access to resources



public  **dropResourceAccess** (*string* $resourceName, *mixed* $accessList)

Removes an access from a resource



protected  **_allowOrDeny** ()

...


public  **allow** (*string* $roleName, *string* $resourceName, *mixed* $access)

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




public *boolean*  **deny** (*string* $roleName, *string* $resourceName, *mixed* $access)

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




public *boolean*  **isAllowed** (*string* $role, *string* $resource, *unknown* $access)

Check whether a role is allowed to access an action from a resource 

.. code-block:: php

    <?php

     //Does andres have access to the customers resource to create?
     $acl->isAllowed('andres', 'Products', 'create');
    
     //Do guests have access to any resource to edit?
     $acl->isAllowed('guests', '*', 'edit');




public *string*  **getActiveRole** ()

Returns the role which the list is checking if it's allowed to certain resource/access



public *string*  **getActiveResource** ()

Returns the resource which the list is checking if some role can access it



public *string*  **getActiveAccess** ()

Returns the access which the list is checking if some role can access it



protected  **_rebuildAccessList** ()

Rebuild the list of access from the inherit lists



public  **setEventsManager** (*unknown* $eventsManager) inherited from Phalcon\Acl

Sets the events manager



public :doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>`  **getEventsManager** () inherited from Phalcon\Acl

Returns the internal event manager



