---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Flash'
---
# Abstract class **Phalcon\Flash**

*implements* [Phalcon\FlashInterface](Phalcon_FlashInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/flash.zep)

Shows HTML notifications related to different circumstances. Classes can be stylized using CSS

```php
<?php

$flash->success("The record was successfully deleted");
$flash->error("Cannot open the file");

```

## Metode

publik **__construct** (*mixed* $cssClasses])

Phalcon\Flash constructor

public **getLocal** ()

Mengembalikan mode autoescape dalam html yang dihasilkan

publik **Mengubahakhirankelaskontrol** (*bercampur* $autoescape)

Atur mode autoescape di html yang dihasilkan

publik ** getLifetime </ 0> ()</p> 

Mengembalikan Layanan Escaper

public **setEscaperService** ([Phalcon\EscaperInterface](Phalcon_EscaperInterface) $escaperService)

Mengatur Layanan Escaper

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Mengatur injector ketergantungan

publik **mendapatkanDI** ()

Mengembalikan injector ketergantungan internal

public **useImplicitOutput** (*mixed* $implicitFlush)

Tetapkan apakah keluaran harus secara implisit memerah ke keluaran atau dikembalikan sebagai tali

public **escapeHtml** (*mixed* $automaticHtml)

Tetapkan apakah keluaran harus diformat secara implisit dengan HTML

public **setParams ** (*array *$cssClasses)

Tetapkan sebuah array dengan kelas CSS untuk memformat pesan

publik **menyaring** (*campur * $message)

Menunjukkan pesan kesalahan HTML

```php
<?php

$flash->error("This is an error");

```

publik **menangani** ([*bercampur* $message)

Menunjukkan pesan pemberitahuan/informasi HTML

```php
<?php

$flash->notice("This is an information");

```

public **success** (*mixed* $message)

Menunjukkan pesan sukses HTML

```php
<?php

$flash->success("The process was finished successfully");

```

publik **menangani** ([*bercampur* $message)

Menunjukkan pesan peringatan HTML

```php
<?php

$flash->warning("Hey, this is important");

```

public *string* | *void* **outputMessage** (*mixed* $type, *string* | *array* $message)

Keluarkan pesan yang memformatnya dengan HTML

```php
<?php

$flash->outputMessage("error", $message);

```

publik **jelas** ()

Menghapus pesan akumulasi bila disiram secara implisit dinonaktifkan

abstract public **message** (*mixed* $type, *mixed* $message) inherited from [Phalcon\FlashInterface](Phalcon_FlashInterface)

...