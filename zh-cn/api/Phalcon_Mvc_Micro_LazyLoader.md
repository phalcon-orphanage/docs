* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Mvc\Micro\LazyLoader'

* * *

# Class **Phalcon\Mvc\Micro\LazyLoader**

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/mvc/micro/lazyloader.zep" class="btn btn-default btn-sm">源码在GitHub</a>

Lazy-Load of handlers for Mvc\Micro using auto-loading

## 方法

public **getDefinition** ()

...

public **__construct** (*mixed* $definition)

Phalcon\Mvc\Micro\LazyLoader constructor

public *mixed* **__call** (*string* $method, *array* $arguments)

Initializes the internal handler, calling functions on it

public *mixed* **callMethod** (*string* $method, *array* $arguments, [[Phalcon\Mvc\Model\BinderInterface](Phalcon_Mvc_Model_BinderInterface) $modelBinder])

Calling __call method