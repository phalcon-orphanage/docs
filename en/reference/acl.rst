Access Control Lists ACL
========================
:doc:`Phalcon_Acl <../api/Phalcon_Acl>` provides an easy and lightweight management of ACLs as well as the permissions attached to them. `Access Control Lists`_ (ACL) allow an application to control access to its areas and the underlying objects from requests. You are encouraged to read more about the ACL methodology so as to be familiar with its concepts.

In summary, ACLs have roles and resources. Resources are objects which abide by the permissions defined to them by the ACLs. Roles are objects that request access to resources and can be allowed or denied access by the ACL mechanism.

Creating an ACL
---------------
This component is designed to initially work in memory. This provides ease of use and speed in accessing every aspect of the list. The :doc:`Phalcon_Acl <../api/Phalcon_Acl>` constructor takes as its first parameter an adapter used to retriever the information related to the control list. An example using the memory adapter is below: 

.. code-block:: php

    <?php $acl = new Phalcon_Acl("Memory");

By default :doc:`Phalcon_Acl <../api/Phalcon_Acl>` allows access to action on resources that have not been yet defined. To increase the security level of the access list we can define a "deny" level as a default access level. 

.. code-block:: php

    <?php

    // Default action is deny access
    $acl->setDefaultAction(Phalcon_Acl::DENY);

Adding Roles to the ACL
-----------------------
A role is an object that can or cannot access certain resources in the access list. As an example, we will define roles as groups of people in an organization. The :doc:`Phalcon_Acl_Role <../api/Phalcon_Acl_Role>` class is available to create roles in a more structured way. Let's add some roles to our recently created list: 

.. code-block:: php

    <?php

    // Create some roles
    $roleAdmins = new Phalcon_Acl_Role("Administrators", "Super-User role");
    $roleGuests = new Phalcon_Acl_Role("Guests");
    
    // Add "Guests" role to acl
    acl->addRole($roleGuests);
    
    // Add "Designers" role to acl without a Phalcon_Acl_Role
    $acl->addRole("Designers");

As you can see, roles are defined directly without using a instance.

Adding Resources
----------------
Resources are objects where access is controlled. Normally in MVC applications resources refer to controllers. Although this is not mandatory, the :doc:`Phalcon_Acl_Resource <../api/Phalcon_Acl_Resource>` class can be used in defining resources. It's important to add related actions or operations to a resource so that the ACL can understand what it should to control. 

.. code-block:: php

    <?php

    // Define the "Customers" resource
    $customersResource = new Phalcon_Acl_Resource("Customers");
    
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
    $acl->isAllowed("Guests", "Customers", "edit");   //Returns 0
    $acl->isAllowed("Guests", "Customers", "search"); //Returns 1
    $acl->isAllowed("Guests", "Customers", "create"); //Returns 1

Roles Inheritance
-----------------
You can build complex role structures using the inheritance that :doc:`Phalcon_Acl_Role <../api/Phalcon_Acl_Role>` provides. Roles can inherit from other roles, thus allowing access to supersets or subsets of resources. To use role inheritance, you need to pass the inherited role as the second parameter of the function call, when adding that role in the list. 

.. code-block:: php

    <?php

    // Create some roles
    $roleAdmins = new Phalcon_Acl_Role("Administrators", "Super-User role");
    $roleGuests = new Phalcon_Acl_Role("Guests");
    
    // Add "Guests" role to acl
    $acl->addRole($roleGuests);
    
    // Add "Administrators" role inheriting from "Guests" its accesses
    $acl->addRole($roleAdmins, $roleGuests);

Serializing ACL lists
---------------------
To improve performance :doc:`Phalcon_Acl <../api/Phalcon_Acl>` instances can be serialized and stored in text files or a database table so that they can be loaded at will without having to redefine the whole list. You can do that as follows: 

.. code-block:: php

    <?php

    //Check whether acl data already exist
    if (!file_exists("app/security/acl.data")) {
    
        $acl = new Phalcon_Acl("Memory");

        //... Define roles, resources, access, etc

        // Store serialized list into plain file
        file_put_contents("app/security/acl.data", serialize($acl));
    
    } else {
    
         //Restore acl object from serialized file
         $acl = unserialize(file_get_contents("app/security/acl.data"));
    }
    
    // Use acl list as needed
    if ($acl->isAllowed("Guests", "Customers", "edit")) {
        echo "Access granted!";
    } else {
        echo "Access denied :(";
    }

Integrating ACL with Controllers
--------------------------------
The following example shows how to do a simple integration between ACL and :doc:`Phalcon_Controller <../api/Phalcon_Controller>`:

.. code-block:: php

    <?php
    
    class PostsController extends Phalcon_Controller
    {
    
      private $_acl = null;
    
      /**
       * Gets a Phalcon_Acl instance
       */
      private function _getAcl()
      {
    
         // Create an ACL only once by request
         if (!$this->_acl) {
    
            $acl = new Phalcon_Acl("Memory");
    
            $acl->addResource("posts", array("index", "create"));
    
            // Set access to Public role
            $acl->addRole("Public");
            $acl->allow("Public", "posts", "index");
    
            // Set access to Users role
            $acl->addRole("Users");
            $acl->allow("Users", "posts", "index");
            $acl->deny("Users", "posts", "create");
    
            $this->_acl = $acl;
         }
    
         return $this->_acl;
      }
    
      /**
       * Returns the user profile in session
       */
      private function _getUser()
      {
        if (Phalcon_Session::has("authInfo")) {
            return Phalcon_Session::get("authInfo");
        } else {
            return array(
                "Profile" => "Public"
            );
        }
      }
    
      /**
       * beforeDispatch is executed before every action in the controller
       */
      function beforeDispatch($controllerName, $actionName)
      {
    
        $acl  = $this->_getAcl();
        $user = $this->_getUser();
    
        if (!$acl->isAllowed($user["Profile"], $controllerName, $actionName)) {
            // Forward flow to another controller if the user does not have permission
            $this->_forward("index/index");
            return false;
        }
    
      }
    
    }

You can also use :doc:`Phalcon_Cache <../api/Phalcon_Cache>` to store the ACL to different backends such as Files, Memcached, Apc, etc. 

.. _Access Control Lists: http://en.wikipedia.org/wiki/Access_control_list
