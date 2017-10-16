# Solicita una nueva funcionalidad

Una NFR (New Feature Request) es un pequeño documento explicando cómo debe presentarse una nueva solicitud de función, cómo se puede implementar y cómo puede ayudar a los desarrolladores del núcleo y otros entender como implementarla.

Una NFR contiene: * sintaxis sugerida * sugerencias de nombres de clase y métodos * una breve documentación * si la función ya está implementada en otros frameworks, una breve explicación de como fue implementada y sus ventajas

En los siguientes casos se rechazará una nueva solicitud de funcionalidad: * La función hace el framework más lento * La característica de no ofrece ningún valor adicional al framework * El NFR no es claro, mala documentación, explicación confusa, etcétera. * La NFR no sigue la directrices/filosofía actual del framework * La NFR afecta/rompe aplicaciones desarrolladas en versiones actuales/anteriores del framework * El autor no proporciona feedback cuando solicita * Es técnicamente imposible aplicar * Sólo se puede utilizar en las etapas de desarrollo o pruebas * Enviando o presentado, clases o componentes no siguen el [ Principio de simple responsabilidad](http://en.wikipedia.org/wiki/Single_responsibility_principle) * Métodos estáticos no son permitidos

Para enviar una NFR no necesita proporcionar el código C, Zephir o desarrollar la función. Nuevas solicitudes de Funcionalidad explican el objetivo de la aplicación prevista y abren la discusión sobre la mejor manera de implementarlo.

Todas las NFR deben ser publicadas como un tema nuevo en [Github](https://github.com/phalcon/cphalcon/issues).