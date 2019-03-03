---
layout: article
language: 'es-es'
version: '4.0'
upgrade: '#logger'
category: 'logger'
---
# Componente Registro

* * *

## Crear un registro

La creación de un registro se hace en varios pasos. Primero, se crea un objeto de registro y, segundo, se incluye un adaptador. Cumplidos estos pasos, se pueden empezar a registar mensajes según las necesidades de la aplicación.

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

$adapter = new Stream('/logs/application.log');
$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$logger->error('Algo falló');
```

En este ejemplo se crea un adaptador [Stream](api/Phalcon_Logger_Adapter_Stream). Luego se crea un objeto de registro y se le adjunta el adaptador. Cada adaptador debe tener un nombre único, de tal manera que el registro sepa dónde guardar los mensajes. Cuando se llama el método `error` en el objeto de registro, el mensaje será almacenado en `/logs/application.log`.

Dado que el componente de registro implementa PSR-3, los siguientes métodos están disponibles:

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

$adapter = new Stream('/logs/application.log');
$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$logger->alert("Este es un mensaje de alerta");
$logger->critical("Este es un mensaje de alerta crítica");
$logger->debug("Este es un mensaje de depuración");
$logger->error("Este es un mensaje de error");
$logger->emergency("Este es un mensaje de emergencia");
$logger->info("Este es un mensaje de información");
$logger->log(Logger::CRITICAL, "Este es un mensaje de registro");
$logger->notice("Este es un mensaje informativo");
$logger->warning("Este es un mensaje de advertencia");

```

El resultado de los anteriores mensajes registrados es:

```bash
[Tue, 25 Dec 18 12:13:14 -0400][ALERT] Este es un mensaje de alerta
[Tue, 25 Dec 18 12:13:14 -0400][CRITICAL] Este es un mensaje de alerta crítica
[Tue, 25 Dec 18 12:13:14 -0400][DEBUG] Este es un mensaje de depuración
[Tue, 25 Dec 18 12:13:14 -0400][ERROR] Este es un mensaje de error
[Tue, 25 Dec 18 12:13:14 -0400][EMERGENCY] Este es un mensaje de emergencia
[Tue, 25 Dec 18 12:13:14 -0400][INFO] Este es un mensaje de información
[Tue, 25 Dec 18 12:13:14 -0400][CRITICAL] Este es un mensaje de registro
[Tue, 25 Dec 18 12:13:14 -0400][NOTICE] Este es un mensaje informativo
[Tue, 25 Dec 18 12:13:14 -0400][WARNING] Este es un mensaje de advertencia
```