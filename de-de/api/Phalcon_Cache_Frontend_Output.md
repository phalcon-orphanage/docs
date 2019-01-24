---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Cache\Frontend\Output'
---
# Class **Phalcon\Cache\Frontend\Output**

*implements* [Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface)

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/frontend/output.zep)

Ermöglicht das Zwischenspeichern der Ausgabe Fragmente mit Ob_ * Funktionen

```php <?php

* * use Phalcon\Tag; * use Phalcon\Cache\Backend\File; * use Phalcon\Cache\Frontend\Output; * * // Erzeuge ein Ausgabe Frontend. Die Dateien für 2 Tage cachen * $frontCache = new Output( * [ * "lifetime" => 172800, * ] * ); * * // Erzeugt eine Komponente, welche vom "Output" an ein "File" backend cached * // Setzt das Cache Verzeichnis fest - es ist wichtig das abschleßende "/" am Ende * // zu behalten * $cache = new File( * $frontCache, * [ * "cacheDir" => "../app/cache/", * ] * ); * * // Holen/Setzen der Cache Datei von ../app/cache/my-cache.html * $content = $cache->start("my-cache.html"); * * // Wenn $content null ist wird der Inhalt für den cache generiert * if (null === $content) { * // Datum und Zeit ausgeben * echo date("r"); * * // Generate a link to the sign-up action * echo Tag::linkTo( * [ * "user/signup", * "Sign Up", * "class" => "signup-button", * ] * ); * * // Die Ausgabe in der Cache Datei speichern * $cache->save(); * } else { * // Die gecachte Ausgabe anzeigen * echo $content; * }

*```

## Methoden

public **__construct** ([*array* $frontendOptions])

Phalcon\Cache\Frontend\Output constructor

public **getLifetime** ()

Liefert die Cache-Lebensdauer

public **isBuffering** ()

Prüft, ob das Frontend Ausgaben puffert

public **start** ()

Starts output frontend. Currently, does nothing

public *string* **getContent** ()

Liefert einen zwischengespeicherten Inhalt

public **stop** ()

Stoppt die Frontend Ausgabe

public **beforeStore** (*mixed* $data)

Serialisiert Daten vor dem Speichern

public **afterRetrieve** (*mixed* $data)

Unserializes Daten nach der Entnahme