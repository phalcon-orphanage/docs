Access Control Lists ACL
========================
:doc:`Phalcon\\Acl <../api/Phalcon_Acl>` provides an easy and lightweight management of ACLs as well as the permissions
attached to them. `Access Control Lists`_ (ACL) allow an application to control access to its areas and the underlying
objects from requests. You are encouraged to read more about the ACL methodology so as to be familiar with its concepts.

In summary, ACLs have roles and resources. Resources are objects which abide by the permissions defined to them by
the ACLs. Roles are objects that request access to resources and can be allowed or denied access by the ACL mechanism.

Creating an ACL
---------------
This component is designed to initially work in memory. This provides ease of use and speed in accessing every aspect of the list. The :doc:`Phalcon\\Acl <../api/Phalcon_Acl>` constructor takes as its first parameter an adapter used to retriever the information related to the control list. An example using the memory adapter is below:

.. code-block:: php

    <?php $acl = new \Phalcon\Acl\Adapter\Memory();

By default :doc:`Phalcon\\Acl <../api/Phalcon_Acl>` allows access to action on resources that have not been yet defined. To increase the security level of the access list we can define a "deny" level as a default access level.

.. code-block:: php

    <?php

    // Default action is deny access
    $acl->setDefaultAction(Phalcon\Acl::DENY);

Adding Roles to the ACL
-----------------------
A role is an object that can or cannot access certain resources in the access list. As an example, we will define roles as groups of people in an organization. The :doc:`Phalcon\\Acl\\Role <../api/Phalcon_Acl_Role>` class is available to create roles in a more structured way. Let's add some roles to our recently created list:

.. code-block:: php

    <?php

    // Create some roles
    $roleAdmins = new \Phalcon\Acl\Role("Administrators", "Super-User role");
    $roleGuests = new \Phalcon\Acl\Role("Guests");

    // Add "Guests" role to acl
    acl->addRole($roleGuests);

    // Add "Designers" role to acl without a Phalcon\Acl\Role
    $acl->addRole("Designers");

As you can see, roles are defined directly without using a instance.

Adding Resources
----------------
Resources are objects where access is controlled. Normally in MVC applications resources refer to controllers. Although this is not mandatory, the :doc:`Phalcon\\Acl\\Resource <../api/Phalcon_Acl_Resource>` class can be used in defining resources. It's important to add related actions or operations to a resource so that the ACL can understand what it should to control.

.. code-block:: php

    <?php

    // Define the "Customers" resource
    $customersResource = new \Phalcon\Acl\Resource("Customers");

    // Add "customers" resource with a couple of operations
    $acl->addResource($customersResource, "search");
    $acl->addResource($customersResource, array("create", "update"));

Defining Access Controls
------------------------
Now we've roles and resources. It's time to define the ACL i.e. which roles can access which resources. This part is very important especially taking in consideration your default access level "allow" or "deny".

.. code-block:: php

    <?php

    // Set access level for roles into resources
    $acl->allow("Guests", "Customers", "search");
    $acl->allow("Guests", "Customers", "create");
    $acl->deny("Guests", "Customers", "update");

The allow method designates that a particular role has granted access to access a particular resource. The deny method does the opposite.

Querying an ACL
---------------
Once the list has been completely defined. We can query it to check if a role has a given permission or not.

.. code-block:: php

    <?php

    // Check whether role has access to the operations
    $acl->isAllowed("Guests", "Customers", "edit");   // Returns 0
    $acl->isAllowed("Guests", "Customers", "search"); // Returns 1
    $acl->isAllowed("Guests", "Customers", "create"); // Returns 1

Roles Inheritance
-----------------
You can build complex role structures using the inheritance that :doc:`Phalcon\\Acl\\Role <../api/Phalcon_Acl_Role>` provides. Roles can inherit from other roles, thus allowing access to supersets or subsets of resources. To use role inheritance, you need to pass the inherited role as the second parameter of the function call, when adding that role in the list.

.. code-block:: php

    <?php

    // Create some roles
    $roleAdmins = new \Phalcon\Acl\Role("Administrators", "Super-User role");
    $roleGuests = new \Phalcon\Acl\Role("Guests");

    // Add "Guests" role to acl
    $acl->addRole($roleGuests);

    // Add "Administrators" role inheriting from "Guests" its accesses
    $acl->addRole($roleAdmins, $roleGuests);

Serializing ACL lists
---------------------
To improve performance :doc:`Phalcon\\Acl <../api/Phalcon_Acl>` instances can be serialized and stored in APC, session, text files or a database table
so that they can be loaded at will without having to redefine the whole list. You can do that as follows:

.. code-block:: php

    <?php

    // Check whether acl data already exist
    if (!file_exists("app/security/acl.data")) {

        $acl = new \Phalcon\Acl("Memory");

        // ... Define roles, resources, access, etc

        // Store serialized list into plain file
        file_put_contents("app/security/acl.data", serialize($acl));

    } else {

         // Restore acl object from serialized file
         $acl = unserialize(file_get_contents("app/security/acl.data"));
    }

    // Use acl list as needed
    if ($acl->isAllowed("Guests", "Customers", "edit")) {
        echo "Access granted!";
    } else {
        echo "Access denied :(";
    }

Acl Events
----------
:doc:`Phalcon\\Acl <../api/Phalcon_Acl>` is able to send events to a :doc:`EventsManager <events>` if it's present. Events
are triggered using the type "acl". Some events when returning boolean false could stop the active operation. The following events are supported:

+----------------------+------------------------------------------------------------+---------------------+
| Event Name           | Triggered                                                  | Can stop operation? |
+======================+============================================================+=====================+
| beforeCheckAccess    | Triggered before checking if a role/resource has access    | Yes                 |
+----------------------+------------------------------------------------------------+---------------------+
| afterCheckAccess     | Triggered after checking if a role/resource has access     | No                  |
+----------------------+------------------------------------------------------------+---------------------+

The following example demonstrates how to attach listeners to this component:

.. code-block:: php

    <?php

    // Create an event manager
    $eventsManager = new Phalcon\Events\Manager();

    // Attach a listener for type "acl"
    $eventsManager->attach("acl", function ($event, $acl) {
        if ($event->getType() == 'beforeCheckAccess') {
             echo   $acl->getActiveRole(),
                    $acl->getActiveResource(),
                    $acl->getActiveAccess();
        }
    });

    $acl = new \Phalcon\Acl\Adapter\Memory();

    // Setup the $acl
    // ...

    // Bind the eventsManager to the acl component
    $acl->setEventsManager($eventManagers);

Implementing your own adapters
------------------------------
The :doc:`Phalcon\\Acl\\AdapterInterface <../api/Phalcon_Acl_AdapterInterface>` interface must be implemented in order
to create your own ACL adapters or extend the existing ones.

.. _Access Control Lists: http://en.wikipedia.org/wiki/Access_control_list
