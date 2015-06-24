Interface **Phalcon\\Mvc\\Model\\CriteriaInterface**
====================================================

Methods
-------

abstract public  **setModelName** (*unknown* $modelName)

...


abstract public  **getModelName** ()

...


abstract public  **bind** (*unknown* $bindParams)

...


abstract public  **bindTypes** (*unknown* $bindTypes)

...


abstract public  **where** (*unknown* $conditions)

...


abstract public  **conditions** (*unknown* $conditions)

...


abstract public  **orderBy** (*unknown* $orderColumns)

...


abstract public  **limit** (*unknown* $limit, [*unknown* $offset])

...


abstract public  **forUpdate** ([*unknown* $forUpdate])

...


abstract public  **sharedLock** ([*unknown* $sharedLock])

...


abstract public  **andWhere** (*unknown* $conditions, [*unknown* $bindParams], [*unknown* $bindTypes])

...


abstract public  **orWhere** (*unknown* $conditions, [*unknown* $bindParams], [*unknown* $bindTypes])

...


abstract public  **betweenWhere** (*unknown* $expr, *unknown* $minimum, *unknown* $maximum)

...


abstract public  **notBetweenWhere** (*unknown* $expr, *unknown* $minimum, *unknown* $maximum)

...


abstract public  **inWhere** (*unknown* $expr, *unknown* $values)

...


abstract public  **notInWhere** (*unknown* $expr, *unknown* $values)

...


abstract public  **getWhere** ()

...


abstract public  **getConditions** ()

...


abstract public  **getLimit** ()

...


abstract public  **getOrder** ()

...


abstract public  **getParams** ()

...


abstract public static  **fromInput** (*unknown* $dependencyInjector, *unknown* $modelName, *unknown* $data)

...


abstract public  **execute** ()

...


