---
layout: default
language: 'es-es'
version: '4.0'
upgrade: '#flash'
title: 'Mensajes Flash'
keywords: 'flash, mensajes flash, flash directo, flash sesión, plantillas'
---

# Mensajes Flash

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen

Los mensajes flash son usados para notificar al usuario sobre el estado de acciones que ha hecho o simplemente muestra información a los usuarios. Estos tipos de mensajes pueden ser generados usando este componente.

## Adaptadores

Este componente usa adaptadores que indican como se muestran los mensajes o se envían a la vista. Hay dos adaptadores disponibles aunque puede crear fácilmente su propio adaptador usando el interfaz [Phalcon\Flash\FlashInterface](api/phalcon_flash#flash-flashinterface).

| Adaptador                                                  | Descripción                                                                                                         |
| ---------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------- |
| [Phalcon\Flash\Direct](api/phalcon_flash#flash-direct)   | Las salidas de los mensajes se transfieren directamente al flasher                                                  |
| [Phalcon\Flash\Session](api/phalcon_flash#flash-session) | Se almacena temporalmente los mensajes en la sesión, luego se pueden imprimir los mensajes en la siguiente consulta |

### Direct

[Phalcon\Flash\Direct](api/phalcon_flash#flash-direct) se puede usar para mostrar directamente los mensajes establecidos en el componente. Esto es útil en casos donde necesita mostrar datos de vuelta al usuario en la petición actual que no emplea ninguna redirección.

```php
<?php

use Phalcon\Escaper;
use Phalcon\Flash\Direct;

$escaper = new Escaper();
$flash   = new Direct($escaper);

$flash->error('Something went wrong');
```

### Session

[Phalcon\Flash\Session](api/phalcon_flash#flash-session) se puede usar para mostrar mensajes establecidos en el componente. El componente almacena de forma transparente los mensajes en la sesión para usarse después de una redirección.

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

Imagine un formulario de inicio de sesión donde necesita validar el nombre de usuario y contraseña e informar al usuario si sus credenciales son correctas. [Phalcon\Flash\Session](api/phalcon_flash#flash-session) se puede usar para realizar estas tareas como sigue:  
- El usuario introduce las credenciales y hace click sobre `Login` - La aplicación publica los datos a `loginAction` de nuestro controlador - La aplicación comprueba si los datos y la combinación no son correctos - La aplicación almacena el mensaje `Credenciales Incorrectas` en el mensajero flash - La aplicación redirecciona al usuario de vuelta a la página de login (`/login`) - El mensajero Flash todavía mantiene el mensaje `Credenciales Incorrectas` y lo muestra en pantalla.

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

> **NOTA**: En el ejemplo anterior, el servicio `flashSession` ya ha sido registrado en el contenedor DI. Para más información sobre esto por favor consulte la sección correspondiente a continuación.
{: .alert .alert-info }

## Estilo

El componente (independientemente del adaptador) ofrece un estilo automático de los mensajes en pantalla. Esto significa que los mensajes serán envueltos en etiquetas `<div>`. Hay también un mapeo del tipo de mensaje a clase CSS, del que puede sacar partido basándose en la hoja de estilos que use en su aplicación. Por defecto el componente usa el siguiente mapeo:

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

> **NOTA**: `setCssClasses()` devuelve el objeto para que pueda usarlo en una interfaz más fluida encadenando llamadas.
{: .alert .alert-info }

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

> **NOTA**: `setCustomTemplate()` devuelve el objeto para que pueda usarlo en una interfaz más fluida encadenando llamadas.
{: .alert .alert-info }

## Mensajes

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

> **NOTA**: `clear()` funciona solo cuando el volcado implícito está deshabilitado (`setImplicitFlush(false)`)
{: .alert .alert-info }

## Volcado Implícito

Por defecto el volcado implícito está establecido a `true`. Sin embargo puede desactivarlo usando `setImplicitFlush(false)`. El propósito de este método es establecer si la salida debe ser volcada implícitamente a la salida o devuelta como una cadena

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

> **NOTA**: `setImplicitFlush()` devuelve el objeto para que pueda usarlo de una forma más fluida encadenando llamadas.
{: .alert .alert-info }

> 
> **NOTA**: Cuando usa el componente [Phalcon\Flash\Direct](api/phalcon_flash#flash-direct), para mostrar directamente los resultados en la página **debe** establecer `setImplicitFlush()` a `false`.
{: .alert .alert-warning }

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

> **NOTA**: `setAutoescape()` devuelve el objeto para que pueda usarlo de una forma más fluida encadenando llamadas.
{: .alert .alert-info }

## Inyección de Dependencias

Si usa el contenedor [Phalcon\Di\FactoryDefault](api/phalcon_di#di-factorydefault), [Phalcon\Flash\Direct](api/phalcon_flash#flash-direct) ya está registrado con el nombre `flash`. Adicionalmente [Phalcon\Flash\Session](api/phalcon_flash#flash-session) ya está registrado con el nombre `flashSession`.

Un ejemplo del registro del servicio así de cómo acceder a él a continuación:

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

> **NOTA** No necesita pasar el escapador o la sesión en el constructor. Si usa el contenedor Di y esos servicios ya se han registrado en él, se usarán internamente. Esta es otra forma de instanciar los componentes.
{: .alert .alert-info }

Ahora puede usar el componente en un controlador (o un componente que implemente [Phalcon\Di\Injectable](api/phalcon_di#di-injectable))

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
