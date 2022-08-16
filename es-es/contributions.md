---
layout: default
language: 'es-es'
version: '5.0'
title: 'Contribuciones'
keywords: 'contributing, nfr, pull request, pr, new feature request'
---

# Contribuciones
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

# Cómo contribuir en Phalcon
Phalcon es un proyecto de código abierto que depende en gran medida de los esfuerzos y contribuciones voluntarias. ¡Por lo que son bienvenidas las contribuciones de todos!

Por favor, lea con calma este documento para compenetrarse con el proceso de colaboración, de tal manera que sea lo más transparente y eficiente posible para toda la comunidad. By following these guidelines, we can have faster resolution of issues, better communication, and we can all move the project forward!

The Phalcon source code (along with documentation, websites etc.) is stored in [GitHub][github]. You can browse our repositories in our [organization page][phalcon-org].

If you wish to contribute to Phalcon, you can do so by issuing a [GitHub pull request][github-pr].

Hay una plantilla muy útil para crear el *pull request*. Es muy importante y útil para la comunidad, incluir las pruebas del *pull request*. Cada *pull request* será revisado por un colaborador central (alguien con permiso para fusionar los pull requests). Basado en el tipo y contenido del *pull request*, podría ser:

* fusionado inmediatamente o
* puesto en espera, donde el revisor requiere cambios (estilo, pruebas, etc.)
* puesto en espera, si una discusión es necesaria (comunidad, equipo central, etc.)
* rechazado

> **NOTE**: If your pull request is a new feature, it is best to discuss with the core team first, to ensure that it will align with the evolution of the framework. 
> 
> {:.alert .alert-warning}

> **NOTE**: Please make sure that the target branch that you send your pull request is correct and that you have already rebased your code. Pull requests to the **master** branch are not allowed 
> 
> {:.alert .alert-danger}

## Documentación
Si la programación en Zephir le parece desalentadora, hay muchas otras áreas en las cuales se puede contribuir. Por ejemplo, se puede revisar o corregir la documentación, en caso que se presente algún error tipográfico o de contenido. También es posible mejorar la documentación contribuyendo con más ejemplos en las páginas correspondientes.

All you have to do is go to our [docs][phalcon-docs] repository, fork it, make the changes and send us a pull request.

> **NOTE**: Note that changes to the `docs` repository are allowed **only** to the English documents (`en` folder). 
> 
> {:.alert .alert-warning}

## Traducciones
If you wish to contribute to Phalcon by translating our documents in your native tongue, you can utilize the excellent service of our friends at [Crowdin][crowdin]. Our project is located [here][phalcon-docs]. Si su idioma no está listado, por favor, envíenos un mensaje para que podamos añadirlo.

## Preguntas y ayuda

> **NOTE**: We only accept bug reports, new feature requests and pull requests in GitHub. For questions regarding the usage of the framework or support requests please visit the [official forum][phalcon-forum] or our [Discord][phalcon-discord] server. 
> 
> {:.alert .alert-danger}

## Lista de verificación para reporte de errores
- Verificar que se está utilizando la última versión de Phalcon antes de reportar un incidente en GitHub.
- Solo se revisarán los errores encontrados en la última versión publicada de Phalcon.
- Utilizar la plantilla para reportar problemas, incluyendo todos los pasos necesarios para que el equipo principal pueda reproducirlos y resolverlos. El detalle en estos pasos reduce de manera significativa el tiempo necesario para identificar la causa del problema y resolverlo. Agradecemos también (si es posible) que se incluya el código de las pruebas con errores. Please check how to create the [reproducible tests][tests] page for more information.
- Como parte del reporte, por favor incluya información adicional, como el sistema operativo, versión de PHP, versión de Phalcon, servidor web, memoria, etcétera.
- If you're submitting a [Segmentation Fault][segfault] error, we require a backtrace. Por favor consulte la guía de [generación de traza inversa](#generating-a-backtrace) para obtener más información.

### Generar una traza inversa
Sometimes due to [Segmentation Fault][segfault] error, Phalcon could crash some of your web server processes. Para ayudarnos a encontrar la causa de esta violación, es necesario incluir la traza inversa de la caída del sistema.

Por favor consulte los siguientes enlaces para obtener instrucciones sobre cómo generar dicha traza:

* [Generando una backtrace de gdb][gdb]
* [Generar una backtrace, con un compilador, en Win32][gdb-w32]
* [Símbolos de depuración][symbols]
* [Compilando PHP][building-php]

## Lista de verificación para *Pull Request(s)*
- No se aceptan *pull requests* a la rama `master`. Por favor haga un *fork* del repositorio y cree su rama (*branch*) de la rama "fuente" necesaria, por ejemplo `4.0.x`. Si es el caso, por favor haga un *rebase* de su rama antes de enviar el *pull request*. En caso de que se presenten conflictos, le pediremos que por favor vuelva a hacer el *rebase* de su rama.
- Agregar pruebas al *pull request* o ajustar las existentes. Es muy importante hacerlo porque básicamente es la justificación del *pull request*. Please check our [testing][env] page for more information on how to set up a test environment and how to write tests.
- Since Phalcon is written in [Zephir][zephir], please do not submit commits that modify the C generated files directly
- Phalcon sigue una guía de estilo. Por favor, instale el complemento `editorconfig` en su entorno de desarrollo integrado (*IDE*) que se encuentra en el archivo `.editorconfig` del repositorio, así no tendrá que preocuparse por las normas de codificación. All tests (PHP code), follow the [PSR-2][psr-2] standard
- Suprimir cualquier cambio hecho a los archivos `ext/kernel`, `*.zep.c` y `*.zep.h` antes de enviar su *pull request*
- More information [here][pr].

Before submitting **new functionality**, please open a [NFR][nfr] as a new issue on GitHub to discuss the impact of including the functionality or changes in the core extension. Una vez que la funcionalidad sea aprobada, confirme que su *pull request (PR)* contiene lo siguiente:

- Una actualización al `CHANGELOG.md`
- Pruebas Unitarias
- Documentación o Ejemplos de Uso

## Obtener Ayuda
If you have any questions about how to use Phalcon, please see the [support page][support].

## Solicitar Funcionalidades
If you have any changes or new features in mind, please fill an [NFR][nfr].

¡Gracias!


<3 Phalcon Team

[github]: https://github.com
[phalcon-org]: https://github.com/phalcon
[github-pr]: https://help.github.com/articles/using-pull-requests/
[phalcon-docs]: https://crowdin.com/project/phalcon-documentation
[phalcon-docs]: https://crowdin.com/project/phalcon-documentation
[crowdin]: https://crowdin.com
[phalcon-forum]: https://phalcon.io/forum
[phalcon-discord]: https://phalcon.io/discord
[tests]: reproducible-tests
[segfault]: https://en.wikipedia.org/wiki/Segmentation_fault
[gdb]: https://bugs.php.net/bugs-generating-backtrace.php
[gdb-w32]: https://bugs.php.net/bugs-generating-backtrace-win32.php
[symbols]: https://github.com/oerdnj/deb.sury.org/wiki/Debugging-symbols
[building-php]: http://www.phpinternalsbook.com/build_system/building_php.html
[env]: testing-environment
[zephir]: https://zephir-lang.com
[psr-2]: https://www.php-fig.org/psr/
[pr]: new-pull-request
[nfr]: new-feature-request
[support]: https://phalcon.io/support
