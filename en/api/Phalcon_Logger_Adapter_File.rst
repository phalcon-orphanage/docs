Class **Phalcon\Logger\Adapter\File**
=====================================

*extends* :doc:`Phalcon\\Logger <Phalcon_Logger>`

Constants
---------

integer **SPECIAL**

integer **CUSTOM**

integer **DEBUG**

integer **INFO**

integer **NOTICE**

integer **WARNING**

integer **ERROR**

integer **ALERT**

integer **CRITICAL**

integer **EMERGENCE**

Methods
---------

public **__construct** (*unknown* $name, *unknown* $options)

public **setFormat** (*unknown* $format)

public **getFormat** ()

public **getTypeString** (*unknown* $type)

protected **_applyFormat** ()

public **setDateFormat** (*unknown* $date)

public **getDateFormat** ()

public **log** (*unknown* $message, *unknown* $type)

public **begin** ()

public **commit** ()

public **rollback** ()

public **close** ()

public **__wakeup** ()

public **debug** (*unknown* $message)

public **error** (*unknown* $message)

public **info** (*unknown* $message)

public **notice** (*unknown* $message)

public **warning** (*unknown* $message)

public **alert** (*unknown* $message)

