<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Genel Bakış</a> <ul>
        <li>
          <a href="#using">Denetleyicilerin Kullanımı</a>
        </li>
        <li>
          <a href="#dispatch-loop">Görev Döngüsü</a>
        </li>
        <li>
          <a href="#initializing">Denetleyicileri Başlatma</a>
        </li>
        <li>
          <a href="#injecting-services">Enjeksiyon Hizmetleri</a>
        </li>
        <li>
          <a href="#request-response">İstek ve Yanıt</a>
        </li>
        <li>
          <a href="#session-data">Oturum Verileri</a>
        </li>
        <li>
          <a href="#services">Hizmetleri Denetleyiciler Olarak Kullanma</a>
        </li>
        <li>
          <a href="#events">Denetleyicilerdeki Olaylar</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Genel Bakış

<a name='using'></a>

## Denetleyicilerin Kullanımı

Eylemler, istekleri işleyen bir denetleyicideki yöntemlerdir. Varsayılan olarak, bir denetleyicideki tüm ortak yöntemler eyleme eşlenir ve bir URL tarafından erişilebilir durumdadır. Eylem, isteği yorumlamaktan ve cevabı oluşturmaktan sorumludur. Genellikle yanıtlar işlenmiş görünüm biçimindedir ancak yanıtı oluşturmak için başka yollar da vardır.

Örneğin, böyle bir URL'ye eriştiğinizde: `http://localhost/blog/posts/show/2015/the-post-title` Phalcon varsayılan olarak her parçayı şöyle bölecektir:

| Açıklama           | Rumuz          |
| ------------------ | -------------- |
| **Phalcon Dizini** | blog           |
| **Denetleyici**    | posts          |
| **Eylem**          | show           |
| **Parametre**      | 2015           |
| **Parametre**      | the-post-title |

Bu durumda, PostsController bu isteği işleyecektir. Denetleyicileri bir uygulamaya koymak için özel bir yer yoktur; bunlar :doc: `autoloaders <loader>` kullanılarak yüklenebilir, böylece denetleyicilerinizi istediğiniz gibi organize etmen serbesttir.

Eylemlerin soneki 'Controller' iken denetleyicilerin soneki 'Action' olmalıdır. Denetleyicinin bir örneği aşağıdaki gibidir:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {

    }

    public function showAction($year, $postTitle)
    {

    }
}
```

Ek URI parametreleri, yerel değişkenler kullanılarak kolayca erişilebilmesi için eylem parametreleri olarak tanımlanır. Bir denetleyici isteğe bağlı olarak `Phalcon\Mvc\Controller`'yi genişletebilir. Bunu yaparak, denetleyicinin uygulama servislerine kolay erişimi olabilir.

Varsayılan değer içermeyen parametreler gerektiği gibi işlenir. Parametreler için isteğe bağlı değerleri ayarlamak, PHP'de her zamanki gibi yapılır:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {

    }

    public function showAction($year = 2015, $postTitle = 'bazı varsayılan başlık')
    {

    }
}
```

Parametreler, rotada geçirildikleri sırayla aynı sırayla atanır. Aşağıdaki gibi adından keyfi bir parametre alabilirsiniz:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {

    }

    public function showAction()
    {
        $year      = $this->dispatcher->getParam('year');
        $postTitle = $this->dispatcher->getParam('postTitle');
    }
}
```

<a name='dispatch-loop'></a>

## Görev Döngüsü

Görev döngüsü yürütülecek eylem kalmayana dek Görevlendirici içerisinde yürütülecektir. Önceki örnekte yalnızca bir eylem gerçekleştirildi. Şimdi `forward()` yönteminin, yürütmeyi farklı bir denetleyiciye/eyleme yönlendirerek gönderim döngüsünde daha karmaşık bir işlem akışı sağlayabileceğini göreceğiz.

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {

    }

    public function showAction($year, $postTitle)
    {
        $this->flash->error(
            "Bu alana erişmek için izniniz yok"
        );

        // Akışı başka bir eyleme ilet
        $this->dispatcher->forward(
            [
                'controller' => 'users',
                'action'     => 'signin',
            ]
        );
    }
}
```

Kullanıcıların belirli bir eyleme erişme izni yoksa Users denetleyicisinde 'signin' eylemine yönlendirilirler.

```php
<?php

use Phalcon\Mvc\Controller;

class UsersController extends Controller
{
    public function indexAction()
    {

    }

    public function signinAction()
    {

    }
}
```

Başvurunuzda, başvurunuzun durduğu döngüsel referanslar olmadıkça, "ileriye doğru" sınırlama yoktur. Gönderim döngüsü tarafından gönderilecek başka eylem yoksa, dağıtım programı otomatik olarak `Phalcon\Mvc\View` tarafından yönetilen MVC'nin görüntüleme katmanını çağırır.

<a name='initializing'></a>

## Denetleyicileri Başlatma

`Phalcon\Mvc\Controller`, bir denetleyicide herhangi bir eylem gerçekleştirilmeden önce önce uygulanan `initialize()` yöntemini sunar. `__construct()` yönteminin kullanılması önerilmez.

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public $settings;

    public function initialize()
    {
        $this->settings = [
            'mySetting' => 'value',
        ];
    }

    public function saveAction()
    {
        if ($this->settings['mySetting'] === 'value') {
            // ...
        }
    }
}
```

<h5 class='alert alert-warning'>The `initialize()` method is only called if the `beforeExecuteRoute` event is executed with success. This avoid that application logic in the initializer cannot be executed without authorization.</h5>

Denetleyici nesnesinin oluşturulmasından hemen sonra bazı başlatma mantığını yürütmek isterseniz `onConstruct()` yöntemini uygulayabilirsiniz:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function onConstruct()
    {
        // ...
    }
}
```

<h5 class='alert alert-warning'>Be aware that `onConstruct()` method is executed even if the action to be executed doesn't exist in the controller or the user does not have access to it (according to custom control access provided by the developer).</h5>

<a name='injecting-services'></a>

## Enjeksiyon Hizmetleri

Bir denetleyici `Phalcon\Mvc\Controller`'ı genişletirse, uygulama sırasında servis kabına kolay erişime sahip olur. Örneğin, böyle bir hizmeti kaydettiyseniz:

```php
<?php

use Phalcon\Di;

$di = new Di();

$di->set(
    'storage',
    function () {
        return new Storage(
            '/some/directory'
        );
    },
    true
);
```

Ardından, bu hizmete çeşitli şekillerde erişebiliriz:

```php
<?php

use Phalcon\Mvc\Controller;

class FilesController extends Controller
{
    public function saveAction()
    {
        // Hizmete sadece aynı isme sahip olan mülkiyete erişerek enjekte etme
        $this->storage->save('/some/file');

        // Hizmete DI'den erişim
        $this->di->get('storage')->save('/some/file');

        // Sihirli alıcıyı kullanarak servise erişmenin bir başka yolu
        $this->di->getStorage()->save('/some/file');

        // Sihirli alıcıyı kullanarak servise erişmenin bir başka yolu
        $this->getDi()->getStorage()->save('/some/file');

        // Dizim-sözdizimini kullanma
        $this->di['storage']->save('/some/file');
    }
}
```

If you're using Phalcon as a full-stack framework, you can read the services provided [by default](/[[language]]/[[version]]/di) in the framework.

<a name='request-response'></a>

## İstek ve Yanıt

İskeletin önceden kayıtlı bir dizi hizmet sunduğunu varsayarsak. HTTP ortamıyla nasıl etkileşim kuracağımızı açıklıyoruz. 'İstek' hizmeti bir `Phalcon\Http\Request` örneğini içerir ve 'yanıt', kullanıcıya ne gönderileceğini gösteren bir `Phalcon\Http\Response` içerir.

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {

    }

    public function saveAction()
    {
        // POST ile istekte bulunup bulunmadığını kontrol edin
        if ($this->request->isPost()) {
            // POST verisine erişim
            $customerName = $this->request->getPost('name');
            $customerBorn = $this->request->getPost('born');
        }
    }
}
```

Yanıt nesnesi genellikle doğrudan kullanılmaz, ancak işlemin başlamasından önce oluşturulur, bazen - bir `afterDispatch` olayında olduğu gibi - yanıtın doğrudan erişilmesi yararlı olabilir:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {

    }

    public function notFoundAction()
    {
        // HTTP 404 yanıt üstbilgisi gönderme
        $this->response->setStatusCode(404, 'Bulunamadı');
    }
}
```

Learn more about the HTTP environment in their dedicated articles [request](/[[language]]/[[version]]/request) and [response](/[[language]]/[[version]]/response).

<a name='session-data'></a>

## Oturum Verileri

Oturumlar, istekler arasında kalıcı verileri korumamıza yardımcı olur. Kalıcı olması gereken verileri kapsüllemek için herhangi bir denetleyiciden bir `Phalcon\Session\Bag`'e erişebilirsiniz:

```php
<?php

use Phalcon\Mvc\Controller;

class UserController extends Controller
{
    public function indexAction()
    {
        $this->persistent->name = 'Mustafa';
    }

    public function welcomeAction()
    {
        echo 'Welcome, ', $this->persistent->name;
    }
}
```

<a name='services'></a>

## Hizmetleri Denetleyiciler Olarak Kullanma

Hizmetler denetleyiciler gibi davranabilir, denetleyiciler sınıflar her zaman hizmetler kapsayıcısından istenir. Buna göre, adıyla tescillenen diğer sınıflar bir denetleyiciyi kolayca değiştirebilir:

```php
<?php

// Bir denetleyiciyi bir hizmet olarak kaydettirme
$di->set(
    'IndexController',
    function () {
        $component = new Component();

        return $component;
    }
);

// Ad alanlı bir denetleyiciyi bir hizmet olarak kaydettirme
$di->set(
    'Backend\Controllers\IndexController',
    function () {
        $component = new Component();

        return $component;
    }
);
```

<a name='using'></a>

0## Denetleyicilerdeki Olaylar

Denetleyiciler, [görevlendirici](/en/[[versopm]]/dispatcher) olayları için dinleyiciler olarak otomatik olarak davranır; bu olay adlarıyla yöntemleri uygulamak, eylemler yürütülmeden önce / sonra kanca noktaları uygulamaya izin verir:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function beforeExecuteRoute($dispatcher)
    {
        // Bu, bulunan her eylemden önce yürütülür
        if ($dispatcher->getActionName() === 'save') {
            $this->flash->error(
                "Yazıları kaydetmek için izniniz yok"
            );

            $this->dispatcher->forward(
                [
                    'controller' => 'home',
                    'action'     => 'index',
                ]
            );

            return false;
        }
    }

    public function afterExecuteRoute($dispatcher)
    {
        // Bulunan her eylemden sonra yürütülür
    }
}
```