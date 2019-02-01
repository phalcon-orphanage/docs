---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Cli\RouterInterface'
---
# Interface **Phalcon\Cli\RouterInterface**

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cli/routerinterface.zep)

## Métodos

abstract public **setDefaultModule** (*mixed* $moduleName)

...

publico abstracto**establecer la tarea predeterminada**(*mezclado*$taskName)

...

abstract public **setDefaultAction** (*mixed* $actionName)

...

abstract public **setDefaults** (*array* $defaults)

...

abstract public **handle** ([*mixed* $arguments])

...

abstract public **add** (*mixed* $pattern, [*mixed* $paths])

...

abstract public **getModuleName** ()

...

publico abstracto**obtener el nombre de la tarea**()

...

abstract public **getActionName** ()

...

abstract public **getParams** ()

...

abstract public **getMatchedRoute** ()

...

abstract public **getMatches** ()

...

abstract public **wasMatched** ()

...

abstract public **getRoutes** ()

...

abstract public **getRouteById** (*mixed* $id)

...

abstract public **getRouteByName** (*mixed* $name)

...