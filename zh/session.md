<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">在会话中存储数据</a> 
      <ul>
        <li>
          <a href="#start">启动新会话</a>
          <ul>
            <li>
              <a href="#start-factory">Factory</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#store">Storing/Retrieving data in Session</a>
        </li>
        <li>
          <a href="#remove-destroy">删除/销毁会话</a>
        </li>
        <li>
          <a href="#data-isolation">Isolating Session Data between Applications</a>
        </li>
        <li>
          <a href="#bags">Session Bags</a>
        </li>
        <li>
          <a href="#data-persistency">Persistent Data in Components</a>
        </li>
        <li>
          <a href="#custom-adapters">Implementing your own adapters</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Storing data in the Session

The session component provides object-oriented wrappers to access session data.

Reasons to use this component instead of raw-sessions:

* You can easily isolate session data across applications on the same domain
* Intercept where session data is set/get in your application
* Change the session adapter according to the application needs

<a name='start'></a>

## Starting the Session

Some applications are session-intensive, almost any action that performs requires access to session data. There are others who access session data casually. Thanks to the service container, we can ensure that the session is accessed only when it's clearly needed:

```php
<?php

use Phalcon\Session\Adapter\Files as Session;

// Start the session the first time when some component request the session service
$di->setShared(
    'session',
    function () {
        $session = new Session();

        $session->start();

        return $session;
    }
);
```

<a name='start-factory'></a>

## Factory

Loads Session Adapter class using `adapter` option

```php
<?php

use Phalcon\Session\Factory;

$options = [
    'uniqueId'   => 'my-private-app',
    'host'       => '127.0.0.1',
    'port'       => 11211,
    'persistent' => true,
    'lifetime'   => 3600,
    'prefix'     => 'my_',
    'adapter'    => 'memcache',
];

$session = Factory::load($options);
$session->start();
```

<a name='store'></a>

## Storing/Retrieving data in Session

From a controller, a view or any other component that extends `Phalcon\Di\Injectable` you can access the session service and store items and retrieve them in the following way:

```php
<?php

use Phalcon\Mvc\Controller;

class UserController extends Controller
{
    public function indexAction()
    {
        // Set a session variable
        $this->session->set('user-name', 'Michael');
    }

    public function welcomeAction()
    {
        // Check if the variable is defined
        if ($this->session->has('user-name')) {
            // Retrieve its value
            $name = $this->session->get('user-name');
        }
    }

}
```

<a name='remove-destroy'></a>

## Removing/Destroying Sessions

It's also possible remove specific variables or destroy the whole session:

```php
<?php

use Phalcon\Mvc\Controller;

class UserController extends Controller
{
    public function removeAction()
    {
        // Remove a session variable
        $this->session->remove('user-name');
    }

    public function logoutAction()
    {
        // Destroy the whole session
        $this->session->destroy();
    }
}
```

<a name='data-isolation'></a>

## Isolating Session Data between Applications

Sometimes a user can use the same application twice, on the same server, in the same session. Surely, if we use variables in session, we want that every application have separate session data (even though the same code and same variable names). To solve this, you can add a prefix for every session variable created in a certain application:

```php
<?php

use Phalcon\Session\Adapter\Files as Session;

// Isolating the session data
$di->set(
    'session',
    function () {
        // All variables created will prefixed with 'my-app-1'
        $session = new Session(
            [
                'uniqueId' => 'my-app-1',
            ]
        );

        $session->start();

        return $session;
    }
);
```

Adding a unique ID is not necessary.

<a name='bags'></a>

## Session Bags

`Phalcon\Session\Bag` is a component that helps separating session data into `namespaces`. Working by this way you can easily create groups of session variables into the application. By only setting the variables in the `bag`, it's automatically stored in session:

```php
<?php

use Phalcon\Session\Bag as SessionBag;

$user = new SessionBag('user');

$user->setDI($di);

$user->name = 'Kimbra Johnson';
$user->age  = 22;
```

<a name='data-persistency'></a>

## Persistent Data in Components

Controller, components and classes that extends `Phalcon\Di\Injectable` may inject a `Phalcon\Session\Bag`. This class isolates variables for every class. Thanks to this you can persist data between requests in every class in an independent way.

```php
<?php

use Phalcon\Mvc\Controller;

class UserController extends Controller
{
    public function indexAction()
    {
        // Create a persistent variable 'name'
        $this->persistent->name = 'Laura';
    }

    public function welcomeAction()
    {
        if (isset($this->persistent->name)) {
            echo 'Welcome, ', $this->persistent->name;
        }
    }
}
```

在组件：

```php
<?php

use Phalcon\Mvc\User\Component;

class Security extends Component
{
    public function auth()
    {
        // Create a persistent variable 'name'
        $this->persistent->name = 'Laura';
    }

    public function getAuthName()
    {
        return $this->persistent->name;
    }
}
```

The data added to the session (`$this->session`) are available throughout the application, while persistent (`$this->persistent`) can only be accessed in the scope of the current class.

<a name='custom-adapters'></a>

## Implementing your own adapters

The `Phalcon\Session\AdapterInterface` interface must be implemented in order to create your own session adapters or extend the existing ones.

There are more adapters available for this components in the [Phalcon Incubator](https://github.com/phalcon/incubator/tree/master/Library/Phalcon/Session/Adapter)