---
layout: default
language: 'es-es'
version: '4.0'
title: 'Phalcon\Acl'
---

* [Phalcon\Acl\Adapter\AbstractAdapter](#acl-adapter-abstractadapter)
* [Phalcon\Acl\Adapter\AdapterInterface](#acl-adapter-adapterinterface)
* [Phalcon\Acl\Adapter\Memory](#acl-adapter-memory)
* [Phalcon\Acl\Component](#acl-component)
* [Phalcon\Acl\ComponentAware](#acl-componentaware)
* [Phalcon\Acl\ComponentInterface](#acl-componentinterface)
* [Phalcon\Acl\Enum](#acl-enum)
* [Phalcon\Acl\Exception](#acl-exception)
* [Phalcon\Acl\Role](#acl-role)
* [Phalcon\Acl\RoleAware](#acl-roleaware)
* [Phalcon\Acl\RoleInterface](#acl-roleinterface)

<h1 id="acl-adapter-abstractadapter">Abstract Class Phalcon\Acl\Adapter\AbstractAdapter</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Acl/Adapter/AbstractAdapter.zep)

| Namespace | Phalcon\Acl\Adapter | | Uses | Phalcon\Acl\Enum, Phalcon\Events\ManagerInterface, Phalcon\Events\EventsAwareInterface | | Implements | AdapterInterface, EventsAwareInterface |

Adaptador para adaptadores Phalcon\Acl

## Propiedades

```php
/**
 * Active access which the list is checking if some role can access it
 *
 * @var string|null
 */
protected activeAccess;

/**
 * Access Granted
 *
 * @var bool
 */
protected accessGranted = false;

/**
 * Role which the list is checking if it's allowed to certain
 * component/access
 *
 * @var string|null
 */
protected activeRole;

/**
 * Component which the list is checking if some role can access it
 *
 * @var string|null
 */
protected activeComponent;

/**
 * Default access
 *
 * @var int
 */
protected defaultAccess;

/**
 * Events manager
 *
 * @var ManagerInterface|null
 */
protected eventsManager;

```

## Métodos

```php
public function getActiveAccess(): string|null
```

```php
public function getActiveComponent(): string|null
```

```php
public function getActiveRole(): string|null
```

```php
public function getDefaultAction(): int;
```

Devuelve el nivel de acceso ACL por defecto

```php
public function getEventsManager(): ManagerInterface;
```

Devuelve el gestor de eventos interno

```php
public function setDefaultAction( int $defaultAccess ): void;
```

Establece el nivel de acceso predeterminado (Phalcon\Acl::ALLOW o Phalcon\Acl::DENY)

```php
public function setEventsManager( ManagerInterface $eventsManager ): void;
```

Establece el gestor de eventos

<h1 id="acl-adapter-adapterinterface">Interface Phalcon\Acl\Adapter\AdapterInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Acl/Adapter/AdapterInterface.zep)

| Namespace | Phalcon\Acl\Adapter | | Uses | Phalcon\Acl\ComponentInterface, Phalcon\Acl\RoleInterface |

Interfaz para adaptadores Phalcon\Acl

## Métodos

```php
public function addComponent( mixed $componentObject, mixed $accessList ): bool;
```

Añade un componente a la lista ACL

Los nombres de acceso pueden ser una acción particular, por ejemplo buscar, actualizar, eliminar, etc o una lista de ellos

```php
public function addComponentAccess( string $componentName, mixed $accessList ): bool;
```

Añade acceso a los componentes

```php
public function addInherit( string $roleName, mixed $roleToInherit ): bool;
```

Hace un rol heredero de otro rol existente

```php
public function addRole( mixed $role, mixed $accessInherits = null ): bool;
```

Añade un rol a la lista ACL. Second parameter lets to inherit access data from other existing role

```php
public function allow( string $roleName, string $componentName, mixed $access, mixed $func = null ): void;
```

Permitir el acceso a un rol en un componente

```php
public function deny( string $roleName, string $componentName, mixed $access, mixed $func = null ): void;
```

Denegar acceso a un rol en un componente

```php
public function dropComponentAccess( string $componentName, mixed $accessList ): void;
```

Elimina un acceso de un componente

```php
public function getActiveAccess(): null | string;
```

Devuelve el acceso que la lista está verificando si algún rol puede acceder a él

```php
public function getActiveComponent(): null | string;
```

Devuelve el componente que la lista está comprobando si algún rol puede acceder a él

```php
public function getActiveRole(): null | string;
```

Devuelve el rol que la lista está comprobando si está permitido para cierto componente/acceso

```php
public function getComponents(): ComponentInterface[];
```

Devuelve un vector con cada componente registrado en la lista

```php
public function getDefaultAction(): int;
```

Devuelve el nivel de acceso ACL por defecto

```php
public function getNoArgumentsDefaultAction(): int;
```

Devuelve el nivel de acceso ALC predeterminado cuando no se proporciona ningún argumento en la acción `isAllowed` si existe una función para `accessKey`

```php
public function getRoles(): RoleInterface[];
```

Devuelve un vector con cada rol registrado en la lista

```php
public function isAllowed( mixed $roleName, mixed $componentName, string $access, array $parameters = null ): bool;
```

Comprueba si un rol puede acceder a una acción desde un componente

```php
public function isComponent( string $componentName ): bool;
```

Comprueba si el componente existe en la lista de componentes

```php
public function isRole( string $roleName ): bool;
```

Comprueba si existe un rol en la lista de roles

```php
public function setDefaultAction( int $defaultAccess ): void;
```

Establece el nivel de acceso predeterminado (Phalcon\Acl\Enum::ALLOW o Phalcon\Acl\Enum::DENY)

```php
public function setNoArgumentsDefaultAction( int $defaultAccess ): void;
```

Establece el nivel de acceso predeterminado (Phalcon\Acl\Enum::ALLOW o Phalcon\Acl\Enum::DENY) cuando no se proporcionan argumentos en la acción `isAllowed` si existe función para `accessKey`

<h1 id="acl-adapter-memory">Class Phalcon\Acl\Adapter\Memory</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Acl/Adapter/Memory.zep)

| Namespace | Phalcon\Acl\Adapter | | Uses | Phalcon\Acl\Enum, Phalcon\Acl\Role, Phalcon\Acl\RoleInterface, Phalcon\Acl\Component, Phalcon\Acl\Exception, Phalcon\Events\Manager, Phalcon\Acl\RoleAware, Phalcon\Acl\ComponentAware, Phalcon\Acl\ComponentInterface, ReflectionFunction | | Extends | AbstractAdapter |

Administra listas de ACL en memoria

```php
$acl = new \Phalcon\Acl\Adapter\Memory();

$acl->setDefaultAction(
    \Phalcon\Acl\Enum::DENY
);

// Register roles
$roles = [
    "users"  => new \Phalcon\Acl\Role("Users"),
    "guests" => new \Phalcon\Acl\Role("Guests"),
];
foreach ($roles as $role) {
    $acl->addRole($role);
}

// Private area components
$privateComponents = [
    "companies" => ["index", "search", "new", "edit", "save", "create", "delete"],
    "products"  => ["index", "search", "new", "edit", "save", "create", "delete"],
    "invoices"  => ["index", "profile"],
];

foreach ($privateComponents as $componentName => $actions) {
    $acl->addComponent(
        new \Phalcon\Acl\Component($componentName),
        $actions
    );
}

// Public area components
$publicComponents = [
    "index"   => ["index"],
    "about"   => ["index"],
    "session" => ["index", "register", "start", "end"],
    "contact" => ["index", "send"],
];

foreach ($publicComponents as $componentName => $actions) {
    $acl->addComponent(
        new \Phalcon\Acl\Component($componentName),
        $actions
    );
}

// Grant access to public areas to both users and guests
foreach ($roles as $role) {
    foreach ($publicComponents as $component => $actions) {
        $acl->allow($role->getName(), $component, "*");
    }
}

// Grant access to private area to role Users
foreach ($privateComponents as $component => $actions) {
    foreach ($actions as $action) {
        $acl->allow("Users", $component, $action);
    }
}
```

## Propiedades

```php
/**
 * Access
 *
 * @var mixed
 */
protected access;

/**
 * Access List
 *
 * @var mixed
 */
protected accessList;

/**
 * Returns latest function used to acquire access
 *
 * @var mixed
 */
protected activeFunction;

/**
 * Returns number of additional arguments(excluding role and resource) for active function
 *
 * @var int
 */
protected activeFunctionCustomArgumentsCount = 0;

/**
 * Returns latest key used to acquire access
 *
 * @var string|null
 */
protected activeKey;

/**
 * Components
 *
 * @var mixed
 */
protected components;

/**
 * Component Names
 *
 * @var mixed
 */
protected componentsNames;

/**
 * Function List
 *
 * @var mixed
 */
protected func;

/**
 * Default action for no arguments is allow
 *
 * @var mixed
 */
protected noArgumentsDefaultAction;

/**
 * Roles
 *
 * @var mixed
 */
protected roles;

/**
 * Role Inherits
 *
 * @var mixed
 */
protected roleInherits;

/**
 * Roles Names
 *
 * @var mixed
 */
protected rolesNames;

```

## Métodos

```php
public function __construct();
```

Constructor Phalcon\Acl\Adapter\Memory

```php
public function addComponent( mixed $componentValue, mixed $accessList ): bool;
```

Añade un componente a la lista ACL

Los nombre de acceso pueden ser una acción particular, por ejemplo buscar, actualizar, borrar, etc o una lista de ellos

Ejemplo:

```php
// Add a component to the the list allowing access to an action
$acl->addComponent(
    new Phalcon\Acl\Component("customers"),
    "search"
);

$acl->addComponent("customers", "search");

// Add a component  with an access list
$acl->addComponent(
    new Phalcon\Acl\Component("customers"),
    [
        "create",
        "search",
    ]
);

$acl->addComponent(
    "customers",
    [
        "create",
        "search",
    ]
);
```

```php
public function addComponentAccess( string $componentName, mixed $accessList ): bool;
```

Añade acceso a los componentes

```php
public function addInherit( string $roleName, mixed $roleToInherits ): bool;
```

Hace un rol heredero de otro rol existente

```php
$acl->addRole("administrator", "consultant");
$acl->addRole("administrator", ["consultant", "consultant2"]);
```

```php
public function addRole( mixed $role, mixed $accessInherits = null ): bool;
```

Añade un rol a la lista ACL. El segundo parámetro permite heredar datos de acceso de otro rol existente

```php
$acl->addRole(
    new Phalcon\Acl\Role("administrator"),
    "consultant"
);

$acl->addRole("administrator", "consultant");
$acl->addRole("administrator", ["consultant", "consultant2"]);
```

```php
public function allow( string $roleName, string $componentName, mixed $access, mixed $func = null ): void;
```

Permitir el acceso a un rol en un componente. Puede usar `*` como comodín

```php
// Allow access to guests to search on customers
$acl->allow("guests", "customers", "search");

// Allow access to guests to search or create on customers
$acl->allow("guests", "customers", ["search", "create"]);

// Allow access to any role to browse on products
$acl->allow("*", "products", "browse");

// Allow access to any role to browse on any component
$acl->allow("*", "*", "browse");


```php
public function deny( string $roleName, string $componentName, mixed $access, mixed $func = null ): void;
```

Denegar el acceso a un rol en un componente. Puede usar `*` como comodín

```php
// Deny access to guests to search on customers
$acl->deny("guests", "customers", "search");

// Deny access to guests to search or create on customers
$acl->deny("guests", "customers", ["search", "create"]);

// Deny access to any role to browse on products
$acl->deny("*", "products", "browse");

// Deny access to any role to browse on any component
$acl->deny("*", "*", "browse");
```

```php
public function dropComponentAccess( string $componentName, mixed $accessList ): void;
```

Elimina un acceso de un componente

```php
public function getActiveFunction(): mixed
```

```php
public function getActiveFunctionCustomArgumentsCount(): int
```

```php
public function getActiveKey(): string|null
```

```php
public function getComponents(): ComponentInterface[];
```

Devuelve un vector con cada componente registrado en la lista

```php
public function getNoArgumentsDefaultAction(): int;
```

Devuelve el nivel de acceso ACL predeterminado cuando no se proporcionan argumentos en la acción `isAllowed` si una `función` (callable) existe para `accessKey`

```php
public function getRoles(): RoleInterface[];
```

Devuelve un vector con cada rol registrado en la lista

```php
public function isAllowed( mixed $roleName, mixed $componentName, string $access, array $parameters = null ): bool;
```

Comprueba si un rol puede acceder a una acción desde un componente

```php
// Does andres have access to the customers component to create?
$acl->isAllowed("andres", "Products", "create");

// Do guests have access to any component to edit?
$acl->isAllowed("guests", "*", "edit");
```

```php
public function isComponent( string $componentName ): bool;
```

Comprueba si el componente existe en la lista de componentes

```php
public function isRole( string $roleName ): bool;
```

Comprueba si existe un rol en la lista de roles

```php
public function setNoArgumentsDefaultAction( int $defaultAccess ): void;
```

Establece el nivel de acceso predeterminado (`Phalcon\Enum::ALLOW` o `Phalcon\Enum::DENY`) cuando no se proporcionan argumentos en la acción `isAllowed` si existe `func` para `accessKey`

<h1 id="acl-component">Class Phalcon\Acl\Component</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Acl/Component.zep)

| Namespace | Phalcon\Acl | | Implements | ComponentInterface |

Esta clase define la entidad componente y su descripción

## Propiedades

```php
/**
 * Component description
 *
 * @var string
 */
private description;

/**
 * Component name
 *
 * @var string
 */
private name;

```

## Métodos

```php
public function __construct( string $name, string $description = null );
```

Constructor Phalcon\Acl\Component

```php
public function __toString(): string
```

```php
public function getDescription(): string
```

```php
public function getName(): string
```

<h1 id="acl-componentaware">Interface Phalcon\Acl\ComponentAware</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Acl/ComponentAware.zep)

| Namespace | Phalcon\Acl |

Interfaz para clases que se podrían usar en el método permitir como RECURSO

## Métodos

```php
public function getComponentName(): string;
```

Devuelve el nombre del componente

<h1 id="acl-componentinterface">Interface Phalcon\Acl\ComponentInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Acl/ComponentInterface.zep)

| Namespace | Phalcon\Acl |

Interfaz para Phalcon\Acl\Component

## Métodos

```php
public function __toString(): string;
```

Método mágico __toString

```php
public function getDescription(): string;
```

Devuelve la descripción del componente

```php
public function getName(): string;
```

Devuelve el nombre del componente

<h1 id="acl-enum">Class Phalcon\Acl\Enum</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Acl/Enum.zep)

| Namespace | Phalcon\Acl |

Constantes para adaptadores Phalcon\Acl\Adapter

## Constantes

```php
const ALLOW = 1;
const DENY = 0;
```

<h1 id="acl-exception">Class Phalcon\Acl\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Acl/Exception.zep)

| Namespace | Phalcon\Acl | | Extends | \Phalcon\Exception |

Clase para excepciones lanzadas por Phalcon\Acl

<h1 id="acl-role">Class Phalcon\Acl\Role</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Acl/Role.zep)

| Namespace | Phalcon\Acl | | Implements | RoleInterface |

Esta clase define la entidad rol y su descripción

## Propiedades

```php
/**
 * Role name
 *
 * @var string
 */
private name;

/**
 * Role description
 *
 * @var string
 */
private description;

```

## Métodos

```php
public function __construct( string $name, string $description = null );
```

Constructor Phalcon\Acl\Role

```php
public function __toString(): string
```

```php
public function getDescription(): string
```

```php
public function getName(): string
```

<h1 id="acl-roleaware">Interface Phalcon\Acl\RoleAware</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Acl/RoleAware.zep)

| Namespace | Phalcon\Acl |

Interfaz para clases que se podrían usar en el método permitir como ROL

## Métodos

```php
public function getRoleName(): string;
```

Devuelve el nombre del rol

<h1 id="acl-roleinterface">Interface Phalcon\Acl\RoleInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Acl/RoleInterface.zep)

| Namespace | Phalcon\Acl |

Interfaz para Phalcon\Acl\Role

## Métodos

```php
public function __toString(): string;
```

Método mágico __toString

```php
public function getDescription(): string;
```

Devuelve la descripción del rol

```php
public function getName(): string;
```

Devuelve el nombre del rol
