---
layout: default
language: 'pl-pl'
version: '4.0'
title: 'Domain'
---

# Domain Component

* * *

The domain component incorporates components that are used for the implementation of the [Action Domain Responder](https://en.wikipedia.org/wiki/Action%E2%80%93domain%E2%80%93responder) ([ADR](http://pmjones.io/adr/)) pattern and can also be used when implementing [Domain Driven Design](https://en.wikipedia.org/wiki/Domain-driven_design).

## Payload

The [Action Domain Responder](https://en.wikipedia.org/wiki/Action%E2%80%93domain%E2%80%93responder) requires a data transfer mechanism between the three layers to serve your application. The [Phalcon\Domain\Payload](Phalcon_Domain##domain-payload-payload) is a data transfer object that is used to send data between the three layers of the pattern.

```php
<?php

use Phalcon\Domain\Payload;

$payload = new Payload();
```

When using this object, you can set its status, the input, the output, any messages or extra information required by each layer of your pattern to be transferred to the next layer that requires it during the application flow. The class itself is a data wrapper that contains the necessary information to be passed between layers.

The properties stored are:

* `extras`: Extra information
* `input`: Input
* `messages`: Messages
* `status`: Status
* `output`: Output

The component offers getters and setters for the above properties.

> All the setters return back a [Phalcon\Domain\Payload](Phalcon_Domain##domain-payload-payload) object, which allows you to chain calls for a more fluent syntax.
{: .alert .alert-info }

## Factory

[Phalcon\Domain\PayloadFactory](Phalcon_Domain##domain-payload-payloadfactory) is also available, offering an easy way to generate new Payload objects.

```php
<?php
use Phalcon\Domain\PayloadFactory;

$payloadFactory = new PayloadFactory();
$payload = $payloadFactory->newInstance();
?>
```

## Interfaces

There are three interfaces that you can take advantage of if you wish to extend the object.

* `ReadableInterface`: contains only read methods
* `WritableInterface`: contains only write methods
* `PayloadInterface`: contains both read and write methods

## Status Values

The [Phalcon\Domain\Payload\Status](Phalcon_Domain##domain-payload-status) class contains several constants to help with the domain status of your Payload objects. You can always extend the class and introduce your own domain statuses, depending on the needs of your application.

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

These statuses can be used at the display/view layer of your application to process domain objects retrieved via `Payload::getOutput()`.

## Przykład

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

## Links

* [Action Domain Responder](https://en.wikipedia.org/wiki/Action%E2%80%93domain%E2%80%93responder)
* [Clarifications to a review of Action Domain Responder](http://paul-m-jones.com/post/2018/12/19/clarifications-to-a-review-of-action-domain-responder/)