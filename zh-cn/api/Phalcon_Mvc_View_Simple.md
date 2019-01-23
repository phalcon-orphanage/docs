---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Mvc\View\Simple'
---
# Class **Phalcon\Mvc\View\Simple**

*extends* abstract class [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

*implements* [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\Mvc\ViewBaseInterface](Phalcon_Mvc_ViewBaseInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/view/simple.zep)

此组件允许呈现无层次视图

```php
<?php

use Phalcon\Mvc\View\Simple as View;

$view = new View();

// Render a view
echo $view->render(
    "templates/my-view",
    [
        "some" => $param,
    ]
);

// Or with filename with extension
echo $view->render(
    "templates/my-view.volt",
    [
        "parameter" => $here,
    ]
);

```

## 方法

public **getRegisteredEngines** ()

public **__construct** ([*array* $options])

Phalcon\Mvc\View\Simple constructor

public **setViewsDir** (*mixed* $viewsDir)

Sets views directory. Depending of your platform, always add a trailing slash or backslash

public **getViewsDir** ()

获取视图目录

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

protected *array* **_loadTemplateEngines** ()

Loads registered template engines, if none is registered it will use Phalcon\Mvc\View\Engine\Php

final protected **_internalRender** (*string* $path, *array* $params)

尝试与每个引擎注册组件中呈现的视图

public **render** (*string* $path, [*array* $params])

呈现一个视图

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

public **setCacheOptions** (*array* $options)

设置缓存选项

public *array* **getCacheOptions** ()

返回的缓存选项

protected **_createCache** ()

Create a Phalcon\Cache based on the internal cache options

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

public *array* **getParamsToView** ()

返回参数到视图

public **setContent** (*mixed* $content)

从外部设置查看内容

```php
<?php

$this->view->setContent("<h1>hello</h1>");

```

public **getContent** ()

返回缓存视图的另一个阶段的输出

public *string* **getActiveRenderPath** ()

返回当前呈现的视图的路径

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

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

设置依赖注入器

public **getDI** () inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

返回内部依赖注入器

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

设置事件管理器

public **getEventsManager** () inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

返回内部事件管理器