---
layout: default
title: 'Domain'
keywords: 'domain, adr, payload, dominio'
---

# Domain
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

> In future versions of Phalcon, this component will be reworked to follow the [Payload Interop][payload-interop] interface. 
> 
> {: .alert .alert-warning }

The domain component incorporates components that are used for the implementation of the [Action Domain Responder][adr] ([ADR][adr-jones]) pattern and can also be used when implementing [Domain Driven Design][ddd].

## Carga útil
The [Action Domain Responder][adr] requires a data transfer mechanism between the three layers to serve your application. The [Phalcon\Domain\Payload][payload-payload] is a data transfer object that is used to send data between the three layers of the pattern.

```php
<?php

use Phalcon\Domain\Payload;

$payload = new Payload();
```

Al usar este objeto, puede establecer su estado, la entrada, la salida, cualquier mensaje o información adicional requerida por cada capa de su patrón para ser transferida a la siguiente capa que lo requiere durante el flujo de la aplicación. La clase en sí misma es un envoltorio de datos que contiene la información necesaria para ser pasada entre capas.

Las propiedades almacenadas son:

| Propiedad  | Descripción       |
| ---------- | ----------------- |
| `extras`   | Extra information |
| `input`    | Entrada           |
| `messages` | Messages          |
| `status`   | Estado            |
| `output`   | Salida            |

El componente ofrece *getters* y *setters* para las propiedades anteriores.

> **NOTE**: All the setters return a [Phalcon\Domain\Payload][payload-payload] object, which allows you to chain calls for a more fluent syntax. 
> 
> {: .alert .alert-info }

## Fábrica (Factory)
[Phalcon\Domain\PayloadFactory][payload-payloadfactory] is also available, offering an easy way to generate new Payload objects.

```php
<?php
use Phalcon\Domain\PayloadFactory;

$payloadFactory = new PayloadFactory();
$payload = $payloadFactory->newInstance();
?>
```

## Interfaces
Hay tres interfaces que se pueden aprovechar si se desea ampliar el objeto.

| Interface           | Descripción                          |
| ------------------- | ------------------------------------ |
| `ReadableInterface` | contains only read methods           |
| `WritableInterface` | contains only write methods          |
| `PayloadInterface`  | contains both read and write methods |

## Valores de estado
The [Phalcon\Domain\Payload\Status][payload-status] class contains several constants to help with the domain status of your Payload objects. Siempre puede extender la clase e introducir sus propios estados de dominio, dependiendo de las necesidades de su aplicación.

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

* [Respondedor de dominio de acción][adr]
* [Aclaraciones a una revisión de Action Domain Responder][adr-clarifications]
* [Payload Interop][payload-interop]


[adr]: https://en.wikipedia.org/wiki/Action%E2%80%93domain%E2%80%93responder


[adr]: https://en.wikipedia.org/wiki/Action%E2%80%93domain%E2%80%93responder
[adr-jones]: http://pmjones.io/adr/
[adr-clarifications]: http://paul-m-jones.com/post/2018/12/19/clarifications-to-a-review-of-action-domain-responder/
[ddd]: https://en.wikipedia.org/wiki/Domain-driven_design
[payload-interop]: https://github.com/payload-interop/payload-interop
[payload-payload]: api/phalcon_domain#domain-payload-payload
[payload-payloadfactory]: api/phalcon_domain#domain-payload-payloadfactory
[payload-status]: api/phalcon_domain#domain-payload-status
