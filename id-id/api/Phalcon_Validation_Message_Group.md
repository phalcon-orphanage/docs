---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Validation\Message\Group'
---
# Class **Phalcon\Validation\Message\Group**

*implements* [Countable](https://php.net/manual/en/class.countable.php), [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php), [Iterator](https://php.net/manual/en/class.iterator.php), [Traversable](https://php.net/manual/en/class.traversable.php)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/validation/message/group.zep)

Mewakili kelompok pesan validasi

## Metode

public **__construct** ([*array* $messages])

Phalcon\Validation\Message\Group constructor

public [Phalcon\Validation\Message](Phalcon_Validation_Message) **offsetGet** (*int* $index)

Mendapatkan atribut pesan menggunakan sintaks array

```php
<?php

print_r(
    $messages[0]
);

```

public **offsetSet** (*int* $index, [Phalcon\Validation\Message](Phalcon_Validation_Message) $message)

Menetapkan atribut menggunakan sintaks-array

```php
<?php

$messages[0] = new \Phalcon\Validation\Message("This is a message");

```

public *boolean* **offsetExists** (*int* $index)

Pemeriksaan jika ada indeks

```php
<?php

var_dump(
    isset($message["database"])
);

```

public **offsetUnset** (*mixed* $index)

Menghapus pesan dari daftar

```php
<?php

unset($message["database"]);

```

public **appendMessage** ([Phalcon\Validation\MessageInterface](Phalcon_Validation_MessageInterface) $message)

Menambahkan pesan ke grup

```php
<?php

$messages->appendMessage(
    new \Phalcon\Validation\Message("This is a message")
);

```

public **appendMessages** ([Phalcon\Validation\MessageInterface](Phalcon_Validation_MessageInterface) $messages)

Menambahkan sebuah array dari pesan ke grup

```php
<?php

$messages->appendMessages($messagesArray);

```

public *array* **filter** (*string* $fieldName)

Filter grup pesan dengan nama field

publik **menghitung**()

Mengembalikan jumlah pesan dalam daftar

publik**mundur**()

Melakukan pemutaran balik internal iterator

public **current** ()

Mengembalikan pesan yang sekarang di iterator

publik **kunci** ()

Mengembalikan posisi/kunci saat ini di iterator

publik **berikutnya** ()

Bergerak pointer internal iterasi kepada posisi yang berikut

publik **sah** ()

Periksa apakah pesan yang sekarang di iterator berlaku

public static [Phalcon\Validation\Message\Group](Phalcon_Validation_Message_Group) **__set_state** (*array* $group)

Sihir __set_state membantu untuk membangun kembali pesan variabel saat mengekspor