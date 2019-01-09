* * *

layout: default language: 'en' version: '3.4'

* * *

<a name='contributing'></a>

# Contribuir con Phalcon

Phalcon is an open source project and heavily relies on volunteer efforts. We welcome contributions from everyone!

Por favor, tómese un momento, para revisar este documento con el fin de hacer el proceso de contribución más fácil y eficaz para todos.

Seguir estas directrices, permite una mejor comunicación, más rápida resolución de problemas y permite que el proyecto avance.

<a name='contributions'></a>

## Contribuciones

Las contribuciones para Phalcon deben realizarse en la forma de [Pull Requests de GitHub](https://help.github.com/articles/using-pull-requests/). Cada pull request será revisada por un colaborador principal (alguien con permiso para fusionar los pull requests). Basado en el tipo y contenido del pull request, puede ser fusionado inmediatamente, puesto en espera si se requieren aclaraciones, o bien, rechazado.

Por favor asegúrese que está enviando su pull request a la rama correcta y que ya cuenta con un rebase en el código.

<a name='questions-and-support'></a>

## Preguntas y Ayuda

<h5 class='alert alert-warning'>Solo aceptamos reportes de errores, solicitudes de nuevas características y pull requests en GitHub. For questions regarding the usage of the framework or support requests please visit the <a href='https://phalcon.link/forum'>official forum</a>.</h5>

<a name='bug-report-checklist'></a>

## Lista de verificación para Reportes de Errores

- Asegúrate de estar utilizando la última versión liberadas de Phalcon antes de enviar un reporte de errores. Los errores en las versiones anteriores al último publicado no serán abordados por el equipo central.
- Si has encontrado un error, es esencial añadir información relevante para reproducirlo. Ser capaz de reproducir un error reduce en gran manera el tiempo para investigar y solucionarlo. Esta información debe venir en la forma de un script, pequeña aplicación o incluso una prueba que falla. Para obtener más información, compruebe por favor [Presentar prueba Reproducible](https://github.com/phalcon/cphalcon/wiki/Submit-Reproducible-Test).
- Como parte de su informe, por favor incluya información adicional, como el sistema operativo, versión de PHP, versión de Phalcon, servidor web, memoria, etcétera.
- Si estás enviando un error de [Segmentation Fault](https://en.wikipedia.org/wiki/Segmentation_fault), requerimos un backtrace. Consulte [generación de un Backtrace](#bug-report-generating-backtrace) para obtener más información.

<a name='bug-report-generating-backtrace'></a>

### Generación de un Backtrace

A veces debido a un error de [Fallo de segmentación](https://en.wikipedia.org/wiki/Segmentation_fault), Phalcon podría bloquear algunos procesos de su servidor web. Por favor ayúdenos a averiguar el problema añadiendo un backtrace del bloqueo de procesos a su informe de fallo.

Por favor siga estas indicaciones para entender cómo generar el backtrace:

- [Generando un backtrace de gdb](https://bugs.php.net/bugs-generating-backtrace.php)
- [Generar una backtrace, con un compilador, en Win32](http://bugs.php.net/bugs-generating-backtrace-win32.php)
- [Símbolos de depuración](https://github.com/oerdnj/deb.sury.org/wiki/Debugging-symbols)
- [Compilando PHP](http://www.phpinternalsbook.com/build_system/building_php.html)

<a name='pull-request-checklist'></a>

## Lista de Verificación para Pull Request

- No envíe su pull request directamente a la rama `master`. Cree una rama de la rama requerida y, si es necesario, rebase a la rama adecuada antes de enviar su solicitud de pull request. Si no es posible hacer una fusión limpia con la rama master se te pedirá que hagas una nueva rama como base para tus cambios
- No pongas actualizaciones de submódulos, `composer.lock`, etc. en tu solicitud de extracción a menos que sean para commits fusionados
- Agregar las pruebas pertinentes para corregir el error o la nueva característica. Revise nuestra [guía de testeo](https://github.com/phalcon/cphalcon/blob/master/tests/README.md) para más información
- Phalcon está escrito en [Zephir](https://zephir-lang.com/), por favor no envíe cambios que modifiquen archivos C que se generan directamente o de aquellos cuyas funcionalidad/correcciones se aplican en el lenguaje de programación C
- Asegúrese de que el código PHP que escriba ajusta con el estilo general y codificación estándar de las [Normas Aceptadas de PHP](http://www.php-fig.org/psr/)
- Retire cualquier cambio a los archivos `ext/kernel`, `*. zep.c` y `*. zep.h` antes de enviar su pull request

Before submit **new functionality**, please open a [NFR](/3.4/en/new-feature-request) as a new issue on GitHub to discuss the impact of including the functionality or changes in the core extension. Una vez aprobada la funcionalidad, asegúrese de que su PR contiene lo siguiente:

- Una actualización al `CHANGELOG.md`
- Pruebas unitarias
- Documentación o ejemplos de uso

<a name='getting-support'></a>

## Solicitar Soporte

Si usted tiene una pregunta acerca de cómo utilizar Phalcon, consulte la [Página de soporte](https://phalconphp.com/support).

<a name='requesting-features'></a>

## Solicitar Funcionalidades

If you have any changes or new features in mind, please fill an [NFR](/3.4/en/new-feature-request).

¡Gracias!

&lt;3 El equipo de Phalcon