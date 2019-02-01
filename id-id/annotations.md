---
layout: article
language: 'id-id'
version: '4.0'
---
**This article reflects v3.4 and has not yet been revised**

<a name='overview'></a>

# Parser Anotasi

It is the first time that an annotations parser component is written in C for the PHP world. `Phalcon\Annotations` is a general purpose component that provides ease of parsing and caching annotations in PHP classes to be used in applications.

Annotations are read from docblocks in classes, methods and properties. An annotation can be placed at any position in the docblock:

```php
& lt;? php / ** * Ini adalah deskripsi kelas * * @AmazingClass (true) * / class Example {/ ** * Ini properti dengan fitur khusus * * @SpecialFeature * / protected $ someProperty; / ** * Ini adalah metode * * @SpecialFeature * / fungsi umum someMethod () {// ...
    }}
```

An annotation has the following syntax:

```php
/ ** * @ Anotasi-Nama * @ Anotasi-Nama (param1, param2, ...) * /
```

Also, an annotation can be placed at any part of a docblock:

```php
<php
/ **
  * Ini properti dengan fitur spesial
  * Komentar lebih lanjut
  *
  * @SpecialFeature ({someParameter = 'nilai', salah})
  * @AnotherSpecialFeature (benar)
  * /
```

The parser is highly flexible, the following docblock is valid:

```php
<? php / ** * ini sebuah properti dengan fitur khusus @SpecialFeature ({someParameter = 'nilai', palsu}) Komentar lebih @AnotherSpecialFeature(true) @MoreAnnotations ** /
```

However, to make the code more maintainable and understandable it is recommended to place annotations at the end of the docblock:

```php
<php
/ **
  * Ini properti dengan fitur spesial
  * Komentar lebih lanjut
  *
  * @SpecialFeature ({someParameter = 'nilai', salah})
  * @AnotherSpecialFeature (benar)
  * /
```

<a name='factory'></a>

## Pabrik

There are many annotations adapters available (see [Adapters](#adapters)). Yang Anda gunakan akan tergantung pada kebutuhan aplikasi Anda. The traditional way of instantiating such an adapter is as follows:

```php
<? php menggunakan Phalcon\Annotations\Adapter\Memory sebagai MemoryAdapter; $reader = new MemoryAdapter(); // .....
```

However you can also utilize the factory method to achieve the same thing:

```php
<? php menggunakan Phalcon\Annotations\Factory;$options = ['prefix' = > 'penjelasan', 'hidup' = > '3600', 'adaptor' = > 'memori', / / Load adaptor memori]; $annotations = Factory::load($options);
```

The Factory loader provides more flexibility when dealing with instantiating annotations adapters from configuration files.

<a name='reading'></a>

## Membaca anotasi

A reflector is implemented to easily get the annotations defined on a class using an object-oriented interface:

```php
<? php menggunakan Phalcon\Annotations\Adapter\Memory sebagai MemoryAdapter;$reader = new MemoryAdapter();  Mencerminkan anotasi di kelas contoh$reflector = $reader -> get('Example');  Membaca penjelasan dalam kelas docblock$annotations = $reflector -> getClassAnnotations();  Melintasi anotasi foreach ($annotations sebagai $annotation) {/ / cetak anotasi nama echo $annotation -> getName(), PHP_EOL;      Cetak jumlah argumen echo $annotation -> numberArguments(), PHP_EOL;      Mencetak argumen print_r ($annotation -> getArguments()); }
```

The annotation reading process is very fast, however, for performance reasons it is recommended to store the parsed annotations using an adapter. Adapters cache the processed annotations avoiding the need of parse the annotations again and again.

[Phalcon\Annotations\Adapter\Memory](api/Phalcon_Annotations_Adapter_Memory) was used in the above example. This adapter only caches the annotations while the request is running and for this reason the adapter is more suitable for development. There are other adapters to swap out when the application is in production stage.

<a name='types'></a>

## Jenis anotasi

Annotations may have parameters or not. A parameter could be a simple literal (strings, number, boolean, null), an array, a hashed list or other annotation:

```php
<? php / ** * penjelasan sederhana ** @SomeAnnotation * / / ** * anotasi dengan parameter ** @SomeAnnotation ('Halo', 'dunia', 1, 2, 3, palsu, benar) * / / ** * anotasi dengan nama parameter ** @SomeAnnotation (pertama = 'Halo', kedua = 'dunia', ketiga = 1) * @SomeAn notasi (pertama: 'Halo', kedua: 'dunia', ketiga: 1) * / / ** * lewat sebuah array ** @SomeAnnotation ([1, 2, 3, 4]) * @SomeAnnotation ({1, 2, 3, 4}) * / / ** * melewati hash sebagai parameter ** @SomeAnnotation ({pertama = 1, kedua = 2, ketiga = 3}) * @SomeAnnotation ({'pertama' = 1, yang econd'= 2, 'ketiga' = 3}) * @SomeAnnotation({'first': 1, 'second': 2, 'third': 3}) * @SomeAnnotation (['pertama': 1, 'kedua': 2, 'ketiga': 3]) * / / ** * bersarang array hash ** @SomeAnnotation ({'name' = 'SomeName', 'lainnya' = {* 'foo1': 'bar1', 'foo2': 'bar2', {1, 2, 3}, *}}) * / / ** * Bersarang anotasi ** @SomeAnnotation (first=@AnotherAnnotation (1, 2, 3)) * /
```

<a name='usage'></a>

## Penggunaan praktis

Next we will explain some practical examples of annotations in PHP applications:

<a name='usage-cache'></a>

### Cache Enabler dengan Anotasi

Let's pretend we've created the following controller and you want to create a plugin that automatically starts the cache if the last action executed is marked as cacheable. First off all, we register a plugin in the Dispatcher service to be notified when a route is executed:

```php
// Lampirkan plugin ke acara 'pengiriman'
    $ eventsManager- & gt; attach (
        'pengiriman',
        CacheEnablerPlugin baru ()
    );

    $ dispatcher = new MvcDispatcher ();

    $ dispatcher- & gt; setEventsManager ($ eventsManager);

    kembali $ dispatcher;
};
```

`CacheEnablerPlugin` is a plugin that intercepts every action executed in the dispatcher enabling the cache if needed:

```php
& lt;? php

gunakan Phalcon \ Events \ Event;
gunakan Phalcon \ Mvc \ Dispatcher;
gunakan Phalcon \ Mvc \ User \ Plugin;

/ **
 * Mengaktifkan cache untuk tampilan jika yang terbaru
 * Tindakan yang dieksekusi memiliki anotasi @Cache
 * /
kelas CacheEnablerPlugin memperluas Plugin
{
    / **
     * Acara ini dijalankan sebelum setiap rute dijalankan di petugas operator
     * /
    fungsi publik sebelumExecuteRoute (event $ event, Dispatcher $ dispatcher)
    {
        // Parsel anotasi pada metode yang saat ini dijalankan
        $ anotasi = $ this- & gt; anotasi- & gt; getMethod (
            $ dispatcher- & gt; getControllerClass (),
            $ dispatcher- & gt; getActiveMethod ()
        );

        // Periksa apakah metode memiliki anotasi 'Cache'
        jika ($ anotasi- & gt; memiliki ('Cache')) {
            // Metode ini memiliki anotasi 'Cache'
            $ anotasi = $ anotasi- & gt; dapatkan ('Cache');

            // dapatkan seumur hidup
            $ lifetime = $ anotasi- & gt; getNamedParameter ('lifetime');

            $ options = [
                'lifetime' = & gt; $ seumur hidup,
            ];

            // Periksa apakah ada kunci cache yang ditentukan pengguna
            jika ($ anotasi- & gt; hasNamedParameter ('kunci')) {
                $ options ['key'] = $ anotasi- & gt; getNamedParameter ('key');
            }

            // Aktifkan cache untuk metode saat ini
            $ this- & gt; view- & gt; cache ($ options);
        }
    }
}
```

Now, we can use the annotation in a controller:

```php
& lt;? php

gunakan Phalcon \ Mvc \ Controller;

kelas NewsController memperluas Controller
{
    fungsi publik indexAction ()
    {

    }

    / **
     * Ini adalah sebuah komentar
     *
     * @Cache (seumur hidup = 86400)
     * /
    showAllAction fungsi publik ()
    {
        $ this- & gt; view- & gt; article = Articles :: find ();
    }

    / **
     * Ini adalah sebuah komentar
     *
     * @Cache (key = 'my-key', lifetime = 86400)
     * /
    showAction fungsi publik ($ siput)
    {
        $ this- & gt; view- & gt; article = Articles :: findFirstByTitle ($ siput);
    }
}
```

<a name='usage-access-management'></a>

### Private/Public areas with Annotations

You can use annotations to tell the ACL which controllers belong to the administrative areas:

```php
& lt;? php

gunakan Phalcon \ Acl;
gunakan Phalcon \ Acl \ Role;
gunakan Phalcon \ Acl \ Resource;
gunakan Phalcon \ Events \ Event;
gunakan Phalcon \ Mvc \ User \ Plugin;
gunakan Phalcon \ Mvc \ Dispatcher;
gunakan Phalcon \ Acl \ Adapter \ Memory as AclList;

/ **
 * Ini adalah plugin keamanan yang mengontrol bahwa pengguna hanya memiliki akses ke modul yang ditugaskan untuk mereka
 * /
kelas SecurityAnnotationsPlugin memperluas Plugin
{
    / **
     * Tindakan ini dijalankan sebelum melakukan tindakan apapun dalam aplikasi
     *
     * @param Event $ event
     * @param Dispatcher $ dispatcher
     *
     * @return bool
     * /
    fungsi publik beforeDispatch (event $ event, Dispatcher $ dispatcher)
    {
        // Kemungkinan nama kelas pengendali
        $ controllerName = $ dispatcher- & gt; getControllerClass ();

        // nama metode yang mungkin
        $ actionName = $ dispatcher- & gt; getActiveMethod ();

        // Dapatkan anotasi di kelas pengontrol
        $ anotasi = $ this- & gt; anotasi- & gt; get ($ controllerName);

        // Pengendali itu bersifat pribadi?
 
Konteks | Permintaan Konteks?
        jika ($ anotasi- & gt; getClassAnnotations () - & gt; have ('Pribadi')) {
            // Periksa apakah variabel sesi aktif?
 
Konteks | Permintaan Konteks?
            jika (! $ this- & gt; session- & gt; get ('auth')) {

                // Pengguna tidak login redirect untuk login
                $ dispatcher- & gt; forward (
                    [
                        'controller' = & gt; 'sidang',
                        'action' = & gt; 'masuk',
                    ]
                );

                kembali salah;
            }
        }

        // Lanjutkan normal
        kembali benar;
    }
}
 
Konteks | Permintaan Konteks
```

<a name='adapters'></a>

## Anotasi Adaptor

This component makes use of adapters to cache or no cache the parsed and processed annotations thus improving the performance or providing facilities to development/testing:

| Kelas                                                                       | Deskripsi                                                                                                                                                                         |
| --------------------------------------------------------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| [Phalcon\Anotasi\Adaptor\Memori](api/Phalcon_Annotations_Adapter_Memory) | The annotations are cached only in memory. When the request ends the cache is cleaned reloading the annotations in each request. This adapter is suitable for a development stage |
| [Phalcon\Anotasi\Adaptor\Files](api/Phalcon_Annotations_Adapter_Files)   | Parsed and processed annotations are stored permanently in PHP files improving performance. This adapter must be used together with a bytecode cache.                             |
| [Phalcon\Anotasi\Adaptor\Apc](api/Phalcon_Annotations_Adapter_Apc)       | Parsed and processed annotations are stored permanently in the APC cache improving performance. This is the faster adapter                                                        |
| [Phalcon\Anotasi\Adaptor\Xcache](api/Phalcon_Annotations_Adapter_Xcache) | Parsed and processed annotations are stored permanently in the XCache cache improving performance. This is a fast adapter too                                                     |

<a name='adapters-custom'></a>

### Menerapkan adapter Anda sendiri

The [Phalcon\Annotations\AdapterInterface](api/Phalcon_Annotations_AdapterInterface) interface must be implemented in order to create your own annotations adapters or extend the existing ones.

<a name='resources'></a>

## Sumber Eksternal

* [Tutorial: Membuat initializer model khusus dengan Anotasi](https://blog.phalconphp.com/post/tutorial-creating-a-custom-models-initializer)