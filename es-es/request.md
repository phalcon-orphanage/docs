---
layout: article
language: 'es-es'
version: '4.0'
category: 'request'
---
# Componente de Petición HTTP

* * *

# Entorno de Consulta

Cada petición HTTP (normalmente originada por un navegador) contiene información adicional sobre la petición, tal como datos de cabecera, archivos, variables, etcétera. Una aplicación basada en web necesita analizar esa información para realizar una acción particular y enviar la respuesta correcta al solicitante. [Phalcon\Http\Request](api/Phalcon_Http_Request) encapsula la información de la solicitud en un objeto de valor simple.

```php
<?php

use Phalcon\Http\Request;

// Obteniendo una instancia de la consulta
$request = new Request();

// Comprobar que la consulta este hecha por el método POST
if (true === $request->isPost()) {
    // Comprobar si la consulta esta hecha con Ajax
    if (true === $request->isAjax()) {
        echo 'La consulta fue hecha utilizando POST y AJAX';
    }
}
```

- [Obteniendo Valores](request-getting-values)
- [Sanitizadores pre establecidos](request-preset-sanitizers)
- [Accediendo a la Consulta desde los Controladores](request-controller-access)
- [Comprobando operaciones](request-checking-operations)
- [Información sobre la solicitud](request-information)
- [Inyección de Dependencias](request-di)
- [Trabajando con Cabeceras](request-working-with-headers)
- [Subiendo Archivos](request-uploading-files)
- [Eventos](request-events)