# Class **Phalcon\\Session\\Adapter\\Memcache**

*extends* abstract class [Phalcon\Session\Adapter](/[[language]]/[[version]]/api/Phalcon_Session_Adapter)

*implements* [Phalcon\Session\AdapterInterface](/[[language]]/[[version]]/api/Phalcon_Session_AdapterInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/session/adapter/memcache.zep" class="btn btn-default btn-sm">Source on GitHub</a>

This adapter store sessions in memcache

```php
<?php

use Phalcon\Session\Adapter\Memcache;

$session = new Memcache(
    [
        "uniqueId"   => "my-private-app",
        "host"       => "127.0.0.1",
        "port"       => 11211,
        "persistent" => true,
        "lifetime"   => 3600,
        "prefix"     => "my_",
    ]
);

$session->start();

$session->set("var", "some-value");

echo $session->get("var");

```


## Constants
*integer* **SESSION_ACTIVE**

*integer* **SESSION_NONE**

*integer* **SESSION_DISABLED**

## Methods
public  **getMemcache** ()

...


public  **getLifetime** ()

...


public  **__construct** ([*array* $options])

Phalcon\\Session\\Adapter\\Memcache constructor



public  **open** ()

...


public  **close** ()

...


public  **read** (*mixed* $sessionId)





public  **write** (*mixed* $sessionId, *mixed* $data)





public  **destroy** ([*mixed* $sessionId])





public  **gc** ()





public  **start** () inherited from [Phalcon\Session\Adapter](/[[language]]/[[version]]/api/Phalcon_Session_Adapter)

Starts the session (if headers are already sent the session will not be started)



public  **setOptions** (*array* $options) inherited from [Phalcon\Session\Adapter](/[[language]]/[[version]]/api/Phalcon_Session_Adapter)

Sets session's options

```php
<?php

$session->setOptions(
    [
        "uniqueId" => "my-private-app",
    ]
);

```



public  **getOptions** () inherited from [Phalcon\Session\Adapter](/[[language]]/[[version]]/api/Phalcon_Session_Adapter)

Get internal options



public  **setName** (*mixed* $name) inherited from [Phalcon\Session\Adapter](/[[language]]/[[version]]/api/Phalcon_Session_Adapter)

Set session name



public  **getName** () inherited from [Phalcon\Session\Adapter](/[[language]]/[[version]]/api/Phalcon_Session_Adapter)

Get session name



public  **regenerateId** ([*mixed* $deleteOldSession]) inherited from [Phalcon\Session\Adapter](/[[language]]/[[version]]/api/Phalcon_Session_Adapter)





public  **get** (*mixed* $index, [*mixed* $defaultValue], [*mixed* $remove]) inherited from [Phalcon\Session\Adapter](/[[language]]/[[version]]/api/Phalcon_Session_Adapter)

Gets a session variable from an application context

```php
<?php

$session->get("auth", "yes");

```



public  **set** (*mixed* $index, *mixed* $value) inherited from [Phalcon\Session\Adapter](/[[language]]/[[version]]/api/Phalcon_Session_Adapter)

Sets a session variable in an application context

```php
<?php

$session->set("auth", "yes");

```



public  **has** (*mixed* $index) inherited from [Phalcon\Session\Adapter](/[[language]]/[[version]]/api/Phalcon_Session_Adapter)

Check whether a session variable is set in an application context

```php
<?php

var_dump(
    $session->has("auth")
);

```



public  **remove** (*mixed* $index) inherited from [Phalcon\Session\Adapter](/[[language]]/[[version]]/api/Phalcon_Session_Adapter)

Removes a session variable from an application context

```php
<?php

$session->remove("auth");

```



public  **getId** () inherited from [Phalcon\Session\Adapter](/[[language]]/[[version]]/api/Phalcon_Session_Adapter)

Returns active session id

```php
<?php

echo $session->getId();

```



public  **setId** (*mixed* $id) inherited from [Phalcon\Session\Adapter](/[[language]]/[[version]]/api/Phalcon_Session_Adapter)

Set the current session id

```php
<?php

$session->setId($id);

```



public  **isStarted** () inherited from [Phalcon\Session\Adapter](/[[language]]/[[version]]/api/Phalcon_Session_Adapter)

Check whether the session has been started

```php
<?php

var_dump(
    $session->isStarted()
);

```



public  **status** () inherited from [Phalcon\Session\Adapter](/[[language]]/[[version]]/api/Phalcon_Session_Adapter)

Returns the status of the current session.

```php
<?php

var_dump(
    $session->status()
);

if ($session->status() !== $session::SESSION_ACTIVE) {
    $session->start();
}

```



public  **__get** (*mixed* $index) inherited from [Phalcon\Session\Adapter](/[[language]]/[[version]]/api/Phalcon_Session_Adapter)

Alias: Gets a session variable from an application context



public  **__set** (*mixed* $index, *mixed* $value) inherited from [Phalcon\Session\Adapter](/[[language]]/[[version]]/api/Phalcon_Session_Adapter)

Alias: Sets a session variable in an application context



public  **__isset** (*mixed* $index) inherited from [Phalcon\Session\Adapter](/[[language]]/[[version]]/api/Phalcon_Session_Adapter)

Alias: Check whether a session variable is set in an application context



public  **__unset** (*mixed* $index) inherited from [Phalcon\Session\Adapter](/[[language]]/[[version]]/api/Phalcon_Session_Adapter)

Alias: Removes a session variable from an application context

```php
<?php

unset($session->auth);

```



public  **__destruct** () inherited from [Phalcon\Session\Adapter](/[[language]]/[[version]]/api/Phalcon_Session_Adapter)

...


protected  **removeSessionData** () inherited from [Phalcon\Session\Adapter](/[[language]]/[[version]]/api/Phalcon_Session_Adapter)

...


