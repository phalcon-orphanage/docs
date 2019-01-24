---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\View'
---
# Class **Phalcon\Mvc\View**

*extends* abstract class [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

*implements* [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\Mvc\ViewInterface](Phalcon_Mvc_ViewInterface), [Phalcon\Mvc\ViewBaseInterface](Phalcon_Mvc_ViewBaseInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/view.zep)

Phalcon\Mvc\View is a class for working with the "view" portion of the model-view-controller pattern. Artinya, ada untuk membantu menjaga agar skrip tampilan tidak terpisah dari skrip model dan pengontrol. Ini menyediakan sistem pembantu, filter output, dan variabel yang lolos.

```php
<? php

menggunakan Phalcon\Mvc\View;

$view = new View();

Pengaturan pemandangan direktori
$view -> setViewsDir("app/views/");

$view -> start();

Menunjukkan Lihat posting kemarin (app/views/posts/recent.phtml)
$view -> render ("posts", "baru");
$view -> finish();

Mencetak output dilihat
echo $view -> getContent ();

```

## Constants

*bilangan bulat* **MODELS_DATE_AT**

*bilangan bulat* **MODELS_DATE_AT**

*bilangan bulat* **FETCH_LAZY**

*bilangan bulat* **MODELS_DATE_AT**

* bilangan bulat </ 0> ** TYPE_INTEGER </ 1></p> 

* bilangan bulat </ 0> ** TYPE_INTEGER </ 1></p> 

*bilangan bulat* **OP_NONE**

* bilangan bulat * ** DENY **

## Metode

public **getReader** ()

...

public **getReader** ()

...

publik **dapatkanfilter** ()

umum **__membangun** ([*array* $options])

Phalcon\Mvc\View constructor

terlindung **_memutar** (*campuran* $path)

Memeriksa apakah jalan itu mutlak atau tidak

publik **mendapatkan Server** (*campur aduk* $viewsDir)

Sets the views directory. Depending of your platform, always add a trailing slash or backslash

public **getFilter** ()

Gets dilihat direktori

abstrak publik **setLayoutsDir** (*mixed* $layoutsDir)

Sets the layouts sub-directory. Must be a directory under the views directory. Depending of your platform, always add a trailing slash or backslash

```php
<?php

$view->setLayoutsDir("../common/layouts/");

```

umum **getActiveRole** ()

Mendapatkan sub-direktori layout saat ini

abstrak publik **setPartialsDir** (*mixed* $partialsDir)

Sets a partials sub-directory. Must be a directory under the views directory. Depending of your platform, always add a trailing slash or backslash

```php
<?php

$view->setPartialsDir("../common/partials/");

```

umum **getActiveRole** ()

Mendapatkan sub-direktori partial saat ini

public **setBasePath** (*mixed* $basePath)

Sets base path. Depending of your platform, always add a trailing slash or backslash

```php
<?php

    $view->setBasePath(__DIR__ . "/");

```

public **getBasePath** ()

Mendapatkan jalur dasar

abstrak publik **setRenderLevel** (*mixed* $level)

Menetapkan tingkat render untuk tampilan

```php
<? php

Membuat tampilan yang berkaitan dengan controller hanya
$this -> Tampilan -> setRenderLevel ()
View::LEVEL_LAYOUT
);

```

public **disableLevel** (*mixed* $level)

Menonaktifkan tingkat rendering tertentu

```php
<? php

Membuat semua tingkat kecuali tingkat tindakan
$this -> Tampilan -> disableLevel ()
View::LEVEL_ACTION_VIEW
);

```

abstrak publik **setMainView** (*mixed* $viewPath)

Sets default view name. Must be a file without extension in the views directory

```php
<?php

// Renders as main view views-dir/base.phtml
$this->view->setMainView("base");

```

publik **mendapatkancompiler** ()

Mengembalikan nama tampilan utama

public **setLayout** (*mixed* $layout)

Ubah tata letak yang akan digunakan alih-alih menggunakan nama nama pengontrol terbaru

```php
<?php

$this->view->setLayout("main");

```

public **getLayout** ()

Mengembalikan nama tampilan utama

abstrak publik **setTemplateBefore** (*mixed* $templateBefore)

Menetapkan template sebelum layout controller

abstrak publik **cleanTemplateBefore** ()

Menyetel ulang template sebelum tata letak

abstrak publik **setTemplateBefore** (*mixed* $templateAfter)

Menetapkan template sebelum layout controller

public **cleanTemplateAfter** ()

Menyetel ulang template sebelum tata letak

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

public **getParamsToView** ()

Mengembalikan parameter untuk dilihat

public **getControllerName** ()

Mendapat nama pengontrol yang diberikan

publik **dapatkanNamaAksi** ()

Mendapat nama pengontrol yang diberikan

umum **getParams** ()

Mendapatkan parameter tambahan dari tindakan yang diberikan

publik ** mulai ** ()

Mulai proses rendering yang memungkinkan buffering output

dilindungi (**_loadTemplateEngines**)

Loads registered template engines, if none is registered it will use Phalcon\Mvc\View\Engine\Php

protected **_engineRender** (*array* $engines, *string* $viewPath, *boolean* $silence, *boolean* $mustClean, [[Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface) $cache])

Memeriksa apakah tampilan ada pada ekstensi terdaftar dan memberikannya

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

umum **membaca** (*campuran* $view)

Cek apakah ada Lihat

public **__construct** (*string* $controllerName, [*boolean* $actionName], [*array* $params])

Jalankan proses render dari pengiriman data online

```php
<? php

Menunjukkan Lihat posting kemarin (app/views/posts/recent.phtml)
$view -> start() - > render ("posts", "baru") -> finish();

```

publik **telah**(*campuraduk*$renderView)

Choose a different view to render instead of last-controller/last-action

```php
<?php

use Phalcon\Mvc\Controller;

class ProductsController extends Controller
{
   public function saveAction()
   {
        // Do some save stuff...

        // Then show the list view
        $this->view->pick("products/list");
   }
}

```

umum **tableExists** (*mixed* $partialPath, [*mixed* $params])

Memberikan sebagian tampilan

```php
<? php

Mengambil isi dari parsial
echo $this -> getPartial("shared/footer");

```

```php
<?php

// Retrieve the contents of a partial with arguments
echo $this->getPartial(
    "shared/footer",
    [
        "content" => $html,
    ]
);

```

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

umum *array* **fetchAll** (*string* $controllerName, [*int* $actionName], [*array* $params], [*array* $configCallback])

Melakukan terjemahan otomatis kembali output sebagai string

```php
<?php

$template = $this->view->getRender(
    "products",
    "show",
    [
        "products" => $products,
    ]
);

```

publik**mundur**()

Selesaikan proses render dengan menghentikan buffering output

dilindungi (**getEventsManager**)

Create a Phalcon\Cache based on the internal cache options

publik **mulai** ()

Periksa apakah komponen saat ini caching konten output

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

publik **setContent** (*mixed* $content)

Eksternal menetapkan konten tampilan

```php
<? php$this -> Tampilan -> setContent ("<h1>Halo</h1>");

```

public ** getContent </ 0> ()</p> 

Mengembalikan hasil cache dari tahap tampilan yang lain

publik ** getLifetime </ 0> ()</p> 

Kembali jalan (atau jalur) pandangan yang saat ini diberikan

publik **mulai** ()

Menonaktifkan proses auto-rendering

publik **mulai** ()

Menonaktifkan proses auto-rendering

umum **reset** ()

Mengatur ulang komponen tampilan ke nilai standar pabriknya

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

publik **mulai** ()

Apakah rendering otomatis diaktifkan

publik **menyaring** (*campur * $key)

Metode magister untuk mengambil jika variabel diatur dalam tampilan

```php
<?php

echo isset($this->view->products);

```

dilindungi (**getEventsManager**)

Gets dilihat direktori

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Mengatur injector ketergantungan

public **getDI** () inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Mengembalikan injector ketergantungan internal

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Menyetel pengelola acara

public **getEventsManager** () inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Mengembalikan manajer acara internal