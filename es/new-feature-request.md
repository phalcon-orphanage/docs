# Solicita una nueva funcionalidad

Una NFR (New Feature Request) es un pequeño documento explicando cómo debe presentarse una nueva solicitud de función, cómo se puede implementar y cómo puede ayudar a los desarrolladores del núcleo y otros entender como implementarla.

Una solicitud de nueva funcionalidad contiene:

* Sintaxis sugerida
* Sugerencias de nombres de clase y métodos
* Una breve documentación
* Si la función ya está implementada en otros frameworks, una breve explicación de lo que fue implementado y sus ventajas

En los siguientes casos se rechazará una solicitud de nueva característica:

* Una característica que haga al framework más lento
* La característica que no proporcione ningún valor adicional al framework
* Si la solicitud no es clara, mal documentada, explicación confusa, etcétera.
* La solicitud no sigue la directrices o filosofía actual del framework
* La solicitud afecta/rompe aplicaciones desarrolladas en versiones actuales o anteriores del framework
* El autor de la propuesta no provee una retroalimentación o respuesta cuando así lo solicite
* Es técnicamente imposible de aplicar
* Sólo se puede utilizar en etapas de desarrollo o prueba
* Si las clases o componentes presentados y propuestos no siguen el <a href="[">Principio de Responsabilidad Individual](https://es.wikipedia.org/wiki/Principio_de_responsabilidad_%C3%BAnica)
* Los métodos estáticos no están permitidos

To send a NFR you don't need to provide Zephir or C code or develop the feature. New Feture requests explain the goal of the intended implementation and open discussion on how best to implement it.

Todas las NFR deben ser publicadas como un tema nuevo en [Github](https://github.com/phalcon/cphalcon/issues).