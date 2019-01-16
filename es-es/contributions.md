* * *

layout: article language: 'en' version: '4.0'

* * *

##### This article reflects v3.4 and has not yet been revised

{:.alert .alert-danger}

<a name='contributing'></a>

# Contribuir con Phalcon

Phalcon is an open source project and heavily relies on volunteer efforts. We welcome contributions from everyone!

Please take a moment to review this document in order to make the contribution process easy and effective for all.

Following these guidelines, allows better communication, faster resolution of issues and moves the project forward.

<a name='contributions'></a>

## Contribuciones

Contributions to Phalcon should be made in the form of [GitHub pull requests](https://help.github.com/articles/using-pull-requests/). Each pull request will be reviewed by a core contributor (someone with permission to merge pull requests). Based on the type and content of the pull request, it can either be merged immediately, put on hold if clarifications are needed, or rejected.

Please ensure that you are sending your pull request to the correct branch and that you already have rebased your code.

<a name='questions-and-support'></a>

## Preguntas y ayuda

<h5 class='alert alert-warning'>We only accept bug reports, new feature requests and pull requests in GitHub. For questions regarding the usage of the framework or support requests please visit the <a href='https://phalcon.link/forum'>official forum</a>.</h5>

<a name='bug-report-checklist'></a>

## Lista de verificación para Reportes de Errores

- Asegúrese de que está utilizando la última versión publicada de Phalcon antes de presentar un informe de error. Los errores en versiones anteriores a la última lanzada no serán abordados por el equipo principal.
- Si has encontrado un error, es esencial añadir información relevante para reproducirlo. Ser capaz de reproducir un error reduce en gran manera el tiempo para investigar y solucionarlo. Esta información debe venir en la forma de un script, pequeña aplicación o incluso una prueba que falla. Para obtener más información, compruebe por favor [Presentar prueba Reproducible](https://github.com/phalcon/cphalcon/wiki/Submit-Reproducible-Test).
- Como parte de su informe, por favor incluya información adicional, como el sistema operativo, versión de PHP, versión de Phalcon, servidor web, memoria, etcétera.
- Si estás enviando un error de [Segmentation Fault](https://en.wikipedia.org/wiki/Segmentation_fault), requerimos un backtrace. Consulte [generación de un Backtrace](#bug-report-generating-backtrace) para obtener más información.

<a name='bug-report-generating-backtrace'></a>

### Generar una traza inversa

Sometimes due to [Segmentation Fault](https://en.wikipedia.org/wiki/Segmentation_fault) error, Phalcon could crash some of your web server processes. Please help us to find out the problem by adding a crash backtrace to your bug report.

Please follow this guides to understand how to generate the backtrace:

- [Generando un backtrace de gdb](https://bugs.php.net/bugs-generating-backtrace.php)
- [Generar una backtrace, con un compilador, en Win32](https://bugs.php.net/bugs-generating-backtrace-win32.php)
- [Símbolos de depuración](https://github.com/oerdnj/deb.sury.org/wiki/Debugging-symbols)
- [Compilando PHP](https://www.phpinternalsbook.com/build_system/building_php.html)

<a name='pull-request-checklist'></a>

## Checklist para una solicitud de Pull

- No envíe su pull request directamente a la rama `master`. Cree una rama de la rama requerida y, si es necesario, rebase a la rama adecuada antes de enviar su solicitud de pull request. Si no es posible hacer una fusión limpia con la rama master se te pedirá que hagas una nueva rama como base para tus cambios
- No pongas actualizaciones de submódulos, `composer.lock`, etc. en tu solicitud de extracción a menos que sean para commits fusionados
- Añadir pruebas relevantes para el error corregido o la nueva característica. Consulte nuestra [guía de la pruebas](https://github.com/phalcon/cphalcon/blob/master/tests/README.md) para obtener más información
- Phalcon está escrito en [Zephir](https://zephir-lang.com/), por favor no envíe cambios que modifiquen archivos C que se generan directamente o de aquellos cuyas funcionalidad/correcciones se aplican en el lenguaje de programación C
- Make sure that the PHP code you write fits with the general style and coding standards of the [Accepted PHP Standards](https://www.php-fig.org/psr/)
- Retire cualquier cambio a los archivos `ext/kernel`, `*. zep.c` y `*. zep.h` antes de enviar su pull request

Before submit **new functionality**, please open a [NFR](/4.0/en/new-feature-request) as a new issue on GitHub to discuss the impact of including the functionality or changes in the core extension. Once the functionality is approved, make sure your PR contains the following:

- Una actualización al `CHANGELOG.md`
- Pruebas unitarias
- Documentación o ejemplos de uso

<a name='getting-support'></a>

## Obtener ayuda

If you have any questions about how to use Phalcon, please see the [support page](https://phalconphp.com/support).

<a name='requesting-features'></a>

## Solicitar funcionalidades

If you have any changes or new features in mind, please fill an [NFR](/4.0/en/new-feature-request).

Thanks!

<3 Phalcon Team