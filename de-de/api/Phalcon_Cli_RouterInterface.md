---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Cli\RouterInterface'
---
# Interface **Phalcon\Cli\RouterInterface**

[Source on Github](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cli/routerinterface.zep)

## Methods

abstract public **setDefaultModule** (*mixed* $moduleName)

...

abstract public **setDefaultTask** (*mixed* $taskName)

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

abstract public **getTaskName** ()

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