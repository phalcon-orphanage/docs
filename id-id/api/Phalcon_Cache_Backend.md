---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Cache\Backend'
---
# Abstract class **Phalcon\Cache\Backend**

*implements* [Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/backend.zep)

This class implements common functionality for backend adapters. A backend cache adapter may extend this class

## Metode

publik ** getFrontend </ 0> ()</p> 

...

public ** setFrontend </ 0> (* mixed </ 1> $ frontend)</p> 

...

public **getOptions** ()

...

public ** setOptions </ 0> (* mixed </ 1> $ options)</p> 

...

publik ** getLastKey </ 0> ()</p> 

...

publik ** setLastKey </ 0> ( * campuran </ 1> $ lastKey )</p> 

...

public **__construct** ([Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface) $frontend, [*array* $options])

Phalcon\Cache\Backend constructor

public * mixed </ 0> ** mulai </ 1> ( * int </ 0> | * string </ 0> $ keyName , [ * int </ 0> $ lifetime ] )</p> 

Starts a cache. The keyname allows to identify the created fragment

publik **berhenti** ([*campuran* $Buffer berhenti])

Menghentikan frontend tanpa menyimpan konten dalam cache

publik ** isFresh </ 0> ()</p> 

Memeriksa apakah cache terakhir masih segar atau di-cache

publik **dimulai** ()

Memeriksa apakah cache sudah mulai buffering atau tidak

public * int </ 0> ** getLifetime </ 1> ()</p> 

Dapat di set seumur hidup

abstract public **get** (*mixed* $keyName, [*mixed* $lifetime]) inherited from [Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface)

...

abstract public **save** ([*mixed* $keyName], [*mixed* $content], [*mixed* $lifetime], [*mixed* $stopBuffer]) inherited from [Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface)

...

abstract public **delete** (*mixed* $keyName) inherited from [Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface)

...

abstract public **queryKeys** ([*mixed* $prefix]) inherited from [Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface)

...

abstract public **exists** ([*mixed* $keyName], [*mixed* $lifetime]) inherited from [Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface)

...