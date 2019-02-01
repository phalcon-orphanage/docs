---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Cli\Dispatcher'
---
# Class **Phalcon\Cli\Dispatcher**

*extends* abstract class [Phalcon\Dispatcher](Phalcon_Dispatcher)

*implements* [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\DispatcherInterface](Phalcon_DispatcherInterface), [Phalcon\Cli\DispatcherInterface](Phalcon_Cli_DispatcherInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cli/dispatcher.zep)

Yönlendirme, komut satırı değişkenlerini alma, modül adını, görev adını, eylem adını ve içindeki isteğe bağlı parametreleri ayıklama ve ardından bir görevi başlatma ve üzerinde bir eylem çağırma işlemidir.

```php
<?php

use Phalcon\Di;
use Phalcon\Cli\Dispatcher;

$di = new Di();
$dispatcher = new Dispatcher();
$dispatcher->setDi($di);

$dispatcher->setTaskName("posts");
$dispatcher->setActionName("index");
$dispatcher->setParams([]);

$handle = $dispatcher->dispatch();

```

## Sabitler

*integer* **EXCEPTION_NO_DI**

*integer* **EXCEPTION_CYCLIC_ROUTING**

*integer* **EXCEPTION_HANDLER_NOT_FOUND**

*integer* **EXCEPTION_INVALID_HANDLER**

*integer* **EXCEPTION_INVALID_PARAMS**

*integer* **EXCEPTION_ACTION_NOT_FOUND**

## Metodlar

public **setTaskSuffix** (*mixed* $taskSuffix)

Varsayılan görev son ekini ayarlar

public **setDefaultTask** (*mixed* $taskName)

Varsayılan görev adını ayarlar

public **setTaskName** (*mixed* $taskName)

Gönderilecek görev adını ayarlar

public **getTaskName** ()

En son gönderilen görev adını getirir

protected **_throwDispatchException** (*mixed* $message, [*mixed* $exceptionCode])

Dahili bir istisna atar

protected **_handleException** ([Exception](https://php.net/manual/en/class.exception.php) $exception)

Bir kullanıcı istisnasını işler

public **getLastTask** ()

En son gönderilen denetleyiciyi döner

public **getActiveTask** ()

Göndericideki aktif görevi döner

public **setOptions** (*array* $options)

Gönderilecek seçenekleri ayarlar

public **getOptions** ()

Gönderilmiş seçenekleri getirir

public **getOption** (*mixed* $option, [*string* | *array* $filters], [*mixed* $defaultValue])

Bir seçeneği adına ve sayısal indisine göre getirir

public **hasOption** (*mixed* $option)

Bir seçeneğin var olup olmadığını kontrol edin

public **callActionMethod** (*mixed* $handler, *mixed* $actionMethod, [*array* $params])

Eylem yöntemini çağırır.

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Bağımlılık enjektörünü ayarlar

public **getDI** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Returns the internal dependency injector

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Olay yöneticisini ayarlar

public **getEventsManager** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Dahili olay yöneticisini döndürür

public **setActionSuffix** (*mixed* $actionSuffix) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Varsayılan eylemin son ekini ayarlar

public **getActionSuffix** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Varsayılan eylemin son ekini alır

public **setModuleName** (*mixed* $moduleName) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Denetleyicinin bulunduğu modülü ayarlar (yalnızca bilgi verici)

public **getModuleName** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Gets the module where the controller class is

public **setNamespaceName** (*mixed* $namespaceName) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Denetleyici sınıfının bulunduğu isim alanını ayarlar

public **getNamespaceName** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Geçerli işleyici adına öncelenecek bir ad alanını döndürür

public **setDefaultNamespace** (*mixed* $namespaceName) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Varsayılan isim alanını ayarlar

public **getDefaultNamespace** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Varsayılan isim alanını döndürür

public **setDefaultAction** (*mixed* $actionName) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Varsayılan eylem ismini ayarlar

public **setActionName** (*mixed* $actionName) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Gönderilecek eylem adını ayarlar

public **getActionName** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

En son gönderilen eylemin adını getirir

public **setParams** (*array* $params) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Gönderilecek eylem parametrelerini ayarlar

public **getParams** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Eylem parametrelerini al

public **setParam** (*mixed* $param, *mixed* $value) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Set a param by its name or numeric index

public *mixed* **getParam** (*mixed* $param, [*string* | *array* $filters], [*mixed* $defaultValue]) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Gets a param by its name or numeric index

public *boolean* **hasParam** (*mixed* $param) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Parametrenin varlığını kontrol et

public **getActiveMethod** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Returns the current method to be/executed in the dispatcher

public **isFinished** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Gönderim döngüsünün bitip tamamlanmadığını kontrol eder veya gönderilecek fazla denetleyici/görevi vardır

public **setReturnedValue** (*mixed* $value) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

En son geri getirilen değeri bir eylemle manuel olarak ayarlar

public *mixed* **getReturnedValue** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

En son gönderilen eylem tarafından geri getirilen değeri geri getirir

public **setModelBinding** (*mixed* $value, [*mixed* $cache]) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Enable/Disable model binding during dispatch

```php
<?php

$di->set('dispatcher', function() {
    $dispatcher = new Dispatcher();

    $dispatcher->setModelBinding(true, 'cache');
    return $dispatcher;
});

```

public **setModelBinder** ([Phalcon\Mvc\Model\BinderInterface](Phalcon_Mvc_Model_BinderInterface) $modelBinder, [*mixed* $cache]) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Dağıtım sırasında model bağlamayı etkinleştir

```php
<?php

$di->set('dispatcher', function() {
    $dispatcher = new Dispatcher();

    $dispatcher->setModelBinder(new Binder(), 'cache');
    return $dispatcher;
});

```

public **getModelBinder** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Model bağlayıcıyı getirir

public *object* **dispatch** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Yönlendirme parametrelerini hesaba katarak bir işleyici eylemini gönderir

protected *object* **_dispatch** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Yönlendirme parametrelerini hesaba katarak bir işleyici eylemini gönderir

public **forward** (*array* $forward) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Yürütme akışını başka bir denetleyiciye/eyleme iletir.

```php
<?php

$this->dispatcher->forward(
    [
        "controller" => "posts",
        "action"     => "index",
    ]
);

```

public **wasForwarded** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Mevcut yürütülen eylemin başka biri tarafından gönderilip gönderilmediğini kontrol edin

public **getHandlerClass** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

İsteği göndermek için bulunabilecek olası sınıf adı

public **getBoundModels** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Bağlayıcı örneğinden bağlı modelleri döndürür

```php
<?php

class UserController extends Controller
{
    public function showAction(User $user)
    {
        $boundModels = $this->dispatcher->getBoundModels(); // return array with $user
    }
}

```

protected **_resolveEmptyProperties** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Boş özellikleri varsayılanlarına ayarlayın (varsayılanlar mevcutsa)