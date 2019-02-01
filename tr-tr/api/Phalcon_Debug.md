---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Debug'
---
# Class **Phalcon\Debug**

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/debug.zep)

Provides debug capabilities to Phalcon applications

## Metodlar

public **setUri** (*mixed* $uri)

Change the base URI for static resources

public **setShowBackTrace** (*mixed* $showBackTrace)

Sets if files the exception's backtrace must be showed

public **setShowFiles** (*mixed* $showFiles)

Dosyanın arka izinin bir kısmıbın çıkışta gösterilmesi için ayarlayın

public **setShowFileFragment** (*mixed* $showFileFragment)

Dosyaların tamamen açılması gerekip gerekmediğini veya çıktıda gösterilip gösterilmeyeceğini veya sadece istisna ile ilgili parçaların gösterdiğini ayarlar

public **listen** ([*mixed* $exceptions], [*mixed* $lowSeverity])

Yakalanmayan istisnaları, usulsüz bildirimleri veya uyarıları dinleyin

public **listenExceptions** ()

Listen for uncaught exceptions

public **listenLowSeverity** ()

Listen for unsilent notices or warnings

public **reset** ()

Halts the request showing a backtrace

public **debugVar** (*mixed* $varz, [*mixed* $key])

Tamir Etme çıktısına bir değişken ekler

public **clearVars** ()

Önceden eklenen değişkenleri temizleme

protected **_escapeString** (*mixed* $value)

Escapes a string with htmlentities

protected **_getArrayDump** (*array* $argument, [*mixed* $n])

Bir dizilimin tekrarlanan temsilini üretir

protected **_getVarDump** (*mixed* $variable)

Bir değişkenin bir dizi temsilini üretir

public **getMajorVersion** ()

Returns the major framework's version

public **getVersion** ()

Geçerli sürüm belgelerine bir bağlantı oluşturur

public **getCssSources** ()

Css kaynaklarını döndürür

public **getJsSources** ()

Javascript kaynaklarını döndürür

final protected **showTraceItem** (*mixed* $n, *array* $trace)

Shows a backtrace item

public **onUncaughtLowSeverity** (*mixed* $severity, *mixed* $message, *mixed* $file, *mixed* $line, *mixed* $context)

Throws an exception when a notice or warning is raised

public **onUncaughtException** ([Exception](https://php.net/manual/en/class.exception.php) $exception)

Yakalanmayan istisnaları işler