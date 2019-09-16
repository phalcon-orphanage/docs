---
layout: default
language: 'id-id'
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

There are some prerequisites for the Vökuró to run. You will need to have PHP >= 7.2 installed on your machine and the following extensions: - ctype - curl - dom - json - iconv - igbinary - mbstring - memcached - opcache - openssl - pdo - pdo_mysql - psr - session - simplexml - tokenizer - xml - xmlwriter - zip

Phalcon needs to be installed. Head over to the <installation> page if you need help with installing Phalcon. Note that Phalcon v4 requires the PSR extension to be installed and loaded **before** Phalcon. To install PSR you can check the [php-psr](https://github.com/jbboehr/php-psr) GitHub page.

Finally, you will also need to ensure that you have updated the composer packages (see section below).

### Run

If all the above requirements are satisfied, you can run the application using PHP's built in web server by issuing the following command on a terminal:

```bash
php -S localhost:8080 -t public/
```

The above command will start serving the site for `localhost` at the port `8080`. You can change those settings to suit your needs. Alternatively you can set up your site in Apache or nginX using a virtual host. Please consult the relevant documentation on how to set up a virtual host for these web servers.

### Docker

In the `resources` folder you will find a `Dockerfile` which allows you to quickly set up the environment and run the application.

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

The available options are:

| Option               | Description                                                                                                                                                             |
| -------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `APP_CRYPT_SALT`     | Random and long string that is used by the [Phalcon\Crypt](crypt) component to produce passwords and any additional security features                                  |
| `APP_BASE_URI`       | Usually `/` if your web server points directly to the Vökuró directory. If you have installed Vökuró in a sub directory, you can adjust the base URI                    |
| `APP_PUBLIC_URL`     | The public URL of the application. This is used for the emails.                                                                                                         |
| `DB_ADAPTER`         | The database adapter. The available adapters are: `mysql`, `pgsql`, `sqlite`. Please ensure that the relevant extensions for the database are installed in your system. |
| `DB_HOST`            | The database host                                                                                                                                                       |
| `DB_PORT`            | The database port                                                                                                                                                       |
| `DB_USERNAME`        | The database username                                                                                                                                                   |
| `DB_PASSWORD`        | The database password                                                                                                                                                   |
| `DB_NAME`            | The database name                                                                                                                                                       |
| `MAIL_FROM_NAME`     | The FROM name when sending emails                                                                                                                                       |
| `MAIL_FROM_EMAIL`    | The FROM email when sending emails                                                                                                                                      |
| `MAIL_SMTP_SERVER`   | The SMTP server                                                                                                                                                         |
| `MAIL_SMTP_PORT`     | The SMTP port                                                                                                                                                           |
| `MAIL_SMTP_SECURITY` | The SMTP security (e.g. `tls`)                                                                                                                                          |
| `MAIL_SMTP_USERNAME` | The SMTP username                                                                                                                                                       |
| `MAIL_SMTP_PASSWORD` | The SMTP password                                                                                                                                                       |
| `CODECEPTION_URL`    | The Codeception server for tests. If you run the tests locally this should be `127.0.0.1`                                                                               |
| `CODECEPTION_PORT`   | The Codeception port                                                                                                                                                    |

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

### `config.php`

This file holds all configuration parameters that Vökuró needs. Usually you will not need to change this file, since the elements of the array are set by the `.env` file and [Dotenv](https://github.com/vlucas/phpdotenv). However, you might want to change the location of your logs or other paths, should you decide to change the directory structure.

One of the elements you might want to consider when working with Vökuró on your local machine is the `useMail` and set it to `false`. This will instruct Vökuró not to try to connect to a mail server and send an email when a user registers on the site.

### `providers.php`

This file contains all the providers that Vökuró needs. This is a list of classes in the application, that registers the particular class in the DI container. If you need to register new components to your DI container, you can add them to the array of this file.

### `routes.php`

This file contains the routes that Vökuró understands. The router already registers the default routes, so any routes defined in `routes.php` are specific ones. You can add any non standard routes you need, when customizing Vökuró, in this file. As a reminder, the default routes are:

```bash
/:controller/:action/:parameters
```

### Providers

As mentioned above, Vökuró uses classes called Providers in order to register services in the DI container. This is just one way to register services in the DI container, nothing stops you from putting all these registrations in a single file.

For Vökuró we decided to use one file per service as well as a `providers.php` (see above) as the registration configuration array for these services. This allows us to have much smaller chunks of code, organized in a separate file per service, as well as an array that allows us to register or unregister/disable a service without removing files. All we need to do is change the `providers.php` array.

The provider classes are located in `src/Providers`. Each of the provider classes implements the [Phalcon\Di\ServiceProviderInterface](api/Phalcon_Di#di-serviceproviderinterface) interface. For more information, see the bootstrapping section below.

## Composer

[Vökuró](https://github.com/phalcon/vokuro) uses [composer](https://getcomposer.org) to download and install supplemental PHP libraries. The libraries used are:

- [Dotenv](https://github.com/vlucas/phpdotenv)
- [Phinx](https://github.com/cakephp/phinx)
- [Swift Mailer](https://swiftmailer.symfony.com)

Looking at `composer.json` the required packages are:

```json
"require": {
    "php": ">=7.2",
    "ext-openssl": "*",
    "ext-phalcon": "~4.0.0-beta.2",
    "robmorgan/phinx": "^0.11.1",
    "swiftmailer/swiftmailer": "^5.4",
    "vlucas/phpdotenv": "^3.4"
}
```

If this is a fresh installation you can run

```bash
composer install
```

of if you want to upgrade the existing installations of the above packages:

```bash
composer update
```

For more information about composer, you can visit their [documentation](https://getcomposer.org) page.

## Bootstrapping

### Entry

The entry point of our application is `public/index.php`. This file contains the necessary code that bootstraps the application and runs it. It also serves as a single point of entry to our application, making things much easier for us when we want to trap errors, protect files etc.

Let's look at the code:

```php
<?php

use Vokuro\Application as VokuroApplication;

error_reporting(E_ALL);
$rootPath = dirname(__DIR__);

try {
    require_once $rootPath . '/vendor/autoload.php';

    /**
     * Load .env configurations
     */
    Dotenv\Dotenv::create($rootPath)->load();

    /**
     * Run Vökuró!
     */
    echo (new VokuroApplication($rootPath))->run();
} catch (Exception $e) {
    echo $e->getMessage(), '<br>';
    echo nl2br(htmlentities($e->getTraceAsString()));
}
```

First of all we ensure that we have full error reporting. You can of course change this if you wish, or rework the code where error reporting is controlled by an entry in your `.env` file.

A `try`/`catch` block wraps all operations. This ensures that all errors are caught and displayed on screen.

> **NOTE** You will need to rework the code to enhance security. Currently, if an error happens with the database, the `catch` code will echo on screen the database credentials with the exception. This code is intended as a tutorial not a full scale production application
{: .alert .alert-danger }

We ensure that we have access to all the supporting libraries by loading composer's autoloader. In the `composer.json` we have also defined the `autoload` entry, directing the autoloader to load any `Vokuro` namespaced classes from the `src` folder.

```json
"autoload": {
    "psr-4": {
        "Vokuro\\": "app/"
    },
    "files": [
        "app/Helpers.php"
    ]
}
```

Then we load the environment variables as defined in our `.env` file by calling the

```php
Dotenv\Dotenv::create($rootPath)->load();
```

Finally, we run our application.

### Application

All the application logic is wrapped in the `Vokuro\Application` class. Let's see how this is done:

```php
<?php
declare(strict_types=1);

namespace Vokuro;

use Exception;
use Phalcon\Application\AbstractApplication;
use Phalcon\Di\DiInterface;
use Phalcon\Di\FactoryDefault;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Mvc\Application as MvcApplication;

/**
 * Vökuró Application
 */
class Application
{
    const APPLICATION_PROVIDER = 'bootstrap';

    /**
     * @var AbstractApplication
     */
    protected $app;

    /**
     * @var DiInterface
     */
    protected $di;

    /**
     * Project root path
     *
     * @var string
     */
    protected $rootPath;

    /**
     * @param string $rootPath
     *
     * @throws Exception
     */
    public function __construct(string $rootPath)
    {
        $this->di       = new FactoryDefault();
        $this->app      = $this->createApplication();
        $this->rootPath = $rootPath;

        $this->di->setShared(self::APPLICATION_PROVIDER, $this);

        $this->initializeProviders();
    }

    /**
     * Run Vökuró Application
     *
     * @return string
     * @throws Exception
     */
    public function run(): string
    {
        return (string) $this
            ->app
            ->handle($_SERVER['REQUEST_URI'])
            ->getContent()
        ;
    }

    /**
     * Get Project root path
     *
     * @return string
     */
    public function getRootPath(): string
    {
        return $this->rootPath;
    }

    /**
     * @return AbstractApplication
     */
    protected function createApplication(): AbstractApplication
    {
        return new MvcApplication($this->di);
    }

    /**
     * @throws Exception
     */
    protected function initializeProviders(): void
    {
        $filename = $this->rootPath 
                 . '/configs/providers.php';
        if (!file_exists($filename) || !is_readable($filename)) {
            throw new Exception(
                'File providers.php does not exist or is not readable.'
            );
        }

        $providers = include_once $filename;
        foreach ($providers as $providerClass) {
            /** @var ServiceProviderInterface $provider */
            $provider = new $providerClass;
            $provider->register($this->di);
        }
    }
}

```

The constructor of the class first creates a new DI container and store it in a local property. We are using the [Phalcon\Di\FactoryDefault](di) one, which has a lot of services already registered for us.

We then create a new [Phalcon\Mvc\Application](application) and store it in a property also. We also store the root path because it is useful throughout the application.

We then register this class (the `Vokuro\Application`) in the Di container using the name `bootstrap`. This allows us to have access to this class from any part of our application through the Di container.

The last thing we do is to register all the providers. Although the [Phalcon\Di\FactoryDefault](di) object has a lot of services already registered for us, we still need to register providers that suit the needs of our application. As mentioned above, each provider class implements the [Phalcon\Di\ServiceProviderInterface](api/Phalcon_Di#di-serviceproviderinterface) interface, so we can load each class and call the `register()` method with the Di container to register each service. We therefore first load the configuration array `config/providers.php` and then loop through the entries and register each provider in turn.

The available providers are:

| Provider                 | Description                                       |
| ------------------------ | ------------------------------------------------- |
| `AclProvider`            | Permissons                                        |
| `AuthProvider`           | Authentication                                    |
| `ConfigProvider`         | Configuration values                              |
| `CryptProvider`          | Encryption                                        |
| `DbProvider`             | Database access                                   |
| `DispatcherProvider`     | Dispatcher - what controller to call for what URL |
| `FlashProvider`          | Flash messages for feedback to the user           |
| `LoggerProvider`         | Logger for errors and other information           |
| `MailProvider`           | Mail support                                      |
| `ModelsMetadataProvider` | Metadata for models                               |
| `RouterProvider`         | Routes                                            |
| `SecurityProvider`       | Security                                          |
| `SessionBagProvider`     | Session data                                      |
| `SessionProvider`        | Session data                                      |
| `UrlProvider`            | URL handling                                      |
| `ViewProvider`           | Views and view engine                             |

`run()` will now handle the `REQUEST_URI`, handle it and return the content back. Internally the application will calculate the route based on the request, and dispatch the relevant controller and view before returning the result of this operation back to the user as a response.

## Database

## Models

## Controllers

## Views

## Components

### Acl

### Auth

### Mail

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