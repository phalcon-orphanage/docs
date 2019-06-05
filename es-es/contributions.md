---
layout: default
language: 'es-es'
version: '4.0'
---

# Contribuciones

* * *

# Cómo contribuir en Phalcon

Phalcon es un proyecto de código abierto y depende en gran medida de los esfuerzos y contribuciones voluntarias. ¡Son bienvenidas las contribuciones de todos!

Por favor lea con calma este documento para compenetrarse con el proceso de colaboración, de tal manera que sea lo más transparente y eficiente posible para toda la comunidad. Al seguir estas guías será posible resolver los problemas más rápido, mejorar la comunicación y ¡avanzar con el proyecto hacia adelante entre todos!

El código fuente de Phalcon (junto con la documentación, sitios web, etc.) se almacena en [GitHub](https://github.com). Los repositorios se encuentran disponibles en nuestra [página de organización](https://github.com/phalcon).

Para contribuir en Phalcon es suficiente con crear un *[pull request](https://help.github.com/articles/using-pull-requests/)* en GitHub.

Hay una plantilla muy útil para crear el *pull request*. Es muy importante y útil para la comunidad, incluir las pruebas del *pull request*. Cada *pull request* será revisado por un colaborador principal (con autorización para incluirlo [*merge*]). Según el tipo y contenido del *pull request*, podrá ser: * incluido de inmediato; * puesto en espera (el revisor pedirá cambios de estilo, pruebas, etc.); * puesto en espera (el revisor considera que debe ser discutido por la comunidad, el equipo principal, etc.); * rechazado.

> Por favor, asegúrese que la rama de destino a la que envía el *pull request* es la correcta y que ya ha rebasado su código. Tenga en cuenta que los *pull requests* a la rama ***master*** no están permitidos.

## Documentación

Si la programación en Zephir parece ser asustadora, hay muchas otras áreas en las cuales se puede contribuir. You can always check the documentation for any typographic or context errors. You could also enhance the documentation with more examples in the respective pages.

All you have to do is go to our [docs](https://github.com/phalcon/docs) repository, fork it, make the changes and send us a pull request.

> Note that changes to the `docs` repository are allowed **only** to the English documents (`en` folder).
{:.alert .alert-warning}

## Translations

If you wish to contribute to Phalcon by translating our documents in your native tongue, you can utilize the excellent service of our friends at [Crowdin](https://crowdin.com). Our project is located [here](https://crowdin.com/project/phalcon-documentation). If your language is not listed, please send us a message so that we can add it.

## Questions and Support

> We only accept bug reports, new feature requests and pull requests in GitHub. For questions regarding the usage of the framework or support requests please visit the [official forum](https://phalcon.link/forum) or our [Discord](https://phalcon.link/discord) server.
{:.alert .alert-danger}

## Bug Report Checklist

- Make sure you are using the latest released version of Phalcon before creating an issue in GitHub.
- Only bugs found in the latest released version of Phalcon will be addressed.
- We have a handy template when creating an issue to help you provide as much information for the core team to reproduce and address. Being able to reproduce a bug significantly reduces the time to find the cause and fix it. Scripts of even failing tests are more than appreciated. Please check how to create the [reproducible tests](reproducible-tests) page for more information.
- Como parte del reporte, por favor incluya información adicional, como el sistema operativo, versión de PHP, versión de Phalcon, servidor web, memoria, etcétera.
- If you're submitting a [Segmentation Fault](https://en.wikipedia.org/wiki/Segmentation_fault) error, we require a backtrace. Please check the [Generating a Backtrace](#bug-report-generating-backtrace) section for more information.

### Generar una traza inversa

Sometimes due to [Segmentation Fault](https://en.wikipedia.org/wiki/Segmentation_fault) error, Phalcon could crash some of your web server processes. In order to help us find the cause of this segmentation fault, we will need the crash backtrace.

Please check the following links for instructions on how to generate the backtrace:

- [Generando una backtrace de gdb](https://bugs.php.net/bugs-generating-backtrace.php)
- [Generar una backtrace, con un compilador, en Win32](https://bugs.php.net/bugs-generating-backtrace-win32.php)
- [Símbolos de depuración](https://github.com/oerdnj/deb.sury.org/wiki/Debugging-symbols)
- [Compilando PHP](http://www.phpinternalsbook.com/build_system/building_php.html)

## Pull Request Checklist

- Pull requests to the `master` branch are not accepted. Please fork the repository and create your branch from the necessary "source" branch, for instance `4.0.x` and if need be rebase your branch before submitting your pull request. If there are collisions, we will ask you to rebase your branch again.
- Add tests to your pull request or adjust existing ones. This is very important since it helps justify your pull request. Please check our [testing](testing-environment) page for more information on how to set up a test environment and how to write tests.
- Since Phalcon is written in [Zephir](https://zephir-lang.com), please do not submit commits that modify the C generated files directly
- Phalcon follows a specific coding style. Please install the `editorconfig` plugin in your favorite IDE to take advantage of the supplied `.editorconfig` file that comes with this repository and not to have to worry about coding standards. All tests (PHP code), follow the [PSR-2](https://www.php-fig.org/psr/) standard
- Suprimir cualquier cambio hecho a los archivos `ext/kernel`, `*. zep.c` y `*. zep.h` antes de enviar su *pull request*.
- More information [here](new-pull-request)

Before submitting **new functionality**, please open a [NFR](new-feature-request) as a new issue on GitHub to discuss the impact of including the functionality or changes in the core extension. Once the functionality is approved, make sure your PR contains the following:

- Una actualización al `CHANGELOG.md`
- Pruebas unitarias
- Documentación o ejemplos de uso

## Getting Support

If you have any questions about how to use Phalcon, please see the [support page](http://phalcon.link/support).

## Requesting Features

If you have any changes or new features in mind, please fill an [NFR](new-feature-request).

Thanks!

<3 Phalcon Team