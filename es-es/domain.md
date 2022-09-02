---
layout: default
language: 'es-es'
version: '4.0'
title: 'Domain'
keywords: 'domain, adr, payload, dominio'
---

# Dominio *(Domain)*

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

El componente de dominio incorpora componentes que se utilizan para la implementación del patrón [Respondedor de Dominio de Acción](https://en.wikipedia.org/wiki/Action%E2%80%93domain%E2%80%93responder) ([ADR](http://pmjones.io/adr/)) y también se pueden usar al implementar [Diseño Dirigido por Dominio](https://en.wikipedia.org/wiki/Domain-driven_design).

## Carga útil

El [Respondedor de Dominio de Acción](https://en.wikipedia.org/wiki/Action%E2%80%93domain%E2%80%93responder) requiere un mecanismo de transferencia de datos entre las tres capas para servir su aplicación. El [Phalcon\Domain\Payload](api/phalcon_domain#domain-payload-payload) es un objeto de transferencia de datos que se utiliza para enviar datos entre las tres capas del patrón.

```php
<?php

use Phalcon\Domain\Payload;

$payload = new Payload();
```

Al usar este objeto, puede establecer su estado, la entrada, la salida, cualquier mensaje o información adicional requerida por cada capa de su patrón para ser transferida a la siguiente capa que lo requiere durante el flujo de la aplicación. La clase en sí misma es un envoltorio de datos que contiene la información necesaria para ser pasada entre capas.

Las propiedades almacenadas son:

* `extras`: Información extra
* `input`: Entrada
* `messages`: Mensajes
* `status`: Estado
* `output`: Salida

El componente ofrece *getters* y *setters* para las propiedades anteriores.

> **NOTA**: Todos los *setters* regresan un objeto [Phalcon\Domain\Payload](api/phalcon_domain#domain-payload-payload), que te permite encadenar llamadas para una sintaxis más fluida.
{: .alert .alert-info }

## Fábrica *(Factory)*

También está disponible [Phalcon\Domain\PayloadFactory](api/phalcon_domain#domain-payload-payloadfactory), ofreciendo una forma fácil de generar nuevos objetos de Payload.

```php
<?php
use Phalcon\Domain\PayloadFactory;

$payloadFactory = new PayloadFactory();
$payload = $payloadFactory->newInstance();
?>
```

## Interfaces

Hay tres interfaces que se pueden aprovechar si se desea ampliar el objeto.

* `ReadableInterface`: contiene solo métodos de lectura
* `WritableInterface`: contiene solo métodos de escritura
* `PayloadInterface`: contiene ambos métodos de escritura y lectura

## Valores de estado

La clase [Phalcon\Domain\Payload\Status](api/phalcon_domain#domain-payload-status) contiene varias constantes para ayudar con el estado de dominio de tus objetos de Payload. Siempre puede extender la clase e introducir sus propios estados de dominio, dependiendo de las necesidades de su aplicación.

* `ACCEPTED` 
* `AUTHENTICATED` 
* `AUTHORIZED` 
* `CREATED` 
* `DELETED` 
* `ERROR` 
* `FAILURE` 
* `FOUND` 
* `NOT_ACCEPTED` 
* `NOT_AUTHENTICATED`
* `NOT_AUTHORIZED` 
* `NOT_CREATED` 
* `NOT_DELETED` 
* `NOT_FOUND` 
* `NOT_UPDATED` 
* `NOT_VALID` 
* `PROCESSING` 
* `SUCCESS` 
* `UPDATED` 
* `VALID` 

Estos estados pueden ser usados en la capa de visualización/vista de su aplicación para procesar los objetos de dominio recuperados a través de `Payload::getOutput()`.

## Ejemplo

```php
<?php

use Application\Models\Reports;
use Phalcon\Domain\PayloadFactory;
use Phalcon\Domain\Payload\Status;
use Phalcon\Mvc\Controller;

class ReportsController extends Controller
{
    public function viewAction(int $reportId)
    {
        $factory = new PayloadFactory();
        $payload = $factory->newInstance();

        $report = Reports::find(
            [
                'conditions' => 'reportId = :reportId:',
                'bind'       => [
                    'reportId' => $reportId,
                 ],
            ]          
        );

        if (false === $report) {
            $payload
                ->setStatus(Status::NOT_FOUND)
                ->setInput(func_get_args())
            ;
        } else {
            $payload
                ->setStatus(Status::FOUND)
                ->setOutput($report)
            ;
        }

        return $payload;
    }
}   
```

## Enlaces

* [Respondedor de dominio de acción](https://en.wikipedia.org/wiki/Action%E2%80%93domain%E2%80%93responder)
* [Aclaraciones a una revisión de Action Domain Responder](http://paul-m-jones.com/post/2018/12/19/clarifications-to-a-review-of-action-domain-responder/)
