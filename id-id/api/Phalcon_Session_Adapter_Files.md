* * *

<<<<<<< HEAD
layout: default language: 'en' version: '4.0' title: 'Phalcon\Session\Adapter\Files'
=======
layout: article language: 'en' version: '4.0' title: 'Phalcon\Session\Adapter\Files'
>>>>>>> 73fa73b040c87e5bc28ac848a5de044aaa9774c5

* * *

# Class **Phalcon\Session\Adapter\Files**

<<<<<<< HEAD
*extends* abstract class [Phalcon\Session\Adapter](/3.4/en/api/Phalcon_Session_Adapter)

*implements* [Phalcon\Session\AdapterInterface](/3.4/en/api/Phalcon_Session_AdapterInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v3.4.0/phalcon/session/adapter/files.zep" class="btn btn-default btn-sm">Source on GitHub</a>
=======
*extends* abstract class [Phalcon\Session\Adapter](/4.0/en/api/Phalcon_Session_Adapter)

*implements* [Phalcon\Session\AdapterInterface](/4.0/en/api/Phalcon_Session_AdapterInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/session/adapter/files.zep" class="btn btn-default btn-sm">Source on GitHub</a>
>>>>>>> 73fa73b040c87e5bc28ac848a5de044aaa9774c5

## Constants

*integer* **SESSION_ACTIVE**

*integer* **SESSION_NONE**

*integer* **SESSION_DISABLED**

## Methods

<<<<<<< HEAD
public **__construct** ([*array* $options]) inherited from [Phalcon\Session\Adapter](/3.4/en/api/Phalcon_Session_Adapter)

Phalcon\Session\Adapter constructor

public **start** () inherited from [Phalcon\Session\Adapter](/3.4/en/api/Phalcon_Session_Adapter)

Starts the session (if headers are already sent the session will not be started)

public **setOptions** (*array* $options) inherited from [Phalcon\Session\Adapter](/3.4/en/api/Phalcon_Session_Adapter)
=======
public **__construct** ([*array* $options]) inherited from [Phalcon\Session\Adapter](/4.0/en/api/Phalcon_Session_Adapter)

Phalcon\Session\Adapter constructor

public **start** () inherited from [Phalcon\Session\Adapter](/4.0/en/api/Phalcon_Session_Adapter)

Starts the session (if headers are already sent the session will not be started)

public **setOptions** (*array* $options) inherited from [Phalcon\Session\Adapter](/4.0/en/api/Phalcon_Session_Adapter)
>>>>>>> 73fa73b040c87e5bc28ac848a5de044aaa9774c5

Sets session's options

```php
<?php

$session->setOptions(
    [
        "uniqueId" => "my-private-app",
    ]
);

```

<<<<<<< HEAD
public **getOptions** () inherited from [Phalcon\Session\Adapter](/3.4/en/api/Phalcon_Session_Adapter)

Get internal options

public **setName** (*mixed* $name) inherited from [Phalcon\Session\Adapter](/3.4/en/api/Phalcon_Session_Adapter)

Set session name

public **getName** () inherited from [Phalcon\Session\Adapter](/3.4/en/api/Phalcon_Session_Adapter)

Get session name

public **regenerateId** ([*mixed* $deleteOldSession]) inherited from [Phalcon\Session\Adapter](/3.4/en/api/Phalcon_Session_Adapter)

public **get** (*mixed* $index, [*mixed* $defaultValue], [*mixed* $remove]) inherited from [Phalcon\Session\Adapter](/3.4/en/api/Phalcon_Session_Adapter)
=======
public **getOptions** () inherited from [Phalcon\Session\Adapter](/4.0/en/api/Phalcon_Session_Adapter)

Get internal options

public **setName** (*mixed* $name) inherited from [Phalcon\Session\Adapter](/4.0/en/api/Phalcon_Session_Adapter)

Set session name

public **getName** () inherited from [Phalcon\Session\Adapter](/4.0/en/api/Phalcon_Session_Adapter)

Get session name

public **regenerateId** ([*mixed* $deleteOldSession]) inherited from [Phalcon\Session\Adapter](/4.0/en/api/Phalcon_Session_Adapter)

public **get** (*mixed* $index, [*mixed* $defaultValue], [*mixed* $remove]) inherited from [Phalcon\Session\Adapter](/4.0/en/api/Phalcon_Session_Adapter)
>>>>>>> 73fa73b040c87e5bc28ac848a5de044aaa9774c5

Gets a session variable from an application context

```php
<?php

$session->get("auth", "yes");

```

<<<<<<< HEAD
public **set** (*mixed* $index, *mixed* $value) inherited from [Phalcon\Session\Adapter](/3.4/en/api/Phalcon_Session_Adapter)
=======
public **set** (*mixed* $index, *mixed* $value) inherited from [Phalcon\Session\Adapter](/4.0/en/api/Phalcon_Session_Adapter)
>>>>>>> 73fa73b040c87e5bc28ac848a5de044aaa9774c5

Sets a session variable in an application context

```php
<?php

$session->set("auth", "yes");

```

<<<<<<< HEAD
public **has** (*mixed* $index) inherited from [Phalcon\Session\Adapter](/3.4/en/api/Phalcon_Session_Adapter)
=======
public **has** (*mixed* $index) inherited from [Phalcon\Session\Adapter](/4.0/en/api/Phalcon_Session_Adapter)
>>>>>>> 73fa73b040c87e5bc28ac848a5de044aaa9774c5

Check whether a session variable is set in an application context

```php
<?php

var_dump(
    $session->has("auth")
);

```

<<<<<<< HEAD
public **remove** (*mixed* $index) inherited from [Phalcon\Session\Adapter](/3.4/en/api/Phalcon_Session_Adapter)
=======
public **remove** (*mixed* $index) inherited from [Phalcon\Session\Adapter](/4.0/en/api/Phalcon_Session_Adapter)
>>>>>>> 73fa73b040c87e5bc28ac848a5de044aaa9774c5

Removes a session variable from an application context

```php
<?php

$session->remove("auth");

```

<<<<<<< HEAD
public **getId** () inherited from [Phalcon\Session\Adapter](/3.4/en/api/Phalcon_Session_Adapter)
=======
public **getId** () inherited from [Phalcon\Session\Adapter](/4.0/en/api/Phalcon_Session_Adapter)
>>>>>>> 73fa73b040c87e5bc28ac848a5de044aaa9774c5

Returns active session id

```php
<?php

echo $session->getId();

```

<<<<<<< HEAD
public **setId** (*mixed* $id) inherited from [Phalcon\Session\Adapter](/3.4/en/api/Phalcon_Session_Adapter)
=======
public **setId** (*mixed* $id) inherited from [Phalcon\Session\Adapter](/4.0/en/api/Phalcon_Session_Adapter)
>>>>>>> 73fa73b040c87e5bc28ac848a5de044aaa9774c5

Set the current session id

```php
<?php

$session->setId($id);

```

<<<<<<< HEAD
public **isStarted** () inherited from [Phalcon\Session\Adapter](/3.4/en/api/Phalcon_Session_Adapter)
=======
public **isStarted** () inherited from [Phalcon\Session\Adapter](/4.0/en/api/Phalcon_Session_Adapter)
>>>>>>> 73fa73b040c87e5bc28ac848a5de044aaa9774c5

Check whether the session has been started

```php
<?php

var_dump(
    $session->isStarted()
);

```

<<<<<<< HEAD
public **destroy** ([*mixed* $removeData]) inherited from [Phalcon\Session\Adapter](/3.4/en/api/Phalcon_Session_Adapter)
=======
public **destroy** ([*mixed* $removeData]) inherited from [Phalcon\Session\Adapter](/4.0/en/api/Phalcon_Session_Adapter)
>>>>>>> 73fa73b040c87e5bc28ac848a5de044aaa9774c5

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

<<<<<<< HEAD
public **status** () inherited from [Phalcon\Session\Adapter](/3.4/en/api/Phalcon_Session_Adapter)
=======
public **status** () inherited from [Phalcon\Session\Adapter](/4.0/en/api/Phalcon_Session_Adapter)
>>>>>>> 73fa73b040c87e5bc28ac848a5de044aaa9774c5

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

<<<<<<< HEAD
public **__get** (*mixed* $index) inherited from [Phalcon\Session\Adapter](/3.4/en/api/Phalcon_Session_Adapter)

Alias: Gets a session variable from an application context

public **__set** (*mixed* $index, *mixed* $value) inherited from [Phalcon\Session\Adapter](/3.4/en/api/Phalcon_Session_Adapter)

Alias: Sets a session variable in an application context

public **__isset** (*mixed* $index) inherited from [Phalcon\Session\Adapter](/3.4/en/api/Phalcon_Session_Adapter)

Alias: Check whether a session variable is set in an application context

public **__unset** (*mixed* $index) inherited from [Phalcon\Session\Adapter](/3.4/en/api/Phalcon_Session_Adapter)
=======
public **__get** (*mixed* $index) inherited from [Phalcon\Session\Adapter](/4.0/en/api/Phalcon_Session_Adapter)

Alias: Gets a session variable from an application context

public **__set** (*mixed* $index, *mixed* $value) inherited from [Phalcon\Session\Adapter](/4.0/en/api/Phalcon_Session_Adapter)

Alias: Sets a session variable in an application context

public **__isset** (*mixed* $index) inherited from [Phalcon\Session\Adapter](/4.0/en/api/Phalcon_Session_Adapter)

Alias: Check whether a session variable is set in an application context

public **__unset** (*mixed* $index) inherited from [Phalcon\Session\Adapter](/4.0/en/api/Phalcon_Session_Adapter)
>>>>>>> 73fa73b040c87e5bc28ac848a5de044aaa9774c5

Alias: Removes a session variable from an application context

```php
<?php

unset($session->auth);

```

<<<<<<< HEAD
public **__destruct** () inherited from [Phalcon\Session\Adapter](/3.4/en/api/Phalcon_Session_Adapter)

...

protected **removeSessionData** () inherited from [Phalcon\Session\Adapter](/3.4/en/api/Phalcon_Session_Adapter)
=======
public **__destruct** () inherited from [Phalcon\Session\Adapter](/4.0/en/api/Phalcon_Session_Adapter)

...

protected **removeSessionData** () inherited from [Phalcon\Session\Adapter](/4.0/en/api/Phalcon_Session_Adapter)
>>>>>>> 73fa73b040c87e5bc28ac848a5de044aaa9774c5

...