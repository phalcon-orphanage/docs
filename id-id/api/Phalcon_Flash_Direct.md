---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Flash\Direct'
---
# Class **Phalcon\Flash\Direct**

*extends* abstract class [Phalcon\Flash](Phalcon_Flash)

*implements* [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\FlashInterface](Phalcon_FlashInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/flash/direct.zep)

This is a variant of the Phalcon\Flash that immediately outputs any message passed to it

## Metode

publik **pesan** (*campur aduk* $type, *campur aduk* $message)

Keluarkan sebuah pesan

publik **keluaran** ([*campur aduk* $remove])

Mencetak pesan yang terakumulasi dalam flasher

public **__construct** ([*mixed* $cssClasses]) inherited from [Phalcon\Flash](Phalcon_Flash)

Phalcon\Flash constructor

public **getAutoescape** () inherited from [Phalcon\Flash](Phalcon_Flash)

Mengembalikan mode autoescape dalam html yang dihasilkan

public **setAutoescape** (*mixed* $autoescape) inherited from [Phalcon\Flash](Phalcon_Flash)

Atur mode autoescape di html yang dihasilkan

public **getEscaperService** () inherited from [Phalcon\Flash](Phalcon_Flash)

Mengembalikan Layanan Escaper

public **setEscaperService** ([Phalcon\EscaperInterface](Phalcon_EscaperInterface) $escaperService) inherited from [Phalcon\Flash](Phalcon_Flash)

Mengatur Layanan Escaper

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Flash](Phalcon_Flash)

Mengatur injector ketergantungan

public **getDI** () inherited from [Phalcon\Flash](Phalcon_Flash)

Mengembalikan injector ketergantungan internal

public **setImplicitFlush** (*mixed* $implicitFlush) inherited from [Phalcon\Flash](Phalcon_Flash)

Tetapkan apakah keluaran harus secara implisit memerah ke keluaran atau dikembalikan sebagai tali

public **setAutomaticHtml** (*mixed* $automaticHtml) inherited from [Phalcon\Flash](Phalcon_Flash)

Tetapkan apakah keluaran harus diformat secara implisit dengan HTML

public **setCssClasses** (*array* $cssClasses) inherited from [Phalcon\Flash](Phalcon_Flash)

Tetapkan sebuah array dengan kelas CSS untuk memformat pesan

public **error** (*mixed* $message) inherited from [Phalcon\Flash](Phalcon_Flash)

Menunjukkan pesan kesalahan HTML

```php
<?php

$flash->error("This is an error");

```

public **notice** (*mixed* $message) inherited from [Phalcon\Flash](Phalcon_Flash)

Menunjukkan pesan pemberitahuan/informasi HTML

```php
<?php

$flash->notice("This is an information");

```

public **success** (*mixed* $message) inherited from [Phalcon\Flash](Phalcon_Flash)

Menunjukkan pesan sukses HTML

```php
<?php

$flash->success("The process was finished successfully");

```

public **warning** (*mixed* $message) inherited from [Phalcon\Flash](Phalcon_Flash)

Menunjukkan pesan peringatan HTML

```php
<?php

$flash->warning("Hey, this is important");

```

public *string* | *void* **outputMessage** (*mixed* $type, *string* | *array* $message) inherited from [Phalcon\Flash](Phalcon_Flash)

Keluarkan pesan yang memformatnya dengan HTML

```php
<?php

$flash->outputMessage("error", $message);

```

public **clear** () inherited from [Phalcon\Flash](Phalcon_Flash)

Menghapus pesan akumulasi bila disiram secara implisit dinonaktifkan