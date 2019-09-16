---
layout: default
language: 'fa-ir'
version: '4.0'
title: 'Tutorial - Vökuró'
---

# Tutorial - Vökuró

* * *

![](/assets/images/document-status-under-review-red.svg)

## Vökuró

[Vökuró](https://github.com/phalcon/vokuro) is a sammple application, showcasing a typical web application written in Phalcon. This application focuses on: - User Login (security) - User Signup (security) - User Permissions - User management

> You can use Vökuró as a starting point for your application and enhance it further to meet your needs. By no means this is a perfect application and it does not fit all needs.
{: .alert .alert-info }

> 
> This tutorial assumes that you are familiar with the concepts of the Model View Controller design pattern.
{: .alert .alert-warning }

## Installation

### Downloading

In order to install the application, you can either clone or download it from [GitHub](https://github.com/phalcon/vokuro). You can visit the GitHub page, download the application and then unzip it to a directory on your machine. Alternatively you can use `git clone`:

```bash
git clone https://github.com/phalcon/vokuro
```

### Extensions

There are some prerequisites for the Vökuró to run. You will need to have PHP >= 7.2 installed on your machine and the following extensions: - ctype - curl - dom - json - iconv - igbinary - mbstring - memcached - opcache - pdo - pdo_mysql - psr - session - simplexml - tokenizer - xml - xmlwriter - zip

Finally you will need to have Phalcon v4 installed. Head over to the <installation> if you need help with installing Phalcon. Note that Phalcon v4 requires the PSR extension to be installed and loaded **before** Phalcon. To install PSR you can check the [php-psr](https://github.com/jbboehr/php-psr) GitHub page.

### Docker

In the `resopurces` folder you will find a `Dockerfile` which allows you to quickly set up the environment and run the application.

**add how**

### Nanobox

In the `resources` folder you will also find a `boxfile.yml` file that allows you to use nanobox in order to set up the environment quickly. All you have to do is copy the file to the root of your directory and run `nanobox run php-server`. Once the application is set up for the first time, you will be able to navigate to the IP address presented on screen and work with the application.

For more information on how to set up nanobox, check our \[Environments Nanobox\]\[environments-nanobox\] page as well as the [Nanobox Guides](https://guides.nanobox.io/php/) page

> In this tutorial, we assume that your application has been downloaded or cloned in a directory called `vokuro`.
{: .alert .alert-info }

## Structure

Looking at the structure of the application we have the following:

```bash
vokuro/
    .ci
    configs
    db
        migrations
        seeds
    public
    resources
    src
        Controllers
        Forms
        Models
        Phalcon
        Plugins
        Providers
    tests
    themes
        vokuro
    var
        cache
            acl
            metaData
            session
            volt
        logs
    vendor
```

| Directory         | Description                                           |
| ----------------- | ----------------------------------------------------- |
| `.ci`             | Files necessary for setting services for the CI       |
| `configs`         | Configuration files                                   |
| `db`              | Holds the migrations for the databsae                 |
| `public`          | Entry point for the application, css, js, images      |
| `resources`       | Docker/nanobox files for setting the application      |
| `src`             | Where the application lives (controllers, forms etc.) |
| `src/Controllers` | Controllers                                           |
| `src/Forms`       | Forms                                                 |
| `src/Models`      | Database Models                                       |
| `src/Plugins`     | Plugins                                               |
| `src/Providers`   | Providers: setting services in the DI container       |
| `tests`           | Tests                                                 |
| `themes`          | Themes/views for easy customization                   |
| `themes/vokuro`   | Default theme for the application                     |
| `var`             | Various supporting files                              |
| `var/cache`       | Cache files                                           |
| `var/logs`        | Logs                                                  |
| `vendor`          | Vendor/composer based libraries                       |

## Configuration

### `.env`

[Vökuró](https://github.com/phalcon/vokuro) uses the popular [Dotenv](https://github.com/vlucas/phpdotenv) library by Vance Lucas. The library utilizes a `.env` file located in your root folder, which holds configuration parameters such as the database server host, username, password etc. There is a `.env.example` file that comes with Vökuró that you can copy and rename to `.env` and then edit it to match your environment. You need to do this first so that your application can run properly.

Once the configuration file is in place, visiting the IP address will present a screen similar to this:

![](/assets/images/content/tutorial-vokuro-1.png)

### `Database`

You also need to initialize the database. [Vökuró](https://github.com/phalcon/vokuro) uses the popular library [Phinx](https://github.com/cakephp/phinx) by Rob Morgan (now the Cake Foundation). The library uses its own configuration file (`phinx.php`), but for Vökuró you don't need to adjust any settings since `phinx.php` reads the `.env` file to retrieve the configuration settings. This allows you to set your configuration parameters in one place.

We will now need to run the migrations. To check the status of our database:

```bash
/app $ ./vendor/bin/phinx status
```

You will see the following screen:

![](/assets/images/content/tutorial-vokuro-2.png)

To initialize the database we need to run the migrations:

```bash
/app $ ./vendor/bin/phinx migrate
```

The screen will show the operation:

![](/assets/images/content/tutorial-vokuro-3.png)

And the `status` command will now show all green:

![](/assets/images/content/tutorial-vokuro-4.png)

### `acl.php`

Looking at the `config/` folder, you will notice four files. There is no need for you to change these files to start the application but if you wish to customize it, this is the place to visit. The `acl.php` file returns an array of *routes* that controls which routes are visible to only logged in users.

The current setup will require a user to be logged in, if they visit these routes:

- `users/index`
- `users/search`
- `users/edit`
- `users/create`
- `users/delete`
- `users/changePassword`
- `profiles/index`
- `profiles/search`
- `profiles/edit`
- `profiles/create`
- `profiles/delete`
- `permissions/index`

If you use Vökuró as a starting point for your own application, you will need to modify this file to add or remove routes so as to ensure that your protected routes are behind the login mechanism.

> Keeping the private routes in an array is efficient and easy to maintain for a small to medium application. Once your application starts growing, you might need to consider a different technique to keep your private routes such as the database with a caching mechanism.
{: .alert .alert-info }

### Providers

## Composer

## Database

## Models

## Controllers

## Views

## Components

### Acl

### Auth

### Mail

## Load Classes and Dependencies

This project uses [Phalcon\Loader](api/Phalcon_Loader) to load controllers, models, forms, etc. within the project and [composer](https://getcomposer.org) to load the project's dependencies. So, the first thing you have to do before execute Vökuró is install its dependencies via [composer](https://getcomposer.org). Assuming you have it correctly installed, type the following command in the console:

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