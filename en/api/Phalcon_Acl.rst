Class **Phalcon_Acl**
=====================

This component allows to manage ACL lists. An access control list (ACL) is a list  of permissions attached to an object. An ACL specifies which users or system processes  are granted access to objects, as well as what operations are allowed on given objects.  

.. code-block:: php

    <?php

    $acl = new Phalcon_Acl('Memory');
    
    // Default action is deny access
    $acl->setDefaultAction(Phalcon_Acl::DENY);
    
    // Create some roles
    $roleAdmins = new Phalcon_Acl_Role('Administrators', 'Super-User role');
    $roleGuests = new Phalcon_Acl_Role('Guests');
    
    // Add "Guests" role to acl
    $acl->addRole($roleGuests);
    
    // Add "Designers" role to acl
    $acl->addRole('Designers'));
    
    // Define the "Customers" resource
    $customersResource = new Phalcon_Acl_Resource('Customers', 'Customers management');
    
    // Add "customers" resource with a couple of operations
    $acl->addResource($customersResource, 'search');
    $acl->addResource($customersResource, array('create', 'update'));
    
    // Set access level for roles into resources
    $acl->allow('Guests', 'Customers', 'search');
    $acl->allow('Guests', 'Customers', 'create');
    $acl->deny('Guests', 'Customers', 'update');
    
    // Check whether role has access to the operations
    $acl->isAllowed('Guests', 'Customers', 'edit')    //Returns 0
    $acl->isAllowed('Guests', 'Customers', 'search'); //Returns 1
    $acl->isAllowed('Guests', 'Customers', 'create'); //Returns 1

Constants
---------

integer **ALLOW**

integer **DENY**

Methods
---------

**__construct** (string $adapterName, array $options)

\tPhalcon_Acl Constructor

**mixed** **__call** (string $method, array $arguments)

\tPass any call to the internal adapter object

