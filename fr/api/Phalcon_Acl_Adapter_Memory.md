# Classe **Phalcon\\Acl\\Carte\\Memory**

*extends* classe abstraite [Phalcon\Acl\Carte](/en/3.2/api/Phalcon_Acl_Adapter)

*implémente* [Phalcon\Events\EventsAwareInterface](/en/3.2/api/Phalcon_Events_EventsAwareInterface), [Phalcon\Acl\AdapterInterface](/en/3.2/api/Phalcon_Acl_AdapterInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/acl/adapter/memory.zep" class="btn btn-default btn-sm">Source sur GitHub</a>

Gère les listes ACL dans la mémoire

```php
<?php

$acl = new \Phalcon\Acl\Adapter\Memory();

$acl->setDefaultAction(
    \Phalcon\Acl::DENY
);

// Register roles
$roles = [
    "users"  => new \Phalcon\Acl\Role("Users"),
    "guests" => new \Phalcon\Acl\Role("Guests"),
];
foreach ($roles as $role) {
    $acl->addRole($role);
}

// Private area resources
$privateResources = [
    "companies" => ["index", "search", "new", "edit", "save", "create", "delete"],
    "products"  => ["index", "search", "new", "edit", "save", "create", "delete"],
    "invoices"  => ["index", "profile"],
];

foreach ($privateResources as $resourceName => $actions) {
    $acl->addResource(
        new \Phalcon\Acl\Resource($resourceName),
        $actions
    );
}

// Public area resources
$publicResources = [
    "index"   => ["index"],
    "about"   => ["index"],
    "session" => ["index", "register", "start", "end"],
    "contact" => ["index", "send"],
];

foreach ($publicResources as $resourceName => $actions) {
    $acl->addResource(
        new \Phalcon\Acl\Resource($resourceName),
        $actions
    );
}

// Grant access to public areas to both users and guests
foreach ($roles as $role){
    foreach ($publicResources as $resource => $actions) {
        $acl->allow($role->getName(), $resource, "*");
    }
}

// Grant access to private area to role Users
foreach ($privateResources as $resource => $actions) {
    foreach ($actions as $action) {
        $acl->allow("Users", $resource, $action);
    }
}

```

## Méthodes

public **__construct** ()

Phalcon\\Acl\\Carte\\Memory constructeur

public **addRole** (*RoleInterface* | *string* $role, [*array* | *string* $accessInherits])

Ajoute un rôle à la liste de contrôle d'accès. Le deuxième paramètre permet d'hériter d'accéder aux données à partir d'autres rôles existants Exemple:

```php
<?php

$acl->addRole(
    new Phalcon\Acl\Role("administrator"),
    "consultant"
);

$acl->addRole("administrator", "consultant");

```

public **addInherit** (*mixte* $roleName, *mixte* $roleToInherit)

Faire un rôle hériter d'un autre rôle existant

public **isRole** (*mixed* $roleName)

Vérifier si le rôle existe dans la liste des rôles

public **isResource** (*mixed* $resourceName)

Vérifier si la ressource existe dans la liste des ressources

public **addResource** ([Phalcon\Acl\Resource](/en/3.2/api/Phalcon_Acl_Resource) | *string* $resourceValue, *array* | *string* $accessList)

Ajoute une ressource à la liste des listes de contrôle d'accès Les noms d'accès peuvent être une action particulière, par exemple rechercher, mettre à jour, supprimer, etc ou une liste d'entre eux Exemple:

```php
<?php

// Add a resource to the the list allowing access to an action
$acl->addResource(
    new Phalcon\Acl\Resource("customers"),
    "search"
);

$acl->addResource("customers", "search");

// Add a resource  with an access list
$acl->addResource(
    new Phalcon\Acl\Resource("customers"),
    [
        "create",
        "search",
    ]
);

$acl->addResource(
    "customers",
    [
        "create",
        "search",
    ]
);

```

public **addResourceAccess** (*mixed* $resourceName, *array* | *string* $accessList)

Adds access to resources

public **dropResourceAccess** (*mixed* $resourceName, *array* | *string* $accessList)

Removes an access from a resource

protected **_allowOrDeny** (*mixed* $roleName, *mixed* $resourceName, *mixed* $access, *mixed* $action, [*mixed* $func])

Checks if a role has access to a resource

public **allow** (*mixed* $roleName, *mixed* $resourceName, *mixed* $access, [*mixed* $func])

Allow access to a role on a resource You can use '*' as wildcard Example:

```php
<?php

//Allow access to guests to search on customers
$acl->allow("guests", "customers", "search");

//Allow access to guests to search or create on customers
$acl->allow("guests", "customers", ["search", "create"]);

//Allow access to any role to browse on products
$acl->allow("*", "products", "browse");

//Allow access to any role to browse on any resource
$acl->allow("*", "*", "browse");

```

public **deny** (*mixed* $roleName, *mixed* $resourceName, *mixed* $access, [*mixed* $func])

Refuser l'accès à un rôle sur une ressource Vous pouvez utiliser '*' comme caractère générique Exemple:

```php
<?php

//Deny access to guests to search on customers
$acl->deny("guests", "customers", "search");

//Deny access to guests to search or create on customers
$acl->deny("guests", "customers", ["search", "create"]);

//Deny access to any role to browse on products
$acl->deny("*", "products", "browse");

//Deny access to any role to browse on any resource
$acl->deny("*", "*", "browse");

```

public **isAllowed** (*RoleInterface* | *RoleAware* | *string* $roleName, *ResourceInterface* | *ResourceAware* | *string* $resourceName, *mixed* $access, [*array* $parameters])

Vérifier si un rôle est autorisé à accéder à une action à partir d'une ressource

```php
<?php

//Does andres have access to the customers resource to create?
$acl->isAllowed("andres", "Products", "create");

//Do guests have access to any resource to edit?
$acl->isAllowed("guests", "*", "edit");

```

public **setNoArgumentsDefaultAction** (*mixed* $defaultAccess)

Sets the default access level (Phalcon\\Acl::ALLOW or Phalcon\\Acl::DENY) for no arguments provided in isAllowed action if there exists func for accessKey

public **getNoArgumentsDefaultAction** ()

Returns the default ACL access level for no arguments provided in isAllowed action if there exists func for accessKey

public **getRoles** ()

Return an array with every role registered in the list

public **getResources** ()

Return an array with every resource registered in the list

public **getActiveRole** () inherited from [Phalcon\Acl\Adapter](/en/3.2/api/Phalcon_Acl_Adapter)

Role which the list is checking if it's allowed to certain resource/access

public **getActiveResource** () inherited from [Phalcon\Acl\Adapter](/en/3.2/api/Phalcon_Acl_Adapter)

Resource which the list is checking if some role can access it

public **getActiveAccess** () inherited from [Phalcon\Acl\Adapter](/en/3.2/api/Phalcon_Acl_Adapter)

Active access which the list is checking if some role can access it

public **setEventsManager** ([Phalcon\Events\ManagerInterface](/en/3.2/api/Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Acl\Adapter](/en/3.2/api/Phalcon_Acl_Adapter)

Sets the events manager

public **getEventsManager** () inherited from [Phalcon\Acl\Adapter](/en/3.2/api/Phalcon_Acl_Adapter)

Returns the internal event manager

public **setDefaultAction** (*mixed* $defaultAccess) inherited from [Phalcon\Acl\Adapter](/en/3.2/api/Phalcon_Acl_Adapter)

Sets the default access level (Phalcon\\Acl::ALLOW or Phalcon\\Acl::DENY)

public **getDefaultAction** () inherited from [Phalcon\Acl\Adapter](/en/3.2/api/Phalcon_Acl_Adapter)

Returns the default ACL access level