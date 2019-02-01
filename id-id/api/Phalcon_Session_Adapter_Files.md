---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Session\Adapter\Files'
---
# Class **Phalcon\Session\Adapter\Files**

*extends* abstract class [Phalcon\Session\Adapter](Phalcon_Session_Adapter)

*implements* [Phalcon\Session\AdapterInterface](Phalcon_Session_AdapterInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/session/adapter/files.zep)

## Constants

*bilangan bulat* **SESSION_ACTIVE **

*bilangan bulat* **SESSION_NONE **   Teks paragraf

*bilangan bulat* **SESSION_DISABLED **

## Metode

public **__construct** ([*array* $options]) inherited from [Phalcon\Session\Adapter](Phalcon_Session_Adapter)

Phalcon\Session\Adapter constructor

public **start** () inherited from [Phalcon\Session\Adapter](Phalcon_Session_Adapter)

Mulai sesi (jika header sudah dikirim sesi tidak akan dimulai)

public **setOptions** (*array* $options) inherited from [Phalcon\Session\Adapter](Phalcon_Session_Adapter)

Menetapkan pilihan sesi

```php
<?php

$session->setOptions(
    [
        "uniqueId" => "my-private-app",
    ]
);

```

public **getOptions** () inherited from [Phalcon\Session\Adapter](Phalcon_Session_Adapter)

Dapatkan pilihan internal

public **setName** (*mixed* $name) inherited from [Phalcon\Session\Adapter](Phalcon_Session_Adapter)

Tetapkan nama sesi

public **getName** () inherited from [Phalcon\Session\Adapter](Phalcon_Session_Adapter)

Dapatkan nama sesi

public **regenerateId** ([*mixed* $deleteOldSession]) inherited from [Phalcon\Session\Adapter](Phalcon_Session_Adapter)

public **get** (*mixed* $index, [*mixed* $defaultValue], [*mixed* $remove]) inherited from [Phalcon\Session\Adapter](Phalcon_Session_Adapter)

Mendapat variabel sesi dari konteks aplikasi

```php
<?php

$session->get("auth", "yes");

```

public **set** (*mixed* $index, *mixed* $value) inherited from [Phalcon\Session\Adapter](Phalcon_Session_Adapter)

Menetapkan variabel sesi dalam konteks aplikasi

```php
<?php

$session->set("auth", "yes");

```

public **has** (*mixed* $index) inherited from [Phalcon\Session\Adapter](Phalcon_Session_Adapter)

Periksa apakah variabel sesi diatur dalam konteks aplikasi

```php
<?php

var_dump(
    $session->has("auth")
);

```

public **remove** (*mixed* $index) inherited from [Phalcon\Session\Adapter](Phalcon_Session_Adapter)

Menghapus variabel sesi dari konteks aplikasi

```php
<?php

$session->remove("auth");

```

public **getId** () inherited from [Phalcon\Session\Adapter](Phalcon_Session_Adapter)

Mengembalikan id sesi aktif

```php
<?php

echo $session->getId();

```

public **setId** (*mixed* $id) inherited from [Phalcon\Session\Adapter](Phalcon_Session_Adapter)

Tetapkan Id sesi saat ini

```php
<?php

$session->setId($id);

```

public **isStarted** () inherited from [Phalcon\Session\Adapter](Phalcon_Session_Adapter)

Periksa apakah sesi sudah dimulai

```php
<?php

var_dump(
    $session->isStarted()
);

```

public **destroy** ([*mixed* $removeData]) inherited from [Phalcon\Session\Adapter](Phalcon_Session_Adapter)

Hancurkan sesi aktif

```php
<?php

var_dump(
    $session->destroy()
);

var_dump(
    $session->destroy(true)
);

```

public **status** () inherited from [Phalcon\Session\Adapter](Phalcon_Session_Adapter)

Mengembalikan status sesi saat ini.

```php
<?php

var_dump(
    $session->status()
);

if ($session->status() !== $session::SESSION_ACTIVE) {
    $session->start();
}

```

public **__get** (*mixed* $index) inherited from [Phalcon\Session\Adapter](Phalcon_Session_Adapter)

Alias: Mendapat variabel sesi dari konteks aplikasi

public **__set** (*mixed* $index, *mixed* $value) inherited from [Phalcon\Session\Adapter](Phalcon_Session_Adapter)

Alias: Menetapkan variabel sesi dalam konteks aplikasi

public **__isset** (*mixed* $index) inherited from [Phalcon\Session\Adapter](Phalcon_Session_Adapter)

Alias: Periksa apakah variabel sesi diatur dalam konteks aplikasi

public **__unset** (*mixed* $index) inherited from [Phalcon\Session\Adapter](Phalcon_Session_Adapter)

Alias: Menghapus variabel sesi dari konteks aplikasi

```php
<?php

unset($session->auth);

```

public **__destruct** () inherited from [Phalcon\Session\Adapter](Phalcon_Session_Adapter)

...

protected **removeSessionData** () inherited from [Phalcon\Session\Adapter](Phalcon_Session_Adapter)

...