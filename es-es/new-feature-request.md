* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

# Solicita una nueva funcionalidad

Una NFR (New Feature Request) o solicitud de nueva característica es un pequeño documento explicando cómo debe presentarse, cómo se puede implementar y cómo puede ayudar a los desarrolladores del núcleo y otros a entender como implementarla.

Una NFR contiene: * sintaxis sugerida * sugerencias de nombres de clase y métodos * una breve documentación * si la función ya está implementada en otros frameworks, una breve explicación de como fue implementada y sus ventajas

En los siguientes casos se rechazará una nueva solicitud de funcionalidad: * La función hace el framework más lento * La característica de no ofrece ningún valor adicional al framework * El NFR no es claro, mala documentación, explicación confusa, etcétera. * The NFR doesn't follow the current guidelines/philosophy of the framework * The NFR affects/breaks applications developed in current/older versions of the framework * The original poster doesn't provide feedback/input when requested * It's technically impossible to implement * It can only be used in the development/testing stages * Submitted/proposed classes/components don't follow the [Single Responsibility Principle](https://en.wikipedia.org/wiki/Single_responsibility_principle) * Static methods aren't allowed

Para enviar una NFR no necesita proporcionar el código C, Zephir o desarrollar la función. Las solicitudes de nuevas características explican el objetivo de la aplicación prevista y abren la discusión sobre la mejor manera de implementarla.

Todas las solicitudes deben ser publicadas como un tema nuevo en [Github](https://github.com/phalcon/cphalcon/issues).