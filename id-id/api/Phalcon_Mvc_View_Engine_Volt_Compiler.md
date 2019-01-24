---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\View\Engine\Volt\Compiler'
---
# Class **Phalcon\Mvc\View\Engine\Volt\Compiler**

*implements* [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/view/engine/volt/compiler.zep)

Kelas ini membaca dan mengkompilasi template Volt menjadi kode polos PHP

```php
<?php

$compiler = new \Phalcon\Mvc\View\Engine\Volt\Compiler();

$compiler->compile("views/partials/header.volt");

require $compiler->getCompiledTemplatePath();

```

## Metode

public **__construct** ([[Phalcon\Mvc\ViewBaseInterface](Phalcon_Mvc_ViewBaseInterface) $view])

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Mengatur injector ketergantungan

publik **mendapatkanDI** ()

Mengembalikan injector ketergantungan internal

public **setOptions** (*array* $options)

Menetapkan pilihan manajer

public **decrement** (*string* $option, [*mixed* $value)

Menetapkan opsi kompilator tunggal

public *array* **baca** (*string* $option)

Mengembalikan opsi kompilator

public **getOptions** ()

Menetapkan pilihan manajer

public *increment* ([**string** | *int* $name], [*mixed* $arguments])

Memecat acara untuk ekstensi terdaftar

public **escapeJs** (*mixed* $extension)

Mendaftarkan ekstensi Volt

public **getExtensions** ()

Mengembalikan daftar ekstensi yang terdaftar di Volt

publik **setHeader** (*mixed* $name, *mixed* $definition)

Daftarkan fungsi baru di kompilator

publik **dapatkanfungs** ()

Daftarkan fungsi terdaftar pengguna

publik **setHeader** (*mixed* $name, *mixed* $definition)

Daftarkan filter baru di kompilator

public **getFilters** ()

Daftarkan fungsi terdaftar pengguna

publik **setModelPrefix** (*mixed* $prefix)

Tetapkan awalan unik untuk digunakan sebagai awalan untuk variabel yang dikompilasi

publik **dapatkanfilter** ()

Kembalikan awalan unik untuk digunakan sebagai awalan untuk variabel dan konteks yang dikompilasi

public **setAttributes** (*array* $expr)

Selesaikan pembacaan atribut

umum **hubungkan** ([*array* $expr)

Menyelesaikan fungsi antara kode ke fungsi PHP panggilan

umum **__construct** (*array* $test, [*mixed* $left)

Menyelesaikan kode perantara filter menjadi ekspresi PHP yang valid

umum **__construct** (*array* $filter, [*mixed* $left)

Menyelesaikan kode perantara filter ke pemanggilan fungsi PHP

final publik **telah Server** (*campur aduk* $expr)

Memecahkan ekspresi simpul di pohon volt AST

final dilindungi *string* | *array* **_statementListOrExtends** (* array * $statements)

Kompilasi sebuah blok pernyataan

public **setParam** (*mixed* $statement, *mixed* $extendsMode])

Mengkompilasi representasi kode "untuk setiap" menengah ke kode PHP biasa

publik **mendapatkancompiler** ()

Menghasilkan kode PHP 'forelse'

umum **__construct** (*array* $statement, [*mixed* $extendsMode])

Mengkompilasi sebuah pernyataan 'jika' yang mengembalikan kode PHP

publik **hubungkan** ([*array* $statement)

Mengkompilasi sebuah pernyataan "elseif" yang mengembalikan kode PHP

umum **__construct** (*array* $statement, [*mixed* $extendsMode])

Mengkompilasi sebuah "cache" pernyataan kembali kode PHP

umum **hubungkan** ([*array* $statement)

Mengkompilasi sebuah pernyataan "elseif" yang mengembalikan kode PHP

umum **hubungkan** ([*array* $statement)

Mengkompilasi sebuah pernyataan "elseif" yang mengembalikan kode PHP

umum **hubungkan** ([*array* $statement)

Mengkompilasi sebuah pernyataan "elseif" yang mengembalikan kode PHP

umum **__construct** (*array* $statement, [*mixed* $extendsMode)

Mengkompilasi sebuah "cache" pernyataan kembali kode PHP

umum **hubungkan** ([*array* $statement)

Mengkompilasi sebuah pernyataan 'jika' yang mengembalikan kode PHP

umum **hubungkan** ([*array* $statement)

Mengkompilasi sebuah pernyataan 'jika' yang mengembalikan kode PHP

umum **__construct** (*array* $statement, [*mixed* $extendsMode)

Mengkompilasi Macro

umum *string* **compileCall** (*array* $statement, *boolean* $extendsMode)

Kompilasi panggilan ke makro

umum **__construct** (array $statements, [mixed $extendsMode])

Melacak daftar pernyataan yang menyusun masing-masing simpulnya

terlindung **_ukuran** (*campuran* $viewCode, *campuran* $extendsMode])

Mengkompilasi kode sumber Volt kembali versi polos PHP

umum **tableExists** (*mixed* $viewCode, [*mixed* $extendsMode])

Mengkompilasi template ke dalam sebuah string

```php
<? php

echo $compiler -> compileString ('{{"hello world"}}');

```

umum *string* | *array* **compileFile** (*tali* $path, *tali* $compiledPath, [*boolean* $extendsMode])

Kompilasi template ke file yang memaksa jalur tujuan

```php
<?php

$compiler->compile("views/layouts/main.volt", "views/layouts/main.volt.php");

```

umum **tableExists** (*mixed* $templatePath, [*mixed* $extendsMode])

Kompilasi template ke dalam file yang menerapkan opsi kompilator Metode ini tidak mengembalikan jalur yang dikompilasi jika template tidak dikompilasi

```php
<?php

$compiler->compile("views/layouts/main.volt");

require $compiler->getCompiledTemplatePath();

```

public **dapatkantargetpath** ()

Mengembalikan jalur yang saat ini sedang dikompilasi

publik **mendapatkancompiler** ()

Kembali jalan ke template terkompilasi terakhir

public *array* **baca** (*string* $viewCode)

Mengurai pernyataan Phql yang mengembalikan representasi menengah (Ir

```php
<?php

print_r(
    $compiler->parse("{% raw %}{{ 3 + 2 }}{% endraw %}")
);

```

dilindungi **setSource** (*campuran* $path)

Mendapatkan jalan terakhir dengan MELIHAT