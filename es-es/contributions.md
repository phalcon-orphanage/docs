---
layout: default
language: 'es-es'
version: '4.0'
title: 'Contributing'
keywords: 'contributing, nfr, pull request, pr, new feature request'
---

# Contribuciones

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

# Cómo contribuir en Phalcon

Phalcon es un proyecto de código abierto que depende en gran medida de los esfuerzos y contribuciones voluntarias. ¡Por lo que son bienvenidas las contribuciones de todos!

Please take a few moments to review this document to understand the contribution process and make it as efficient as possible for all. By following these guidelines, we can have faster resolution of issues, better communication and we can all move the project forward!

The Phalcon source code (along with documentation, websites etc.) is stored in [GitHub](https://github.com). You can browse our repositories in our [organization page](https://github.com/phalcon).

If you wish to contribute to Phalcon, you can do so by issuing a [GitHub pull request](https://help.github.com/articles/using-pull-requests/).

When you create a pull request, we have a handy template to help you describe what is the scope of the pull request. It is very important and helpful to the community that you add tests to your pull request. Each pull request will be reviewed by a core contributor (someone with permissions to merge pull requests). Based on the type and content of the pull request, it could be: * merged immediately or * put on hold, where the reviewer requires changes (styling, tests etc.) * put on hold, if discussion is necessary (community, core team etc.) * rejected

> **NOTE**: Please make sure that the target branch that you send your pull request is correct and that you have already rebased your code. Tenga en cuenta que los *pull requests* a la rama ***master*** no están permitidos.

## Documentación

If programming in Zephir seems daunting, there are plenty of areas that you can contribute. You can always check the documentation for any typographic or context errors. You could also enhance the documentation with more examples in the respective pages.

All you have to do is go to our [docs](https://crowdin.com/project/phalcon-documentation) repository, fork it, make the changes and send us a pull request.

> **NOTE**: Note that changes to the `docs` repository are allowed **only** to the English documents (`en` folder).
{:.alert .alert-warning}

## Traducciones

If you wish to contribute to Phalcon by translating our documents in your native tongue, you can utilize the excellent service of our friends at [Crowdin](https://crowdin.com). Our project is located [here](https://crowdin.com/project/phalcon-documentation). If your language is not listed, please send us a message so that we can add it.

## Preguntas y ayuda

> **NOTE**: We only accept bug reports, new feature requests and pull requests in GitHub. For questions regarding the usage of the framework or support requests please visit the [official forum](https://phalcon.io/forum) or our [Discord](https://phalcon.io/discord) server.
{:.alert .alert-danger}

## Lista de verificación para reporte de errores

- Verificar que se está utilizando la última versión de Phalcon antes de reportar un incidente en GitHub.
- Solo se revisarán los errores encontrados en la última versión publicada de Phalcon.
- Utilizar la plantilla para reportar problemas, incluyendo todos los pasos necesarios para que el equipo principal pueda reproducirlos y resolverlos. El detalle en estos pasos reduce de manera significativa el tiempo necesario para identificar la causa del problema y resolverlo. Agradecemos también (si es posible) que se incluya el código de las pruebas con errores. Para más información, por favor, revise la guía para crear [pruebas reproducibles](reproducible-tests).
- Como parte del reporte, por favor incluya información adicional, como el sistema operativo, versión de PHP, versión de Phalcon, servidor web, memoria, etcétera.
- Si se trata de un error de violación de acceso (*[Segmentation Fault](https://es.wikipedia.org/wiki/Violaci%C3%B3n_de_acceso)*) es necesario incluir el registro de seguimiento (*backlog*). Please check the [Generating a Backtrace](#generating-a-backtrace) section for more information.

### Generating a Backtrace

Sometimes due to [Segmentation Fault](https://en.wikipedia.org/wiki/Segmentation_fault) error, Phalcon could crash some of your web server processes. In order to help us find the cause of this segmentation fault, we will need the crash backtrace.

Please check the following links for instructions on how to generate the backtrace:

- [Generando una backtrace de gdb](https://bugs.php.net/bugs-generating-backtrace.php)
- [Generar una backtrace, con un compilador, en Win32](https://bugs.php.net/bugs-generating-backtrace-win32.php)
- [Símbolos de depuración](https://github.com/oerdnj/deb.sury.org/wiki/Debugging-symbols)
- [Compilando PHP](http://www.phpinternalsbook.com/build_system/building_php.html)

## Lista de verificación para *Pull Request(s)*

- No se aceptan *pull requests* a la rama `master`. Por favor haga un *fork* del repositorio y cree su rama (*branch*) de la rama "fuente" necesaria, por ejemplo `4.0.x`. Si es el caso, por favor haga un *rebase* de su rama antes de enviar el *pull request*. En caso de que se presenten conflictos, le pediremos que por favor vuelva a hacer el *rebase* de su rama.
- Agregar pruebas al *pull request* o ajustar las existentes. Es muy importante hacerlo porque básicamente es la justificación del *pull request*. Por favor, revise la página de [pruebas](testing-environment) para saber cómo configurar un entorno de pruebas y cómo escribirlas.
- Dado que Phalcon está escrito en [Zephir](https://zephir-lang.com), por favor, no envíe *commits* que modifiquen los archivos creados en C directamente.
- Phalcon sigue una guía de estilo. Por favor, instale el complemento `editorconfig` en su entorno de desarrollo integrado (*IDE*) que se encuentra en el archivo `.editorconfig` del repositorio, así no tendrá que preocuparse por las normas de codificación. Todas las pruebas en código PHP se ajustan a la normativa [PSR-2](https://www.php-fig.org/psr/).
- Suprimir cualquier cambio hecho a los archivos `ext/kernel`, `*. zep.c` y `*. zep.h` antes de enviar su *pull request*.
- More information [here](new-pull-request).

Before submitting **new functionality**, please open a [NFR](new-feature-request) as a new issue on GitHub to discuss the impact of including the functionality or changes in the core extension. Once the functionality is approved, make sure your PR contains the following:

- Una actualización al `CHANGELOG.md`
- Pruebas unitarias
- Documentación o Ejemplos de Uso

## Obtener Ayuda

Si tiene alguna pregunta sobre cómo utilizar Phalcon, consulte la [página de soporte](http://phalcon.io/support).

## Solicitar Funcionalidades

Si tienes algún cambio o nuevas características en mente, por favor rellena una Solicitud de Nueva Funcionalidad [(NFR)](new-feature-request).

¡Gracias!

<3 Phalcon Team