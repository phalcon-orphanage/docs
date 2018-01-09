# Solicita una nueva funcionalidad

Una NFR (New Feature Request) es un pequeño documento explicando cómo debe presentarse una nueva solicitud de función, cómo se puede implementar y cómo puede ayudar a los desarrolladores del núcleo y otros entender como implementarla.

A NFR contains:

* Suggested syntax
* Suggested class names and methods
* A short documentation
* If the feature is already implemented in other frameworks, a short explanation of how that was implemented and its advantages

In the following cases a new feature request will be rejected:

* The feature makes the framework slow
* The feature doesn't provide any additional value to the framework
* The NFR is not clear, bad documentation, unclear explanation, etc.
* The NFR doesn't follow the current guidelines/philosophy of the framework
* The NFR affects/breaks applications developed in current/older versions of the framework
* The original poster doesn't provide feedback/input when requested
* It's technically impossible to implement
* It can only be used in the development/testing stages
* Submitted/proposed classes/components don't follow the [Single Responsibility Principle](http://en.wikipedia.org/wiki/Single_responsibility_principle)
* Static methods aren't allowed

Para enviar una NFR no necesita proporcionar el código C, Zephir o desarrollar la función. Nuevas solicitudes de Funcionalidad explican el objetivo de la aplicación prevista y abren la discusión sobre la mejor manera de implementarlo.

Todas las NFR deben ser publicadas como un tema nuevo en [Github](https://github.com/phalcon/cphalcon/issues).