<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Tutorial: Vökuró</a> <ul>
        <li>
          <a href="#structure">Estructura del proyecto</a>
        </li>
        <li>
          <a href="#dependencies">Carga de clases y dependencias</a>
        </li>
        <li>
          <a href="#sign-up">Registrarse</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Tutorial: Vökuró

Vökuró es otra aplicación de ejemplo que se puede utilizar para aprender más sobre Phalcon. Vökuró es un pequeño sitio web que muestra cómo implementar características en materia de seguridad y gestión de usuarios y permisos. Puede clonar su código desde [Github](https://github.com/phalcon/vokuro).

<a name='structure'></a>

## Estructura del proyecto

Una vez clonado el proyecto en la raíz de tu documento, podrá ver la siguiente estructura:

```bash
vokuro/
    app/
        config/
        controllers/
        forms/
        library/
        models/
        views/
    cache/
    public/
        css/
        img/
    schemas/
```

Este proyecto sigue una estructura similar al utilizado en INVO. Una vez que usted abra la aplicación en su navegador `http://localhost/vokuro` verás algo como esto:

![](/images/content/tutorial-vokuro-1.png)

La aplicación se divide en dos partes, un frontend, donde los visitantes pueden inscribirse al servicio y un backend donde los usuarios administradores pueden gestionar los usuarios registrados. Ambos, frontend y backend, se combinan en un solo módulo.

<a name='dependencies'></a>

## Carga de clases y dependencias

Este proyecto utiliza `Phalcon\Loader` para cargar los controladores, modelos, formularios, etcétera. dentro del proyecto y [composer](https://getcomposer.org/) para cargar las dependencias del proyecto. Por lo tanto, lo primero que tienes que ejecutar antes de Vökuró es instalar sus dependencias a través de [composer](https://getcomposer.org/). Suponiendo que lo tiene correctamente instalado, escriba el siguiente comando en la consola:

```bash
cd vokuro
composer install
```

Vökuró envía mensajes de correo electrónico para confirmar la inscripción de usuarios registrados utilizando Swift, el archivo `composer.json` se ve de la siguiente manera:

```json
{
    "require" : {
        "php": ">=5.5.0",
        "ext-phalcon": ">=3.0.0",
        "swiftmailer/swiftmailer": "^5.4",
        "amazonwebservices/aws-sdk-for-php": "~1.0"
    }
}
```

Ahora, hay un archivo llamado `app/config/loader.php` donde se configura toda la carga automática. Al final de este archivo se puede ver que el autocargador de composer es incluido, permitiendo a la aplicación cargar automáticamente cualquiera de las clases en las dependencias descargadas:

```php
<?php

// ...

// Utilice el autocargador de composer para cargar todas las dependencias
require_once BASE_PATH . '/vendor/autoload.php';
```

Por otra parte, Vökuró, a diferencia del INVO, utiliza espacios de nombres para controladores y modelos, que es la práctica recomendada para estructurar un proyecto. De esta manera el autocargador se ve ligeramente diferente al que vimos antes (`app/config/loader.php`):

```php
<?php

use Phalcon\Loader;

$loader = new Loader();

$loader->registerNamespaces(
    [
        'Vokuro\Models'      => $config->application->modelsDir,
        'Vokuro\Controllers' => $config->application->controllersDir,
        'Vokuro\Forms'       => $config->application->formsDir,
        'Vokuro'             => $config->application->libraryDir,
    ]
);

$loader->register();

// ...
```

En lugar de utilizar `registerDirectories()`, utilizamos `registerNamespaces()`. Cada espacio de nombres apunta a un directorio definido en el archivo de configuración (app/config/config.php). Por ejemplo el espacio de nombres `Vokuro\Controllers` apunta a `app/controllers` para que todas las clases requeridas por la aplicación dentro de este espacio de nombres lo requieren en su definición:

```php
<?php

namespace Vokuro\Controllers;

class AboutController extends ControllerBase
{
    // ...
}
```

<a name='sign-up'></a>

## Registrarse

En primer lugar, vamos a ver cómo los usuarios están registrados en Vökuró. Cuando un usuario hace clic en el botón `crear una cuenta`, el controlador `SessionController` se invoca y la acción `signup` se ejecuta:

```php
<?php

namespace Vokuro\Controllers;

use Vokuro\Forms\SignUpForm;

class SessionController extends ControllerBase
{
    public function signupAction()
    {
        $form = new SignUpForm();

        // ...

        $this->view->form = $form;
    }
}
```

Esta acción simplemente pasa una instancia del formulario `SignUpForm` a la vista, que se procesa para que el usuario introduzca los datos de inicio de sesión:

```twig
{{ form('class': 'form-search') }}

    <h2>
        Regístrate
    </h2>

    <p>{{ form.label('name') }}</p>
    <p>
        {{ form.render('name') }}
        {{ form.messages('name') }}
    </p>

    <p>{{ form.label('email') }}</p>
    <p>
        {{ form.render('email') }}
        {{ form.messages('email') }}
    </p>

    <p>{{ form.label('password') }}</p>
    <p>
        {{ form.render('password') }}
        {{ form.messages('password') }}
    </p>

    <p>{{ form.label('confirmPassword') }}</p>
    <p>
        {{ form.render('confirmPassword') }}
        {{ form.messages('confirmPassword') }}
    </p>

    <p>
        {{ form.render('terms') }} {{ form.label('terms') }}
        {{ form.messages('terms') }}
    </p>

    <p>{{ form.render('Sign Up') }}</p>

    {{ form.render('csrf', ['value': security.getToken()]) }}
    {{ form.messages('csrf') }}

    <hr>

{{ endForm() }}
```