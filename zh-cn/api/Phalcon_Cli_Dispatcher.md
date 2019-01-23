---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Cli\Dispatcher'
---
# Class **Phalcon\Cli\Dispatcher**

*extends* abstract class [Phalcon\Dispatcher](Phalcon_Dispatcher)

*implements* [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\DispatcherInterface](Phalcon_DispatcherInterface), [Phalcon\Cli\DispatcherInterface](Phalcon_Cli_DispatcherInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cli/dispatcher.zep)

调度器是以命令行参数、 提取模块名称、 任务名称、 操作名称和可选的参数，它包含的，然后实例化的任务和要求它的行动过程。

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

## 常量

*integer* **EXCEPTION_NO_DI**

*integer* **EXCEPTION_CYCLIC_ROUTING**

*integer* **EXCEPTION_HANDLER_NOT_FOUND**

*integer* **EXCEPTION_INVALID_HANDLER**

*integer* **EXCEPTION_INVALID_PARAMS**

*integer* **EXCEPTION_ACTION_NOT_FOUND**

## 方法

public **setTaskSuffix** (*mixed* $taskSuffix)

设置默认任务后缀

public **setDefaultTask** (*mixed* $taskName)

设置默认任务名称

public **setTaskName** (*mixed* $taskName)

设置要分派的任务名称

public **getTaskName** ()

获取最后派遣任务名称

protected **_throwDispatchException** (*mixed* $message, [*mixed* $exceptionCode])

将引发内部异常

protected **_handleException** ([Exception](https://php.net/manual/en/class.exception.php) $exception)

处理用户异常

public **getLastTask** ()

返回最新的派遣的控制器

public **getActiveTask** ()

在调度程序返回活动任务

public **setOptions** (*array* $options)

设置选项以将派遣

public **getOptions** ()

派出的选项

public **getOption** (*mixed* $option, [*string* | *array* $filters], [*mixed* $defaultValue])

获取由其名称或数字索引选项

public **hasOption** (*mixed* $option)

检查是否存在一个选项

public **callActionMethod** (*mixed* $handler, *mixed* $actionMethod, [*array* $params])

调用的操作方法。

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

设置依赖注入器

public **getDI** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

返回内部依赖注入器

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

设置事件管理器

public **getEventsManager** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

返回内部事件管理器

public **setActionSuffix** (*mixed* $actionSuffix) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Sets the default action suffix

public **getActionSuffix** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Gets the default action suffix

public **setModuleName** (*mixed* $moduleName) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Sets the module where the controller is (only informative)

public **getModuleName** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Gets the module where the controller class is

public **setNamespaceName** (*mixed* $namespaceName) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Sets the namespace where the controller class is

public **getNamespaceName** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Gets a namespace to be prepended to the current handler name

public **setDefaultNamespace** (*mixed* $namespaceName) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Sets the default namespace

public **getDefaultNamespace** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Returns the default namespace

public **setDefaultAction** (*mixed* $actionName) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

设置默认操作名称

public **setActionName** (*mixed* $actionName) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Sets the action name to be dispatched

public **getActionName** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Gets the latest dispatched action name

public **setParams** (*array* $params) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Sets action params to be dispatched

public **getParams** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Gets action params

public **setParam** (*mixed* $param, *mixed* $value) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Set a param by its name or numeric index

public *mixed* **getParam** (*mixed* $param, [*string* | *array* $filters], [*mixed* $defaultValue]) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Gets a param by its name or numeric index

public *boolean* **hasParam** (*mixed* $param) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Check if a param exists

public **getActiveMethod** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Returns the current method to be/executed in the dispatcher

public **isFinished** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Checks if the dispatch loop is finished or has more pendent controllers/tasks to dispatch

public **setReturnedValue** (*mixed* $value) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Sets the latest returned value by an action manually

public *mixed* **getReturnedValue** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Returns value returned by the latest dispatched action

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

Enable model binding during dispatch

```php
<?php

$di->set('dispatcher', function() {
    $dispatcher = new Dispatcher();

    $dispatcher->setModelBinder(new Binder(), 'cache');
    return $dispatcher;
});

```

public **getModelBinder** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Gets model binder

public *object* **dispatch** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Dispatches a handle action taking into account the routing parameters

protected *object* **_dispatch** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Dispatches a handle action taking into account the routing parameters

public **forward** (*array* $forward) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

将转发到另一个的控制器操作的执行流程。

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

Check if the current executed action was forwarded by another one

public **getHandlerClass** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Possible class name that will be located to dispatch the request

public **getBoundModels** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Returns bound models from binder instance

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

Set empty properties to their defaults (where defaults are available)