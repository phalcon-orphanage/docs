---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Session\Adapter'
---
# Abstract class **Phalcon\Session\Adapter**

*implements* [Phalcon\Session\AdapterInterface](Phalcon_Session_AdapterInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/session/adapter.zep)

Base class for Phalcon\Session adapters

## Constants

*bilangan bulat* **SESSION_ACTIVE **

*bilangan bulat* **SESSION_NONE **   Teks paragraf

*bilangan bulat* **SESSION_DISABLED **

## Metode

umum **__membangun** ([*array* $options])

Phalcon\Session\Adapter constructor

publik ** mulai ** ()

Mulai sesi (jika header sudah dikirim sesi tidak akan dimulai)

public **setOptions** (*array* $options)

Menetapkan pilihan sesi

```php
<?php

$session->setOptions(
    [
        "uniqueId" => "my-private-app",
    ]
);

```

public **getOptions** ()

Dapatkan pilihan internal

publik **setNama** (*dicampur* $name)

Tetapkan nama sesi

publik **getNama** ()

Dapatkan nama sesi

public **regenerateId** ([*mixed* $deleteOldSession])

public **get** (*mixed* $index, [*mixed* $defaultValue], [*mixed* $remove])

Mendapat variabel sesi dari konteks aplikasi

```php
<?php

$session->get("auth", "yes");

```

public **set** (*mixed* $index, *mixed* $value)

Menetapkan variabel sesi dalam konteks aplikasi

```php
<?php

$session->set("auth", "yes");

```

public **has** (*mixed* $index)

Periksa apakah variabel sesi diatur dalam konteks aplikasi

```php
<?php

var_dump(
    $session->has("auth")
);

```

public **remove** (*mixed* $index)

Menghapus variabel sesi dari konteks aplikasi

```php
<?php

$session->remove("auth");

```

public **getId** ()

Mengembalikan id sesi aktif

```php
<?php

echo $session->getId();

```

public **setId** (*mixed* $id)

Tetapkan Id sesi saat ini

```php
<?php

$session->setId($id);

```

publik **dimulai** ()

Periksa apakah sesi sudah dimulai

```php
<?php

var_dump(
    $session->isStarted()
);

```

public **destroy** ([*mixed* $removeData])

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

public **status** ()

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

public **__get** (*mixed* $index)

Alias: Mendapat variabel sesi dari konteks aplikasi

public **__set** (*mixed* $index, *mixed* $value)

Alias: Menetapkan variabel sesi dalam konteks aplikasi

public **__isset** (*mixed* $index)

Alias: Periksa apakah variabel sesi diatur dalam konteks aplikasi

public **__unset** (*mixed* $index)

Alias: Menghapus variabel sesi dari konteks aplikasi

```php
<?php

unset($session->auth);

```

publik **__penghancuran** ()

...

protected **removeSessionData** ()

...