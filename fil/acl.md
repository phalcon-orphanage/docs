<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Access Control Lists (ACL)</a>
      <ul>
        <li>
          <a href="#setup">Creating an ACL</a>
        </li>
        <li>
          <a href="#adding-roles">Adding Roles to the ACL</a>
        </li>
        <li>
          <a href="#adding-resources">Adding Resources</a>
        </li>
        <li>
          <a href="#access-controls">Defining Access Controls</a>
        </li>
        <li>
          <a href="#querying">Querying an ACL</a>
        </li>
        <li>
          <a href="#function-based-access">Function based access</a>
        </li>
        <li>
          <a href="#objects">Objects as role name and resource name</a>
        </li>
        <li>
          <a href="#roles-inheritance">Roles Inheritance</a>
        </li>
        <li>
          <a href="#serialization">Serializing ACL lists</a>
        </li>
        <li>
          <a href="#events">Events</a>
        </li>
        <li>
          <a href="#custom-adapters">Implementing your own adapters</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Access Control Lists (ACL)

`Phalcon\Acl` provides an easy and lightweight management of ACLs as well as the permissions attached to them. [Access Control Lists](http://en.wikipedia.org/wiki/Access_control_list) (ACL) allow an application to control access to its areas and the underlying objects from requests. You are encouraged to read more about the ACL methodology so as to be familiar with its concepts.

In summary, ACLs have roles and resources. Resources are objects which abide by the permissions defined to them by the ACLs. Roles are objects that request access to resources and can be allowed or denied access by the ACL mechanism.

<a name='setup'></a>

## Creating an ACL

This component is designed to initially work in memory. This provides ease of use and speed in accessing every aspect of the list. The `Phalcon\Acl` constructor takes as its first parameter an adapter used to retrieve the information related to the control list. An example using the memory adapter is below:

```php
<?php

use Phalcon\Acl\Adapter\Memory as AclList;

$acl = new AclList();
```

By default `Phalcon\Acl` allows access to action on resources that have not yet been defined. To increase the security level of the access list we can define a `deny` level as a default access level.

```php
<?php

use Phalcon\Acl;

// Default action is deny access
$acl->setDefaultAction(
    Acl::DENY
);
```

<a name='adding-roles'></a>

## Adding Roles to the ACL

A role is an object that can or cannot access certain resources in the access list. As an example, we will define roles as groups of people in an organization. The `Phalcon\Acl\Role` class is available to create roles in a more structured way. Let's add some roles to our recently created list:

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

As you can see, roles are defined directly without using an instance.

<a name='adding-resources'></a>

## Adding Resources

Resources are objects where access is controlled. Normally in MVC applications resources refer to controllers. Although this is not mandatory, the `Phalcon\Acl\Resource` class can be used in defining resources. It's important to add related actions or operations to a resource so that the ACL can understand what it should to control.

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

## Defining Access Controls

Now that we have roles and resources, it's time to define the ACL (i.e. which roles can access which resources). This part is very important especially taking into consideration your default access level `allow` or `deny`.

```php
<?php

// Set access level for roles into resources

$acl->allow('Guests', 'Customers', 'search');

$acl->allow('Guests', 'Customers', 'create');

$acl->deny('Guests', 'Customers', 'update');
```

The `allow()` method designates that a particular role has granted access to a particular resource. The `deny()` method does the opposite.

<a name='querying'></a>

## Querying an ACL

Once the list has been completely defined. We can query it to check if a role has a given permission or not.

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

## Function based access

Also you can add as 4th parameter your custom function which must return boolean value. It will be called when you use `isAllowed()` method. You can pass parameters as associative array to `isAllowed()` method as 4th argument where key is parameter name in our defined function.

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

Also if you don't provide any parameters in `isAllowed()` method then default behaviour will be `Acl::ALLOW`. You can change it by using method `setNoArgumentsDefaultAction()`.

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

## Ang mga objects bilang pangalan ng role at resource

Maari kang magpasa ng mga objects bilang `roleName` at `resourceName`. Ang iyong mga class ay dapat magpapatupad sa `Phalcon\Acl\RoleAware` para sa `roleName` at ang `Phalcon\Acl\ResourceAware` para sa `resourceName`.

Ang ating `UserRole` na class

```php
<?php

use Phalcon\Acl\RoleAware;

// Ilikha ang ating class na gagamitin bilang role roleName
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

    // Nagawang function mula sa RoleAware na Interface
    public function getRoleName()
    {
        return $this->roleName;
    }
}
```

At ang ating `ModelResource` na class

```php
<?php

use Phalcon\Acl\ResourceAware;

// Ilikha ang ating class na gagamitin bilang resourceName
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

    // Nagawang function mula sa ResourceAware na Interface
    public function getResourceName()
    {
        return $this->resourceName;
    }
}
```

Pagkatapos ay maaari mo nang gamitin ang mga ito sa `isAllowed()` na method.

```php
<?php

use UserRole;
use ModelResource;

// Itakda ang access level para sa mga papel ng mga resources
$acl->allow('Guests', 'Customers', 'search');
$acl->allow('Guests', 'Customers', 'create');
$acl->deny('Guests', 'Customers', 'update');

// Ilikha ang ating mga object na nagbibigay ng roleName at resourceName

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

// Nagsusuri kung ang mga user na object ay mayroong access sa operasyon na nasa model object

// Returns false
$acl->isAllowed(
    $designer,
    $customer,
    'search'
);

// Nagbabalik ng true
$acl->isAllowed(
    $guest,
    $customer,
    'search'
);

// Nagbabalik ng true
$acl->isAllowed(
    $anotherGuest,
    $customer,
    'search'
);
```

Maaari mo ding i-access ang mga object na iyon sa loob ng iyong custom na function sa `allow()` o `deny()`. Sila ay awtomatikong na-bind sa mga parameter sa pamamagitan ng tipo sa function.

```php
<?php

use UserRole;
use ModelResource;

// Itakda ang access level para sa papel sa mga resources na may mga custom na function
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

// Illikha ang ating mga objects na nagbibigay ng roleName at resourceName

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

// Nagsusuri kung ang ating mga user na object ay mayroong access sa mga operasyon na nasa model na object

// Nagsasauli ng false
$acl->isAllowed(
    $designer,
    $customer,
    'search'
);

// Nagsasauli ng true
$acl->isAllowed(
    $guest,
    $customer,
    'search'
);

// Nagsasauli ng false
$acl->isAllowed(
    $anotherGuest,
    $customer,
    'search'
);
```

Maaari ka pa ring magdagdag ng kahit anong mga custom na mga parameter sa function at magpasa ng associative na array sa `isAllowed()` na method. Ang pagkasunod-sunod din ay hindi mahalaga.

<a name='roles-inheritance'></a>

## Inheritance ng mga Role

Maaari kang bumuo ng komplikadong role na mga istraktura gamit ang inheritance na binibigay ng `Phalcon\Acl\Role`. Ang mga roles ay maaaring magmana mula sa ibang mga role, kaya naman ay nagbibigay ng access sa mga superset o mga subset ng mga resources. Para magamit ang role inheritance, kailangan mong magpasa ng namanang role bilang pangalawang parameter ng pagtawag ng method, habang nagdadagdag sa role na ito sa listahan.

```php
<?php

use Phalcon\Acl\Role;

// ...

// Maglikha ng ilang mga role

$roleAdmins = new Role('Administrators', 'Super-User role');

$roleGuests = new Role('Guests');

// Magdagdag ng 'Guests' na role sa ACL
$acl->addRole($roleGuests);

// Magdagdag ng 'Administrators' na role na nagmamana mula sa 'Guests' na ina-access nito
$acl->addRole($roleAdmins, $roleGuests);
```

<a name='serialization'></a>

## Pag-serialize ng ACL na mga listahan

Para mapabuti ang performance ng `Phalcon\Acl`, ang mga instances ay maaaring i-serialize at i-store sa APC na sesyon, mga text file o isang database na table para sila ay maaaring i-load kung gusto mo nang hindi nangangailangan na ilarawan ulit ang buong listahan. Maaari mo itong gawin gaya ng sumusunod:

```php
<?php

use Phalcon\Acl\Adapter\Memory as AclList;

// ...

// Suriin kung ang ACL na mga datos ay umiiral na
if (!is_file('app/security/acl.data')) {
    $acl = new AclList();

    // ... Paglalarawan sa mga role, mga resources, sa access, atbp.

    // Pag-store ng mga naka-serialize na listahan sa isang simpleng file
    file_put_contents(
        'app/security/acl.data',
        serialize($acl)
    );
} else {
    // Pag-restore ng ACL na object mula sa isang naka-serialize na file
    $acl = unserialize(
        file_get_contents('app/security/acl.data')
    );
}

// Gamitin ang ACL na listahan kung kinakailangan
if ($acl->isAllowed('Guests', 'Customers', 'edit')) {
    echo 'Access granted!';
} else {
    echo 'Access denied :(';
}
```

Ito ay inirerekomenda na gumamit ng Memory adapter habang nagde-develop at gumagamit ng isa sa ibang mga adaptor sa produksyon.

<a name='events'></a>

## Mga Pangyayari

Ang `Phalcon\Acl` ay makakapadala ng mga event papunta sa `EventsManager` kung ito ay nandito. Ang mga events ay mai-trigger gamit ang tipo na 'acl'. Ang ilang mga pangyayari na nagsasauli ng boolean na false ay maaaring makapigil sa aktibong operasyon. Ang sumusunod na mga pangyayari ay sinusuportahan:

| Pangalan ng Pangyayari | Nai-trigger                                                                 | Maaaring magtigil ng operasyon? |
| ---------------------- | --------------------------------------------------------------------------- |:-------------------------------:|
| beforeCheckAccess      | Na-trigger bago magsusuri kung ang isang role/resource ay mayroong access   |               Oo                |
| afterCheckAccess       | Na-trigger pagkatapos magsusuri kung ang isang role/resource ay may acccess |              Hindi              |

Ang sumusunod na mga halimbawa ay nagpapakita kung paano maglakip ng mga listener sa komponent na ito:

```php
<?php

use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;

// ...

// Maglikha ng event manager
$eventsManager = new EventsManager();

// Paglakip ng listener para sa tipong 'acl'
$eventsManager->attach(
    'acl:beforeCheckAccess',
    function (Event $event, $acl) {
        echo $acl->getActiveRole();

        echo $acl->getActiveResource();

        echo $acl->getActiveAccess();
    }
);

$acl = new AclList();

// I-setup ang $acl
// ...

// Nag-bind sa eventsManager sa ACL komponent
$acl->setEventsManager($eventsManager);
```

<a name='custom-adapters'></a>

## Pagsasagawa ng iyong sariling mga adaptor

Ang `Phalcon\Acl\AdapterInterface` na interface ay dapat maisagawa para malikha ang iyong sariling ACL na mga adaptor o mag-extend sa mga umiiral na.