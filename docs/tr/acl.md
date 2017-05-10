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

`Phalcon\Acl` ACL ve bunlara bağlı izinleri kolay ve hafif bir şekilde yönetmenizi sağlar. [Erişim Kontrol Listeleri](http://en.wikipedia.org/wiki/Access_control_list) (ACL) bir uygulamanın kendi alanlarına ve temel alınan nesneleri isteklerden denetlemesine izin verir. ACL metodolojisi hakkında daha fazla bilgi edinmeniz ve böylece kavramlarıyla aşina olmanız önerilir.

Özetlemek gerekirse, ACL'lerin rolleri ve kaynakları vardır. Kaynaklar, ACL'ler tarafından tanımlanan izinlere uyan nesnelerdir. Roller, kaynaklara erişim isteyen nesnelerdir ve ACL mekanizması tarafından erişime izin verilebilir veya erişim engellenebilir.

<a name='setup'></a>

## ACL Oluşturma

Bu bileşen başlangıçta bellekte çalışmak üzere tasarlanmıştır. Bu, kullanım kolaylığı sağlar ve listenin her alanına erişirken hızlanır. `Phalcon\Acl` yapılandırıcı, ilk parametresi olarak kontrol listesiyle ilgili bilgileri almak için kullanılan bir bağdaştırıcı alır. Bellek adaptörünü kullanan bir örnek aşağıda verilmiştir:

```php
<?php

use Phalcon\Acl\Adapter\Memory as AclList;

$acl = new AclList();
```

Varsayılan olarak `Phalcon\Acl`, henüz tanımlanmamış kaynaklara erişime izin verir. Erişim listesinin güvenlik seviyesini artırmak için bir `deny` seviyesini varsayılan erişim seviyesi olarak tanımlayabiliriz.

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

Bir rol, erişim listesindeki belirli kaynaklara erişebilen veya erişemeyen bir nesnedir. Örnek olarak, rolleri bir organizasyon içerisindeki gruplar olarak tanımlayacağız. `Phalcon\Acl\Role` sınıfı, daha yapılandırılmış bir şekilde roller oluşturmak için kullanılabilir. Yakın zamanda oluşturulmuş listemize bazı roller ekleyelim:

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

Kaynaklar, erişimin kontrol edildiği nesnelerdir. Normalde MVC uygulamalarında kaynaklar denetleyicileri gösterir. Bu zorunlu olmasa da, `Phalcon\Acl\Resource` sınıfı kaynakları tanımlamada kullanılabilir. ACL'nin kontrol etmesi gereken şeyi anlaması için bir kaynağa ilgili işlemler veya işlemler eklemek önemlidir.

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

## ACL Sorgulama

Liste tamamen tanımlandıktan sonra bir role belirli bir izin verilip verilmediğini kontrol etmek için sorgulayabiliriz.

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

Ayrıca, 4'üncü parametre olarak boolean değerini döndüren özel işlevinizi ekleyebilirsiniz. `isAllowed()` yöntemini kullandığınızda çağrılır. You can pass parameters as associative array to `isAllowed()` method as 4th argument where key is parameter name in our defined function.

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

## Rollerin Kalıtımı

`Phalcon\Acl\Role` sınıfının sağladığı kalıtımı kullanarak karmaşık rol yapıları oluşturabilirsiniz. Roller diğer rollerden miras kalabilir, böylece üst sınıflara veya kaynak alt kümelerine erişime izin verebilir. Rol kalıtımını kullanmak için, devredilen rolü, listede bu rolü eklerken yöntem çağrısının ikinci parametresi olarak iletmeniz gerekir.

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

To improve performance `Phalcon\Acl` instances can be serialized and stored in APC, session, text files or a database table so that they can be loaded at will without having to redefine the whole list. Bunu şu şekilde yapabilirsiniz:

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

<a name='setup'></a>

0## Olaylar

`Phalcon\Acl` is able to send events to an `EventsManager` if it's present. Olaylar 'acl' türünü kullanarak tetiklenir. Boolean false döndürürken bazı olaylar etkin işlemi durdurabilir. Aşağıdaki olaylar desteklenmektedir:

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

<a name='setup'></a>

1## Kendi Bağdaştırıcılarını Uygulama

`Phalcon\Acl\AdapterInterface` arabirimi kendi ACL bağdaştırıcıları oluşturmak veya mevcut olanları genişletmek için uygulanması gerekir.