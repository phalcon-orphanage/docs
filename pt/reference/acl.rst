Access Control Lists (ACL)
==========================

:doc:`Phalcon\\Acl <../api/Phalcon_Acl>` provides an easy and lightweight management of ACLs as well as the permissions
attached to them. `Access Control Lists`_ (ACL) allow an application to control access to its areas and the underlying
objects from requests. You are encouraged to read more about the ACL methodology so as to be familiar with its concepts.

In summary, ACLs have roles and resources. Resources are objects which abide by the permissions defined to them by
the ACLs. Roles are objects that request access to resources and can be allowed or denied access by the ACL mechanism.

Creating an ACL
---------------
This component is designed to initially work in memory. This provides ease of use and speed in accessing every aspect of the list. The :doc:`Phalcon\\Acl <../api/Phalcon_Acl>` constructor takes as its first parameter an adapter used to retrieve the information related to the control list. An example using the memory adapter is below:

.. code-block:: php

    <?php

    use Phalcon\Acl\Adapter\Memory as AclList;

    $acl = new AclList();

By default :doc:`Phalcon\\Acl <../api/Phalcon_Acl>` allows access to action on resources that have not yet been defined. To increase the security level of the access list we can define a "deny" level as a default access level.

.. code-block:: php

    <?php

    use Phalcon\Acl;

    // Default action is deny access
    $acl->setDefaultAction(
        Acl::DENY
    );

Adding Roles to the ACL
-----------------------
A role is an object that can or cannot access certain resources in the access list. As an example, we will define roles as groups of people in an organization. The :doc:`Phalcon\\Acl\\Role <../api/Phalcon_Acl_Role>` class is available to create roles in a more structured way. Let's add some roles to our recently created list:

.. code-block:: php

    <?php

    use Phalcon\Acl\Role;

    // Create some roles.
    // The first parameter is the name, the second parameter is an optional description.
    $roleAdmins = new Role("Administrators", "Super-User role");
    $roleGuests = new Role("Guests");

    // Add "Guests" role to ACL
    $acl->addRole($roleGuests);

    // Add "Designers" role to ACL without a Phalcon\Acl\Role
    $acl->addRole("Designers");

As you can see, roles are defined directly without using an instance.

Adding Resources
----------------
Resources are objects where access is controlled. Normally in MVC applications resources refer to controllers. Although this is not mandatory, the :doc:`Phalcon\\Acl\\Resource <../api/Phalcon_Acl_Resource>` class can be used in defining resources. It's important to add related actions or operations to a resource so that the ACL can understand what it should to control.

.. code-block:: php

    <?php

    use Phalcon\Acl\Resource;

    // Define the "Customers" resource
    $customersResource = new Resource("Customers");

    // Add "customers" resource with a couple of operations

    $acl->addResource(
        $customersResource,
        "search"
    );

    $acl->addResource(
        $customersResource,
        [
            "create",
            "update",
        ]
    );

Defining Access Controls
------------------------
Now that we have roles and resources, it's time to define the ACL (i.e. which roles can access which resources). This part is very important especially taking into consideration your default access level "allow" or "deny".

.. code-block:: php

    <?php

    // Set access level for roles into resources

    $acl->allow("Guests", "Customers", "search");

    $acl->allow("Guests", "Customers", "create");

    $acl->deny("Guests", "Customers", "update");

The :code:`allow()` method designates that a particular role has granted access to a particular resource. The :code:`deny()` method does the opposite.

Querying an ACL
---------------
Once the list has been completely defined. We can query it to check if a role has a given permission or not.

.. code-block:: php

    <?php

    // Check whether role has access to the operations

    // Returns 0
    $acl->isAllowed("Guests", "Customers", "edit");

    // Returns 1
    $acl->isAllowed("Guests", "Customers", "search");

    // Returns 1
    $acl->isAllowed("Guests", "Customers", "create");

Function based access
---------------------
Also you can add as 4th parameter your custom function which must return boolean value. It will be called when you use :code:`isAllowed()` method. You can pass parameters as associative array to :code:`isAllowed()` method as 4th argument where key is parameter name in our defined function.

.. code-block:: php

    <?php
    // Set access level for role into resources with custom function
    $acl->allow(
        "Guests",
        "Customers",
        "search",
        function ($a) {
            return $a % 2 === 0;
        }
    );

    // Check whether role has access to the operation with custom function

    // Returns true
    $acl->isAllowed(
        "Guests",
        "Customers",
        "search",
        [
            "a" => 4,
        ]
    );

    // Returns false
    $acl->isAllowed(
        "Guests",
        "Customers",
        "search",
        [
            "a" => 3,
        ]
    );

Also if you don't provide any parameters in :code:`isAllowed()` method then default behaviour will be :code:`Acl::ALLOW`. You can change it by using method :code:`setNoArgumentsDefaultAction()`.

.. code-block:: php

    use Phalcon\Acl;

    <?php
    // Set access level for role into resources with custom function
    $acl->allow(
        "Guests",
        "Customers",
        "search",
        function ($a) {
            return $a % 2 === 0;
        }
    );

    // Check whether role has access to the operation with custom function

    // Returns true
    $acl->isAllowed(
        "Guests",
        "Customers",
        "search"
    );

    // Change no arguments default action
    $acl->setNoArgumentsDefaultAction(
        Acl::DENY
    );

    // Returns false
    $acl->isAllowed(
        "Guests",
        "Customers",
        "search"
    );

Objects as role name and resource name
--------------------------------------
You can pass objects as :code:`roleName` and :code:`resourceName`. Your classes must implement :doc:`Phalcon\\Acl\\RoleAware <../api/Phalcon_Acl_RoleAware>` for :code:`roleName` and :doc:`Phalcon\\Acl\\ResourceAware <../api/Phalcon_Acl_ResourceAware>` for :code:`resourceName`.

Our :code:`UserRole` class

.. code-block:: php

    <?php

    use Phalcon\Acl\RoleAware;

    // Create our class which will be used as roleName
    class UserRole implements RoleAware
    {
        protected $id;

        protected $roleName;

        public function __construct($id, $roleName)
        {
            $this->id       = $id;
            $this->roleName = $roleName;
        }

        public function getId()
        {
            return $this->id;
        }

        // Implemented function from RoleAware Interface
        public function getRoleName()
        {
            return $this->roleName;
        }
    }

And our :code:`ModelResource` class

.. code-block:: php

    <?php

    use Phalcon\Acl\ResourceAware;

    // Create our class which will be used as resourceName
    class ModelResource implements ResourceAware
    {
        protected $id;

        protected $resourceName;

        protected $userId;

        public function __construct($id, $resourceName, $userId)
        {
            $this->id           = $id;
            $this->resourceName = $resourceName;
            $this->userId       = $userId;
        }

        public function getId()
        {
            return $this->id;
        }

        public function getUserId()
        {
            return $this->userId;
        }

        // Implemented function from ResourceAware Interface
        public function getResourceName()
        {
            return $this->resourceName;
        }
    }

Then you can use them in :code:`isAllowed()` method.

.. code-block:: php

    <?php

    use UserRole;
    use ModelResource;

    // Set access level for role into resources
    $acl->allow("Guests", "Customers", "search");
    $acl->allow("Guests", "Customers", "create");
    $acl->deny("Guests", "Customers", "update");

    // Create our objects providing roleName and resourceName

    $customer = new ModelResource(
        1,
        "Customers",
        2
    );

    $designer = new UserRole(
        1,
        "Designers"
    );

    $guest = new UserRole(
        2,
        "Guests"
    );

    $anotherGuest = new UserRole(
        3,
        "Guests"
    );

    // Check whether our user objects have access to the operation on model object

    // Returns false
    $acl->isAllowed(
        $designer,
        $customer,
        "search"
    );

    // Returns true
    $acl->isAllowed(
        $guest,
        $customer,
        "search"
    );

    // Returns true
    $acl->isAllowed(
        $anotherGuest,
        $customer,
        "search"
    );

Also you can access those objects in your custom function in :code:`allow()` or :code:`deny()`. They are automatically bind to parameters by type in function.

.. code-block:: php

    <?php

    use UserRole;
    use ModelResource;

    // Set access level for role into resources with custom function
    $acl->allow(
        "Guests",
        "Customers",
        "search",
        function (UserRole $user, ModelResource $model) { // User and Model classes are necessary
            return $user->getId == $model->getUserId();
        }
    );

    $acl->allow(
        "Guests",
        "Customers",
        "create"
    );

    $acl->deny(
        "Guests",
        "Customers",
        "update"
    );

    // Create our objects providing roleName and resourceName

    $customer = new ModelResource(
        1,
        "Customers",
        2
    );

    $designer = new UserRole(
        1,
        "Designers"
    );

    $guest = new UserRole(
        2,
        "Guests"
    );

    $anotherGuest = new UserRole(
        3,
        "Guests"
    );

    // Check whether our user objects have access to the operation on model object

    // Returns false
    $acl->isAllowed(
        $designer,
        $customer,
        "search"
    );

    // Returns true
    $acl->isAllowed(
        $guest,
        $customer,
        "search"
    );

    // Returns false
    $acl->isAllowed(
        $anotherGuest,
        $customer,
        "search"
    );

You can still add any custom parameters to function and pass associative array in :code:`isAllowed()` method. Also order doesn't matter.

Roles Inheritance
-----------------
You can build complex role structures using the inheritance that :doc:`Phalcon\\Acl\\Role <../api/Phalcon_Acl_Role>` provides. Roles can inherit from other roles, thus allowing access to supersets or subsets of resources. To use role inheritance, you need to pass the inherited role as the second parameter of the method call, when adding that role in the list.

.. code-block:: php

    <?php

    use Phalcon\Acl\Role;

    // ...

    // Create some roles

    $roleAdmins = new Role("Administrators", "Super-User role");

    $roleGuests = new Role("Guests");

    // Add "Guests" role to ACL
    $acl->addRole($roleGuests);

    // Add "Administrators" role inheriting from "Guests" its accesses
    $acl->addRole($roleAdmins, $roleGuests);

Serializing ACL lists
---------------------
To improve performance :doc:`Phalcon\\Acl <../api/Phalcon_Acl>` instances can be serialized and stored in APC, session, text files or a database table
so that they can be loaded at will without having to redefine the whole list. You can do that as follows:

.. code-block:: php

    <?php

    use Phalcon\Acl\Adapter\Memory as AclList;

    // ...

    // Check whether ACL data already exist
    if (!is_file("app/security/acl.data")) {
        $acl = new AclList();

        // ... Define roles, resources, access, etc

        // Store serialized list into plain file
        file_put_contents(
            "app/security/acl.data",
            serialize($acl)
        );
    } else {
        // Restore ACL object from serialized file
        $acl = unserialize(
            file_get_contents("app/security/acl.data")
        );
    }

    // Use ACL list as needed
    if ($acl->isAllowed("Guests", "Customers", "edit")) {
        echo "Access granted!";
    } else {
        echo "Access denied :(";
    }

It's recommended to use the Memory adapter during development and use one of the other adapters in production.

ACL Events
----------
:doc:`Phalcon\\Acl <../api/Phalcon_Acl>` is able to send events to a :doc:`EventsManager <events>` if it's present. Events
are triggered using the type "acl". Some events when returning boolean false could stop the active operation. The following events are supported:

+-------------------+---------------------------------------------------------+---------------------+
| Event Name        | Triggered                                               | Can stop operation? |
+===================+=========================================================+=====================+
| beforeCheckAccess | Triggered before checking if a role/resource has access | Yes                 |
+-------------------+---------------------------------------------------------+---------------------+
| afterCheckAccess  | Triggered after checking if a role/resource has access  | No                  |
+-------------------+---------------------------------------------------------+---------------------+

The following example demonstrates how to attach listeners to this component:

.. code-block:: php

    <?php

    use Phalcon\Acl\Adapter\Memory as AclList;
    use Phalcon\Events\Event;
    use Phalcon\Events\Manager as EventsManager;

    // ...

    // Create an event manager
    $eventsManager = new EventsManager();

    // Attach a listener for type "acl"
    $eventsManager->attach(
        "acl:beforeCheckAccess",
        function (Event $event, $acl) {
            echo $acl->getActiveRole();

            echo $acl->getActiveResource();

            echo $acl->getActiveAccess();
        }
    );

    $acl = new AclList();

    // Setup the $acl
    // ...

    // Bind the eventsManager to the ACL component
    $acl->setEventsManager($eventsManager);

Implementing your own adapters
------------------------------
The :doc:`Phalcon\\Acl\\AdapterInterface <../api/Phalcon_Acl_AdapterInterface>` interface must be implemented in order
to create your own ACL adapters or extend the existing ones.

.. _Access Control Lists: http://en.wikipedia.org/wiki/Access_control_list
