* * *

layout: default language: 'en' version: '3.4'

* * *

<a name='overview'></a>

# Erişim Kontrol Listeleri (ACL)

[Phalcon\Acl](api/Phalcon_Acl) provides an easy and lightweight management of ACLs as well as the permissions attached to them. [Erişim Kontrol Listeleri](http://en.wikipedia.org/wiki/Access_control_list) (ACL) bir uygulamanın kendi alanlarına ve temel alınan nesneleri isteklerden denetlemesine izin verir. ACL metodolojisi hakkında daha fazla bilgi edinmeniz ve böylece kavramlarıyla aşina olmanız önerilir.

Özetlemek gerekirse, ACL'lerin rolleri ve kaynakları vardır. Kaynaklar, ACL'ler tarafından tanımlanan izinlere uyan nesnelerdir. Roller, kaynaklara erişim isteyen nesnelerdir ve ACL mekanizması tarafından erişime izin verilebilir veya erişim engellenebilir.

<a name='setup'></a>

## Creating an ACL

Bu bileşen başlangıçta bellekte çalışmak üzere tasarlanmıştır. Bu, kullanım kolaylığı sağlar ve listenin her alanına erişirken hızlanır. The [Phalcon\Acl](api/Phalcon_Acl) constructor takes as its first parameter an adapter used to retrieve the information related to the control list. Bellek adaptörünü kullanan bir örnek aşağıda verilmiştir:

```php
<?php

use Phalcon\Acl\Adapter\Memory as AclList;

$acl = new AclList();
```

By default [Phalcon\Acl](api/Phalcon_Acl) allows access to action on resources that have not yet been defined. Erişim listesinin güvenlik seviyesini artırmak için bir `deny` seviyesini varsayılan erişim seviyesi olarak tanımlayabiliriz.

```php
<?php

use Phalcon\Acl;

// Varsayılan işlem erişimi reddet
$acl->setDefaultAction(
    Acl::DENY
);
```

<a name='adding-roles'></a>

## Adding Roles to the ACL

Bir rol, erişim listesindeki belirli kaynaklara erişebilen veya erişemeyen bir nesnedir. Örnek olarak, rolleri bir organizasyon içerisindeki gruplar olarak tanımlayacağız. The [Phalcon\Acl\Role](api/Phalcon_Acl_Role) class is available to create roles in a more structured way. Yakın zamanda oluşturulmuş listemize bazı roller ekleyelim:

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

## Adding Resources

Kaynaklar, erişimin kontrol edildiği nesnelerdir. Normalde MVC uygulamalarında kaynaklar denetleyicileri gösterir. Although this is not mandatory, the [Phalcon\Acl\Resource](api/Phalcon_Acl_Resource) class can be used in defining resources. ACL'nin kontrol etmesi gereken şeyi anlaması için bir kaynağa ilgili işlemler veya işlemler eklemek önemlidir.

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

## Defining Access Controls

Artık roller ve kaynaklara sahibiz, şimdi ACL'yi tanımlama zamanı geldi (yani hangi rollerin hangi kaynaklara erişebileceğini). Bu bölüm, özellikle varsayılan erişim düzeyiniz `izin vermek` veya `reddetmek` olarak dikkate alırsak çok önemlidir.

```php
<?php

// Rollerin erişim seviyelerini kaynaklara ayarlayın

$acl->allow('Ziyaretçiler', 'Müşteriler', 'search');

$acl->allow('Ziyaretçiler', 'Müşteriler', 'create');

$acl->deny('Ziyaretçiler', 'Müşteriler', 'update');
```

The `allow()` method designates that a particular role has granted access to a particular resource. The `deny()` method does the opposite.

<a name='querying'></a>

## Querying an ACL

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

## Function based access

Ayrıca, 4'üncü parametre olarak boolean değerini döndüren özel işlevinizi ekleyebilirsiniz. `isAllowed()` yöntemini kullandığınızda çağrılır. Parametreleri ilişkisel dizi olarak `isAllowed()` yöntemine 4. argüman olarak aktarabilirsiniz, burada anahtar tanımlı işlevimizdeki parametre adıdır.

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

Ayrıca `isAllowed()` yönteminde herhangi bir parametre sağlamazsanız, varsayılan davranış `Acl::ALLOW` olacaktır. Bunu `setNoArgumentsDefaultAction()` yöntemi kullanarak değiştirebilirsiniz.

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

## Objects as role name and resource name

Nesneleri `roleName` ve `resourceName` olarak geçirebilirsiniz. Your classes must implement [Phalcon\Acl\RoleAware](api/Phalcon_Acl_RoleAware) for `roleName` and [Phalcon\Acl\ResourceAware](api/Phalcon_Acl_ResourceAware) for `resourceName`.

`UserRole` sınıfımız

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

## Roles Inheritance

You can build complex role structures using the inheritance that [Phalcon\Acl\Role](api/Phalcon_Acl_Role) provides. Roller diğer rollerden miras kalabilir, böylece üst sınıflara veya kaynak alt kümelerine erişime izin verebilir. Rol kalıtımını kullanmak için, devredilen rolü, listede bu rolü eklerken yöntem çağrısının ikinci parametresi olarak iletmeniz gerekir.

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

## Serializing ACL lists

To improve performance [Phalcon\Acl](api/Phalcon_Acl) instances can be serialized and stored in APC, session, text files or a database table so that they can be loaded at will without having to redefine the whole list. Bunu şu şekilde yapabilirsiniz:

```php
<?php

use Phalcon\Acl\Adapter\Memory as AclList;

// ...

// ACL verisinin mevcut olup olmadığını kontrol etme
if (!is_file('app/security/acl.data')) {
    $acl = new AclList();

    // ... Rolleri, kaynakları, erişimi vb. tanımlayın

    // Seri hale getirilmiş listeyi düz dosyaya kaydedin
    file_put_contents(
        'app/security/acl.data',
        serialize($acl)
    );
} else {
    // Sıralı dosyadan ACL nesnesini geri yükle
    $acl = unserialize(
        file_get_contents('app/security/acl.data')
    );
}

// ACL listesini gerektiği gibi kullanın
if ($acl->isAllowed('Ziyaretçiler', 'Müşteriler', 'edit')) {
    echo 'Erişim izni verildi!';
} else {
    echo 'Erişim reddedildi :(';
}
```

Geliştirme sırasında Memory adaptörünü kullanmanız ve canlı ortamda diğer adaptörlerden birini kullanmanız önerilir.

<a name='events'></a>

## Events

[Phalcon\Acl](api/Phalcon_Acl) is able to send events to an `EventsManager` if it's present. Olaylar 'acl' türünü kullanarak tetiklenir. Boolean false döndürürken bazı olaylar etkin işlemi durdurabilir. Aşağıdaki olaylar desteklenmektedir:

| Olay Adı          | Tetiklendi                                                               | İşlemi durdurabilir mi? |
| ----------------- | ------------------------------------------------------------------------ |:-----------------------:|
| beforeCheckAccess | Bir rol/kaynağa erişim olup olmadığını kontrol etmeden önce tetiklenir   |          Evet           |
| afterCheckAccess  | Bir rol/kaynağa erişim olup olmadığını kontrol ettikten sonra tetiklenir |          Hayır          |

Aşağıdaki örnek, dinleyicilerin bu bileşene nasıl ekleneceğini göstermektedir:

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

<a name='custom-adapters'></a>

## Implementing your own adapters

The [Phalcon\Acl\AdapterInterface](api/Phalcon_Acl_AdapterInterface) interface must be implemented in order to create your own ACL adapters or extend the existing ones.