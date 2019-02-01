---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Mvc\Controller'
---
# Abstract class **Phalcon\Mvc\Controller**

*extends* abstract class [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

*implements* [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\Mvc\ControllerInterface](Phalcon_Mvc_ControllerInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/controller.zep)

Cada controlador de aplicación debe extender esta clase que encapsula toda la funcionalidad del controlador

El controlador proporciona el "flujo" entre modelos y vistas. Los controladores son responsables de procesar las solicitudes entrantes del navegador web, solicitar información a los modelos y pasar esa información a las vistas para su presentación.

```php
<?php

<?php

class PeopleController extends \Phalcon\Mvc\Controller
{
    // This action will be executed by default
    public function indexAction()
    {

    }

    public function findAction()
    {

    }

    public function saveAction()
    {
        // Forwards flow to the index action
        return $this->dispatcher->forward(
            [
                "controller" => "people",
                "action"     => "index",
            ]
        );
    }
}

```

## Métodos

final public **__construct** ()

Phalcon\Mvc\Controller constructor

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Configura el inyector de dependencia

public **getDI** () inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Devuelve el inyector de dependencias interno

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Establece el gestor de eventos

public **getEventsManager** () inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Devuelve el administrador de eventos interno

public **__get** (*mixed* $propertyName) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Magic method __get