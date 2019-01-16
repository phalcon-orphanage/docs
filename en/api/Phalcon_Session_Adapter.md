---
layout: article
language: 'en'
version: '4.0'
title: 'Phalcon\Session\Adapter'
---
# Abstract class **Phalcon\Session\Adapter**

*implements* [Phalcon\Session\AdapterInterface](Phalcon_Session_AdapterInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/session/adapter.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Base class for Phalcon\Session adapters


## Constants
*integer* **SESSION_ACTIVE**

*integer* **SESSION_NONE**

*integer* **SESSION_DISABLED**

## Methods
public  **__construct** ([*array* $options])

Phalcon\Session\Adapter constructor



public  **start** ()

Starts the session (if headers are already sent the session will not be started)



public  **setOptions** (*array* $options)

Sets session's options

```php
<?php

$session->setOptions(
    [
        "uniqueId" => "my-private-app",
    ]
);

```



public  **getOptions** ()

Get internal options



public  **setName** (*mixed* $name)

Set session name



public  **getName** ()

Get session name



public  **regenerateId** ([*mixed* $deleteOldSession])





public  **get** (*mixed* $index, [*mixed* $defaultValue], [*mixed* $remove])

Gets a session variable from an application context

```php
<?php

$session->get("auth", "yes");

```



public  **set** (*mixed* $index, *mixed* $value)

Sets a session variable in an application context

```php
<?php

$session->set("auth", "yes");

```



public  **has** (*mixed* $index)

Check whether a session variable is set in an application context

```php
<?php

var_dump(
    $session->has("auth")
);

```



public  **remove** (*mixed* $index)

Removes a session variable from an application context

```php
<?php

$session->remove("auth");

```



public  **getId** ()

Returns active session id

```php
<?php

echo $session->getId();

```



public  **setId** (*mixed* $id)

Set the current session id

```php
<?php

$session->setId($id);

```



public  **isStarted** ()

Check whether the session has been started

```php
<?php

var_dump(
    $session->isStarted()
);

```



public  **destroy** ([*mixed* $removeData])

Destroys the active session

```php
<?php

var_dump(
    $session->destroy()
);

var_dump(
    $session->destroy(true)
);

```



public  **status** ()

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



public  **__get** (*mixed* $index)

Alias: Gets a session variable from an application context



public  **__set** (*mixed* $index, *mixed* $value)

Alias: Sets a session variable in an application context



public  **__isset** (*mixed* $index)

Alias: Check whether a session variable is set in an application context



public  **__unset** (*mixed* $index)

Alias: Removes a session variable from an application context

```php
<?php

unset($session->auth);

```



public  **__destruct** ()

...


protected  **removeSessionData** ()

...


