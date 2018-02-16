# Class **Phalcon\\Acl\\Adapter\\Memory**

*extends* abstract class [Phalcon\Acl\Adapter](/en/3.2/api/Phalcon_Acl_Adapter)

*mga ipapagawa* [Phalcon\Events\EventsAwareInterface](/en/3.2/api/Phalcon_Events_EventsAwareInterface),[Phalcon\Acl\AdaptorNgInterface](/en/3.2/api/Phalcon_Acl_AdapterInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/acl/adapter/memory.zep" class="btn btn-default btn-sm">Pinagkukunan sa Github</a>

Mga Pangangasiwa sa ACL na mga listahan ng memorya

```php
<<?php

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

## Mga Paraan

pampublikong **__construct** ()

Phalcon\\Acl\\Adaptor\\Memorya

pampublikong **addRole** (*RoleInterface* | *string*$role, [*array* | * string* $accessInherits])

Magdagdag ng isang tungkulin sa listahan ng ACL. Ang pangalawang parametro ay pinapayagan na mag-inherit ng pag-access sa datos mula sa ibang mayroong tungkulin Halimbawa:

```php
<?php

$acl->addRole(
    new Phalcon\Acl\Role("administrator"),
    "consultant"
);

$acl->addRole("administrator", "consultant");

```

pampublikong **addInherit** (*mixed*$roleName, *mixed* $roleToInherit)

Gawin ang isang tungkulin na mag-inherit mula sa ibang mayroong tungkulin

pampublikong **isRole** (*mixed*$roleName)

Siyasatin kung ang tungkulin ay mayroon sa listahan ng mga tungkulin

pampublikong **isResource** (*mixed*$resourceName)

Siyasatin kung ang pinagkukunan ay mayroon sa listahan ng mga pinagkukunan

pampublikong **addResource** ([Phalcon\Acl\Resource](/en/3.2/api/Phalcon_Acl_Resource) | *string* $resourceValue, *array* | *string* $accessList)

Magdagdag ng isang pinagkukunan sa listahan ACL Ang pag-access ng mga pangalan ay maaaring maging isang partikular na aksyon, sa pamamagitan ng halimbawa hanapin, pagbabago, pagbubura, at iba pa o isang listahan ng mga ito Halimbawa:

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

pampublikong **addResourceAccess** (*mixed*$resourceName, *array* | *string* $accessList)

Magdagdag ng pag-access sa mga pinagkukunan

pampublikong **dropresourceAccess** (*mixed* $resourceName, *array* | *string*$accessList)

Mga nag-aalis ng isang pa-access mula sa isang pinagkukunan

protektado ng **_allowOrDeny** (*mixed* $roleName, *mixed* $resourceName, *mixed* $access, *mixed* $action, [*mixed* $func])

Siyasatin kung ang isang tungkulin ay mayroong access sa isang pinagkukunan

pampublikong **allow** (*mixed* $roleName, *mixed* $resourceName, *mixed* $access, [*mixed* $func])

Payagan na ma-access ang isang tungkulin sa isang pinagkukunan Maaari mong gamitin ang '*' bilang wildcard Halimbawa:

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

pampublikong **deny** (*mixed* $roleName, *mixed* $resourceName, *mixed* $access, [*mixed* $func])

Tanggihan ang pag-access sa isang tungkulin ng isang pinagkukunan maaari mong gamitin ang '*' bilang wildcard Halimbawa:

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

pampublikong **isAllowed** (*RoleInterface* | *RoleAware* | *string* $roleName, *ResouceInterface* | *ResourcesAware* | *string*$resourceName, *mixed* $access, [*array*$parameters])

Siyasatin kung ang isang role ay pinayagan na i-access ang isang aksyon mula sa isang pinagkukunan

```php
<?php

//May access ba Si Andress sa mga mamimili sa pinagkukunan upang makagawa?
$acl->isAllowed("andres", "Products", "create");

// Ang mga panauhin ba ay may acces sa kahit anung pinagkukunan upang mag-edit?
$acl->isAllowed("guests", "*", "edit");

```

pampublikong **setNoArgumentsDefaultAction** (*mixed* $defaultAccess)

Itakda ang pag-access sa libel ng default (Phalcon\\Acl::ALLOW or Phalcon\\Acl::DENY) para sa paglaan ng walang mga argumento sa isAllowed na aksyon kung mayroong func para sa accessKey

pampublikong **getNoArgumentsDefaultAction** ()

Bumabalik sa default ang ACL access na libel para sa mga walang argumento na nilaan sa isAllowed na aksyon kung mayroong func para sa accessKey

pampublikong **getRoles** ()

Ibalik ang isang array sa bawat tungkulin ng rehistrado sa listahan

pampublikong **getResources** ()

Ibalik ang isang array sa bawat pinagkukunan na rehistrado sa listhan

pampublikong **getActiveRole** () inherited from [Phalcon\Acl\Adapter](/en/3.2/api/Phalcon_Acl_Adapter)

Ang tungkulin kung saan ang listahan ay nagsisiyasat kung ito ay pinayagan sa tiyak na pinagkukunan/access

pampublikong **getActiveResource** () inherited from [Phalcon\Acl\Adapter](/en/3.2/api/Phalcon_Acl_Adapter)

Ang pinagkukunan kung saan ang listahan ay sinisiyasat kung may tungkulin na maaaring mag-access dito

pampublikong **getActiveAccess** () inherited from [Phalcon\Acl\Adapter](/en/3.2/api/Phalcon_Acl_Adapter)

Ang aktibong pag-access kung saan ang listahan ay sinisiyasat kung may tungkulin na maaring mag-access dito

pampublikong **setEventsManager** ([Phalcon\Events\ManagerInterface](/en/3.2/api/Phalcon_Events_ManagerInterface)$eventsManager) inherited from [Phalcon\Acl\Adapter](/en/3.2/api/Phalcon_Acl_Adapter)

Mga pag-takda ng mga pangyayari ng tagapangasiwa

pampublikong **getEventsManager** () inherited from [Phalcon\Acl\Adapter](/en/3.2/api/Phalcon_Acl_Adapter)

Ibabalik ang panloob na tagapangasiwa sa pangyayari

pampublikong **setDefaultAction** (*mixed* $defaultAccess) inherited from [Phalcon\Acl\adapter](/en/3.2/api/Phalcon_Acl_Adapter)

Itakda ang default access na libel (Phalcon\\Acl::ALLOW or Phalcon\\Acl::DENY)

pampublikong **getDefaultAction** () inherited from [Phalcon\Acl\Adapter](/en/3.2/api/Phalcon_Acl_Adapter)

Ibabalik ang default sa ACL access na libel