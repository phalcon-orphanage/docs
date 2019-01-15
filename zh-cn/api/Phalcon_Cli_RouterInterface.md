* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Cli\RouterInterface'

* * *

# Interface **Phalcon\Cli\RouterInterface**

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/cli/routerinterface.zep" class="btn btn-default btn-sm">源码在GitHub</a>

## 方法

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