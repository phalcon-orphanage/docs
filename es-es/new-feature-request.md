---
layout: default
language: 'es-es'
version: '4.0'
title: 'Solicitud de Nueva Funcionalidad'
keywords: 'Solicitud de Nueva Funcionalidad, nfr'
---

# Solicitud de Nueva Funcionalidad

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

[Lista de Solicitudes de Nuevas Funcionalidades](new-feature-request-list)

Una Solicitud de Nueva Funcionalidad (NFR por sus siglas en inglés) es un pequeño documento explicando cómo debe presentarse, cómo se puede implementar y cómo puede ayudar a los desarrolladores principales y otros a entender como implementarla.

Una solicitud de nueva funcionalidad contiene:

* Sintaxis sugerida
* Sugerencias de nombres de clase y métodos
* Una descripción detallando el uso
* Cómo puede beneficiar al *framework* y a la comunidad
* Si la función ya está implementada en otros frameworks, una breve explicación de lo que fue implementado y sus ventajas

En los siguientes casos se rechazará una solicitud de nueva característica **si**:

* Una característica que haga al framework más lento
* La característica que no proporcione ningún valor adicional al framework
* Si la solicitud no es clara, mal documentada, explicación confusa, etcétera.
* La *NFR* no ha sido discutida con el equipo o votada por la comunidad
* La solicitud no sigue la directrices o filosofía actual del framework
* La solicitud afecta/rompe aplicaciones desarrolladas en versiones actuales o anteriores del framework
* El autor de la propuesta no provee una retroalimentación o respuesta cuando así lo solicite
* Es técnicamente imposible de aplicar
* Sólo se puede utilizar en etapas de desarrollo o prueba
* Si las clases o componentes presentados y propuestos no siguen el [Principio de Responsabilidad Simple](https://en.wikipedia.org/wiki/Single_responsibility_principle)
* Los métodos estáticos no están permitidos

Para enviar una *NFR* no es necesario proveer el código Zephir o C, o desarrollar la funcionalidad. Las *NFR* explican claramente cuál es el objetivo que se busca implementar y empiezan una sana discusión sobre cuál es la mejor forma de lograrlo.

Todas las NFR deben ser publicadas como nuevas incidencias en [GitHub](https://github.com/phalcon/cphalcon/issues). Es muy importante utilizar el prefijo `[NFR]` en el título de la incidencia.
