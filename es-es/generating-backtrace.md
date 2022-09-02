---
layout: default
language: 'es-es'
version: '4.0'
title: 'Generar una traza inversa'
keywords: 'backtrace, depuración, fallas de segmentación'
---

# Generar una traza inversa

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

Phalcon está compilado en una extensión C cargada en su servidor web. Debido a esto, los errores conducen a fallas de segmentación, causando que Phalcon bloquee algunos de sus procesos de servidor web.

Para depurar estos defectos de segmentación se requiere un *stacktrace* (traza inversa). La creación de un seguimiento de pila requiere una compilación especial de php y se deben seguir algunos pasos para generar un seguimiento que permita al equipo de Phalcon depurar este comportamiento.

Por favor sigue estas indicaciones para entender cómo generar el *backtrace*.

<https://bugs.php.net/bugs-generating-backtrace.php>

<https://bugs.php.net/bugs-generating-backtrace-win32.php>
