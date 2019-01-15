* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# Genel Bakış

<a name='using'></a>

## Denetleyicilerin Kullanımı

Eylemler, istekleri işleyen bir denetleyicideki yöntemlerdir. Varsayılan olarak, bir denetleyicideki tüm ortak yöntemler eyleme eşlenir ve bir URL tarafından erişilebilir durumdadır. Eylem, isteği yorumlamaktan ve cevabı oluşturmaktan sorumludur. Genellikle yanıtlar işlenmiş görünüm biçimindedir ancak yanıtı oluşturmak için başka yollar da vardır.

For instance, when you access a URL like this: `https://localhost/blog/posts/show/2015/the-post-title` Phalcon by default will decompose each part like this:

| Description        | Rumuz          |
| ------------------ | -------------- |
| **Phalcon Dizini** | blog           |
| **Denetleyici**    | posts          |
| **Eylem**          | show           |
| **Parametre**      | 2015           |
| **Parametre**      | the-post-title |

In this case, the `PostsController` will handle this request. There is no a special location to put controllers in an application, they could be loaded using [Phalcon\Loader](api/Phalcon_Loader), so you're free to organize your controllers as you need.

Controllers must have the suffix `Controller` while actions the suffix `Action`. A sample of a controller is as follows:

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

Ek URI parametreleri, yerel değişkenler kullanılarak kolayca erişilebilmesi için eylem parametreleri olarak tanımlanır. A controller can optionally extend [Phalcon\Mvc\Controller](api/Phalcon_Mvc_Controller). Bunu yaparak, denetleyicinin uygulama servislerine kolay erişimi olabilir.

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

If users don't have permission to access a certain action then they will be forwarded to the `signin` action in the `UsersController`.

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

There is no limit on the `forwards` you can have in your application, so long as they do not result in circular references, at which point your application will halt. If there are no other actions to be dispatched by the dispatch loop, the dispatcher will automatically invoke the view layer of the MVC that is managed by [Phalcon\Mvc\View](api/Phalcon_Mvc_View).

<a name='initializing'></a>

## Denetleyicileri Başlatma

[Phalcon\Mvc\Controller](api/Phalcon_Mvc_Controller) offers the `initialize()` method, which is executed first, before any action is executed on a controller. `__construct()` yönteminin kullanılması önerilmez.

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

<h5 class='alert alert-warning'>The <code>initialize()</code> method is only called if the <code>beforeExecuteRoute</code> event is executed with success. This avoid that application logic in the initializer cannot be executed without authorization.</h5>

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

<h5 class='alert alert-warning'>Be aware that <code>onConstruct()</code> method is executed even if the action to be executed doesn't exist in the controller or the user does not have access to it (according to custom control access provided by the developer).</h5>

<a name='injecting-services'></a>

## Enjeksiyon Hizmetleri

If a controller extends [Phalcon\Mvc\Controller](api/Phalcon_Mvc_Controller) then it has easy access to the service container in application. For example, if we have registered a service like this:

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

If you're using Phalcon as a full-stack framework, you can read the services provided [by default](/4.0/en/di) in the framework.

<a name='request-response'></a>

## İstek ve Yanıt

İskeletin önceden kayıtlı bir dizi hizmet sunduğunu varsayarsak. HTTP ortamıyla nasıl etkileşim kuracağımızı açıklıyoruz. The `request` service contains an instance of [Phalcon\Http\Request](api/Phalcon_Http_Request) and the `response` contains a [Phalcon\Http\Response](api/Phalcon_Http_Response) representing what is going to be sent back to the client.

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

Learn more about the HTTP environment in their dedicated articles [request](/4.0/en/request) and [response](/4.0/en/response).

<a name='session-data'></a>

## Oturum Verileri

Sessions help us maintain persistent data between requests. You can access a [Phalcon\Session\Bag](api/Phalcon_Session_Bag) from any controller to encapsulate data that needs to be persistent:

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

<a name='events'></a>

## Denetleyicilerdeki Olaylar

Controllers automatically act as listeners for [dispatcher](/4.0/en/dispatcher) events, implementing methods with those event names allow you to implement hook points before/after the actions are executed:

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