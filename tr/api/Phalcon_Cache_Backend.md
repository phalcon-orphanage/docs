# Abstract class **Phalcon\\Cache\\Backend**

*uygulamalar* [Phalcon\Önbellek\Arkayüz Ara birimi](/en/3.2/api/Phalcon_Cache_BackendInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/cache/backend.zep" class="btn btn-default btn-sm">Source on GitHub</a>

This class implements common functionality for backend adapters. A backend cache adapter may extend this class

## Methods

herkese açık **Önyüz al** ()

...

herkese açık **Önyüz ayarla** (*karışık* $başlangıç aşaması)

...

herkese açık **Seçenekleri al** ()

...

herkese açık **Seçenekleri ayarla** (*karışık* $seçenekler)

...

herkese açık **Son Anahtarı al** ()

...

herkese açık **Son Anahtarı ayarla** (*karışık* $Son Anahtar)

...

herkese açık **__düzenle** ([Phalcon\Önbellek\Önyüz Ara birimi](/en/3.2/api/Phalcon_Cache_FrontendInterface) $başlangıç aşaması, [*dizi* $seçenekler])

Phalcon\\Önbellek\\Arkayüz oluşturucu

herkese açık *karışık* **başlat** (*int* | *dizi* $anahtar Adı, [*int* $ömür])

Starts a cache. The keyname allows to identify the created fragment

herkese açık **durdur** ([*karışık* $Ara belleği durdur])

Stops the frontend without store any cached content

herkese açık **Taze** ()

Checks whether the last cache is fresh or cached

herkese açık **Başladı** ()

Checks whether the cache has starting buffering or not

herkese açık *int* **ömür süresi** ()

Gets the last lifetime set

abstract public **get** (*mixed* $keyName, [*mixed* $lifetime]) inherited from [Phalcon\Cache\BackendInterface](/en/3.2/api/Phalcon_Cache_BackendInterface)

...

abstract public **save** ([*mixed* $keyName], [*mixed* $content], [*mixed* $lifetime], [*mixed* $stopBuffer]) inherited from [Phalcon\Cache\BackendInterface](/en/3.2/api/Phalcon_Cache_BackendInterface)

...

abstract public **delete** (*mixed* $keyName) inherited from [Phalcon\Cache\BackendInterface](/en/3.2/api/Phalcon_Cache_BackendInterface)

...

abstract public **queryKeys** ([*mixed* $prefix]) inherited from [Phalcon\Cache\BackendInterface](/en/3.2/api/Phalcon_Cache_BackendInterface)

...

abstract public **exists** ([*mixed* $keyName], [*mixed* $lifetime]) inherited from [Phalcon\Cache\BackendInterface](/en/3.2/api/Phalcon_Cache_BackendInterface)

...