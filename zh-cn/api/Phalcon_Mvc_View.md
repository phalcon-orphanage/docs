---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Mvc\View'
---
# Class **Phalcon\Mvc\View**

*extends* abstract class [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

*implements* [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\Mvc\ViewInterface](Phalcon_Mvc_ViewInterface), [Phalcon\Mvc\ViewBaseInterface](Phalcon_Mvc_ViewBaseInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/view.zep)

Phalcon\Mvc\View is a class for working with the "view" portion of the model-view-controller pattern. 那就是，它存在是为了帮助保持视图脚本分开的模型和控制器的脚本。 它提供了系统的助手、 输出筛选器和变量转义。

```php
<?php

use Phalcon\Mvc\View;

$view = new View();

// Setting views directory
$view->setViewsDir("app/views/");

$view->start();

// Shows recent posts view (app/views/posts/recent.phtml)
$view->render("posts", "recent");
$view->finish();

// Printing views output
echo $view->getContent();

```

## 常量

*integer* **LEVEL_MAIN_LAYOUT**

*integer* **LEVEL_AFTER_TEMPLATE**

*integer* **LEVEL_LAYOUT**

*integer* **LEVEL_BEFORE_TEMPLATE**

*integer* **LEVEL_ACTION_VIEW**

*integer* **LEVEL_NO_RENDER**

*integer* **CACHE_MODE_NONE**

*integer* **CACHE_MODE_INVERSE**

## 方法

public **getRenderLevel** ()

...

public **getCurrentRenderLevel** ()

...

public **getRegisteredEngines** ()

public **__construct** ([*array* $options])

Phalcon\Mvc\View constructor

final protected **_isAbsolutePath** (*mixed* $path)

检查不是是绝对路径

public **setViewsDir** (*mixed* $viewsDir)

Sets the views directory. Depending of your platform, always add a trailing slash or backslash

public **getViewsDir** ()

获取视图目录

public **setLayoutsDir** (*mixed* $layoutsDir)

Sets the layouts sub-directory. Must be a directory under the views directory. Depending of your platform, always add a trailing slash or backslash

```php
<?php

$view->setLayoutsDir("../common/layouts/");

```

public **getLayoutsDir** ()

获取当前布局子目录

public **setPartialsDir** (*mixed* $partialsDir)

Sets a partials sub-directory. Must be a directory under the views directory. Depending of your platform, always add a trailing slash or backslash

```php
<?php

$view->setPartialsDir("../common/partials/");

```

public **getPartialsDir** ()

获取当前的渲染子目录

public **setBasePath** (*mixed* $basePath)

Sets base path. Depending of your platform, always add a trailing slash or backslash

```php
<?php

    $view->setBasePath(__DIR__ . "/");

```

public **getBasePath** ()

获取基路径

public **setRenderLevel** (*mixed* $level)

设置视图的呈现级别

```php
<?php

// 只呈现与控制器相关的视图
$this->view->setRenderLevel(
    View::LEVEL_LAYOUT
);

```

public **disableLevel** (*mixed* $level)

禁用特定的呈现级别

```php
<?php

// 渲染所有级别，除了动作级别
$this->view->disableLevel(
    View::LEVEL_ACTION_VIEW
);

```

public **setMainView** (*mixed* $viewPath)

Sets default view name. Must be a file without extension in the views directory

```php
<?php

// Renders as main view views-dir/base.phtml
$this->view->setMainView("base");

```

public **getMainView** ()

返回主视图的名称

public **setLayout** (*mixed* $layout)

更改布局，而不是使用新的控制器名称的使用

```php
<?php

$this->view->setLayout("main");

```

public **getLayout** ()

返回主视图的名称

public **setTemplateBefore** (*mixed* $templateBefore)

设置前控制器布局模板

public **cleanTemplateBefore** ()

重置任何"template before"布局

public **setTemplateAfter** (*mixed* $templateAfter)

设置"template after"控制器布局

public **cleanTemplateAfter** ()

重置任何模板前布局

public **setParamToView** (*mixed* $key, *mixed* $value)

将参数添加到视图 （setVar 别名）

```php
<?php

$this->view->setParamToView("products", $products);

```

public **setVars** (*array* $params, [*mixed* $merge])

设置所有渲染参数

```php
<?php

$this->view->setVars(
    [
        "products" => $products,
    ]
);

```

public **setVar** (*mixed* $key, *mixed* $value)

将单个视图参数设置

```php
<?php

$this->view->setVar("products", $products);

```

public **getVar** (*mixed* $key)

返回先前在视图中设置的参数

public **getParamsToView** ()

返回参数到视图

public **getControllerName** ()

获取呈现的控制器的名称

public **getActionName** ()

获取呈现的操作的名称

public **getParams** ()

获取操作呈现的额外参数

public **start** ()

开始渲染过程启用输出缓存

protected **_loadTemplateEngines** ()

Loads registered template engines, if none is registered it will use Phalcon\Mvc\View\Engine\Php

protected **_engineRender** (*array* $engines, *string* $viewPath, *boolean* $silence, *boolean* $mustClean, [[Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface) $cache])

检查是否存在对视图注册扩展并呈现它

public **registerEngines** (*array* $engines)

注册模板化引擎

```php
<?php

$this->view->registerEngines(
    [
        ".phtml" => "Phalcon\Mvc\View\Engine\Php",
        ".volt"  => "Phalcon\Mvc\View\Engine\Volt",
        ".mhtml" => "MyCustomEngine",
    ]
);

```

public **exists** (*mixed* $view)

检查是否存在的视图

public **render** (*string* $controllerName, *string* $actionName, [*array* $params])

从调度数据执行渲染过程

```php
<?php

// Shows recent posts view (app/views/posts/recent.phtml)
$view->start()->render("posts", "recent")->finish();

```

public **pick** (*mixed* $renderView)

选择一个不同的视图，而不是最后一个控制器最后行动呈现

```php
<?php

use Phalcon\Mvc\Controller;

class ProductsController extends Controller
{
   public function saveAction()
   {
        // Do some save stuff...

        // Then show the list view
        $this->view->pick("products/list");
   }
}

```

public **getPartial** (*mixed* $partialPath, [*mixed* $params])

呈现分部视图

```php
<?php

// Retrieve the contents of a partial
echo $this->getPartial("shared/footer");

```

```php
<?php

// Retrieve the contents of a partial with arguments
echo $this->getPartial(
    "shared/footer",
    [
        "content" => $html,
    ]
);

```

public **partial** (*mixed* $partialPath, [*mixed* $params])

呈现分部视图

```php
<?php

// Show a partial inside another view
$this->partial("shared/footer");

```

```php
<?php

// Show a partial inside another view with parameters
$this->partial(
    "shared/footer",
    [
        "content" => $html,
    ]
);

```

public *string* **getRender** (*string* $controllerName, *string* $actionName, [*array* $params], [*mixed* $configCallback])

执行返回作为字符串输出的自动呈现

```php
<?php

$template = $this->view->getRender(
    "products",
    "show",
    [
        "products" => $products,
    ]
);

```

public **finish** ()

通过停止输出缓冲完成渲染过程

protected **_createCache** ()

Create a Phalcon\Cache based on the internal cache options

public **isCaching** ()

检查是否该组件当前缓存的输出内容

public **getCache** ()

返回用到缓存中的缓存实例

public **cache** ([*mixed* $options])

缓存到一定程度的实际视图渲染

```php
<?php

$this->view->cache(
    [
        "key"      => "my-key",
        "lifetime" => 86400,
    ]
);

```

public **setContent** (*mixed* $content)

从外部设置查看内容

```php
<?php

$this->view->setContent("<h1>hello</h1>");

```

public **getContent** ()

返回缓存视图的另一个阶段的输出

public **getActiveRenderPath** ()

返回当前呈现的视图的路径 （或路径）

public **disable** ()

禁用自动渲染过程

public **enable** ()

启用自动渲染过程

public **reset** ()

将视图组件重置为其出厂默认值

public **__set** (*mixed* $key, *mixed* $value)

魔术的方法来将变量传递到视图

```php
<?php

$this->view->products = $products;

```

public **__get** (*mixed* $key)

魔术的方法来检索变量传递给视图

```php
<?php

echo $this->view->products;

```

public **isDisabled** ()

是否启用自动呈现

public **__isset** (*mixed* $key)

魔术的方法来检索如果在视图中设置的变量

```php
<?php

echo isset($this->view->products);

```

protected **getViewsDirs** ()

获取视图目录

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

设置依赖注入器

public **getDI** () inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

返回内部依赖注入器

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

设置事件管理器

public **getEventsManager** () inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

返回内部事件管理器