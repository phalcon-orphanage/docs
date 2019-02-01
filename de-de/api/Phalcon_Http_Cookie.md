---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Http\Cookie'
---
# Class **Phalcon\Http\Cookie**

*implements* [Phalcon\Http\CookieInterface](Phalcon_Http_CookieInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/http/cookie.zep)

Bietet OO Wrapper um ein HTTP-Cookie zu verwalten

## Methoden

public **__construct** (*string* $name, [*mixed* $value], [*int* $expire], [*string* $path], [*boolean* $secure], [*string* $domain], [*boolean* $httpOnly])

Phalcon\Http\Cookie constructor

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Sets the dependency injector

public **getDI** ()

Returns the internal dependency injector

public [Phalcon\Http\Cookie](Phalcon_Http_Cookie) **setValue** (*string* $value)

Setzt den Cookie-Wert

public *mixed* **getValue** ([*string* | *array* $filters], [*string* $defaultValue])

Gibt den Cookie-Wert zurück

public **send** ()

Sendet das Cookie an den HTTP-Client Speichert die Cookie-Definition in der Session

public **restore** ()

Liest die Cookie-bezogenen Informationen aus dem SESSION um das Cookie wiederherzustellen, wie es war Da diese Methode automatisch intern aufgerufen wird, muss man sie also normalerweise nicht aufrufen

public **delete** ()

Löscht das Cookie indem ein Ablaufdatum in der Vergangenheit gesetzt wird

public **setSignKey** (*string* $signKey = null): [Phalcon\Http\CookieInterface](Phalcon_Http_CookieInterface)

Sets the cookie's sign key. The `$signKey` MUST be at least 32 characters long and generated using a cryptographically secure pseudo random generator.

You can use `null` to disable cookie signing.

See: [Phalcon\Security\Random](Phalcon_Security_Random) Throws: [Phalcon\Http\Cookie\Exception](Phalcon_Http_Cookie_Exception)

public **useEncryption** (*mixed* $useEncryption)

Legt fest, ob das Cookie automatisch verschlüsselt/entschlüsselt sein muss

public **isUsingEncryption** ()

Prüft, ob das Cookie implizite Verschlüsselung verwendet

public **setExpiration** (*mixed* $expire)

Setzt die Cookie Ablaufzeit

public **getExpiration** ()

Gibt die Cookie Ablaufzeit zurück

public **setPath** (*mixed* $path)

Setzt die Cookie Ablaufzeit

public **getName** ()

Gibt den aktuellen Cookie Namen zurück

public **getPath** ()

Gibt den aktuellen Cookie Pfad zurück

public **setDomain** (*mixed* $domain)

Setzt die Domäne, der das Cookie zur Verfügung steht

public **getDomain** ()

Gibt die Domäne zurück, der das Cookie zur Verfügung steht

public **setSecure** (*mixed* $secure)

Legt fest, ob das Cookie nur gesendet werden muss, wenn die Verbindung sicher (HTTPS) ist

public **getSecure** ()

Gibt zurück, ob das Cookie nur gesendet werden muss, wenn die Verbindung sicher (HTTPS) ist

public **setHttpOnly** (*mixed* $httpOnly)

Legt fest, ob auf das Cookie nur über das HTTP-Protokoll zugegriffen werden kann

public **getHttpOnly** ()

Gibt zurück, ob auf das Cookie nur über das HTTP-Protokoll zugegriffen werden kann

public **__toString** ()

Magische __toString-Methode konvertiert den Cookie-Wert in in eine Zeichenkette