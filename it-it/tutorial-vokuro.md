---
layout: default
language: 'it-it'
version: '4.0'
title: 'Tutorial - Vökuró'
keywords: 'tutorial, vokuro tutorial, step by step, mvc, security, permissions'
---

# Tutorial - Vökuró

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg) ![](/assets/images/level-intermediate.svg)

## Vökuró

[Vökuró](https://github.com/phalcon/vokuro) is a sample application, showcasing a typical web application written in Phalcon. This application focuses on: - User Login (security) - User Signup (security) - User Permissions - User management

> **NOTE**: You can use Vökuró as a starting point for your application and enhance it further to meet your needs. By no means this is a perfect application and it does not fit all needs.
{: .alert .alert-info }

> 
> **NOTE**: This tutorial assumes that you are familiar with the concepts of the Model View Controller design pattern. (see References at the end of this tutorial)
{: .alert .alert-warning }

> 
> **NOTE**: Note the code below has been formatted to increase readability
{: .alert .alert-warning }

## Installation

### Downloading

In order to install the application, you can either clone or download it from [GitHub](https://github.com/phalcon/vokuro). You can visit the GitHub page, download the application and then unzip it to a directory on your machine. Alternatively you can use `git clone`:

```bash
git clone https://github.com/phalcon/vokuro
```

### Extensions

There are some prerequisites for the Vökuró to run. You will need to have PHP >= 7.2 installed on your machine and the following extensions: - ctype - curl - dom - json - iconv - mbstring - memcached - opcache - openssl - pdo - pdo_mysql - psr - session - simplexml - xml - xmlwriter

Phalcon needs to be installed. Head over to the <installation> page if you need help with installing Phalcon. Note that Phalcon v4 requires the PSR extension to be installed and loaded **before** Phalcon. To install PSR you can check the [php-psr](https://github.com/jbboehr/php-psr) GitHub page.

Finally, you will also need to ensure that you have updated the composer packages (see section below).

### Run

If all the above requirements are satisfied, you can run the application using PHP's built-in web server by issuing the following command on a terminal:

```bash
php -S localhost:8080 -t public/ .htrouter.php
```

The above command will start serving the site for `localhost` at the port `8080`. You can change those settings to suit your needs. Alternatively you can set up your site in Apache or nginX using a virtual host. Please consult the relevant documentation on how to set up a virtual host for these web servers.

### Docker

In the `resources` folder you will find a `Dockerfile` which allows you to quickly set up the environment and run the application. To use the `Dockerfile` we need to decide the name of our dockerized application. For the purposes of this tutorial, we will use `phalcon-tutorial-vokuro`.

From the root of the application we need to compile the project (you only need to do this once):

```bash
$ docker build -t phalcon-tutorial-vokuro -f resources/Dockerfile .
```

and then run it

```bash
$ docker run -it --rm phalcon-tutorial-vokuro bash
```

This will enter us in the dockerized environment. To check the PHP version:

```bash
root@c7b43060b115:/code $ php -v

PHP 7.3.9 (cli) (built: Sep 12 2019 10:08:33) ( NTS )
Copyright (c) 1997-2018 The PHP Group
Zend Engine v3.3.9, Copyright (c) 1998-2018 Zend Technologies
    with Zend OPcache v7.3.9, Copyright (c) 1999-2018, by Zend Technologies
```

and Phalcon:

```bash
root@c7b43060b115:/code $ php -r 'echo Phalcon\Version::get();'

4.0.0
```

You now have a dockerized environment with all the necessary components to run Vökuró.

### Nanobox

In the `resources` folder you will also find a `boxfile.yml` file that allows you to use nanobox in order to set up the environment quickly. All you have to do is copy the file to the root of your directory and run `nanobox run php-server`. Once the application is set up for the first time, you will be able to navigate to the IP address presented on screen and work with the application.

For more information on how to set up nanobox, check our \[Environments Nanobox\]\[environments-nanobox\] page as well as the [Nanobox Guides](https://guides.nanobox.io/php/) page

> **NOTE**: In this tutorial, we assume that your application has been downloaded or cloned in a directory called `vokuro`.
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
| `db`              | Holds the migrations for the database                 |
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

### Config

**acl.php**

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

> **NOTE**: Keeping the private routes in an array is efficient and easy to maintain for a small to medium application. Once your application starts growing, you might need to consider a different technique to keep your private routes such as the database with a caching mechanism.
{: .alert .alert-info }

**config.php**

This file holds all configuration parameters that Vökuró needs. Usually you will not need to change this file, since the elements of the array are set by the `.env` file and [Dotenv](https://github.com/vlucas/phpdotenv). However, you might want to change the location of your logs or other paths, should you decide to change the directory structure.

One of the elements you might want to consider when working with Vökuró on your local machine is the `useMail` and set it to `false`. This will instruct Vökuró not to try to connect to a mail server and send an email when a user registers on the site.

**providers.php**

This file contains all the providers that Vökuró needs. This is a list of classes in the application, that registers the particular class in the DI container. If you need to register new components to your DI container, you can add them to the array of this file.

**routes.php**

This file contains the routes that Vökuró understands. The router already registers the default routes, so any routes defined in `routes.php` are specific ones. You can add any non standard routes you need, when customizing Vökuró, in this file. As a reminder, the default routes are:

```bash
/:controller/:action/:parameters
```

### Providers

As mentioned above, Vökuró uses classes called Providers in order to register services in the DI container. This is just one way to register services in the DI container, nothing stops you from putting all these registrations in a single file.

For Vökuró we decided to use one file per service as well as a `providers.php` (see above) as the registration configuration array for these services. This allows us to have much smaller chunks of code, organized in a separate file per service, as well as an array that allows us to register or unregister/disable a service without removing files. All we need to do is change the `providers.php` array.

The provider classes are located in `src/Providers`. Each of the provider classes implements the [Phalcon\Di\ServiceProviderInterface](api/phalcon_di#di-serviceproviderinterface) interface. For more information, see the bootstrapping section below.

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

The last thing we do is to register all the providers. Although the [Phalcon\Di\FactoryDefault](di) object has a lot of services already registered for us, we still need to register providers that suit the needs of our application. As mentioned above, each provider class implements the [Phalcon\Di\ServiceProviderInterface](api/phalcon_di#di-serviceproviderinterface) interface, so we can load each class and call the `register()` method with the Di container to register each service. We therefore first load the configuration array `config/providers.php` and then loop through the entries and register each provider in turn.

The available providers are:

| Provider                 | Description                                       |
| ------------------------ | ------------------------------------------------- |
| `AclProvider`            | Permissions                                       |
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

As mentioned above, Vökuró can be installed with MariaDB/MySQL/Aurora, PostgreSql or SQLite as the database store. For the purposes of this tutorial, we are using MariaDB. The tables that the application uses are:

| Table                 | Description                             |
| --------------------- | --------------------------------------- |
| `email_confirmations` | Email confirmations for registration    |
| `failed_logins`       | Failed login attempts                   |
| `password_changes`    | When a password was changed and by whom |
| `permissions`         | Permission matrix                       |
| `phinxlog`            | Phinx migration table                   |
| `profiles`            | Profile for each user                   |
| `remember_tokens`     | *Remember Me* functionality tokens      |
| `reset_passwords`     | Reset password tokens table             |
| `success_logins`      | Successful login attempts               |
| `users`               | Users                                   |

## Models

Following the [Model-View-Controller](https://en.wikipedia.org/wiki/Model–view–controller) pattern, Vökuró has one model per database table (excluding the `phinxlog`). The models allow us to interact with the database tables in an easy object oriented manner. The models are located in the `/src/Models` directory, and each model defines the relevant fields, source table as well as any relationships between the model and others. Some models also implement validation rules to ensure that data is stored properly in the database.

```php
<?php
declare(strict_types=1);

namespace Vokuro\Models;

use Phalcon\Mvc\Model;

/**
 * SuccessLogins
 *
 * This model registers successfully logins registered users have made
 */
class SuccessLogins extends Model
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var integer
     */
    public $usersId;

    /**
     * @var string
     */
    public $ipAddress;

    /**
     * @var string
     */
    public $userAgent;

    public function initialize()
    {
        $this->belongsTo(
            'usersId', 
            Users::class, 
            'id', 
            [
                'alias' => 'user',
            ]
        );
    }
}
```

In the model above, we have defined all the fields of the table as public properties for easy access:

```php
echo $successLogin->ipAddress;
```

> **NOTE**: If you notice, the property names map exactly the case (upper/lower) of the field names in the relevant table.
{: .alert .alert-warning }

In the `initialize()` method, we also define a relationship between this model and the `Users` model. We assign the fields (local/remote) as well as an `alias` for this relationship. We can therefore access the user related to a record of this model as follows:

```php
echo $successLogin->user->name;
```

> **NOTE**: Feel free to open each model file and identify the relationships between the models. Check our documentation for the difference between various types of relationships
{: .alert .alert-info }

## Controllers

Again following the [Model-View-Controller](https://en.wikipedia.org/wiki/Model–view–controller) pattern, Vökuró has one controller to handle a specific *parent* route. This means that the `AboutController` handles the `/about` route. All controllers are located in the `/src/Cotnrollers` directory.

The default controller is `IndexController`. All controller classes have the suffix `Controller`. Each controller has methods suffixed with `Action` and the default action is `indexAction`. Therefore if you visit the site with just the URL, the `IndexController` will be called and the `indexAction` will be executed.

After that, unless you have registered specific routes, the default routes (automatically registered) will try to match:

```bash
/profiles/search
```

to

```bash
/src/Controllers/SearchController.php -> searchAction
```

The available controllers, actions and routes for Vökuró are:

| Controller    | Action           | Route                     | Description                                 |
| ------------- | ---------------- | ------------------------- | ------------------------------------------- |
| `About`       | `index`          | `/about`                  | Shows the `about` page                      |
| `Index`       | `index`          | `/`                       | Default action - home page                  |
| `Permissions` | `index`          | `/permissions`            | View/change permissions for a profile level |
| `Privacy`     | `index`          | `/privacy`                | View the privacy page                       |
| `Profiles`    | `index`          | `/profiles`               | View profiles default page                  |
| `Profiles`    | `create`         | `/profiles/create`        | Create profile                              |
| `Profiles`    | `delete`         | `/profiles/delete`        | Delete profile                              |
| `Profiles`    | `edit`           | `/profiles/edit`          | Edit profile                                |
| `Profiles`    | `search`         | `/profiles/search`        | Search profiles                             |
| `Session`     | `index`          | `/session`                | Session default action                      |
| `Session`     | `forgotPassword` | `/session/forgotPassword` | Forget password                             |
| `Session`     | `login`          | `/session/login`          | Login                                       |
| `Session`     | `logout`         | `/session/logout`         | Logout                                      |
| `Session`     | `signup`         | `/session/signup`         | Signup                                      |
| `Terms`       | `index`          | `/terms`                  | View the terms page                         |
| `UserControl` | `confirmEmail`   | `/confirm`                | Confirm email                               |
| `UserControl` | `resetPassword`  | `/reset-password`         | Reset password                              |
| `Users`       | `index`          | `/users`                  | Users default screen                        |
| `Users`       | `changePassword` | `/users/changePassword`   | Change user password                        |
| `Users`       | `create`         | `/users/create`           | Create user                                 |
| `Users`       | `delete`         | `/users/delete`           | Delete user                                 |
| `Users`       | `edit`           | `/users/edit`             | Edit user                                   |

## Views

The last element of the [Model-View-Controller](https://en.wikipedia.org/wiki/Model–view–controller) pattern is the views. Vökuró uses [Volt](volt) as the view engine for its views.

> **NOTE**: Generally, one would expect to see a `views` folder under the `/src` folder. Vökuró uses a slightly different approach, storing all the view files under `/themes/vokuro`. 
{: .alert .alert-info }

The views directory contains directories that map to each controller. Inside each of those directories, `.volt` files are mapped to each action. So for example the route:

```bash
/profiles/create
```

maps to:

```bash
ProfilesController -> createAction
```

and the view is located:

```bash
/themes/vokuro/profiles/create.volt
```

The available views are:

| Controller    | Action           | View                           | Description                                 |
| ------------- | ---------------- | ------------------------------ | ------------------------------------------- |
| `About`       | `index`          | `/about/index.volt`            | Shows the `about` page                      |
| `Index`       | `index`          | `/index/index.volt`            | Default action - home page                  |
| `Permissions` | `index`          | `/permissions/index.volt`      | View/change permissions for a profile level |
| `Privacy`     | `index`          | `/privacy/index.volt`          | View the privacy page                       |
| `Profiles`    | `index`          | `/profiles/index.volt`         | View profiles default page                  |
| `Profiles`    | `create`         | `/profiles/create.volt`        | Create profile                              |
| `Profiles`    | `delete`         | `/profiles/delete.volt`        | Delete profile                              |
| `Profiles`    | `edit`           | `/profiles/edit.volt`          | Edit profile                                |
| `Profiles`    | `search`         | `/profiles/search.volt`        | Search profiles                             |
| `Session`     | `index`          | `/session/index.volt`          | Session default action                      |
| `Session`     | `forgotPassword` | `/session/forgotPassword.volt` | Forget password                             |
| `Session`     | `login`          | `/session/login.volt`          | Login                                       |
| `Session`     | `logout`         | `/session/logout.volt`         | Logout                                      |
| `Session`     | `signup`         | `/session/signup.volt`         | Signup                                      |
| `Terms`       | `index`          | `/terms/index.volt`            | View the terms page                         |
| `Users`       | `index`          | `/users/index.volt`            | Users default screen                        |
| `Users`       | `changePassword` | `/users/changePassword.volt`   | Change user password                        |
| `Users`       | `create`         | `/users/create.volt`           | Create user                                 |
| `Users`       | `delete`         | `/users/delete.volt`           | Delete user                                 |
| `Users`       | `edit`           | `/users/edit.volt`             | Edit user                                   |

The `/index.volt` file contains the main layout of the page, including stylesheets, javascript references etc. The `/layouts` directory contains different layouts that are used in the application, for instance a `public` one if the user is not logged in, and a `private` one for logged in users. The individual views are injected into the layouts and construct the final page.

## Components

There are several components that we use in Vökuró, offering functionality throughout the application. All these components are located in the `/src/Plugins` directory.

### Acl

`Vokuro\Plugins\Acl\Acl` is a component that implements an [Access Control List](https://en.wikipedia.org/wiki/Access-control_list) for our application. The ACL controls which user has access to which resources. You can read more about ACL in our [dedicated page](acl).

In this component, We define the resources that are considered *private*. These are held in an internal array with controller as the key and action as the value, and identify which controller/actions require authentication. It also holds human readable descriptions for actions used throughout the application.

The component exposes the following methods:

| Method                                      | Returns      | Description                                                     |
| ------------------------------------------- | ------------ | --------------------------------------------------------------- |
| `getActionDescription($action)`             | `string`     | Returns the action description according to its simplified name |
| `getAcl()`                                  | `ACL object` | Returns the ACL list                                            |
| `getPermissions(Profiles $profile)`         | `array`      | Returns the permissions assigned to a profile                   |
| `getResources()`                            | `array`      | Returns all the resources and their actions available           |
| `isAllowed($profile, $controller, $action)` | `bool`       | Checks if the current profile is allowed to access a resource   |
| `isPrivate($controllerName)`                | `bool`       | Checks if a controller is private or not                        |
| `rebuild()`                                 | `ACL object` | Rebuilds the access list into a file                            |

### Auth

`Vokuro\Plugins\Auth\Auth` is a component that manages authentication and offers identity management in Vökuró.

The component exposes the following methods:

| Method                                   | Description                                                                            |
| ---------------------------------------- | -------------------------------------------------------------------------------------- |
| `check($credentials)`                    | Checks the user credentials                                                            |
| `saveSuccessLogin($user)`                | Creates the remember me environment settings the related cookies and generating tokens |
| `registerUserThrottling($userId)`        | Implements login throttling. Reduces the effectiveness of brute force attacks          |
| `createRememberEnvironment(Users $user)` | Creates the remember me environment settings the related cookies and generating tokens |
| `hasRememberMe(): bool`                  | Check if the session has a remember me cookie                                          |
| `loginWithRememberMe(): Response`        | Logs on using the information in the cookies                                           |
| `checkUserFlags(Users $user)`            | Checks if the user is banned/inactive/suspended                                        |
| `getIdentity(): array / null`            | Returns the current identity                                                           |
| `getName(): string`                      | Returns the name of the user                                                           |
| `remove()`                               | Removes the user identity information from session                                     |
| `authUserById($id)`                      | Authenticates the user by his/her id                                                   |
| `getUser(): Users`                       | Get the entity related to user in the active identity                                  |
| `findFirstByToken($token): int / null`   | Returns the current token user                                                         |
| `deleteToken(int $userId)`               | Delete the current user token in session                                               |

### Mail

`Vokuro\Plugins\Mail\Mail` is a wrapper to [Swift Mailer](https://swiftmailer.symfony.com). It exposes two methods `send()` and `getTemplate()` which allow you to get a template from the views and populate it with data. The resulting HTML can then be used in the `send()` method along with the recipient and other parameters to send the email message.

> **NOTE**: Note that this component is used only if `useMail` is enabled in your `.env` file. You will also need to ensure that the SMTP server and credentials are valid.
{: .alert .alert-info } 

## Sign Up

### Controller

In order to access all the areas of Vökuró you need to have an account. Vökuró allows you to sign up to the site by clicking the `Create an Account` button.

What this will do is navigate you to the `/session/signup` URL, which in turn will call the `SessionController` and `signupAction`. Let's have a look what is going on in the `signupAction`:

```php
<?php
declare(strict_types=1);

namespace Vokuro\Controllers;

use Phalcon\Flash\Direct;
use Phalcon\Http\Request;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Security;
use Phalcon\Mvc\View;
use Vokuro\Forms\SignUpForm;
use Vokuro\Models\Users;

/**
 * @property Dispatcher $dispatcher
 * @property Direct     $flash
 * @property Request    $request
 * @property Security   $security
 * @property View       $view
 */
class SessionController extends ControllerBase
{
    /**
     * Allow a user to signup to the system
     */
    public function signupAction()
    {
        $form = new SignUpForm();

        // ....

        $this->view->setVar('form', $form);
    }
}
```

The workflow of the application is:

- Visit `/session/signup` 
    - Create form, send form to the view, render the form
- Submit data (not post) 
    - Form shows again, nothing else happens
- Submit data (post) 
    - Errors 
        - Form validators have errors, send the form to the view, render the form (errors will show)
    - No errors 
        - Data is sanitized
        - New Model created
        - Data saved in the database 
            - Error 
                - Show message on screen and refresh the form
            - Success 
                - Record saved
                - Show confirmation on screen
                - Send email (if applicable)

### Form

In order to have validation for user supplied data, we are utilizing the [Phalcon\Forms\Form](forms) and [Phalcon\Validation\*](validation) classes. These classes allow us to create HTML elements and attach validators to them. The form is then passed to the view, where the actual HTML elements are rendered on the screen.

When the user submits information, we send the posted data back to the form and the relevant validators validate the input and return any potential error messages.

> **NOTE**: All the forms for Vökuró are located in `/src/Forms`
{: .alert .alert-info }

First we create a `SignUpForm` object. In that object we define all the HTML elements we need with their respective validators:

```php
<?php
declare(strict_types=1);

namespace Vokuro\Forms;

use Phalcon\Forms\Element\Check;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\Confirmation;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Identical;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

class SignUpForm extends Form
{
    /**
     * @param string|null $entity
     * @param array       $options
     */
    public function initialize(
        string $entity = null, 
        array $options = []
    ) {
        $name = new Text('name');
        $name->setLabel('Name');
        $name->addValidators(
            [
                new PresenceOf(
                    [
                        'message' => 'The name is required',
                    ]
                ),
            ]
        );

        $this->add($name);

        // Email
        $email = new Text('email');
        $email->setLabel('E-Mail');
        $email->addValidators(
            [
                new PresenceOf(
                    [
                        'message' => 'The e-mail is required',
                    ]
                ),
                new Email(
                    [
                        'message' => 'The e-mail is not valid',
                    ]
                ),
            ]
        );

        $this->add($email);

        // Password
        $password = new Password('password');
        $password->setLabel('Password');
        $password->addValidators(
            [
                new PresenceOf(
                    [
                        'message' => 'The password is required',
                    ]
                ),
                new StringLength(
                    [
                        'min'            => 8,
                        'messageMinimum' => 'Password is too short. ' .
                                            'Minimum 8 characters',
                    ]
                ),
                new Confirmation(
                    [
                        'message' => "Password doesn't match " .
                                     "confirmation",
                        'with'    => 'confirmPassword',
                    ]
                ),
            ]
        );

        $this->add($password);

        // Confirm Password
        $confirmPassword = new Password('confirmPassword');
        $confirmPassword->setLabel('Confirm Password');
        $confirmPassword->addValidators(
            [
                new PresenceOf(
                    [
                        'message' => 'The confirmation password ' .
                                     'is required',
                    ]
                ),
            ]
        );

        $this->add($confirmPassword);

        // Remember
        $terms = new Check(
            'terms', 
            [
                'value' => 'yes',
            ]
        );

        $terms->setLabel('Accept terms and conditions');
        $terms->addValidator(
            new Identical(
                [
                    'value'   => 'yes',
                    'message' => 'Terms and conditions must be ' .
                                 'accepted',
                ]
            )
        );

        $this->add($terms);

        // CSRF
        $csrf = new Hidden('csrf');
        $csrf->addValidator(
            new Identical(
                [
                    'value'   => $this->security->getRequestToken(),
                    'message' => 'CSRF validation failed',
                ]
            )
        );
        $csrf->clear();

        $this->add($csrf);

        // Sign Up
        $this->add(
            new Submit(
                'Sign Up', 
                [
                    'class' => 'btn btn-success',
                ]
            )
        );
    }

    /**
     * Prints messages for a specific element
     *
     * @param string $name
     *
     * @return string
     */
    public function messages(string $name)
    {
        if ($this->hasMessagesFor($name)) {
            foreach ($this->getMessagesFor($name) as $message) {
                return $message;
            }
        }

        return '';
    }
}
```

In the `initialize` method we are setting up all the HTML elements we need. These elements are:

| Element           | Type       | Description                  |
| ----------------- | ---------- | ---------------------------- |
| `name`            | `Text`     | The name of the user         |
| `email`           | `Text`     | The email for the account    |
| `password`        | `Password` | The password for the account |
| `confirmPassword` | `Password` | Password confirmation        |
| `terms`           | `Check`    | Accept the terms checkbox    |
| `csrf`            | `Hidden`   | CSRF protection element      |
| `Sign Up`         | `Submit`   | Submit button                |

Adding elements is pretty straight forward:

```php
<?php
declare(strict_types=1);

// Email
$email = new Text('email');
$email->setLabel('E-Mail');
$email->addValidators(
    [
        new PresenceOf(
            [
                'message' => 'The e-mail is required',
            ]
        ),
        new Email(
            [
                'message' => 'The e-mail is not valid',
            ]
        ),
    ]
);

$this->add($email);
```

First we create a `Text` object and set its name to `email`. We also set the label of the element to `E-Mail`. After that we attach various validators on the element. These will be invoked after the user submits data, and that data is passed in the form.

As we see above, we attach the `PresenceOf` validator on the `email` element with a message `The e-mail is required`. The validator will check if the user has submitted data when they clicked the submit button and will produce the message if the validator fails. The validator checks the passed array (usually `$_POST`) and for this particular element it will check `$_POST['email']`.

We also attach the `Email` validator, which is responsible for checking for a valid email address. As you can see the validators belong in an array, so you can easily attach as many validators as you need on any particular element.

The last thing we do is to add the element in the form.

You will notice that the `terms` element does not have any validators attached to it, so our form will not check the contents of the element.

Special attention to the `password` and `confirmPassword` elements. You will notice that both elements are of type `Password`. The idea is that you need to type your password twice, and the passwords need to match in order to avoid errors.

The `password` field has two validators for content: `PresenceOf` i.e. it is required and `StringLength`: we need the password to be more than 8 characters. We also attach a third validator called `Confirmation`. This special validator ties the `password` element with the `confirmPassword` element. When it is triggered to validate it will check the contents of both elements and if they are not identical, the error message will appear i.e. the validation will fail.

### View

Now that we have everything set up in our form, we pass the form to the view:

```php
$this->view->setVar('form', $form);
```

Our view now needs to *render* the elements:

```twig
{% raw %}
{# ... #}
{% 
    set isEmailValidClass = form.messages('email') ? 
        'form-control is-invalid' : 
        'form-control' 
%}
{# ... #}

<h1 class="mt-3">Sign Up</h1>

<form method="post">
    {# ... #}

    <div class="form-group row">
        {{ 
            form.label(
                'email', 
                [
                    'class': 'col-sm-2 col-form-label'
                ]
            ) 
        }}
        <div class="col-sm-10">
            {{ 
                form.render(
                    'email', 
                    [
                        'class': isEmailValidClass, 
                        'placeholder': 'Email'
                    ]
                ) 
            }}
            <div class="invalid-feedback">
                {{ form.messages('email') }}
            </div>
        </div>
    </div>

    {# ... #}
    <div class="form-group row">
        <div class="col-sm-10">
            {{ 
                form.render(
                    'csrf', 
                    [
                        'value': security.getToken()
                    ]
                ) 
            }}
            {{ form.messages('csrf') }}

            {{ form.render('Sign Up') }}
        </div>
    </div>
</form>

<hr>

{{ link_to('session/login', "&larr; Back to Login") }}
{% endraw %}
```

The variable that we set in our view for our `SignUpForm` object is called `form`. We therefore use it directly and call the methods of it. The syntax in Volt is slightly different. In PHP we would use `$form->render()` whereas in Volt we will use `form.render()`.

The view contains a conditional at the top, checking whether there have been any errors in our form, and if there were, it attaches the `is-invalid` CSS class to the element. This class puts a nice red border by the element, highlighting the error and showing the message.

After that we have regular HTML tags with the relevant styling. In order to display the HTML code of each element we need to call `render()` on the `form` with the relevant element name. Also note that we also call `form.label()` with the same element name, so that we can create respective `<label>` tags.

At the end of the view we render the `CSRF` hidden field as well as the submit button `Sign Up`.

### Post

As mentioned above, once the user fills the form and clicks the `Sign Up` button, the form will *self post* i.e. it will post the data on the same controller and action (in our case `/session/signup`). The action now needs to process this posted data:

```php
<?php
declare(strict_types=1);

namespace Vokuro\Controllers;

use Phalcon\Flash\Direct;
use Phalcon\Http\Request;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Security;
use Phalcon\Mvc\View;
use Vokuro\Forms\SignUpForm;
use Vokuro\Models\Users;

/**
 * @property Dispatcher $dispatcher
 * @property Direct     $flash
 * @property Request    $request
 * @property Security   $security
 * @property View       $view
 */
class SessionController extends ControllerBase
{
    /**
     * Allow a user to signup to the system
     */
    public function signupAction()
    {
        $form = new SignUpForm();

        if (true === $this->request->isPost()) {
            if (false !== $form->isValid($this->request->getPost())) {
                $name     = $this
                    ->request
                    ->getPost('name', 'striptags')
                ;
                $email    = $this
                    ->request
                    ->getPost('email')
                ;
                $password = $this
                    ->request
                    ->getPost('password')
                ;
                $password = $this
                    ->security
                    ->hash($password)
                ;

                $user = new Users(
                    [
                        'name'       => $name,
                        'email'      => $email,
                        'password'   => $password,
                        'profilesId' => 2,
                    ]
                );

                if ($user->save()) {
                    return $this->dispatcher->forward([
                        'controller' => 'index',
                        'action'     => 'index',
                    ]);
                }

                foreach ($user->getMessages() as $message) {
                    $this->flash->error((string) $message);
                }
            }
        }

        $this->view->setVar('form', $form);
    }
}
```

If the user has submitted data, the following line will evaluate and we will be executing code inside the `if` statement:

```php
if (true === $this->request->isPost()) {
```

Here we are checking the request that came from the user, if it is a `POST`. Now that it is, we need to use the form validators and check if we have any errors. The [Phalcon\Http\Request](request) object, allows us to get that data easily by using:

```php
$this->request->getPost()
```

We now need to pass this posted data in the form and call `isValid`. This will fire all the validators for each element and if any of them fail, the form will populate the internal messages collection and return `false`

```php
if (false !== $form->isValid($this->request->getPost())) {
```

If everything is fine, we use again the [Phalcon\Http\Request](request) object to retrieve the submitted data but also sanitize them. The following example strips the tags from the submitted `name` string:

```php
$name     = $this
    ->request
    ->getPost('name', 'striptags')
;
```

Note that we never store clear text passwords. Instead we use the [Phalcon\Security](security) component and call `hash` on it, to transform the supplied password to a one way hash and store that instead. This way, if someone compromises our database, at least they have no access to clear text passwords.

```php
$password = $this
    ->security
    ->hash($password)
;
```

We now need to store the supplied data in the database. We do that by creating a new `Users` model, pass the sanitized data into it and then call `save`:

```php
$user = new Users(
    [
        'name'       => $name,
        'email'      => $email,
        'password'   => $password,
        'profilesId' => 2,
    ]
);

if ($user->save()) {
    return $this
        ->dispatcher
        ->forward(
            [
                'controller' => 'index',
                'action'     => 'index',
            ]
        );
}
```

If the `$user->save()` returns `true`, the user will be forwarded to the home page (`index/index`) and a success message will appear on screen.

### Model

**Relationships**

Now we need to check the `Users` model, since there is some logic we have applied there, in particular the `afterSave` and `beforeValidationOnCreate` events.

The core method, the setup if you like happens in the `initialize` method. That is the spot where we set all the [relationships](db-models-relationships) for the model. For the `Users` class we have several relationships defined. Why relationships you might ask? Phalcon offers an easy way to retrieve related data to a particular model.

If for instance we want to check all the successful logins for a particular user, we can do so with the following code snippet:

```php
<?php
declare(strict_types=1);

use Vokuro\Models\SuccessLogins;
use Vokuro\Models\Users;

$user = Users::findFirst(
    [
        'conditions' => 'id = :id:',
        'bind'       => [
            'id' => 7,
        ] 
    ]
);

$logins = SuccessLogin::find(
    [
        'conditions' => 'userId = :userId:',
        'bind'       => [
            'userId' => 7,
        ] 
    ]
);
```

The above code gets the user with id `7` and then gets all the successful logins from the relevant table for that user.

Using relationships we can let Phalcon do all the heavy lifting for us. So the code above becomes:

```php
<?php
declare(strict_types=1);

use Vokuro\Models\SuccessLogins;
use Vokuro\Models\Users;

$user = Users::findFirst(
    [
        'conditions' => 'id = :id:',
        'bind'       => [
            'id' => 7,
        ] 
    ]
);

$logins = $user->successLogins;

$logins = $user->getRelated('successLogins');
```

The last two lines do exactly the same thing. It is a matter of preference which syntax you want to use. Phalcon will query the related table, filtering the related table with the id of the user.

For our `Users` table we define the following relationships:

| Name              | Source field | Target field | Model             |
| ----------------- | ------------ | ------------ | ----------------- |
| `passwordChanges` | `id`         | `usersId`    | `PasswordChanges` |
| `profile`         | `profileId`  | `id`         | `Profiles`        |
| `resetPasswords`  | `id`         | `usersId`    | `ResetPasswords`  |
| `successLogins`   | `id`         | `usersId`    | `SuccessLogins`   |

```php
<?php
declare(strict_types=1);

namespace Vokuro\Models;

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness;

/**
 * All the users registered in the application
 */
class Users extends Model
{
    // ...

    public function initialize()
    {
        $this->belongsTo(
            'profilesId', 
            Profiles::class, 
            'id', 
            [
                'alias'    => 'profile',
                'reusable' => true,
            ]
        );

        $this->hasMany(
            'id', 
            SuccessLogins::class, 
            'usersId', 
            [
                'alias'      => 'successLogins',
                'foreignKey' => [
                    'message' => 'User cannot be deleted because ' .
                                 'he/she has activity in the system',
                ],
            ]
        );

        $this->hasMany(
            'id', 
            PasswordChanges::class, 
            'usersId', 
            [
                'alias'      => 'passwordChanges',
                'foreignKey' => [
                    'message' => 'User cannot be deleted because ' .
                                 'he/she has activity in the system',
                ],
            ]
        );

        $this->hasMany(
            'id', 
            ResetPasswords::class, 
            'usersId', [
            'alias'      => 'resetPasswords',
            'foreignKey' => [
                'message' => 'User cannot be deleted because ' .
                             'he/she has activity in the system',
            ],
        ]);
    }

    // ...
}
```

As you can see in the defined relationships, we have a `belongsTo` and three `hasMany`. All relationships have an alias so that we can access them easier. The `belongsTo` relationship also has the `reusable` flag set to on. This means that if the relationship is called more than once in the same request, Phalcon would perform the database query only the first time and cache the resultset. Any subsequent calls will use the cached resultset.

Also notable is that we define specific messages for foreign keys. If the particular relationship is violated, the defined message will be raised.

**Events**

[Phalcon\Mvc\Model](db-models) is designed to fire specific <events>. These event methods can be located either in a listener or in the same model.

For the `Users` model, we attach code to the `afterSave` and `beforeValidationOnCreate` events.

```php
<?php
declare(strict_types=1);

namespace Vokuro\Models;

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness;

/**
 * All the users registered in the application
 */
class Users extends Model
{
    public function beforeValidationOnCreate()
    {
        if (true === empty($this->password)) {
            $tempPassword = preg_replace(
                '/[^a-zA-Z0-9]/', 
                '', 
                base64_encode(openssl_random_pseudo_bytes(12))
            );

            $this->mustChangePassword = 'Y';

            $this->password = $this->getDI()
                                   ->getSecurity()
                                   ->hash($tempPassword)
            ;
        } else {
            $this->mustChangePassword = 'N';
        }

        if ($this->getDI()->get('config')->useMail) {
            $this->active = 'N';
        } else {
            $this->active = 'Y';
        }

        $this->suspended = 'N';

        $this->banned = 'N';
    }
}
```

The `beforeValidationOnCreate` will fire every time we have a new record (`Create`), before any validations occur. We check if we have a defined password and if not, we will generate a random string, then hash that string using [Phalcon\Security](security) amd storing it in the `password` property. We also set the flag to change the password.

If the password is not empty, we just set the `mustChangePassword` field to `N`. Finally, we set some defaults on whether the user is `active`, `suspended` or `banned`. This ensures that our record is ready before it is inserted in the database.

```php
<?php
declare(strict_types=1);

namespace Vokuro\Models;

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness;

/**
 * All the users registered in the application
 */
class Users extends Model
{
    public function afterSave()
    {
        if ($this->getDI()->get('config')->useMail) {
            if ($this->active == 'N') {
                $emailConfirmation          = new EmailConfirmations();
                $emailConfirmation->usersId = $this->id;

                if ($emailConfirmation->save()) {
                    $this->getDI()
                         ->getFlash()
                         ->notice(
                            'A confirmation mail has ' .
                            'been sent to ' . $this->email
                        )
                    ;
                }
            }
        }
    }
}
```

The `afterSave` event fires right after a record is saved in the database. In this event we check if emails have been enabled (see `.env` file `useMail` setting), and if active we create a new record in the `EmailConfirmations` table and then save the record. Once everything is done, a notice will appear on screen.

> **NOTE**: Note that the `EmailConfirmations` model also has an `afterCreate` event, which is responsible for actually sending the email to the user.
{: .alert .alert=info }

**Validation**

The model also has the `validate` method which allows us to attach a validator to any number of fields in our model. For the `Users` table, we need the `email` to be unique. As such, we attach the `Uniqueness` [validator](validation) to it. The validator will fire right before any save operation is performed on the model and the message will be returned back if the validation fails.

```php
<?php
declare(strict_types=1);

namespace Vokuro\Models;

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness;

/**
 * All the users registered in the application
 */
class Users extends Model
{
    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            'email', 
            new Uniqueness(
                [
                    "message" => "The email is already registered",
                ]
            )
        );

        return $this->validate($validator);
    }
}
```

## Conclusion

Vökuró is a sample application that we use to demonstrate some of the features that Phalcon offers. It is definitely not a solution that will fit all needs. However you can use it as a starting point to develop your application.

## References

- [Access Control Lists definition](https://en.wikipedia.org/wiki/Access-control_list)
- [Composer](https://getcomposer.org) 
- [DotEnv - Vance Lucas](https://github.com/vlucas/phpdotenv)
- [Model-View-Controller definition](https://en.wikipedia.org/wiki/Model–view–controller)
- [Nanobox Guides](https://guides.nanobox.io/php/)
- [Phinx - Cake PHP](https://github.com/cakephp/phinx)
- [PSR Extension](https://github.com/jbboehr/php-psr)
- [Swift Mailer](https://swiftmailer.symfony.com)
- [Phalcon ACL](acl)
- [Phalcon Forms](forms)
- [Phalcon HTTP Response](response)
- [Phalcon Security](security)
- [Vökuró - GitHub Repository](https://github.com/phalcon/vokuro)