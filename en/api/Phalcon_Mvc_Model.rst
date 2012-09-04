Class **Phalcon\Mvc\Model**
===========================

*implements* Serializable

Constants
---------

integer **OP_CREATE**

integer **OP_UPDATE**

integer **OP_DELETE**

Methods
---------

final public **__construct** (*unknown* $dependencyInjector, *unknown* $managerService, *unknown* $dbService)

public **setDI** (*unknown* $dependencyInjector)

public **getDI** ()

public **setEventsManager** (*unknown* $eventsManager)

public **getEventsManager** ()

protected static **_createSQLSelect** ()

protected static **_getOrCreateResultset** ()

public **setTransaction** (*unknown* $transaction)

protected **setSource** ()

public **getSource** ()

protected **setSchema** ()

public **getSchema** ()

public **setConnectionService** (*unknown* $connectionService)

public **getConnectionService** ()

public **setForceExists** (*unknown* $forceExists)

public **getConnection** ()

public static **dumpResult** (*unknown* $base, *unknown* $result)

public static **find** (*unknown* $parameters)

public static **findFirst** (*unknown* $parameters)

protected **_exists** ()

protected static **_prepareGroupResult** ()

protected static **_getGroupResult** ()

public static **count** (*unknown* $parameters)

public static **sum** (*unknown* $parameters)

public static **maximum** (*unknown* $parameters)

public static **minimum** (*unknown* $parameters)

public static **average** (*unknown* $parameters)

protected **_callEvent** ()

protected **_callEventCancel** ()

protected **_cancelOperation** ()

public **appendMessage** (*unknown* $message)

protected **validate** ()

public **validationHasFailed** ()

public **getMessages** ()

protected **_checkForeignKeys** ()

protected **_checkForeignKeysReverse** ()

protected **_preSave** ()

protected **_postSave** ()

protected **_doLowInsert** ()

protected **_doLowUpdate** ()

public **save** ()

public **create** ()

public **update** ()

public **delete** ()

public **readAttribute** (*unknown* $attribute)

public **writeAttribute** (*unknown* $attribute, *unknown* $value)

protected **hasOne** ()

protected **belongsTo** ()

protected **hasMany** ()

protected **__getRelatedRecords** ()

public **__call** (*unknown* $method, *unknown* $arguments)

public **serialize** ()

public **unserialize** (*unknown* $data)

