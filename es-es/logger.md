---
layout: default
language: 'es-es'
version: '4.0'
upgrade: '#logger'
category: 'logger'
---
# Componente Registro

* * *

- [Registro](logger-overview)
- [Adaptadores](logger-adapters)
- [Creación del componente de registro](logger-creating)
- [Registro con múltiples adaptadores](logger-multiple)
- [Formato de mensaje](logger-message-formatting) 
    - [Línea](logger-message-formatting-line)
    - [JSON](logger-message-formatting-json)
    - [Syslog](logger-message-formatting-syslog)
    - [Personalizado](logger-message-formatting-custom)
- [Interpolación](logger-interpolation)
- [Ejemplos](logger-examples)

* * *

# Registro

[Phalcon\Logger](api/Phalcon_Logger) es el componente que provee servicios de registro (logging) para aplicaciones con backends y adaptadores diversos. Ofrece también registro de transacciones, opciones de configuración, diferentes formatos y filtros. [Phalcon\Logger](api/Phalcon_Logger) es el componente ideal para cubrir todas las necesidades de registro de la aplicación, desde la depuración de procesos hasta el seguimiento de flujo de la misma.

![](/assets/images/implements-psr--3-orange.svg)

[Phalcon\Logger](api/Phalcon_Logger) ha sido reescrito para cumplir con [PSR-3](https://www.php-fig.org/psr/psr-3/), de tal manera que se puede utilizar con cualquier aplicación que necesite un componente de registro compatible con [PSR-3](https://www.php-fig.org/psr/psr-3/) --incluso sin estar basada en Phalcon.

En Phalcon v3.x el componente trae incorporado el adaptador. Esto en esencia significa que cuando se inicia el objeto de registro, el desarrollador está en realidad creando un adaptador (de archivo, flujo, etc.) con capacidad de registro.

En Phalcon v4 el componente se reescribió de tal manera que se dedica a la función de registro y acepta uno o más adaptadores que serán los responsables de las tareas de registro. Así se logra la compatibilidad con [PSR-3](https://www.php-fig.org/psr/psr-3/), se separan las responsabilidades del componente y se logra la funcionalidad de registro múltiple: fácilmente se puede agregar más de un adaptador al componente, cada uno realizando su propio registro. Con esta implementación se redujo el código del registro y se supimió el componente `Logger\Multiple`.