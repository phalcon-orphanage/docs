---
layout: default
language: 'uk-ua'
version: '4.0'
title: 'Phalcon\Mvc\Router\GroupInterface'
---
# Interface **Phalcon\Mvc\Router\GroupInterface**

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/router/groupinterface.zep)

## Methods

abstract public **setHostname** (*mixed* $hostname)

...

abstract public **getHostname** ()

...

abstract public **setPrefix** (*mixed* $prefix)

...

abstract public **getPrefix** ()

...

abstract public **beforeMatch** (*mixed* $beforeMatch)

...

abstract public **getBeforeMatch** ()

...

abstract public **setPaths** (*mixed* $paths)

...

abstract public **getPaths** ()

...

abstract public **getRoutes** ()

...

abstract public **add** (*mixed* $pattern, [*mixed* $paths], [*mixed* $httpMethods])

...

abstract public **addGet** (*mixed* $pattern, [*mixed* $paths])

...

abstract public **addPost** (*mixed* $pattern, [*mixed* $paths])

...

abstract public **addPut** (*mixed* $pattern, [*mixed* $paths])

...

abstract public **addPatch** (*mixed* $pattern, [*mixed* $paths])

...

abstract public **addDelete** (*mixed* $pattern, [*mixed* $paths])

...

abstract public **addOptions** (*mixed* $pattern, [*mixed* $paths])

...

abstract public **addHead** (*mixed* $pattern, [*mixed* $paths])

...

abstract public **clear** ()

...