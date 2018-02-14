# Interface **Phalcon\\Mvc\\Model\\CriteriaInterface**

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/model/criteriainterface.zep" class="btn btn-default btn-sm">Source on GitHub</a>

## Methods
abstract public  **setModelName** (*mixed* $modelName)

...

abstract public  **getModelName** ()

...

abstract public  **bind** (*array* $bindParams)

...

abstract public  **bindTypes** (*array* $bindTypes)

...

abstract public  **where** (*mixed* $conditions)

...

abstract public  **conditions** (*mixed* $conditions)

...

abstract public  **orderBy** (*mixed* $orderColumns)

...

abstract public  **limit** (*mixed* $limit, [*mixed* $offset])

...

abstract public  **forUpdate** ([*mixed* $forUpdate])

...

abstract public  **sharedLock** ([*mixed* $sharedLock])

...

abstract public  **andWhere** (*mixed* $conditions, [*mixed* $bindParams], [*mixed* $bindTypes])

...

abstract public  **orWhere** (*mixed* $conditions, [*mixed* $bindParams], [*mixed* $bindTypes])

...

abstract public  **betweenWhere** (*mixed* $expr, *mixed* $minimum, *mixed* $maximum)

...

abstract public  **notBetweenWhere** (*mixed* $expr, *mixed* $minimum, *mixed* $maximum)

...

abstract public  **inWhere** (*mixed* $expr, *array* $values)

...

abstract public  **notInWhere** (*mixed* $expr, *array* $values)

...

abstract public  **getWhere** ()

...

abstract public  **getConditions** ()

...

abstract public  **getLimit** ()

...

abstract public  **getOrderBy** ()

...

abstract public  **getParams** ()

...

abstract public  **execute** ()

...

