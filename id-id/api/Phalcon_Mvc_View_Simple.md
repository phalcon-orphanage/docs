---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\View\Simple'
---
# Class **Phalcon\Mvc\View\Simple**

*extends* abstract class [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

*implements* [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\Mvc\ViewBaseInterface](Phalcon_Mvc_ViewBaseInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/view/simple.zep)

Komponen ini memungkinkan untuk menampilkan tampilan tampa tingkat hirarkis

```php
<?php

use Phalcon\Mvc\View\Simple as View;

$view = new View();

// Render a view
echo $view->render(
    "templates/my-view",
    [
        "some" => $param,
    ]
);

// Or with filename with extension
echo $view->render(
    "templates/my-view.volt",
    [
        "parameter" => $here,
    ]
);

```

## Metode

publik **dapatkanfilter** ()

umum **__membangun** ([*array* $options])

Phalcon\Mvc\View\Simple constructor

publik **mendapatkan Server** (*campur aduk* $viewsDir)

Sets views directory. Depending of your platform, always add a trailing slash or backslash

public **getFilter** ()

Gets dilihat direktori

publik **mengaturatribut** (*array* $engines)

Mendaftar mesin template

```php
<?php

$this->view->registerEngines(
    [
        ".phtml" => "Phalcon\Mvc\View\Engine\Php",
        ".volt"  => "Phalcon\Mvc\View\Engine\Volt",
        ".mhtml" => "MyCustomEngine",
    ]
);

```

dilindungi (**_loadTemplateEngines**)

Loads registered template engines, if none is registered it will use Phalcon\Mvc\View\Engine\Php

akhir dilindungi **_mergeFindParameters** (*campur aduk* $path, *campur aduk* $params)

Mencoba untuk membuat tampilan dengan setiap mesin yang terdaftar dalam komponen

abstrak publik **tableExists** (*mixed* $path, [*mixed* $params])

Memberikan sebuah tampilan

publik **dapatkan** (*campuran* $partialPath, [*mixed* $params])

Memberikan sebagian tampilan

```php
<? php

Tampilkan parsial dalam pandangan lain
$this -> partial("shared/footer");

```

```php
<? php

Tampilkan parsial dalam pandangan lain dengan parameter
$this -> (parsial
"bersama/footer",
[
"konten" = > $html,
]
);

```

public **setParams ** (*array *$options)

Mengatur pilihan cache

publiK *array* **dapatkanPertandingan** ()

Mengembalikan pilihan cache

dilindungi (**getEventsManager**)

Create a Phalcon\Cache based on the internal cache options

public **getCache** ()

Mengembalikan contoh cache yang digunakan untuk cache

publik **menyaring** (*campur * $options])

Cache tampilan aktual ke tingkat tertentu

```php
<?php

$this->view->cache(
    [
        "key"      => "my-key",
        "lifetime" => 86400,
    ]
);

```

public **setParamToView** (*mixed* $key, *mixed* $value)

Menambahkan parameter ke tampilan (alias setVar)

```php
<?php

$this->view->setParamToView("products", $products);

```

public **setParam** (*mixed* $params, *mixed* $merge])

Tetapkan semua params render

```php
<?php

$this->view->setVars(
    [
        "products" => $products,
    ]
);

```

public **setVar** (*mixed* $key, *mixed* $value)

Tetapkan parameter tampilan tunggal

```php
<?php

$this->view->setVar("products", $products);

```

public **getVar** (*mixed* $key)

Mengembalikan parameter yang telah ditetapkan sebelumnya pada tampilan

publik *array* **MendapatkanParams** ()

Mengembalikan parameter untuk dilihat

publik **setContent** (*mixed* $content)

Eksternal menetapkan konten tampilan

```php
<? php$this -> Tampilan -> setContent ("<h1>Halo</h1>");

```

public ** getContent </ 0> ()</p> 

Mengembalikan hasil cache dari tahap tampilan yang lain

public *string* **getActiveRenderPath** ()

Kembali jalan (atau jalur) pandangan yang saat ini diberikan

publik **setHeader** (*mixed* $key, *mixed* $value)

Metode sihir untuk melewatkan variabel ke tampilan

```php
<?php

$this->view->products = $products;

```

publik **baca** (*mixed* $key)

Metode sihir untuk mengambil variabel dilewatkan ke tampilan

```php
<?php

echo $this->view->products;

```

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Mengatur injector ketergantungan

public **getDI** () inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Mengembalikan injector ketergantungan internal

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Menyetel pengelola acara

public **getEventsManager** () inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Mengembalikan manajer acara internal