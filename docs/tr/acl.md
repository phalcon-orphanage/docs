<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Erişim Kontrol Listeleri</a> <ul>
        <li>
          <a href="#setup">ACL Oluşturma</a>
        </li>
        <li>
          <a href="#adding-roles">ACL'ye Rol Ekleme</a>
        </li>
        <li>
          <a href="#adding-resources">Kaynakları Ekleme</a>
        </li>
        <li>
          <a href="#access-controls">Erişim Kontrolleri Tanımlama</a>
        </li>
        <li>
          <a href="#querying">ACL Sorgulama</a>
        </li>
        <li>
          <a href="#function-based-access">Fonksiyona Dayalı Erişim</a>
        </li>
        <li>
          <a href="#objects">Rol adı ve kaynak adı olan nesneler</a>
        </li>
        <li>
          <a href="#roles-inheritance">Rollerin Kalıtımı</a>
        </li>
        <li>
          <a href="#serialization">ACL Listelerini Seri Hale Getirme</a>
        </li>
        <li>
          <a href="#events">Olaylar</a>
        </li>
        <li>
          <a href="#custom-adapters">Kendi Bağdaştırıcılarını Uygulama</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Erişim Kontrol Listeleri (ACL)

`Phalcon\Acl` provides an easy and lightweight management of ACLs as well as the permissions attached to them. [Access Control Lists](http://en.wikipedia.org/wiki/Access_control_list) (ACL) allow an application to control access to its areas and the underlying objects from requests. You are encouraged to read more about the ACL methodology so as to be familiar with its concepts.

In summary, ACLs have roles and resources. Resources are objects which abide by the permissions defined to them by the ACLs. Roles are objects that request access to resources and can be allowed or denied access by the ACL mechanism.

<a name='setup'></a>

## ACL Oluşturma

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

// Varsayılan işlem erişimi reddet
$acl->setDefaultAction(
    Acl::DENY
);
```

<a name='adding-roles'></a>

## ACL'ye Rol Ekleme

A role is an object that can or cannot access certain resources in the access list. As an example, we will define roles as groups of people in an organization. The `Phalcon\Acl\Role` class is available to create roles in a more structured way. Let's add some roles to our recently created list:

```php
<?php

use Phalcon\Acl\Role;

// Birkaç rol oluştur.
// İlk parametre adı, ikinci parametre ise opsiyonel açıklamadır.
$roleAdmins = new Role('Yöneticiler', 'Süper-Kullanıcı rolü');
$roleGuests = new Role('Ziyaretçiler');

// ACL'ye 'Ziyaretçiler' rolü ekle
$acl->addRole($roleGuests);

// ACL'ye Phalcon\Acl\Role kullanmadan 'Tasarımcılar' rolü ekle
$acl->addRole('Tasarımcılar');
```

Görebildiğiniz gibi, roller bir örnek kullanmadan doğrudan tanımlanır.

<a name='adding-resources'></a>

## Kaynakları Ekleme

Resources are objects where access is controlled. Normally in MVC applications resources refer to controllers. Although this is not mandatory, the `Phalcon\Acl\Resource` class can be used in defining resources. It's important to add related actions or operations to a resource so that the ACL can understand what it should to control.

```php
<?php

use Phalcon\Acl\Resource;

// 'Müşteriler' kaynağı tanımla
$customersResource = new Resource('Müşteriler');

// Birkaç işlemle 'müşteriler' kaynağını ekleyin

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

## Erişim Kontrolleri Tanımlama

Now that we have roles and resources, it's time to define the ACL (i.e. which roles can access which resources). This part is very important especially taking into consideration your default access level `allow` or `deny`.

```php
<?php

// Rollerin erişim seviyelerini kaynaklara ayarlayın

$acl->allow('Ziyaretçiler', 'Müşteriler', 'search');

$acl->allow('Ziyaretçiler', 'Müşteriler', 'create');

$acl->deny('Ziyaretçiler', 'Müşteriler', 'update');
```

The `allow()` method designates that a particular role has granted access to a particular resource. The `deny()` method does the opposite.

<a name='querying'></a>

## ACL Sorgulama

Once the list has been completely defined. We can query it to check if a role has a given permission or not.

```php
<?php

// Rolün operasyonlara erişip erişmediğini kontrol etme

// Geriye 0 döner
$acl->isAllowed('Ziyaretçiler', 'Müşteriler', 'edit');

// Geriye 1 döner
$acl->isAllowed('Ziyaretçiler', 'Müşteriler', 'search');

// Geriye 1 döner
$acl->isAllowed('Ziyaretçiler', 'Müşteriler', 'create');
```

<a name='function-based-access'></a>

## Fonksiyona Dayalı Erişim

Also you can add as 4th parameter your custom function which must return boolean value. It will be called when you use `isAllowed()` method. You can pass parameters as associative array to `isAllowed()` method as 4th argument where key is parameter name in our defined function.

```php
<?php
// Rol için erişim seviyesini özel fonksiyonla kaynaklara ayarlayın
$acl->allow(
    'Ziyaretçiler',
    'Müşteriler',
    'search',
    function ($a) {
        return $a % 2 === 0;
    }
);

// Rolün, özel fonksiyonla işleme erişimi olup olmadığını kontrol edin

// Geriye true döner
$acl->isAllowed(
    'Ziyaretçiler',
    'Müşteriler',
    'search',
    [
        'a' => 4,
    ]
);

// Geriye false döner
$acl->isAllowed(
    'Ziyaretçiler',
    'Müşteriler',
    'search',
    [
        'a' => 3,
    ]
);
```

Also if you don't provide any parameters in `isAllowed()` method then default behaviour will be `Acl::ALLOW`. You can change it by using method `setNoArgumentsDefaultAction()`.

```php
use Phalcon\Acl;

<?php
// Rol için erişim düzeyini özel fonksiyonla kaynaklara ayarla
$acl->allow(
    'Ziyaretçiler',
    'Müşteriler',
    'search',
    function ($a) {
        return $a % 2 === 0;
    }
);

// Rolün, özel fonksiyonla işleme erişimi olup olmadığını kontrol edin

// Returns true
$acl->isAllowed(
    'Ziyaretçiler',
    'Müşteriler',
    'search'
);

// Argümanları değiştirme varsayılan eylem
$acl->setNoArgumentsDefaultAction(
    Acl::DENY
);

// Geriye false döner
$acl->isAllowed(
    'Ziyaretçiler',
    'Müşteriler',
    'search'
);
```

<a name='objects'></a>

## Rol adı ve kaynak adı olan nesneler

You can pass objects as `roleName` and `resourceName`. Your classes must implement `Phalcon\Acl\RoleAware` for `roleName` and `Phalcon\Acl\ResourceAware` for `resourceName`.

Our `UserRole` class

```php
<?php

use Phalcon\Acl\RoleAware;

// roleName olarak kullanılacak sınıfı oluştur
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

    // RoleAware arabiriminden uygulanan fonksiyon
    public function getRoleName()
    {
        return $this->roleName;
    }
}
```

Ve bizim `ModelResource` sınıfımız

```php
<?php

use Phalcon\Acl\ResourceAware;

// resourceName olarak kullanılacak sınıfımızı oluştur
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

    // ResourceAware Arabiriminden uygulanan fonksiyon
    public function getResourceName()
    {
        return $this->resourceName;
    }
}
```

Sonra onları `isAllowed()` yönteminde kullanabilirsiniz.

```php
<?php

use UserRole;
use ModelResource;

// Rol için erişim seviyesini kaynaklara ayarlayın
$acl->allow('Ziyaretçiler', 'Müşteriler', 'search');
$acl->allow('Ziyaretçiler', 'Müşteriler', 'create');
$acl->deny('Ziyaretçiler', 'Müşteriler', 'update');

// roleName ve resourceName sağlayarak nesnelerimizi oluştur

$customer = new ModelResource(
    1,
    'Müşteriler',
    2
);

$designer = new UserRole(
    1,
    'Tasarımcılar'
);

$guest = new UserRole(
    2,
    'Ziyaretçiler'
);

$anotherGuest = new UserRole(
    3,
    'Ziyaretçiler'
);

// Kullanıcı nesnelerinizin model nesnesindeki işleme erişimi olup olmadığını kontrol edin

// Geriye false döner
$acl->isAllowed(
    $designer,
    $customer,
    'search'
);

// Geriye true döner
$acl->isAllowed(
    $guest,
    $customer,
    'search'
);

// Geriye true döner
$acl->isAllowed(
    $anotherGuest,
    $customer,
    'search'
);
```

Also you can access those objects in your custom function in `allow()` or `deny()`. They are automatically bind to parameters by type in function.

```php
<?php

use UserRole;
use ModelResource;

// Rol için erişim düzeyini özel fonksiyonla kaynaklara ayarla
$acl->allow(
    'Ziyaretçiler',
    'Müşteriler',
    'search',
    function (UserRole $user, ModelResource $model) { // Kullanıcı ve Model sınıfları gereklidir
        return $user->getId == $model->getUserId();
    }
);

$acl->allow(
    'Ziyaretçiler',
    'Müşteriler',
    'create'
);

$acl->deny(
    'Ziyaretçiler',
    'Müşteriler',
    'update'
);

// roleName ve resourceName sağlayarak nesnelerimizi oluştur

$customer = new ModelResource(
    1,
    'Müşteriler',
    2
);

$designer = new UserRole(
    1,
    'Tasarımcılar'
);

$guest = new UserRole(
    2,
    'Ziyaretçiler'
);

$anotherGuest = new UserRole(
    3,
    'Ziyaretçiler'
);

// Kullanıcı nesnelerinizin model nesnesindeki işleme erişimi olup olmadığını kontrol edin

// Geriye false döner
$acl->isAllowed(
    $designer,
    $customer,
    'search'
);

// Geriye true döner
$acl->isAllowed(
    $guest,
    $customer,
    'search'
);

// Geriye false döner
$acl->isAllowed(
    $anotherGuest,
    $customer,
    'search'
);
```

You can still add any custom parameters to function and pass associative array in `isAllowed()` method. Also order doesn't matter.

<a name='roles-inheritance'></a>

## Rollerin Kalıtımı

You can build complex role structures using the inheritance that `Phalcon\Acl\Role` provides. Roles can inherit from other roles, thus allowing access to supersets or subsets of resources. To use role inheritance, you need to pass the inherited role as the second parameter of the method call, when adding that role in the list.

```php
<?php

use Phalcon\Acl\Role;

// ...

// Birkaç rol oluştur

$roleAdmins = new Role('Yöneticiler', 'Süper-Kullanıcı rolü');

$roleGuests = new Role('Ziyaretçiler');

// ACL'ye 'Ziyaretçiler' rolü ekle
$acl->addRole($roleGuests);

// Erişimlere 'Misafirler' rolünden miras kalan 'Yöneticiler' rolünü ekleyin
$acl->addRole($roleAdmins, $roleGuests);
```

<a name='serialization'></a>

## ACL Listelerini Seri Hale Getirme

To improve performance `Phalcon\Acl` instances can be serialized and stored in APC, session, text files or a database table so that they can be loaded at will without having to redefine the whole list. You can do that as follows:

```php
<?php

use Phalcon\Acl\Adapter\Memory as AclList;

// ...

// ACL verisinin mevcut olup olmadığını kontrol etme
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

It's recommended to use the Memory adapter during development and use one of the other adapters in production.

<a name='setup'></a>

0## Olaylar

`Phalcon\Acl` is able to send events to an `EventsManager` if it's present. Events are triggered using the type 'acl'. Some events when returning boolean false could stop the active operation. The following events are supported:

| Olay Adı          | Tetiklendi                                              | İşlemi durdurabilir mi? |
| ----------------- | ------------------------------------------------------- |:-----------------------:|
| beforeCheckAccess | Triggered before checking if a role/resource has access |           Yes           |
| afterCheckAccess  | Triggered after checking if a role/resource has access  |           No            |

The following example demonstrates how to attach listeners to this component:

```php
<?php

use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;

// ...

// Bir olay yöneticisi oluşturun
$eventsManager = new EventsManager();

// 'Acl' türü için bir dinleyici ekleyin
$eventsManager->attach(
    'acl:beforeCheckAccess',
    function (Event $event, $acl) {
        echo $acl->getActiveRole();

        echo $acl->getActiveResource();

        echo $acl->getActiveAccess();
    }
);

$acl = new AclList();

// $acl değişkenini ayarla
// ...

// eventsManager öğesini ACL bileşenine bağlayın
$acl->setEventsManager($eventsManager);
```

<a name='setup'></a>

1## Kendi Bağdaştırıcılarını Uygulama

`Phalcon\Acl\AdapterInterface` arabirimi kendi ACL bağdaştırıcıları oluşturmak veya mevcut olanları genişletmek için uygulanması gerekir.