---
layout: default
language: 'it-it'
version: '4.0'
title: 'Views'
keywords: 'mvc, view, view component, simple view, responses'
---

# Views

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Overview

Views represent the user interface of your application. Views are often HTML files with embedded PHP code that perform tasks related solely to the presentation of the data. Views format the content that you need to send back to the user/web browser that initiated the request.

[Phalcon\Mvc\View](api/phalcon_mvc#mvc-view) and [Phalcon\Mvc\View\Simple](api/phalcon_mvc#mvc-view-simple) are responsible for the managing the view layer of your MVC application.

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;

/**
 * @property View $view
 */
class InvoicesController extends Controller
{
    public function viewAction($invoiceId)
    {
        $this->view->invoiceId = $invoiceId;
    }
}
```

## Constants

There are several constants that control the behavior of the rendering process once set in the view

| Constant                | Description                                   |
| ----------------------- | --------------------------------------------- |
| `LEVEL_ACTION_VIEW`     | Render Level: To the action view              |
| `LEVEL_BEFORE_TEMPLATE` | Render Level: To the templates "before"       |
| `LEVEL_LAYOUT`          | Render Level: To the controller layout        |
| `LEVEL_MAIN_LAYOUT`     | Render Level: To the main layout              |
| `LEVEL_NO_RENDER`       | Render Level: No render any view              |
| `LEVEL_AFTER_TEMPLATE`  | Render Level: Render to the templates "after" |

## Methods

```php
public function __construct(array options = [])
```

Phalcon\Mvc\View constructor

```php
public function __get(string $key): mixed | null
```

Magic method to retrieve a variable passed to the view

```php
echo $this->view->invoices;
```

```php
public function __isset(string $key): bool
```

Magic method to retrieve if a variable is set in the view

```php
echo isset($this->view->invoices);
```

```php
public function __set(string $key, var value)
```

Magic method to pass variables to the views

```php
$this->view->invoices = $invoices;
```

```php
public function cleanTemplateAfter(): View
```

Resets any template before layouts

```php
public function cleanTemplateBefore(): View
```

Resets any "template before" layouts

```php
public function disableLevel(mixed $level): ViewInterface
```

Disables a specific level of rendering

```php
$this->view->disableLevel(
    View::LEVEL_ACTION_VIEW
);
```

Render all levels except ACTION level

```php
public function disable(): View
```

Disables the auto-rendering process

```php
public function enable(): View
```

Enables the auto-rendering process

```php
public function exists(string $view): bool
```

Checks whether view exists

```php
public function finish(): View
```

Finishes the render process by stopping the output buffering

```php
public function getActionName(): string
```

Gets the name of the action rendered

```php
public function getActiveRenderPath(): string | array
```

Returns the path (or paths) of the views that are currently rendered

```php
public function getBasePath(): string
```

Gets base path

```php
public function getContent(): string
```

Returns output from another view stage

```php
public function getControllerName(): string
```

Gets the name of the controller rendered

```php
public function getLayout(): string
```

Returns the name of the main view

```php
public function getLayoutsDir(): string
```

Gets the current layouts sub-directory

```php
public function getMainView(): string
```

Returns the name of the main view

```php
public function getParamsToView(): array
```

Returns parameters to views

```php
public function getPartial(
    string $partialPath, 
    mixed $params = null
): string
```

Renders a partial view

```php
echo $this->getPartial("shared/footer");
```

Retrieve the contents of a partial

```php
echo $this->getPartial(
    "shared/footer",
    [
        "content" => $html,
    ]
);
```

Retrieve the contents of a partial with arguments

```php
public function getPartialsDir(): string
```

Gets the current partials sub-directory

```php
public function getRender(
    string $controllerName, 
    string $actionName, 
    array $params = [], 
    mixed configCallback = null
): string
```

Perform the automatic rendering returning the output as a string

```php
$template = $this->view->getRender(
    "invoices",
    "show",
    [
        "invoices" => $invoices,
    ]
);
```

```php
public function getVar(string $key)
```

Returns a parameter previously set in the view

```php
public function getViewsDir(): string | array
```

Gets views directory

```php
protected function getViewsDirs(): array
```

Gets views directories

```php
public function isDisabled(): bool
```

Whether automatic rendering is enabled

```php
public function partial(
    string $partialPath, 
    mixed $params = null
)
```

Renders a partial view

```php
$this->partial("shared/footer");
```

Show a partial inside another view

```php
$this->partial(
    "shared/footer",
    [
        "content" => $html,
    ]
);
```

Show a partial inside another view with parameters

```php
public function pick(var renderView): View
```

Choose a different view to render instead of last-controller/last-action

```php
use Phalcon\Mvc\Controller;

class ProductsController extends Controller
{
    public function saveAction()
    {
        // ...

        $this->view->pick("invoices/list");
    }
}
```

```php
public function registerEngines(
    array $engines
): View
```

Register templating engines

```php
$this->view->registerEngines(
    [
        ".phtml" => \Phalcon\Mvc\View\Engine\Php::class,
        ".volt"  => \Phalcon\Mvc\View\Engine\Volt::class,
        ".mhtml" => \MyCustomEngine::class,
    ]
);
```

```php
public function render(
    string $controllerName,
    string $actionName,
    array $params = []
): View | bool
```

Executes render process from dispatching data

```php
$view
    ->start()
    ->render("posts", "recent")
    ->finish()
;
```

Shows recent posts view (app/views/posts/recent.phtml)

```php
public function reset(): View
```

Resets the view component to its factory default values

```php
public function setBasePath(
    string $basePath
): View
```

Sets base path. Depending of your platform, always add a trailing slash or backslash

```php
$view->setBasePath(__DIR__ . "/");
```

```php
public function setContent(
    string $content
): View
```

Externally sets the view content

```php
$this->view->setContent(
    "<h1>hello</h1>"
);
```

```php
public function setLayout(
    string $layout
): View
```

Change the layout to be used instead of using the name of the latest controller name

```php
$this->view->setLayout("main");
```

```php
public function setLayoutsDir(
    string $layoutsDir
): View
```

Sets the layouts subdirectory. It must be a directory under the views directory. Depending of your platform, always add a trailing slash or backslash

```php
$view->setLayoutsDir(
    "../common/layouts/"
);
```

```php
public function setMainView(
    string viewPath
): View
```

Sets default view name. Must be a file without extension in the views directory

```php
$this->view->setMainView("base");
```

Renders as main view views-dir/base.phtml

```php
public function setPartialsDir(
    string $partialsDir
): View
```

Sets a partials sub-directory. Must be a directory under the views directory. Depending of your platform, always add a trailing slash or backslash

```php
$view->setPartialsDir(
    "../common/partials/"
);
```

```php
public function setParamToView(
    string $key, 
    mixed $value
): View
```

Adds parameters to views (alias of setVar)

```php
$this
    ->view
    ->setParamToView("invoices", $invoices)
;
```

```php
public function setRenderLevel(
    int $level
): ViewInterface
```

Sets the render level for the view

```php
$this->view->setRenderLevel(
    View::LEVEL_LAYOUT
);
```

Render the view related to the controller only

```php
public function setTemplateAfter(
    mixed $templateAfter
): View
```

Sets a "template after" controller layout

```php
public function setTemplateBefore(
    mixed $templateBefore
): View
```

Sets a template before the controller layout

```php
public function setVar(
    string $key, 
    mixed $value
): View
```

Set a single view parameter

```php
$this
    ->view
    ->setVar("invoices", $invoices)
;
```

```php
public function setVars(
    array $params, 
    bool $merge = true
): View
```

Set all the render params

```php
$this->view->setVars(
    [
        "invoices" => $invoices,
    ]
);
```

```php
public function setViewsDir(
    mixed $viewsDir
): View
```

Sets the views directory. Depending of your platform, always add a trailing slash or backslash

```php
public function start(): View
```

Starts rendering process enabling the output buffering

```php
public function toString(
    string $controllerName,
    string $actionName,
    array params = []
): string
```

Renders the view and returns it as a string

## Activation

You must register the view component in your DI container to enable views in your application.

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\View;

$container = new FactoryDefault();

$container->set(
    'view',
    function () {
        $view = new View();

        $view->setViewsDir('../app/views/');

        return $view;
    }
);
```

If no engine is defined, the [Phalcon\Mvc\View\Engine\Php](api/phalcon_mvc#mvc-view-engine-php) will be automatically registered for you. These are files that contain both PHP and HTML code and have the extension `.phtml`. For more information regarding the [Volt](volt) template engine, please check the relevant document.

## Views in Controllers

Phalcon automatically passes the execution to the view component as soon as a particular controller has completed its cycle. The view component will look in the views folder for a folder named as the same name of the last controller executed and then for a file named as the last action executed. For instance, if a request is made to the URL *https://dev.phalcon.ld/admin/invoices/view/12345*, Phalcon will parse the URL as follows:

| Server Address    | `127.0.0.1` |
| ----------------- | ----------- |
| Phalcon Directory | `admin`     |
| Controller        | `invoices`  |
| Action            | `view`      |
| Parameter         | `12345`     |

The dispatcher will look for a `InvoicesController` and its action `viewAction`. A simple controller file for this example:

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;

/**
 * @property View $view
 */
class InvoicesController extends Controller
{
    public function viewAction($invoiceId)
    {
        $this->view->setVar('invoiceId', $invoiceId);
    }
}
```

The `setVar()` method allows us to create view variables on demand so that they can be used in the view template. The example above demonstrates how to pass the `$invoiceId` parameter to the respective view template.

## Hierarchical Rendering

[Phalcon\Mvc\View](api/phalcon_mvc#mvc-view) is the default component for rendering views in Phalcon and supports a hierarchy of files. This hierarchy allows for common layout points (commonly used views), as well as controller named folders defining respective view templates.

The default rendering engine for the view component is PHP. As a result all view related files need to have the `.phtml` extension. For the above example:

    https://dev.phalcon.ld/admin/invoices/view/12345
    

Assuming that the views directory is `app/views`, the view component will find automatically the following 3 view files:

| Name              | File                             | Description                                                                                         |
| ----------------- | -------------------------------- | --------------------------------------------------------------------------------------------------- |
| Action View       | app/views/invoices/view.phtml    | Action related view. It only will be rendered when the `view` action is executed.                   |
| Controller Layout | app/views/layouts/invoices.phtml | Controller related view. It will be rendered for every action executed in the `InvoicesController`. |
| Main Layout       | app/views/index.phtml            | Application related view. It shows on every controller/action of the application                    |

You are not required to implement all of the files mentioned above. [Phalcon\Mvc\View](api/phalcon_mvc#mvc-view) will simply move to the next view level in the hierarchy of files. If all three view files are implemented, they will be processed as follows:

```php
<!-- app/views/invoices/view.phtml -->

<h3>View Name: "view"</h3>

<p>I have received the parameter <?php echo $invoiceId; ?></p>
```

```php
<!-- app/views/layouts/invoices.phtml -->

<h2>Controller view: "invoices"</h2>

<?php echo $this->getContent(); ?>
```

```php
<!-- app/views/index.phtml -->
<html>
    <head>
        <title>Example</title>
    </head>
    <body>
        <h1>Main layout!</h1>

        <?php echo $this->getContent(); ?>

    </body>
</html>
```

> **NOTE**: The call to `$this->getContent()` instructs [Phalcon\Mvc\View](api/phalcon_mvc#mvc-view) on where to inject the contents of the previous view executed in the hierarchy.
{: .alert .alert-info }

For the example above, the output will be:

![](/assets/images/content/views-layout.png)

The generated HTML will be:

```php
<html>
    <head>
        <title>Example</title>
    </head>
    <body>
        <h1>Main layout!</h1>

        <!-- app/views/layouts/invoices.phtml -->

        <h2>Controller view: "invoices"</h2>

        <!-- app/views/invoices/view.phtml -->

        <h3>View Name: "view"</h3>

        <p>I have received the parameter 12345</p>

    </body>
</html>
```

### Templates

Templates are views that can be used to share common view code. They act as controller layouts, so you need to place them in the layouts directory.

Templates can be rendered before the layout (using `$this->view->setTemplateBefore()`) or they can be rendered after the layout (using `this->view->setTemplateAfter()`). In the following example the template (`layouts/common.phtml`) is rendered after the main layout (`layouts/posts.phtml`):

```php
<?php

use Phalcon\Flash\Direct;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;

/**
 * @property Direct $flash
 * @property View   $view
 */
class InvoicesController extends Controller
{
    public function initialize()
    {
        $this->view->setTemplateAfter('common');
    }

    public function lastAction()
    {
        $this->flash->notice(
            'These are the latest invoices'
        );
    }
}
```

```php
<!-- app/views/index.phtml -->
<!DOCTYPE html>
<html>
    <head>
        <title>Invoices</title>
    </head>
    <body>
        <?php echo $this->getContent(); ?>
    </body>
</html>
```

```php
<!-- app/views/layouts/common.phtml -->

<ul class='menu'>
    <li><a href='/'>Home</a></li>
    <li><a href='/list'>List</a></li>
    <li><a href='/support'>Support</a></li>
</ul>

<div class='content'>
    <?php echo $this->getContent(); ?>
</div>
```

```php
<!-- app/views/layouts/invoices.phtml -->

<h1>Invoices</h1>

<?php echo $this->getContent(); ?>
```

```php
<!-- app/views/invoices/last.phtml -->

<article>
    <h2>This is a title</h2>
    <p>This is Invoice One</p>
</article>

<article>
    <h2>Another title</h2>
    <p>This is Invoice Two</p>
</article>
```

The final output will be the following:

```php
<!-- app/views/index.phtml -->
<!DOCTYPE html>
<html>
    <head>
        <title>Invoices</title>
    </head>
    <body>

        <!-- app/views/layouts/common.phtml -->

        <ul class='menu'>
            <li><a href='/'>Home</a></li>
            <li><a href='/list'>List</a></li>
            <li><a href='/support'>Support</a></li>
        </ul>

        <div class='content'>

            <!-- app/views/layouts/invoices.phtml -->

            <h1>Invoices</h1>

            <!-- app/views/invoices/last.phtml -->

            <article>
                <h2>This is a title</h2>
                <p>This is Invoice One</p>
            </article>

            <article>
                <h2>Another title</h2>
                <p>This is Invoice Two</p>
            </article>

        </div>

    </body>
</html>
```

If we had used `$this->view->setTemplateBefore('common')`, this would be the final output:

```php
<!-- app/views/index.phtml -->
<!DOCTYPE html>
<html>
    <head>
        <title>Blog's title</title>
    </head>
    <body>

        <!-- app/views/layouts/invoices.phtml -->

        <h1>Blog Title</h1>

        <!-- app/views/layouts/common.phtml -->

        <ul class='menu'>
            <li><a href='/'>Home</a></li>
            <li><a href='/articles'>Articles</a></li>
            <li><a href='/contact'>Contact us</a></li>
        </ul>

        <div class='content'>

            <!-- app/views/invoices/last.phtml -->

            <article>
                <h2>This is a title</h2>
                <p>This is the post content</p>
            </article>

            <article>
                <h2>This is another title</h2>
                <p>This is another post content</p>
            </article>

        </div>

    </body>
</html>
```

### Render Levels

As seen above, [Phalcon\Mvc\View](api/phalcon_mvc#mvc-view) supports a view hierarchy. You might need to control the level of rendering produced by the view component. The method `Phalcon\Mvc\View::setRenderLevel()` offers this functionality.

This method can be invoked from the controller or from a superior view layer to interfere with the rendering process.

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;

/**
 * @property View   $view
 */
class InvoicesController extends Controller
{
    public function findAction()
    {
        $this->view->setRenderLevel(
            View::LEVEL_NO_RENDER
        );

        // ...
    }

    public function viewAction($invoiceId)
    {
        $this->view->setRenderLevel(
            View::LEVEL_ACTION_VIEW
        );
    }
}
```

The available render levels are:

| Class Constant          | Description                                                              | Order |
| ----------------------- | ------------------------------------------------------------------------ |:-----:|
| `LEVEL_NO_RENDER`       | Indicates to avoid generating any kind of presentation.                  |       |
| `LEVEL_ACTION_VIEW`     | Generates the presentation to the view associated to the action.         |   1   |
| `LEVEL_BEFORE_TEMPLATE` | Generates presentation templates prior to the controller layout.         |   2   |
| `LEVEL_LAYOUT`          | Generates the presentation to the controller layout.                     |   3   |
| `LEVEL_AFTER_TEMPLATE`  | Generates the presentation to the templates after the controller layout. |   4   |
| `LEVEL_MAIN_LAYOUT`     | Generates the presentation to the main layout. File views/index.phtml    |   5   |

### Disabling Render Levels

You can permanently or temporarily disable render levels. A level could be permanently disabled if it isn't used at all in the whole application:

```php
<?php

use Phalcon\Mvc\View;

$container->set(
    'view',
    function () {
        $view = new View();

        // Disable several levels
        $view->disableLevel(
            [
                View::LEVEL_LAYOUT      => true,
                View::LEVEL_MAIN_LAYOUT => true,
            ]
        );

        return $view;
    },
    true
);
```

Or disable temporarily in some part of the application:

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;

/**
 * @property View   $view
 */
class InvoicesController extends Controller
{
    public function findAction()
    {
        $this->view->disableLevel(
            View::LEVEL_MAIN_LAYOUT
        );
    }
}
```

### Disabling the View

If your controller does not produce any output for the view (or not even have one) you may disable the view component avoiding unnecessary processing:

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;

/**
 * @property View   $view
 */
class InvoicesController extends Controller
{
    public function processAction()
    {
        $this->view->disable();
    }
}
```

Alternatively, you can return `false` to produce the same effect:

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;

/**
 * @property View   $view
 */
class InvoicesController extends Controller
{
    public function processAction()
    {
        return false;
    }
}
```

You can return a `response` object to avoid disable the view manually:

```php
<?php

use Phalcon\Http\Response;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;

/**
 * @property Response $response
 * @property View     $view
 */
class InvoicesController extends Controller
{
    public function processAction()
    {
        return $this
            ->response
            ->redirect('index/index')
        ;
    }
}
```

## Simple Rendering

[Phalcon\Mvc\View\Simple](api/phalcon_mvc#mvc-view-simple) is an alternative component to [Phalcon\Mvc\View](api/phalcon_mvc#mvc-view). It keeps most of the philosophy of [Phalcon\Mvc\View](api/phalcon_mvc#mvc-view) but lacks of a hierarchy of files which is, in fact, the main feature of its counterpart.

This component allows you to have control of when a view is rendered and its location. In addition, this component can leverage of view inheritance available in template engines such as [Volt](volt) and others.

The default component must be replaced in the service container:

```php
<?php

use Phalcon\Mvc\View\Simple;

$container->set(
    'view',
    function () {
        $view = new Simple();

        $view->setViewsDir('../app/views/');

        return $view;
    },
    true
);
```

Automatic rendering must be disabled in [Phalcon\Mvc\Application](application) (if needed):

```php
<?php

use Phalcon\Di\FactoryDefault;;
use Phalcon\Mvc\Application;

try {
    $container   = new FactoryDefault();
    $application = new Application($container);

    $application->useImplicitView(false);

    $response = $application->handle(
        $_SERVER["REQUEST_URI"]
    );

    $response->send();
} catch (Exception $e) {
    echo $e->getMessage();
}
```

To render a view it is necessary to call the render method explicitly indicating the relative path to the view you want to display:

```php
<?php

use Phalcon\Http\Response;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;

/**
 * @property Response $response
 * @property View     $view
 */
class InvoicesController extends Controller
{

    public function indexAction()
    {
        // 'views-dir/index.phtml'
        echo $this->view->render('index');

        // 'views-dir/posts/show.phtml'
        echo $this->view->render('posts/show');

        // 'views-dir/index.phtml' passing variables
        echo $this->view->render(
            'index',
            [
                'posts' => Invoices::find(),
            ]
        );

        // 'views-dir/invoices/view.phtml' passing variables
        echo $this->view->render(
            'invoices/view',
            [
                'posts' => Invoices::find(),
            ]
        );
    }
}
```

This is different to the `render` that [Phalcon\Mvc\View](api/phalcon_mvc#mvc-view) implementation, which uses controllers and actions as parameters:

```php
<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Simple;

$params = [
    'invoices' => Invoices::find(),
];

// Phalcon\Mvc\View
$view = new View();
echo $view->render('invoices', 'view', $params);

// Phalcon\Mvc\View\Simple
$simpleView = new Simple();
echo $simpleView->render('invoices/view', $params);
```

### Picking Views

As mentioned above, when [Phalcon\Mvc\View](api/phalcon_mvc#mvc-view) is managed by [Phalcon\Mvc\Application](application), the view rendered is the one related with the last controller and action executed. You could override this by using the `pick()` method:

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;

/**
 * @property Response $response
 * @property View     $view
 */
class InvoicesController extends Controller
{
    public function listAction()
    {
        // Pick 'views-dir/invoices/search' as view to render
        $this->view->pick('invoices/search');

        // Pick 'views-dir/invoices/list' as view to render
        $this->view->pick(
            [
                'invoices',
            ]
        );

        // Pick 'views-dir/invoices/search' as view to render
        $this->view->pick(
            [
                1 => 'search',
            ]
        );
    }
}
```

## Partials

Partial templates are another way of breaking the rendering process into simpler more manageable chunks that can be reused by different parts of the application. With a partial, you can move the code for rendering a particular piece of a response to its own file.

One way to use partials is to treat them as HTML fragments that can be injected wherever needed with any necessary parameters:

```php
<div class='top'>
    <?php $this->partial('shared/ad_banner'); ?>
</div>

<div class='content'>
    <h1>Invoices</h1>

    <p>Check out our specials!</p>
    ...
</div>

<div class='footer'>
    <?php $this->partial('shared/footer'); ?>
</div>
```

The `partial()` method does accept a second parameter as an array of variables/parameters that only will exists in the scope of the partial:

```php
<?php 
    $this->partial(
        'shared/ad_banner', 
        [
            'id'   => $site->id, 
            'size' => 'big'
        ]
    ); 
?>
```

## Values

[Phalcon\Mvc\View](api/phalcon_mvc#mvc-view) is available in each controller using the view variable (`$this->view`). You can use that object to set variables directly to the view from a controller action by using the `setVar()` method.

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;

/**
 * @property View $view
 */
class InvoicesController extends Controller
{
    public function viewAction($invoiceId)
    {
        $invoice = Invoices::findFirst(
            [
                'conditions' => 'inv_id = :id:',
                'bind'       => [
                    'id' => abs(intval($invoiceId)),
                ]
            ]
        );
        $customer = $invoice->getRelated('customer');

        $this->view->setVar('invoice', $invoice);

        $this->view->customerId = $customer->cst_id;

        $this->view->setVars(
            [
                'name_first' => $customer->name_first,
                'name_last'  => $customer->name_last,
            ]
        );
    }
}
```

A variable with the name of the first parameter of `setVar()` will be created in the view, ready to be used. The variable can be of any type, from a simple `string`, `integer` etc. variable to a more complex structure such as `array`, collection etc.

```php
<h1>
    Invoices [Customer #{{ customerId }}]
</h1>

<div class='invoice'>
<?php

    foreach ($invoices as $invoice) {
        echo '<h2>', $invoice->inv_title, '</h2>';
    }

?>
</div>
```

## Template Engines

Template Engines help designers to create views without the use of a complicated syntax. Phalcon includes a powerful and fast templating engine called [Volt](volt) that help with view development while not sacrificing processing speed.

### PHP

The [Phalcon\Mvc\View\Engine\Php](api/phalcon_mvc#mvc-view-engine-php) is the default template engine, if none has been specified.

```php
<?php

use Phalcon\Mvc\View;

$container->set(
    'view',
    function () {
        $view = new View();

        $view->setViewsDir('../app/views/');

        return $view;
    },
    true
);
```

### Volt

You might want to use [Volt](volt) as your template engine. To set it up you need to register the engine and pass it to the view component.

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Di\DiInterface;
use Phalcon\Mvc\ViewBaseInterface;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt;

$container = new FactoryDefault();

$container->setShared(
    'voltService',
    function (ViewBaseInterface $view) {
        $volt = new Volt($view, $this);
        $volt->setOptions(
            [
                'always'    => true,
                'extension' => '.php',
                'separator' => '_',
                'stat'      => true,
                'path'      => appPath('storage/cache/volt/'),
                'prefix'    => '-prefix-',
            ]
        );

        return $volt;
    }
);

$container->set(
    'view',
    function () {
        $view = new View();

        $view->setViewsDir('../app/views/');

        $view->registerEngines(
            [
                '.volt' => 'voltService',
            ]
        );

        return $view;
    }
);
```

### Mustache/Twig/Smarty

If you like to use [Mustache](https://github.com/bobthecow/mustache.php), [Twig](https://twig.symfony.com/) or [Smarty](https://www.smarty.net/) as your template engine, you can visit our [incubator](https://github.com/phalcon/incubator/tree/master/Library/Phalcon/Mvc/View/Engine) repository for examples on how to activate these engines in your application

### Custom

When using an external template engine, [Phalcon\Mvc\View](api/phalcon_mvc#mvc-view) provides exactly the same view hierarchy and it is still possible to access the API inside these templates. If you want to create your own template engine, you can leverage the API to perform the operations you need.

A template engine adapter is a class that acts as bridge between [Phalcon\Mvc\View](api/phalcon_mvc#mvc-view) and the template engine itself. Usually it only needs two methods implemented: `__construct()` and `render()`. The first one receives the [Phalcon\Mvc\View](api/phalcon_mvc#mvc-view) instance that creates the engine adapter and the DI container used by the application.

The method `render()` accepts an absolute path to the view file and the view parameters set using `$this->view->setVar()`. You could read or require it when it's necessary.

```php
<?php

use Phalcon\Di\DiInterface;
use Phalcon\Mvc\View\Engine\AbstractEngine;
use Phalcon\Mvc\View;

class CustomEngine extends AbstractEngine
{
    /**
     * @param View        $view
     * @param DiInterface $container
     */
    public function __construct($view, DiInterface $container)
    {
        parent::__construct($view, $container);
    }

    /**
     * @param string $path
     * @param array $params
     */
    public function render(string $path, $params)
    {
        // Access view
        $view = $this->view;

        // Options
        $options = $this->options;

        // Render the view
        // ...
    }
}
```

You can now replace the template engine with your own in the view setup part of your code. You can always use more than one engine at a time. To achieve this you need to call `Phalcon\Mvc\View::registerEngines()` which accepts an array with setup instructions on which engines are registered. The key of each engine is th extension of the files you need to process. You cannot register two engines with the same key.

The order that the template engines are defined with `Phalcon\Mvc\View::registerEngines()` defines the priority of execution. If [Phalcon\Mvc\View](api/phalcon_mvc#mvc-view) finds two views with the same name but different extensions, it will only render the first one.

```php
<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Php;

$container->set(
    'view',
    function () {
        $view = new View();

        $view->setViewsDir('../app/views/');

        $view->registerEngines(
            [
                '.my-html' => \CustomEngine::class,
            ]
        );

        $view->registerEngines(
            [
                '.my-html' => \CustomEngine::class,
                '.phtml'   => Php::class,
            ]
        );

        return $view;
    },
    true
);
```

## Dependency Injection

Since our view is registered in our Dependency Injection container, the services available in the container are also available in the view. Each service is available by a property with the same name as the defined service.

```js
<script type='text/javascript'>

$.ajax({
    url: '<?php echo $this->url->get('invoices/get'); ?>'
})
.done(function () {
    alert('Done!');
});

</script>
```

In the example above, we are utilizing the [Phalcon\Url](url) component in our javascript code, to correctly set up the URL in our application. The service is available in the view by accessing `$this->url`.

## Stand Alone

You can also use the view as a *glue* component in your application. You will only need to have the proper setup and then use the view to return processed results back.

### Hierarchical Rendering

Once you set up the view with the options that are necessary for your application, you can pass variables to it, as seen above, then call `start()`, `render()` and `finish()`. This will allow the view to compile the data and prepare it for you. You can print the content produced by calling `getContent()`.

```php
<?php

use Phalcon\Mvc\View;

$view = new View();

$view->setViewsDir('../app/views/');

//...

$view->setVar('invoices', $invoices);
$view->setVar('isAdmin', true);

$view->start();
$view->render('invoices', 'list');
$view->finish();

echo $view->getContent();
```

Or using a shorter syntax:

```php
<?php

use Phalcon\Mvc\View;

$view = new View();

echo $view->getRender(
    'invoices',
    'list',
    [
        'invoices' => $invoices,
        'isAdmin'  => true,
    ],
    function ($view) {
        $view->setViewsDir('../app/views/');

        $view->setRenderLevel(
            View::LEVEL_LAYOUT
        );
    }
);
```

### Simple Rendering

You can also use the much smaller [Phalcon\Mvc\View\Simple](api/phalcon_mvc#mvc-view-simple) as a stand alone component. This component is extremely useful when you want to render a template that is not always tied to your application structure. An example is rendering HTML code required by emails.

```php
<?php

use Phalcon\Mvc\View\Simple;

$view = new Simple();

$view->setViewsDir('../app/views/');

echo $view->render('templates/welcome');

echo $view->render(
    'templates/welcome',
    [
        'email'   => $email,
        'content' => $content,
    ]
);
```

In the above example, we set up the engine and then echo a rendered template on screen (`templates/welcome`). We can also send parameters to the template by issuing an array as the second parameter. The keys are the names of the variables.

## Events

[Phalcon\Mvc\View](api/phalcon_mvc#mvc-view) and [Phalcon\Mvc\View\Simple](api/phalcon_mvc#mvc-view-simple) are able to send events to an [Events Manager](events) if it is present. Events are triggered using the type `view`. If an event returns `false` it can stop the active operation. The following events are supported:

| Event Name         | Triggered                           | Can stop |
| ------------------ | ----------------------------------- |:--------:|
| `afterRender`      | After completing the render process |    No    |
| `afterRenderView`  | After rendering an existing view    |    No    |
| `beforeRender`     | Before starting the render process  |   Yes    |
| `beforeRenderView` | Before rendering an existing view   |   Yes    |
| `notFoundView`     | When a view was not found           |    No    |

The following example demonstrates how to attach listeners to this component:

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Events\Event;
use Phalcon\Events\Manager;
use Phalcon\Mvc\View;

$container = new FactoryDefault();
$container->set(
    'view',
    function () {
        $manager = new Manager();

        $manager->attach(
            'view',
            function (Event $event, $view) {
                echo $event->getType(), ' - ', 
                     $view->getActiveRenderPath(), PHP_EOL;
            }
        );

        $view = new View();

        $view->setViewsDir('../app/views/');

        $view->setEventsManager($manager);

        return $view;
    },
    true
);
```

The following example demonstrates how you can create a plugin that *tidies up* your HTML produced by the render process using [Tidy](https://secure.php.net/manual/en/book.tidy.php).

```php
<?php

use Phalcon\Events\Event;

class TidyPlugin
{
    public function afterRender(Event $event, $view)
    {
        $tidyConfig = [
            'clean'          => true,
            'output-xhtml'   => true,
            'show-body-only' => true,
            'wrap'           => 0,
        ];

        $tidy = tidy_parse_string(
            $view->getContent(),
            $tidyConfig,
            'UTF8'
        );

        $tidy->cleanRepair();

        $view->setContent(
            (string) $tidy
        );
    }
}
```

and we can now attach it to our events manager:

```php
<?php

$manager->attach(
    'view:afterRender',
    new TidyPlugin()
);
```

## Exceptions

Any exceptions thrown in the view components ([Phalcon\Mvc\View](api/phalcon_mvc#mvc-view) or [Phalcon\Mvc\View\Simple](api/phalcon_mvc#mvc-view-simple)) will be of type [Phalcon\Mvc\Exception](api/phalcon_mvc#mvc-view-exception) or [Phalcon\View\Engine\Volt\Exception](api/phalcon_mvc#mvc-view-engine-volt-exception) if you are using [Volt](volt). You can use this exception to selectively catch exceptions thrown only from this component.

```php
<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Exception;

try {

    $view = new View();

    echo $view->getRender(
        'unknown-view',
        'list',
        [
            'invoices' => $invoices,
            'isAdmin'  => true,
        ],
        function ($view) {
            $view->setViewsDir('../app/views/');

            $view->setRenderLevel(
                View::LEVEL_LAYOUT
            );
        }
    );
} catch (Exception $ex) {
    echo $ex->getMessage();
}

```