---
layout: default
language: 'es-es'
version: '5.0'
upgrade: '#flash'
title: 'Mensajes Flash'
keywords: 'flash, mensajes flash, flash directo, flash sesión, plantillas'
---

# Mensajes Flash
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Resumen
Los mensajes flash son usados para notificar al usuario sobre el estado de acciones que ha hecho o simplemente muestra información a los usuarios. Estos tipos de mensajes pueden ser generados usando este componente.

## Adaptadores
Este componente usa adaptadores que indican como se muestran los mensajes o se envían a la vista. There are two adapters available, but you can easily create your own adapter using the [Phalcon\Flash\FlashInterface][flash-flashinterface] interface.

| Adaptador                                | Descripción                                                                                                         |
| ---------------------------------------- | ------------------------------------------------------------------------------------------------------------------- |
| [Phalcon\Flash\Direct][flash-direct]   | Las salidas de los mensajes se transfieren directamente al flasher                                                  |
| [Phalcon\Flash\Session][flash-session] | Se almacena temporalmente los mensajes en la sesión, luego se pueden imprimir los mensajes en la siguiente consulta |

### Direct
[Phalcon\Flash\Direct][flash-direct] can be used to directly output messages set in the component. Esto es útil en casos donde necesita mostrar datos de vuelta al usuario en la petición actual que no emplea ninguna redirección.

```php
<?php

use Phalcon\Escaper;
use Phalcon\Flash\Direct;

$escaper = new Escaper();
$flash   = new Direct($escaper);

$flash->error('Something went wrong');
```

### Session
[Phalcon\Flash\Session][flash-session] can be used to output messages set in the component. El componente almacena de forma transparente los mensajes en la sesión para usarse después de una redirección.

```php
<?php

use Phalcon\Escaper;
use Phalcon\Flash\Session as FlashSession;
use Phalcon\Session\Adapter\Stream;
use Phalcon\Session\Manager;

$session = new Manager();
$files = new Stream(
    [
        'savePath' => '/tmp',
    ]
);
$session->setHandler($files);

$escaper = new Escaper();
$flash   = new FlashSession($escaper, $session);

$flash->error('Something went wrong');
```

y en su vista

```php
<?php echo $flash->output(); ?>
```

o cuando se usa Volt

```twig
{% raw %}{{ flash.output() }}{% endraw %}
```

Imagine un formulario de inicio de sesión donde necesita validar el nombre de usuario y contraseña e informar al usuario si sus credenciales son correctas. The [Phalcon\Flash\Session][flash-session] can be used to perform this task as follows:
- User enters credentials and clicks `Login`
- The application posts the data to the `loginAction` of our controller
- The application checks the data and the combination is not correct
- The application stores the `Incorrect Credentials` message in the flash messenger
- The application redirects the user back to the login page (`/login`)
- The Flash messenger still holds the message `Incorrect Credentials` and will display it on the screen.

El siguiente ejemplo muestra este comportamiento en el controlador. Si ocurre un error, ya sea un error actual de la aplicación o resultado de unas credenciales incorrectas, el código establece los mensajes usando `$this->flash->error()`.

```php
<?php

namespace MyApp;

use Phalcon\Flash\Session;
use Phalcon\Http\Request;
use Phalcon\Http\Response;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;
use Vokuro\Auth\Auth; 
use Vokuro\Models\Users;
use Vokuro\Models\ResetPasswords;

/**
 * Controller used handle non-authenticated session actions like 
 * login/logout, user signup, and forgotten passwords
 *
 * @property Auth     $auth
 * @property Request  $request
 * @property Response $response
 * @property Session  $flashSession
 * @property View     $view
 */
class SessionController extends Controller
{
    /**
     * Starts a session in the admin backend
     */
    public function loginAction()
    {
        $form = new LoginForm();

        try {
            if (true !== $this->request->isPost()) {
                // ....
            } else {
                $postData = $this->request->getPost();
                if (true !== $form->isValid($postData)) {
                    // Flash
                    foreach ($form->getMessages() as $message) {
                        $this->flashSession->error($message);
                    }
                } else {
                    $email    = $this->request->getPost('email');
                    $password = $this->request->getPost('password');
                    $remember = $this->request->getPost('remember');

                    $this->auth->check(
                        [
                            'email'    => $email,
                            'password' => $password,
                            'remember' => $remember,
                        ]
                    );

                    return $this->response->redirect('users');
                }
            }
        } catch (AuthException $e) {
            // Flash
            $this->flashSession->error($e->getMessage());
        }

        $this->view->form = $form;
    }
}
```

y en su vista

```php
<?php echo $flashSession->output(); ?>
```

o cuando se usa Volt

```twig
{% raw %}{{ flashSession.output() }}{% endraw %}
```

> **NOTE**: In the above example, the `flashSession` service has been already registered in the DI container. Para más información sobre esto por favor consulte la sección correspondiente a continuación. 
> 
> {: .alert .alert-info }

## Estilo
El componente (independientemente del adaptador) ofrece un estilo automático de los mensajes en pantalla. Esto significa que los mensajes serán envueltos en etiquetas `<div>`. Hay también un mapeo del tipo de mensaje a clase CSS, del que puede sacar partido basándose en la hoja de estilos que use en su aplicación. By default, the component uses the following mapping:

| Tipo      | Nombre de la clase CSS |
| --------- | ---------------------- |
| `error`   | `errorMessage`         |
| `notice`  | `noticeMessage`        |
| `success` | `successMessage`       |
| `warning` | `warningMessage`       |

Usando las clases por defecto, puede estilizar `errorMessage` de acorde a la hoja de estilos de su aplicación para hacer que aparezca de la forma que quiera. Es común que los mensajes de error tengan un fondo rojo, por ejemplo, para que destaquen.

Un mensaje de error:

```php
$flash->error('Error message');
```

producirá:

```html
<div class="errorMessage">Error message</div>
```

Si no quiere usar las clases por defecto, puede usar el método `setCssClasses()` para reemplazar el mapeo de tipo de mensaje al nombre de clase.

```php
<?php

use Phalcon\Escaper;
use Phalcon\Flash\Direct;

$escaper = new Escaper();
$flash   = new Direct($escaper);

var_dump(
    $flash->getCssClasses()
);

// [
//     "error"   => "errorMessage",
//     "notice"  => "noticeMessage",
//     "success" => "successMessage",
//     "warning" => "warningMessage",
// ];


$cssClasses = [
    'error'   => 'alert alert-danger',
    'success' => 'alert alert-success',
    'notice'  => 'alert alert-info',
    'warning' => 'alert alert-warning',
];

$flash->setCssClasses($cssClasses);
```

y luego llamar

```php
$flash->error('Error message');
```

producirá:

```html
<div class="alert alert-danger">Error message</div>
```

> **NOTE**: The `setCssClasses()` returns back the object, so you can use in a more fluent interface by chaining calls. 
> 
> {: .alert .alert-info }

El componente también le permite especificar una plantilla diferente, para que pueda controlar el HTML producido por el componente. `setCustomTemplate()` y `getCustomTemplate()` exponen esta funcionalidad. La plantilla necesita tener dos marcadores de posición:

- `%cssClass%` - donde se inyectará la clase CSS
- `%message%` - donde se inyectará el mensaje

```php
<?php

use Phalcon\Escaper;
use Phalcon\Flash\Direct;

$escaper = new Escaper();
$flash   = new Direct($escaper);

$template = '<span class="%cssClass%">%message%</span>';

$flash->setCustomTemplate($template);
```

y luego llamar

```php
$flash->error('Error message');
```

producirá:

```html
<span class="myErrorClass">Error message</span>
```

> **NOTE**: The `setCustomTemplate()` returns back the object, so you can use in a more fluent interface by chaining calls. 
> 
> {: .alert .alert-info }

You can also set the icon class for each CSS class by using `setCssIconClasses()`. This is particularly useful when working with CSS libraries such as \[Bootstrap\]\[bootstrap\].

```php
<?php

use Phalcon\Escaper;
use Phalcon\Flash\Direct;

$escaper = new Escaper();
$flash   = new Direct($escaper);

$iconClasses = [
    'error'   => 'alert alert-error',
    'success' => 'alert alert-success',
    'notice'  => 'alert alert-notice',
    'warning' => 'alert alert-warning',
];

$flash->setCssClasses($cssClasses);
```

y luego llamar

```php
$flash->error('Error message');
```

producirá:

```html
<div class="errorMessage"><i class="alert alert-error"></i>Error message
```

> **NOTE**: The `setCssIconClasses()` returns back the object, so you can use in a more fluent interface by chaining calls. 
> 
> {: .alert .alert-info }

## Messages
Como se ha mencionado anteriormente, el componente tiene diferentes tipos de mensajes. Para añadir un mensaje al componente puede llamar a `message()` con el tipo y el mensaje propiamente dicho. Los tipos de mensajes son:

- `error`
- `notice`
- `success`
- `warning`

```php
<?php

use Phalcon\Escaper;
use Phalcon\Flash\Direct;

$escaper = new Escaper();
$flash   = new Direct($escaper);

$flash->message('error', 'Error message');
```

Mientras que puede pasar el tipo como primer parámetro cuando se llama a `message()` también puede usar los métodos de ayuda que lo hacen por usted:

```php
<?php

use Phalcon\Escaper;
use Phalcon\Flash\Direct;

$escaper = new Escaper();
$flash   = new Direct($escaper);

$flash->error('Error message');
$flash->notice('Notice message');
$flash->success('Success message');
$flash->warning('Warning message');
```

Si su aplicación lo requiere, podría querer limpiar los mensajes en algún momento cuando construye la respuesta. Para hacerlo puede usar el método `clear()`.

```php
<?php

use Phalcon\Escaper;
use Phalcon\Flash\Direct;

$escaper = new Escaper();
$flash   = new Direct($escaper);

$flash->error('Error message');

$flash->clear();
```

> **NOTE**: `clear()` works only when the implicit flush is disabled (`setImplicitFlush(false)`) 
> 
> {: .alert .alert-info }

## Volcado Implícito
By default, implicit flushing is set to `true`. Sin embargo puede desactivarlo usando `setImplicitFlush(false)`. El propósito de este método es establecer si la salida debe ser volcada implícitamente a la salida o devuelta como una cadena

```php
<?php

use Phalcon\Escaper;
use Phalcon\Flash\Direct;

$escaper = new Escaper();
$flash   = new Direct($escaper);

echo $flash->getImplicitFlush(); // true

$flash->error('Error'); // No output

echo $flash
    ->setImplicitFlush(false) 
    ->error('Error Message') // 'Error Message'
;
```

> **NOTE**: The `setImplicitFlush()` returns back the object, so you can use in a more fluent interface by chaining calls. 
> 
> {: .alert .alert-info }

> **NOTE**: When using the [Phalcon\Flash\Direct][flash-direct] component, to directly show results on the page you **must** set `setImplicitFlush()` to `false`. 
> 
> {: .alert .alert-warning }

## Escape
Por defecto, el componente escapará el contenido del mensaje. Sin embargo, podría haber ocasiones en las que no desee escapar el contenido de sus mensajes. Puede usar `setAutoescape(false)`;

```php
<?php

use Phalcon\Escaper;
use Phalcon\Flash\Direct;

$escaper = new Escaper();
$flash   = new Direct($escaper);

echo $flash->getAutoescape(); // true

$flash
    ->setAutoescape(false)
    ->error('<h1>Error</h1>')
;
```

producirá

```html
<div class="errorMessage">&lt;h1&gt;Error&lt;/h1&gt;</div>
```

> **NOTE**: The `setAutoescape()` returns back the object, so you can use in a more fluent interface by chaining calls. 
> 
> {: .alert .alert-info }

## Inyección de Dependencias
If you use the [Phalcon\Di\FactoryDefault][factorydefault] container, the [Phalcon\Flash\Direct][flash-direct] is already registered for you with the name `flash`. Additionally, the [Phalcon\Flash\Session][flash-session] is already registered for you with the name `flashSession`.

A continuación, un ejemplo de registro del servicio así como de acceso a él:

**Direct**

```php
<?php

use Phalcon\Di;
use Phalcon\Escaper;
use Phalcon\Flash\Direct;

$container = new Di();
$escaper   = new Escaper();

$container->set(
    'flash',
    function () use ($escaper) {
        return new Direct($escaper);
    }
);
```

**Session**

```php
<?php

use Phalcon\Di;
use Phalcon\Escaper;
use Phalcon\Flash\Session as FlashSession;
use Phalcon\Session\Adapter\Stream;
use Phalcon\Session\Manager;

$container = new Di();
$escaper   = new Escaper();
$session   = new Manager();
$files     = new Stream(
    [
        'savePath' => '/tmp',
    ]
);
$session->setHandler($files);

$container->set(
    'flashSession',
    function () use ($escaper, $session) {
        return new FlashSession($escaper, $session);
    }
);
```

> **NOTE** You do not need to pass the escaper or the session in the constructor. Si usa el contenedor Di y esos servicios ya se han registrado en él, se usarán internamente. Esta es otra forma de instanciar los componentes. 
> 
> {: .alert .alert-info }

You can now use the component in a controller (or a component that implements [Phalcon\Di\Injectable][di-injectable])

```php
<?php

namespace MyApp;

use Phalcon\Flash\Direct;
use Phalcon\Mvc\Controller;

/**
 * Invoices controller
 *
 * @property Direct $flash
 */
class InvoicesController extends Controller
{
    public function indexAction()
    {

    }

    public function saveAction()
    {
        $this->flash->success('The post was correctly saved!');
    }
}
```

[flash-direct]: api/phalcon_flash#flash-direct
[flash-flashinterface]: api/phalcon_flash#flash-flashinterface
[flash-session]: api/phalcon_flash#flash-session
[di-injectable]: api/phalcon_di#di-injectable
[factorydefault]: api/phalcon_di#di-factorydefault
