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

> **NOTA:** Solo aceptamos reportes de errores; las solicitudes de nuevas funcionalidades y *pull requests* se deben hacer en GitHub. For questions regarding the usage of the framework or support requests please visit the [github discussions](https://github.com/phalcon/cphalcon/discussions) or our [Discord](https://phalcon.io/discord) server.
{:.alert .alert-danger}

## Lista de verificación para reporte de errores

- Verificar que se está utilizando la última versión de Phalcon antes de reportar un incidente en GitHub.
- Solo se revisarán los errores encontrados en la última versión publicada de Phalcon.
- Utilizar la plantilla para reportar problemas, incluyendo todos los pasos necesarios para que el equipo principal pueda reproducirlos y resolverlos. El detalle en estos pasos reduce de manera significativa el tiempo necesario para identificar la causa del problema y resolverlo. Agradecemos también (si es posible) que se incluya el código de las pruebas con errores. Para más información, por favor, revise la guía para crear [pruebas reproducibles](reproducible-tests).
- Como parte del reporte, por favor incluya información adicional, como el sistema operativo, versión de PHP, versión de Phalcon, servidor web, memoria, etcétera.
- Si se trata de un error de violación de acceso (*[Segmentation Fault](https://es.wikipedia.org/wiki/Violaci%C3%B3n_de_acceso)*) es necesario incluir el registro de seguimiento (*backlog*). Por favor consulte la guía de [generación de traza inversa](#generating-a-backtrace) para obtener más información.

### Generar una traza inversa

A veces, debido a un error de [violación de acceso (*Segmentation Fault*)](https://es.wikipedia.org/wiki/Violaci%C3%B3n_de_acceso), Phalcon podría bloquear algunos procesos de su servidor web. Para ayudarnos a encontrar la causa de esta violación, es necesario incluir la traza inversa de la caída del sistema.

Por favor consulte los siguientes enlaces para obtener instrucciones sobre cómo generar dicha traza:

- [Generando una backtrace de gdb](https://bugs.php.net/bugs-generating-backtrace.php)
- [Generar una backtrace, con un compilador, en Win32](https://bugs.php.net/bugs-generating-backtrace-win32.php)
- [Símbolos de depuración](https://github.com/oerdnj/deb.sury.org/wiki/Debugging-symbols)
- [Compilando PHP](http://www.phpinternalsbook.com/build_system/building_php.html)

## Lista de verificación para *Pull Request(s)*

- No se aceptan *pull requests* a la rama `master`. Por favor haga un *fork* del repositorio y cree su rama (*branch*) de la rama "fuente" necesaria, por ejemplo `4.0.x`. Si es el caso, por favor haga un *rebase* de su rama antes de enviar el *pull request*. En caso de que se presenten conflictos, le pediremos que por favor vuelva a hacer el *rebase* de su rama.
- Agregar pruebas al *pull request* o ajustar las existentes. Es muy importante hacerlo porque básicamente es la justificación del *pull request*. Por favor, revise la página de [pruebas](testing-environment) para saber cómo configurar un entorno de pruebas y cómo escribirlas.
- Dado que Phalcon está escrito en [Zephir](https://zephir-lang.com), por favor, no envíe *commits* que modifiquen los archivos creados en C directamente
- Phalcon sigue una guía de estilo. Por favor, instale el complemento `editorconfig` en su entorno de desarrollo integrado (*IDE*) que se encuentra en el archivo `.editorconfig` del repositorio, así no tendrá que preocuparse por las normas de codificación. Todas las pruebas en código PHP se ajustan a la normativa [PSR-2](https://www.php-fig.org/psr/)
- Suprimir cualquier cambio hecho a los archivos `ext/kernel`, `*.zep.c` y `*.zep.h` antes de enviar su *pull request*
- Más información [aquí](new-pull-request).

Antes de enviar **una nueva funcionalidad**, por favor cree una [Solicitud de Nueva Funcionalidad](new-feature-request) *(New Feature Request, NFR)* en GitHub para debatir el impacto de incluiarla o el de los cambios necesarios en la extensión principal. Una vez que la funcionalidad sea aprobada, confirme que su *pull request (PR)* contiene lo siguiente:

- Una actualización al `CHANGELOG.md`
- Pruebas Unitarias
- Documentación o Ejemplos de Uso

## Obtener Ayuda

Si tiene alguna pregunta sobre cómo utilizar Phalcon, consulte la [página de soporte](https://phalcon.io/support).

## Solicitar Funcionalidades

Si tienes algún cambio o nuevas características en mente, por favor rellena una Solicitud de Nueva Funcionalidad [(NFR)](new-feature-request).

¡Gracias!

<3 Phalcon Team