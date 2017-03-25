Class **Phalcon\\Mvc\\Model\\Binder**
=====================================

*implements* :doc:`Phalcon\\Mvc\\Model\\BinderInterface <Phalcon_Mvc_Model_BinderInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/model/binder.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Phalcon\\Mvc\\Model\\Binding

This is an class for binding models into params for handler


Methods
-------

public  **getBoundModels** ()

Array for storing active bound models



public  **getOriginalValues** ()

Array for original values



public  **__construct** ([:doc:`Phalcon\\Cache\\BackendInterface <Phalcon_Cache_BackendInterface>` $cache])

Phalcon\\Mvc\\Model\\Binder constructor



public  **setCache** (:doc:`Phalcon\\Cache\\BackendInterface <Phalcon_Cache_BackendInterface>` $cache)

Gets cache instance



public  **getCache** ()

Sets cache instance



public  **bindToHandler** (*mixed* $handler, *array* $params, *mixed* $cacheKey, [*mixed* $methodName])

Bind models into params in proper handler



protected  **getParamsFromCache** (*mixed* $cacheKey)

Get params classes from cache by key



protected  **getParamsFromReflection** (*mixed* $handler, *array* $params, *mixed* $cacheKey, *mixed* $methodName)

Get modified params for handler using reflection



