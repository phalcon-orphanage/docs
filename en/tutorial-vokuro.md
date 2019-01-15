---
layout: article
language: 'en'
version: '4.0'
---
##### This article reflects v3.4 and has not yet been revised
{:.alert .alert-danger}

<a name='overview'></a>
# Tutorial: Vökuró
Vökuró is another sample application you can use to learn more about Phalcon. Vökuró is a small website that shows how to implement a security features and management of users and permissions. You can clone its code from [Github](https://github.com/phalcon/vokuro).

<a name='structure'></a>
## Project Structure
Once you clone the project in your document root you'll see the following structure:

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

This project follows a quite similar structure to INVO. Once you open the application in your browser `https://localhost/vokuro` you'll see something like this:

![](/assets/images/content/tutorial-vokuro-1.png)

The application is divided into two parts, a frontend, where visitors can sign up the service and a backend where administrative users can manage registered users. Both frontend and backend are combined in a single module.

<a name='dependencies'></a>
## Load Classes and Dependencies
This project uses [Phalcon\Loader](api/Phalcon_Loader) to load controllers, models, forms, etc. within the project and [composer](https://getcomposer.org/) to load the project's dependencies. So, the first thing you have to do before execute Vökuró is install its dependencies via [composer](https://getcomposer.org/). Assuming you have it correctly installed, type the following command in the console:

```bash
cd vokuro
composer install
```

Vökuró sends emails to confirm the sign up of registered users using Swift, the `composer.json` looks like:

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

Now, there is a file called `app/config/loader.php` where all the auto-loading stuff is set up. At the end of this file you can see that the composer autoloader is included enabling the application to autoload any of the classes in the downloaded dependencies:

```php
<?php

// ...

// Use composer autoloader to load vendor classes
require_once BASE_PATH . '/vendor/autoload.php';
```

Moreover, Vökuró, unlike the INVO, utilizes namespaces for controllers and models which is the recommended practice to structure a project. This way the autoloader looks slightly different than the one we saw before (`app/config/loader.php`):

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

Instead of using `registerDirectories()`, we use `registerNamespaces()`. Every namespace points to a directory defined in the configuration file (app/config/config.php). For instance the namespace `Vokuro\Controllers` points to `app/controllers` so all the classes required by the application within this namespace requires it in its definition:

```php
<?php

namespace Vokuro\Controllers;

class AboutController extends ControllerBase
{
    // ...
}
```

<a name='sign-up'></a>
## Sign Up
First, let's check how users are registered in Vökuró. When a user clicks the `Create an Account` button, the controller SessionController is invoked and the action `signup` is executed:

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

This action simply pass a form instance of `SignUpForm` to the view, which itself is rendered to allow the user enter the login details:

```twig
{% raw %}
{{ form('class': 'form-search') }}

    <h2>
        Sign Up
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
{% endraw %}
```
