# Clase **Phalcon\\Acl\\Adapter\\Memory**

*extends* abstract class [Phalcon\Acl\Adapter](/[[language]]/[[version]]/api/Phalcon_Acl_Adapter)

*implements* [Phalcon\Events\EventsAwareInterface](/[[language]]/[[version]]/api/Phalcon_Events_EventsAwareInterface), [Phalcon\Acl\AdapterInterface](/[[language]]/[[version]]/api/Phalcon_Acl_AdapterInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/acl/adapter/memory.zep" class="btn btn-default btn-sm">Código fuente en GitHub</a>

Gestiona listas ACL en la memoria

```php
<?php

$acl = new \Phalcon\Acl\Adapter\Memory();

$acl->setDefaultAction(
    \Phalcon\Acl::DENY
);

// Registrar roles
$roles = [
    "users"  => new \Phalcon\Acl\Role("Users"),
    "guests" => new \Phalcon\Acl\Role("Guests"),
];
foreach ($roles as $role) {
    $acl->addRole($role);
}

// Recursos del área privada
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

// Recursos del área pública
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

// Otorgar acceso a las áreas publicar a users y guests
foreach ($roles as $role){
    foreach ($publicResources as $resource => $actions) {
        $acl->allow($role->getName(), $resource, "*");
    }
}

// Otorgar acceso al area privada al rol Users
foreach ($privateResources as $resource => $actions) {
    foreach ($actions as $action) {
        $acl->allow("Users", $resource, $action);
    }
}

```

## Métodos

public **__construct** ()

Constructor de Phalcon\\Acl\\Adapter\\Memory

public **addRole** (*RoleInterface* | *string* $role, [*array* | *string* $accessInherits])

Agrega un rol a la lista ACL. El segundo parámetro permite heredar el acceso a los datos de otro rol existente. Ejemplo:

```php
<?php

$acl->addRole(
    new Phalcon\Acl\Role("administrator"),
    "consultant"
);

$acl->addRole("administrator", "consultant");

```

public **addInherit** (*mixed* $roleName, *mixed* $roleToInherit)

Hacer un rol, heredando sus características de otro rol existente

public **isRole** (*mixed* $roleName)

Comprueba si existe el rol en la lista de roles

public **isResource** (*mixed* $resourceName)

Comprueba si el recurso existe en la lista de recursos

public **addResource** ([Phalcon\Acl\Resource](/[[language]]/[[version]]/api/Phalcon_Acl_Resource) | *string* $resourceValue, *array* | *string* $accessList)

Agrega un recurso la lista de acceso ACL. Los nombres de acceso pueden ser una acción específica, por ejemplo: buscar, actualizar, borrar, etc. o una lista de ellos, por ejemplo:

```php
<?php

// Agregar un recurso a lista permitiendo acceso a una acción
$acl->addResource(
    new Phalcon\Acl\Resource("customers"),
    "search"
);

$acl->addResource("customers", "search");

// Agregar un recurso con una lista de acceso
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

Agrega el acceso a recursos

public **dropResourceAccess** (*mixed* $resourceName, *array* | *string* $accessList)

Elimina un acceso de un recurso

protected **_allowOrDeny** (*mixed* $roleName, *mixed* $resourceName, *mixed* $access, *mixed* $action, [*mixed* $func])

Comprueba si un rol tiene acceso a un recurso

public **allow** (*mixed* $roleName, *mixed* $resourceName, *mixed* $access, [*mixed* $func])

Permitir el acceso a un rol en un recurso. Se puede utilizar el asterisco '*' como comodín, por ejemplo:

```php
<?php

// Permitir acceso a guests para buscar en customers
$acl->allow("guests", "customers", "search");

// Permitir acceso a guests para buscar o crear en customers
$acl->allow("guests", "customers", ["search", "create"]);

// Permitir acceso a cualquier rol para visualizar todo en products
$acl->allow("*", "products", "browse");

// Permitir acceso a cualquier rol para visualizar cualquier recurso
$acl->allow("*", "*", "browse");

```

public **deny** (*mixed* $roleName, *mixed* $resourceName, *mixed* $access, [*mixed* $func])

Negar el acceso a un rol en un recurso. Se puede utilizar el asterisco '*' como comodín, por ejemplo:

```php
<?php

// Negar acceso a guests para buscar en customers
$acl->deny("guests", "customers", "search");

// Negar acceso a guests para buscar o crear en customers
$acl->deny("guests", "customers", ["search", "create"]);

// Negar acceso a cualquier rol para visualizar todo en products
$acl->deny("*", "products", "browse");

// Permitir acceso a cualquier rol para visualizar cualquier recurso
$acl->deny("*", "*", "browse");

```

public **isAllowed** (*RoleInterface* | *RoleAware* | *string* $roleName, *ResourceInterface* | *ResourceAware* | *string* $resourceName, *mixed* $access, [*array* $parameters])

Comprobar si un rol tiene permitido el acceso a una acción de un recurso

```php
<?php 
//¿Andres tiene acceso a los recursos de los clientes para crear?
$acl -> isAllowed ("andres", "Products", "create"); 
//¿Los huéspedes tienen acceso a cualquier recurso para editar?
$acl->isAllowed("guests", "*", "edit");

```

public **setNoArgumentsDefaultAction** (*mixed* $defaultAccess)

Establece el nivel de acceso por defecto (Phalcon\\Acl::ALLOW o Phalcon\\Acl::DENY) cuando no se reciben argumentos en la acción isAllowed si existe la función para accessKey

public **getNoArgumentsDefaultAction** ()

Devuelve el nivel de acceso de ACL por defecto sin argumentos en la acción isAllowed si existe la función para accessKey

public **getRoles** ()

Devuelve un array con cada rol registrado en la lista

public **getResources** ()

Devuelve un array con cada recurso registrado en la lista

public **getActiveRole** () inherited from [Phalcon\Acl\Adapter](/[[language]]/[[version]]/api/Phalcon_Acl_Adapter)

Rol que la lista está verificando si está permitido a cierto recurso/acceso

public **getActiveResource** () inherited from [Phalcon\Acl\Adapter](/[[language]]/[[version]]/api/Phalcon_Acl_Adapter)

Recurso que la lista está verificando si algún rol puede acceder a él

public **getActiveAccess** () inherited from [Phalcon\Acl\Adapter](/[[language]]/[[version]]/api/Phalcon_Acl_Adapter)

Acceso activo al cuál la lista esta verificando si algun rol puede accederla

public **setEventsManager** ([Phalcon\Events\ManagerInterface](/[[language]]/[[version]]/api/Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Acl\Adapter](/[[language]]/[[version]]/api/Phalcon_Acl_Adapter)

Establece el administrador de eventos

public **getEventsManager** () inherited from [Phalcon\Acl\Adapter](/[[language]]/[[version]]/api/Phalcon_Acl_Adapter)

Devuelve el administrador de eventos interno

public **setDefaultAction** (*mixed* $defaultAccess) inherited from [Phalcon\Acl\Adapter](/[[language]]/[[version]]/api/Phalcon_Acl_Adapter)

Establece el nivel de acceso por defecto (Phalcon\\Acl::ALLOW o Phalcon\\Acl::DENY)

public **getDefaultAction** () inherited from [Phalcon\Acl\Adapter](/[[language]]/[[version]]/api/Phalcon_Acl_Adapter)

Devuelve el nivel de acceso ACL por defecto