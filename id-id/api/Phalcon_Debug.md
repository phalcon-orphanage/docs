---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Debug'
---
# Class **Phalcon\Debug**

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/debug.zep)

Menyediakan kemampuan debug untuk aplikasi Phalcon

## Metode

umum **setUri** (*campuran* $uri)

Perubahan mendasar URI ke sumber daya statis

umum **setShowBackTrace** (*campuran* $showBackTrace)

Mengatur jika file pengecualian backtrace harus muncul

umum **setShowFiles** (*campuran* $showFiles)

Mengatur jika bagian file dari backtrace harus di tunjukkan dalam output

umum **setShowFileFragment** (*campuran* $showFileFragment)

Mengatur jika file harus benar terbuka dan menunjukkan dalam output atau hanya fragmen yang terkait untuk pengecualian

public **listen** ([*mixed* $exceptions], [*mixed* $lowSeverity])

Dengarkan untuk pengecualian tidak tertangkap dan pemberitahuan tidak diam atau peringatan

public **listenExceptions** ()

Dengarkan untuk pengecualian tidak tertangkap

public **listenLowSeverity** ()

Dengarkan untuk pemberitahuan tidak diam atau peringatan

public **halt** ()

Menghentikan permintaan yang menunjukkan backtrace

public **debugVar** (*mixed* $varz, [*mixed* $key])

Menambahkan sebuah variabel dalam output debug

public **clearVars** ()

Membersikan variabel yang ditambahkan sebelumnya

protected **_escapeString** (*mixed* $value)

Melepaskan sebuah string dengan htmlentities

protected **_getArrayDump** (*array* $argument, [*mixed* $n])

Menciptakan sebuah pernyataan rekursif dari sebuah susunan

protected **_getVarDump** (*mixed* $variable)

Menciptakan sebuah pernyataan string dari sebuah variabel

public **getMajorVersion** ()

Mengembalikan versi kerangka kerja utama

public **getVersion** ()

Menghasilkan sebuah link untuk dokumentasi versi saat ini

public **getCssSources** ()

Mengembalikan sumbernya css

public **getJsSources** ()

Mengembalikan sumbernya javascript

final protected **showTraceItem** (*mixed* $n, *array* $trace)

Menampilkan sebuah item backtrace

public **onUncaughtLowSeverity** (*mixed* $severity, *mixed* $message, *mixed* $file, *mixed* $line, *mixed* $context)

Melemparkan sebuah pengecualian ketika sebuah pemberitahuan atau peringatan di ajukan

public **onUncaughtException** ([Exception](https://php.net/manual/en/class.exception.php) $exception)

Menangani pengecualian tidak tertangkap