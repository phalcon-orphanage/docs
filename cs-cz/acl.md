---
layout: article
language: 'cs-cz'
version: '4.0'
---

<a name='overview'></a>

# Access Control Lists (ACL)

[Phalcon\Acl](api/Phalcon_Acl) provides an easy and lightweight management of ACLs as well as the permissions attached to them. [Access Control Lists](http://en.wikipedia.org/wiki/Access_control_list) (ACL) umožňují řídit přístup k různým částem aplikace a základním objektům z požadavku. Doporučujeme přečíst více informací o metodologii ACL, abyste se seznámili s jeho konceptem.

Ve výsledku ACL obsahují role a zdroje. Zdroje jsou objekty, které řídí oprávnění jim definované v seznamech ACL. Role jsou objekty, které požadují přístup k prostředkům a může jim být povolen nebo odepřen přístup.

<a name='setup'></a>

## Creating an ACL

Tato komponenta je navržena tak, aby od začátku fungovala v paměti. To umožňuje snadné používání a rychlý přístup ke všem vlastnostem seznamu. The [Phalcon\Acl](api/Phalcon_Acl) constructor takes as its first parameter an adapter used to retrieve the information related to the control list. Příklad použití memory adaptéru je následující:

```php
<?php

use Phalcon\Acl\Adapter\Memory as AclList;

$acl = new AclList();
```

By default [Phalcon\Acl](api/Phalcon_Acl) allows access to action on resources that have not yet been defined. Chcete-li zvýšit úroveň zabezpečení seznamu přístupu, můžete definovat úroveň `deny` jako výchozí úroveň přístupu.

```php
<?php

use Phalcon\Acl;

// Default action is deny access
$acl->setDefaultAction(
    Acl::DENY
);
```

<a name='adding-roles'></a>

## Přidání rolí do ACL

Role je objekt, který může nebo nemůže získat přístup k určitým prostředkům v seznamu. Jako příklad definujeme role jako skupiny lidí v rámci organizace. The [Phalcon\Acl\Role](api/Phalcon_Acl_Role) class is available to create roles in a more structured way. Přidejme k našemu nedávno vytvořenému seznamu nějaké role:

```php
<?php

use Phalcon\Acl\Role;

// Create some roles.
// The first parameter is the name, the second parameter is an optional description.
$roleAdmins = new Role('Administrators', 'Super-User role');
$roleGuests = new Role('Guests');

// Add 'Guests' role to ACL
$acl->addRole($roleGuests);

// Add 'Designers' role to ACL without a Phalcon\Acl\Role
$acl->addRole('Designers');
```

Jak vidíte, role jsou definovány přímo bez použití instance.

<a name='adding-resources'></a>

## Přidávání zdrojů

Zdroje jsou objekty, kde se kontroluje přístup. Obvykle v MVC aplikacích zdroje odkazují na controllery. Although this is not mandatory, the [Phalcon\Acl\Resource](api/Phalcon_Acl_Resource) class can be used in defining resources. Důležité je přidat související akce nebo operace k prostředkům, aby seznam ACL pochopil, co by měl kontrolovat.

```php
<?php

use Phalcon\Acl\Resource;

// Define the 'Customers' resource
$customersResource = new Resource('Customers');

// Add 'customers' resource with a couple of operations

$acl->addResource(
    $customersResource,
    'search'
);

$acl->addResource(
    $customersResource,
    [
        'create',
        'update',
    ]
);
```

<a name='access-controls'></a>

## Definování oprávnění

Nyní, když máme role a zdroje, je na čase definovat ACL (tzn. které role mohou přistupovat k jakým zdrojům). Tato část je velmi důležitá, zejména vezmeme-li v úvahu vaše výchozí nastavení úrovně přístupu `allow` nebo `deny`.

```php
<?php

// Set access level for roles into resources

$acl->allow('Guests', 'Customers', 'search');

$acl->allow('Guests', 'Customers', 'create');

$acl->deny('Guests', 'Customers', 'update');
```

Metoda `allow()` určuje, že určitá role má udělený přístup ke konkrétnímu zdroji, metoda `deny()` metoda provádí opak.

<a name='querying'></a>

## Dotazování na ACL

Jakmile je seznam definován, můžeme kontrolovat, zda role má dané oprávnění nebo ne.

```php
<?php

// Check whether role has access to the operations

// Returns 0
$acl->isAllowed('Guests', 'Customers', 'edit');

// Returns 1
$acl->isAllowed('Guests', 'Customers', 'search');

// Returns 1
$acl->isAllowed('Guests', 'Customers', 'create');
```

<a name='function-based-access'></a>

## Funkcí řízený přístup

Také můžete přidat jako 4. parametr vaší vlastní funkci, která musí vrátit boolean hodnotu. Tato funkce bude volána při použití metody `isAllowed()`. Parametry můžete předávat jako asociativní pole metody `isAllowed()` jako 4. argument, kde klíč je název parametru v naší definované funkci.

```php
<?php
// Set access level for role into resources with custom function
$acl->allow(
    'Guests',
    'Customers',
    'search',
    function ($a) {
        return $a % 2 === 0;
    }
);

// Check whether role has access to the operation with custom function

// Returns true
$acl->isAllowed(
    'Guests',
    'Customers',
    'search',
    [
        'a' => 4,
    ]
);

// Returns false
$acl->isAllowed(
    'Guests',
    'Customers',
    'search',
    [
        'a' => 3,
    ]
);
```

Pokud neuvedete žádné parametry v metodě `isAllowed()`, pak výchozí chování bude `Acl::ALLOW`. Výchozí chování můžete změnit pomocí metody `setNoArgumentsDefaultAction()`.

```php
<?php

use Phalcon\Acl;

// Set access level for role into resources with custom function
$acl->allow(
    'Guests',
    'Customers',
    'search',
    function ($a) {
        return $a % 2 === 0;
    }
);

// Check whether role has access to the operation with custom function

// Returns true
$acl->isAllowed(
    'Guests',
    'Customers',
    'search'
);

// Change no arguments default action
$acl->setNoArgumentsDefaultAction(
    Acl::DENY
);

// Returns false
$acl->isAllowed(
    'Guests',
    'Customers',
    'search'
);
```

<a name='objects'></a>

## Objekty jako jméno role a jméno zdroje

Můžete předávat objekty jako `roleName` a `resourceName`. Your classes must implement [Phalcon\Acl\RoleAware](api/Phalcon_Acl_RoleAware) for `roleName` and [Phalcon\Acl\ResourceAware](api/Phalcon_Acl_ResourceAware) for `resourceName`.

Naše třída `UserRole`

```php
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
```

A naše třída `ModelResource`

```php
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
```

Potom můžete použít metodu `isAllowed()`.

```php
<?php

use UserRole;
use ModelResource;

// Set access level for role into resources
$acl->allow('Guests', 'Customers', 'search');
$acl->allow('Guests', 'Customers', 'create');
$acl->deny('Guests', 'Customers', 'update');

// Create our objects providing roleName and resourceName

$customer = new ModelResource(
    1,
    'Customers',
    2
);

$designer = new UserRole(
    1,
    'Designers'
);

$guest = new UserRole(
    2,
    'Guests'
);

$anotherGuest = new UserRole(
    3,
    'Guests'
);

// Check whether our user objects have access to the operation on model object

// Returns false
$acl->isAllowed(
    $designer,
    $customer,
    'search'
);

// Returns true
$acl->isAllowed(
    $guest,
    $customer,
    'search'
);

// Returns true
$acl->isAllowed(
    $anotherGuest,
    $customer,
    'search'
);
```

Také lze přistupovat k těmto objektům ve vlastní funkci `allow()` nebo `deny()`. Objekty jsou automaticky přiřazeny parametrům podle jejich typu ve funkci.

```php
<?php

use UserRole;
use ModelResource;

// Set access level for role into resources with custom function
$acl->allow(
    'Guests',
    'Customers',
    'search',
    function (UserRole $user, ModelResource $model) { // User and Model classes are necessary
        return $user->getId == $model->getUserId();
    }
);

$acl->allow(
    'Guests',
    'Customers',
    'create'
);

$acl->deny(
    'Guests',
    'Customers',
    'update'
);

// Create our objects providing roleName and resourceName

$customer = new ModelResource(
    1,
    'Customers',
    2
);

$designer = new UserRole(
    1,
    'Designers'
);

$guest = new UserRole(
    2,
    'Guests'
);

$anotherGuest = new UserRole(
    3,
    'Guests'
);

// Check whether our user objects have access to the operation on model object

// Returns false
$acl->isAllowed(
    $designer,
    $customer,
    'search'
);

// Returns true
$acl->isAllowed(
    $guest,
    $customer,
    'search'
);

// Returns false
$acl->isAllowed(
    $anotherGuest,
    $customer,
    'search'
);
```

Stále můžete přidat vlastní parametry do funkce a předat asociativní pole v metodě `isAllowed()`. Rovněž nezáleží na pořadí.

<a name='roles-inheritance'></a>

## Dědění rolí

You can build complex role structures using the inheritance that [Phalcon\Acl\Role](api/Phalcon_Acl_Role) provides. Role můžou dědit z jiných rolí, což umožňuje přístup ke zdrojům rodiče. Chcete-li použít dědičnost rolí, je třeba předat zděděnou roli jako druhý parametr volání metody, při přidání této role v seznamu.

```php
<?php

use Phalcon\Acl\Role;

// ...

// Create some roles

$roleAdmins = new Role('Administrators', 'Super-User role');

$roleGuests = new Role('Guests');

// Add 'Guests' role to ACL
$acl->addRole($roleGuests);

// Add 'Administrators' role inheriting from 'Guests' its accesses
$acl->addRole($roleAdmins, $roleGuests);
```

### Setup relationships after adding roles

Or you may prefer to add all of your roles together and then define the inheritance relationships afterwards.

```php
<?php

use Phalcon\Acl\Role;

// Create some roles
$roleAdmins = new Role('Administrators', 'Super-User role');
$roleGuests = new Role('Guests');

// Add Roles to ACL
$acl->addRole($roleGuests);
$acl->addRole($roleAdmins);

// Have 'Administrators' role inherit from 'Guests' its accesses
$acl->addInherit($roleAdmins, $roleGuests);
```

<a name='serialization'></a>

## Serializace ACL

To improve performance [Phalcon\Acl](api/Phalcon_Acl) instances can be serialized and stored in APC, session, text files or a database table so that they can be loaded at will without having to redefine the whole list. Můžete to udělat takto:

```php
<?php

use Phalcon\Acl\Adapter\Memory as AclList;

// ...

// Check whether ACL data already exist
if (!is_file('app/security/acl.data')) {
    $acl = new AclList();

    // ... Define roles, resources, access, etc

    // Store serialized list into plain file
    file_put_contents(
        'app/security/acl.data',
        serialize($acl)
    );
} else {
    // Restore ACL object from serialized file
    $acl = unserialize(
        file_get_contents('app/security/acl.data')
    );
}

// Use ACL list as needed
if ($acl->isAllowed('Guests', 'Customers', 'edit')) {
    echo 'Access granted!';
} else {
    echo 'Access denied :(';
}
```

Je doporučováno používat memory adaptér během vývoje a jeden z ostatních adaptérů v produkci.

<a name='events'></a>

## Events

[Phalcon\Acl](api/Phalcon_Acl) is able to send events to an `EventsManager` if it's present. Události se spouštějí pomocí typu "acl". Některé události při vrácení hodnoty false můžou zastavit aktivní operaci. Podporovány jsou následující události:

| Jméno události    | Spuštění                                            | Zastaví operaci? |
| ----------------- | --------------------------------------------------- |:----------------:|
| beforeCheckAccess | Spustí se před kontrolou, zda má role/zdroj přístup |       Ano        |
| afterCheckAccess  | Spustí se po kontrole, zda má role/zdroj přístup    |        Ne        |

Následující příklad ukazuje, jak připojit listenery k událostem:

```php
<?php

use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;

// ...

// Create an event manager
$eventsManager = new EventsManager();

// Attach a listener for type 'acl'
$eventsManager->attach(
    'acl:beforeCheckAccess',
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
```

<a name='custom-adapters'></a>

## Implementace vlastních adaptérů

The [Phalcon\Acl\AdapterInterface](api/Phalcon_Acl_AdapterInterface) interface must be implemented in order to create your own ACL adapters or extend the existing ones.