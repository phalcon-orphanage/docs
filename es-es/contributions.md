---
layout: default
language: 'es-es'
version: '4.0'
title: 'Contribuciones'
keywords: 'contributing, nfr, pull request, pr, new feature request'
---

# Contribuciones

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

# Cómo contribuir en Phalcon

Phalcon es un proyecto de código abierto que depende en gran medida de los esfuerzos y contribuciones voluntarias. ¡Por lo que son bienvenidas las contribuciones de todos!

Por favor, lea con calma este documento para compenetrarse con el proceso de colaboración, de tal manera que sea lo más transparente y eficiente posible para toda la comunidad. Al seguir estas guías será posible resolver los problemas más rápido, mejorar la comunicación y ¡avanzar con el proyecto hacia adelante entre todos!

El código fuente de Phalcon (junto con la documentación, sitios web, etc.) se almacena en [GitHub](https://github.com). Los repositorios se encuentran disponibles en nuestra [página de organización](https://github.com/phalcon).

Para contribuir en Phalcon es suficiente con crear un [pull request](https://help.github.com/articles/using-pull-requests/) en GitHub.

Hay una plantilla muy útil para crear el *pull request*. Es muy importante y útil para la comunidad, incluir las pruebas del *pull request*. Cada *pull request* será revisado por un colaborador central (alguien con permiso para fusionar los pull requests). Basado en el tipo y contenido del *pull request*, podría ser:

- fusionado inmediatamente o 
- puesto en espera, donde el revisor requiere cambios (estilo, pruebas, etc.)
- puesto en espera, si una discusión es necesaria (comunidad, equipo central, etc.)
- rechazado

> **NOTA:** Por favor, asegúrese que la rama de destino a la que envía el *pull request* es la correcta y que ya ha rebasado su código. Tenga en cuenta que los *pull requests* a la rama ***master*** no están permitidos.

## Documentación

Si la programación en Zephir le parece desalentadora, hay muchas otras áreas en las cuales se puede contribuir. Por ejemplo, se puede revisar o corregir la documentación, en caso que se presente algún error tipográfico o de contenido. También es posible mejorar la documentación contribuyendo con más ejemplos en las páginas correspondientes.

El procedimiento es muy sencillo: solo hay que ir al repositorio de [docs](https://crowdin.com/project/phalcon-documentation), hacer un *fork*, realizar los cambios y enviar el *pull request*.

> **NOTA:** solo es posible hacer cambios en el repositorio de `docs` en la versión en inglés, que se encuentra en la carpeta `en`.
{:.alert .alert-warning}

## Traducciones

Para contribuir con la traducción de los documentos de Phalcon a su lengua materna puede utilizar el excelente servicio de nuestros amigos de [Crowdin](https://crowdin.com). Nuestro proyecto está ubicado [aquí](https://crowdin.com/project/phalcon-documentation). Si su idioma no está listado, por favor, envíenos un mensaje para que podamos añadirlo.

## Preguntas y ayuda

> **NOTA:** Solo aceptamos reportes de errores; las solicitudes de nuevas funcionalidades y *pull requests* se deben hacer en GitHub. Para hacer preguntas sobre el uso del *framework* o para solicitar ayuda visite el [foro oficial](https://phalcon.io/forum) o nuestro servidor en [Discord](https://phalcon.io/discord).
{:.alert .alert-danger}

## Lista de verificación para reporte de errores

- Make sure you are using the latest released version of Phalcon before creating an issue in GitHub.
- Only bugs found in the latest released version of Phalcon will be addressed.
- We have a handy template when creating an issue to help you provide as much information for the core team to reproduce and address. Being able to reproduce a bug significantly reduces the time to find the cause and fix it. Scripts of even failing tests are more than appreciated. Please check how to create the [reproducible tests](reproducible-tests) page for more information.
- As part of your report, please include additional information such as the OS, PHP version, Phalcon version, web server, memory etc.
- If you're submitting a [Segmentation Fault](https://en.wikipedia.org/wiki/Segmentation_fault) error, we require a backtrace. Please check the [Generating a Backtrace](#generating-a-backtrace) section for more information.

### Generar una traza inversa

A veces, debido a un error de [violación de acceso (*Segmentation Fault*)](https://es.wikipedia.org/wiki/Violaci%C3%B3n_de_acceso), Phalcon podría bloquear algunos procesos de su servidor web. Para ayudarnos a encontrar la causa de esta violación, es necesario incluir la traza inversa de la caída del sistema.

Por favor consulte los siguientes enlaces para obtener instrucciones sobre cómo generar dicha traza:

- [Generating a gdb backtrace](https://bugs.php.net/bugs-generating-backtrace.php)
- [Generating a backtrace, with a compiler, on Win32](https://bugs.php.net/bugs-generating-backtrace-win32.php)
- [Debugging Symbols](https://github.com/oerdnj/deb.sury.org/wiki/Debugging-symbols)
- [Building PHP](http://www.phpinternalsbook.com/build_system/building_php.html)

## Lista de verificación para *Pull Request(s)*

- Pull requests to the `master` branch are not accepted. Please fork the repository and create your branch from the necessary "source" branch, for instance `4.0.x` and if need be rebase your branch before submitting your pull request. If there are collisions, we will ask you to rebase your branch again.
- Add tests to your pull request or adjust existing ones. This is very important since it helps justify your pull request. Please check our [testing](testing-environment) page for more information on how to set up a test environment and how to write tests.
- Since Phalcon is written in [Zephir](https://zephir-lang.com), please do not submit commits that modify the C generated files directly
- Phalcon follows a specific coding style. Please install the `editorconfig` plugin in your favorite IDE to take advantage of the supplied `.editorconfig` file that comes with this repository and not to have to worry about coding standards. All tests (PHP code), follow the [PSR-2](https://www.php-fig.org/psr/) standard
- Remove any change to `ext/kernel`, `*.zep.c` and `*.zep.h` files before submitting the pull request
- More information [here](new-pull-request).

Antes de enviar **una nueva funcionalidad**, por favor cree una [Solicitud de Nueva Funcionalidad](new-feature-request) *(New Feature Request, NFR)* en GitHub para debatir el impacto de incluiarla o el de los cambios necesarios en la extensión principal. Una vez que la funcionalidad sea aprobada, confirme que su *pull request (PR)* contiene lo siguiente:

- Una actualización al `CHANGELOG.md`
- Pruebas Unitarias
- Documentación o Ejemplos de Uso

## Obtener Ayuda

Si tiene alguna pregunta sobre cómo utilizar Phalcon, consulte la [página de soporte](http://phalcon.io/support).

## Solicitar Funcionalidades

Si tienes algún cambio o nuevas características en mente, por favor rellena una Solicitud de Nueva Funcionalidad [(NFR)](new-feature-request).

¡Gracias!

<3 Phalcon Team