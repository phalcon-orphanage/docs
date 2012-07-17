Access Control Lists ACL
========================
This component allows to manage ACL lists. An `access control list (ACL) <http://en.wikipedia.org/wiki/Access_control_list>`_ is a list of permissions attached to an object. An ACL specifies that users or system processes are granted access to objects, as well as what operations are allowed on given objects. Phalcon provides the Phalcon_Acl to manage access control lists. Before proceeding, we recommend you to read some ACL documentation, as it is important to be familiarwith some of the ACL concepts. 

Creating an ACL
---------------
This component is designed to initially work in memory.This will give us the ease of handling rapidly every aspect of the list. The Phalcon_Acl constructor takes as its first parameter an adapter used to recover the information related to the control list. In this example we'll use the memory adapter: 

.. code-block:: php

    <?php

    $acl = new Phalcon_Acl("Memory");

By default Phalcon_Acl allows access to action on resources that has not been defined previously.To increase the security level of our access list we'll define a "deny" level as a default access level. 

.. code-block:: php

    <?php

    //Default action is deny access
    $acl->setDefaultAction(Phalcon_Acl::DENY);

Adding Roles to the ACL
-----------------------
A role is somebody or something that can access to certain resources in the access list. In our examplewe will define roles as groups of people in an organization. The is available to create roles in a more structured way.Let's add some roles to our recently created list: 

.. code-block:: php

    <?php

    //Create some roles
    $roleAdmins = new Phalcon_Acl_Role("Administrators", "Super-User role");
    $roleGuests = new Phalcon_Acl_Role("Guests");
    
    //Add "Guests" role to acl
    acl->addRole($roleGuests);
    
    //Add "Designers" role to acl without a Phalcon_Acl_Role
    $acl->addRole("Designers");

As you can see, roles also can be defined directly without using a instance.

Adding Resources
----------------
Resources are objects where access is controlled. Normally in MVC application resources refer tocontrollers. Although this is not mandatory,  can be used defining resources.It's important to add related actions or operations to a resource so ACL can understand what it should to control. 

.. code-block:: php

    <?php

    //Define the "Customers" resource
    $customersResource = new Phalcon_Acl_Resource("Customers");
    
    //Add "customers" resource with a couple of operations
    $acl->addResource($customersResource, "search");
    $acl->addResource($customersResource, array("create", "update"));

Defining Access Controls
------------------------
Now we've roles and resources. It's time to say to ACL which roles can access which resources.This part is very important because it allows to define the control list itself. 

.. code-block:: php

    <?php

    //Set access level for roles into resources
    $acl->allow("Guests", "Customers", "search");
    $acl->allow("Guests", "Customers", "create");
    $acl->deny("Guests", "Customers", "update");

The allow method say to the list: Yes, this role has granted with access to this resource/operation.The deny method does the opposite. 

Querying an ACL
---------------
Once the list has been completely defined. We can begin to query and see if a role has a given permission or not.

.. code-block:: php

    <?php

    //Check whether role has access to the operations
    $acl->isAllowed("Guests", "Customers", "edit"); //Returns 0
    $acl->isAllowed("Guests", "Customers", "search"); //Returns 1
    $acl->isAllowed("Guests", "Customers", "create"); //Returns 1



Roles Inheritance
-----------------
In some cases, role's permissions could be inherited from other existing roles. You can do this by simplyrefer the inherited role as the second parameter when defining a role into the list. 

.. code-block:: php

    <?php

    //Create some roles
    $roleAdmins = new Phalcon_Acl_Role("Administrators", "Super-User role");
    $roleGuests = new Phalcon_Acl_Role("Guests");
    
    //Add "Guests" role to acl
    acl->addRole($roleGuests);
    
    //Add "Administrators" role inheriting from "Guests" its accesses
    $acl->addRole($roleAdmins, $roleGuests);

Serializing ACL lists
---------------------
To improve performance Phalcon_Acl instances can be serialized and stored in plain files to avoidcontinuous definition. You can do that as follows: 

.. code-block:: php

    <?php

    //Check whether acl data already exist
    if (!file_exists("app/security/acl.data")) {
    
     $acl = new Phalcon_Acl("Memory");
    
     //... Define roles, resources, access, etc
    
     //Store serialized list into plain file
     file_put_contents("app/security/acl.data", serialize($acl));
    
    } else {
    
     //Restore acl object from serialized file
     $acl = unserialize(file_get_contents("app/security/acl.data"));
    }
    
    //Use acl list as needed
    if ($acl->isAllowed("Guests", "Customers", "edit")) {
     echo "Access granted!";
    } else {
     echo "Access denied :(";
    }

Integrating ACL with Controllers
--------------------------------
The following example shows how to do a simple integration between ACL and:

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
    
         //Only create an ACL once by request
         if(!$this->_acl){
    
            $acl = new Phalcon_Acl("Memory");
    
            $acl->addResource("posts", array("index", "create"));
    
            //Set access to Public role
            $acl->addRole("Public");
            $acl->allow("Public", "posts", "index");
    
            //Set access to Users role
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
    
        $acl = $this->_getAcl();
        $user = $this->_getUser();
    
        if (!$acl->isAllowed($user["Profile"], $controllerName, $actionName)) {
         //Forward flow to another controller if the user does not have permission
         $this->_forward("index/index");
         return false;
        }
    
      }
    
    }

Also you can use the to store ACL liststo different backends such as Files, Memcached, Apc, etc. 