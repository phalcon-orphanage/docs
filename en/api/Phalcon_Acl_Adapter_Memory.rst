Class **Phalcon\\Acl\\Adapter\\Memory**
=======================================

*extends* :doc:`Phalcon\\Acl <Phalcon_Acl>`

Phalcon\\Acl\\Adapter\\Memory   Manages ACL lists in memory

Constants
---------

integer **ALLOW**

integer **DENY**

Methods
---------

**__construct** ()

**setDefaultAction** (*int* **$defaultAccess**)

**getDefaultAction** ()

*boolean* **addRole** (*string* **$roleObject**, *array* **$accessInherits**)

**addInherit** (*string* **$roleName**, *string* **$roleToInherit**)

*boolean* **isRole** (*string* **$roleName**)

*boolean* **isResource** (*string* **$resourceName**)

*boolean* **addResource** (*Phalcon\Acl\Resource* **$resource**, *unknown* **$accessList**)

**addResourceAccess** (*string* **$resourceName**, *mixed* **$accessList**)

**dropResourceAccess** (*string* **$resourceName**, *mixed* **$accessList**)

**_allowOrDeny** ()

**allow** (*string* **$roleName**, *string* **$resourceName**, *mixed* **$access**)

*boolean* **deny** (*string* **$roleName**, *string* **$resourceName**, *mixed* **$access**)

*boolean* **isAllowed** (*string* **$role**, *string* **$resource**, *unknown* **$access**)

**getActiveRole** ()

**getActiveResource** ()

**getActiveAccess** ()

**_rebuildAccessList** ()

**setEventsManager** (*unknown* **$eventsManager**)

**getEventsManager** ()

