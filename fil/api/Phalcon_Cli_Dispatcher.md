# Klase ng **Phalcon\\Cli\\Dispatcher**

*pinapalawak ang* klase ng abstrak [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

*nagpapatupad ng* [Phalcon\MgaEvent\MgaEventNgAwareInterface](/en/3.2/api/Phalcon_Events_EventsAwareInterface), [Phalcon\Di\InjectionNgAwareInterface](/en/3.2/api/Phalcon_Di_InjectionAwareInterface), [Phalcon\DispatcherNgInterface](/en/3.2/api/Phalcon_DispatcherInterface), [Phalcon\Cli\DispatcherNgInterface](/en/3.2/api/Phalcon_Cli_DispatcherInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/cli/dispatcher.zep" class="btn btn-default btn-sm">Mula sa GitHub</a>

Ang Dispatching ay ang proseso ng pagkuha ng mga argumentong command-line, nagkukuha ng pangalan ng modyul, pangalan ng gawain, pangalan ng aksyon, at ang opsyonal na mga parameter nakapaloob nito, at pagkatapos magbibigay ng halimbawa ng gawain at pagtawag ng isang aksyon nito.

```php
<?php

gamitin ang Phalcon\Di;
gamitin ang Phalcon\Cli\Dispatcher;

$di = bagong Di();
$dispatcher = bagong Dispatcher();
$dispatcher->setDi($di);

$dispatcher->setTaskName("posts");
$dispatcher->setActionName("index");
$dispatcher->setParams([]);

$handle = $dispatcher->dispatch();

```

## Mga Konstant

*kabuuan* **EKSEPSYON_WALANG_DI**

*kabuuan* **EKSEPSYON_CYCLIC_ROUTING**

*kabuuan* **EKSEPSYON_ANG_HANDLER_AY_HINDI_NAKITA**

*kabuuan* **EKSEPSYON_HINDI_BALIDO_ANG_HANDLER**

*kabuuan* **EKSEPSYON_HINDI_BALIDO_ANG_MGA_PARAM**

*kabuuan* **EKSEPSYON_ANG_AKSYON_AY_HINDI_NAKITA**

## Mga Paraan

pampublikong **setTaskSuffix** (*mixed* $taskSuffix)

Itinatakda ang default na gawain ng suffix

pampublikong **setDefaultTask** (*mixed* $taskName)

Itinatakda ang pangalan ng default na gawain

pampublikong **setTaskName** (*mixed* $taskName)

Itinatakda ang pangalan ng gawain para ma-dispatch

pampublikong **getTaskName** ()

Kinukuha ang huling pangalan ng na-dispatch na gawain

protektadong **_throwDispatchException** (*mixed* $message, [*mixed* $exceptionCode])

Magtapon ng isang panloob na eksepsyon

protektadong **_handleException** ([Exception](http://php.net/manual/en/class.exception.php) $exception)

Pinapamahalaan ang isang user na eksepsyon

pampublikong **getLastTask** ()

Ibinabalik ang pinakabagong na-dispatch na kontroler

pampublikong **getActiveTask** ()

Ibinabalik ang aktibo na gawain para sa dispatcher

pampublikong **setOptions** (*array* $options)

Nagtatakda ng mga opsyon para ma-dispatch

pampublikong **getOptions** ()

Kunin ang mga opsyon na na-dispatch

pampublikong **getOption** (*mixed* $option, [*string* | *array* $filters], [*mixed* $defaultValue])

Makakakuha ng isang opsyon sa pamamagitan ng pangalan at numeric na indeks nito

pampublikong **hasOption** (*mixed* $option)

I-tsek kung mayroong pagpipilian

pampublikong **callActionMethod** (*mixed* $handler, *mixed* $actionMethod, [*array* $params])

Tinatawag ang paraan ng aksyon.

pampublikong **setDI** ([Phalcon\DiInterface](/en/3.2/api/Phalcon_DiInterface) $dependencyInjector) na nakuha mula sa [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Itinatakda ang injector ng dependensya

pampublikong **getDI** () na nakuha mula sa [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Ibinabalik ang injector ng panloob na dependency

pampublikong **setEventsManager** ([Phalcon\Events\ManagerInterface](/en/3.2/api/Phalcon_Events_ManagerInterface) $eventsManager) na na-inherit mula sa [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Itinatakda ang pagpapamahala ng mga pangyayari

pampublikong **getEventsManager** () na nakuha mula sa [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Ibinabalik ang pagpapamahala ng panloob na pangyayari

pampublikong **setActionSuffix** (*mixed* $actionSuffix) na nakuha mula sa [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Itinatakda ang suffix ng default na aksyon

pampublikong **getActionSuffix** () na nakuha mula sa [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Kinukuha ang suffix ng default na aksyon

pampublikong **setModuleName** (*mixed* $moduleName) na nakuha mula sa [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Itinatakda ang modyul kung saan ang kontroler ay (impormatibo lamang)

pampublikong **getModuleName** () na nakuha mula sa [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Kinukuha ang modyul kung saan ang klase ng kontroler ay

pampublikong **setNamespaceName** (*mixed* $namespaceName) na nakuha mula sa [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Nagtatakda ng mga namespace kung saan ang klase ng kontroler ay

pampublikong **getNamespaceName** () na nakuha mula sa [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Nagkukuha ng isang namespace para ma-prepend sa kasalukuyang pangalan ng handler

pampublikong **setDefaultNamespace** (*mixed* $namespaceName) na nakuha mula sa [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Nagtatakda ng default na namespace

pampublikong **getDefaultNamespace** () na nakuha mula sa [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Ibinabalik ang namespace ng default

pampublikong **setDefaultAction** (*mixed* $actionName) na nakuha mula sa [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Itinatakda ang pangalan ng default na aksyon

pampublikong **setActionName** (*mixed* $actionName) na nakuha mula sa [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Itinatakda ang pangalan ng aksyon para ma-dispatch

pampublikong **getActionName** () na nakuha mula sa [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Nagkukuha ng pinakabagong na-dispatch na pangalan ng aksyon

pampublikong **setParams** (*array* $params) na nakuha mula sa [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Nagtatakda ng mga param ng aksyon para ma-dispatch

pampublikong **getParams** () na nakuha mula sa [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Nagkukuha ng mga param ng aksyon

pampublikong **setParam** (*mixed* $param, *mixed* $value) na nakuha mula sa [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Nagtatakda ng isang param sa pamamagitan ng pangalan at numeric na indeks nito

pampublikong *mixed* **getParam** (*mixed* $param, [*string* | *array* $filters], [*mixed* $defaultValue]) na nakuha mula sa [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Nagkukuha ng isang param sa pamamagitan ng pangalan at numeric na indeks nito

pampublikong *boolean* **hasParam** (*mixed* $param) na nakuha mula sa [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

I-tsek kung mayroong isang param

pampublikong **getActiveMethod** () na nakuha mula sa [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Ibinabalik ang kasalukuyang pamamaraan para maisagawa sa dispatcher

pampublikong **isFinished** () na nakuha mula sa [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Nagsusuri kung ang loop ng dispatch ay tapos na o ay mas maraming na kontroler/gawain para i-dispatch

pampublikong **setReturnedValue** (*mixed* $value) na nakuha mula sa [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Nagtatakda ng pinakabagong halagang naisuli sa pamamagitan ng manu-manong aksyon

pampublikong *mixed* **getReturnedValue** () na nakuha mula sa [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Ibinabalik ang halaga ng na-return sa pamamagitan ng pinakabagong na-disptach na aksyon

pampublikong **setModelBinding** (*mixed* $value, [*mixed* $cache]) na nakuha mula sa [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Paganahin/Huwag paganhin ang binding ng modelo habang nagdi-disptach

```php
<?php

$di->set('dispatcher', function() {
    $dispatcher = bagong Dispatcher();

    $dispatcher->setModelBinding(true, 'cache');
    return $dispatcher;
});

```

pampublikong **setModelBinder** ([Phalcon\Mvc\Model\BinderInterface](/en/3.2/api/Phalcon_Mvc_Model_BinderInterface) $modelBinder, [*mixed* $cache]) na nakuha mula sa [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Paganahin ang umiiral na modelo habang nagdi-dispatch

```php
<?php

$di->set('dispatcher', function() {
    $dispatcher = bagong Dispatcher();

    $dispatcher->setModelBinder(new Binder(), 'cache');
    return $dispatcher;
});

```

pampublikong **getModelBinder** () na nakuha mula sa [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Nagkukuha ng modelo ng binder

pampublikong *bagay na* **dispatch** () na minana mula sa [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Dispatches a handle action taking into account the routing parameters

protektadong *bagay na* **_dispatch** () na minana mula sa [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Nagpapadala ng isang handle na aksyon na isinasaalang-alang sa account ang mga parameter ng pagra-rout

pampublikong **forward** (*array* $forward) na nakuha mula sa [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Pagpapadala ng daloy ng eksekusyon sa iabng kontroler/aksyon.

```php
<?php

$this->dispatcher->forward(
    [
        "controller" => "posts",
        "action"     => "index",
    ]
);

```

pampublikong **wasForwarded** () na nakuha mula sa [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Suriin kung ang kasalukuyang nagawang aksyon ay ipinadala sa pamamagitan ng isa

pampublikong **getHandlerClass** () na nakuha mula sa [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Posibleng pangalan ng klase na ilalagay para ipadala ang kahilingan

pampublikong **getBoundModels** () na nakuha mula sa [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Ibinabalik ang mga takdang modelo mula sa instansiya ng binder

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

protektadong **_resolveEmptyProperties** () na nakuha mula sa [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Nagtatakda ng mga walang laman na katangian para sa kanilang mga default (kung saan ang mga default ay magagamit)