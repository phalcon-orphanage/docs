---
layout: article
language: 'es-es'
version: '4.0'
---


<a name='contributing'></a>

# Contribuir con Phalcon

Phalcon is an open source project and relies heavily on volunteer efforts and contributions. We welcome contributions from everyone!

Please take a few moments to review this document to understand the contribution process and make it as efficient as possible for all. By following these guidelines, we can have faster resolution of issues, better communication and we can all move the project forward!

The Phalcon source code (along with documentation, websites etc.) is stored in [Github](https://github.com). You can browse our repositories in our [organization page](https://github.com/phalcon).

<a name='contributions'></a>

## Contribuciones

If you wish to contribute to Phalcon, you can do so by issuing a [Github pull request](https://help.github.com/articles/using-pull-requests/).

When you create a pull request, we have a handy template to help you describe what is the scope of the pull request. It is very important and helpful to the community that you add tests to your pull request. Each pull request will be reviewed by a core contributor (someone with permissions to merge pull requests). Based on the type and content of the pull request, it could be: * merged immediately or * put on hold, where the reviewer requires changes (styling, tests etc.) * put on hold, if discussion is necessary (community, core team etc.) * rejected

> Please make sure that the target branch that you send your pull request is correct and that you have already rebased your code. Pull requests to the **master** branch are not allowed {:.alert .alert-danger}

<a name='questions-and-support'></a>

## Preguntas y ayuda

> We only accept bug reports, new feature requests and pull requests in GitHub. For questions regarding the usage of the framework or support requests please visit the [official forum](https://phalcon.link/forum) or our [Discord](https://phalcon.link/discord) server. {:.alert .alert-danger}

<a name='bug-report-checklist'></a>

## Lista de verificación para Reportes de Errores

- Make sure you are using the latest released version of Phalcon before creating an issue in Github.
- Only bugs found in the latest released version of Phalcon will be addressed.
- We have a handy template when creating an issue to help you provide as much information for the core team to reproduce and address. Being able to reproduce a bug significantly reduces the time to find the cause and fix it. Scripts of even failing tests are more than appreciated. Please check how to create the [reproducible tests](reproducible-tests) page for more information.
- Como parte de su informe, por favor incluya información adicional, como el sistema operativo, versión de PHP, versión de Phalcon, servidor web, memoria, etcétera.
- If you're submitting a [Segmentation Fault](https://en.wikipedia.org/wiki/Segmentation_fault) error, we require a backtrace. Please check the [Generating a Backtrace](#bug-report-generating-backtrace) section for more information.

<a name='bug-report-generating-backtrace'></a>

### Generar una traza inversa

Sometimes due to [Segmentation Fault](https://en.wikipedia.org/wiki/Segmentation_fault) error, Phalcon could crash some of your web server processes. In order to help us find the cause of this segmentation fault, we will need the crash backtrace.

Please check the following links for instructions on how to generate the backtrace:

- [Generando un backtrace de gdb](https://bugs.php.net/bugs-generating-backtrace.php)
- [Generar una backtrace, con un compilador, en Win32](https://bugs.php.net/bugs-generating-backtrace-win32.php)
- [Símbolos de depuración](https://github.com/oerdnj/deb.sury.org/wiki/Debugging-symbols)
- [Compilando PHP](https://www.phpinternalsbook.com/build_system/building_php.html)

<a name='pull-request-checklist'></a>

## Checklist para una solicitud de Pull

- Pull requests to the `master` branch are not accepted. Please fork the repository and create your branch from the necessary "source" branch, for instance `4.0.x` and if need be rebase your branch before submitting your pull request. If there are collisions, we will ask you to rebase your branch again.
- Add tests to your pull request or adjust existing ones. This is very important since it helps justify your pull request. Please check our [testing](testing-environment) page for more information on how to set up a test environment and how to write tests.
- Since Phalcon is written in [Zephir](https://zephir-lang.com), please do not submit commits that modify the C generated files directly
- Phalcon follows a specific coding style. Please install the `editorconfig` plugin in your favorite IDE to take advantage of the supplied `.editorconfig` file that comes with this repository and not to have to worry about coding standards. All tests (PHP code), follow the [PSR-2](https://www.php-fig.org/psr/) standard
- Retire cualquier cambio a los archivos `ext/kernel`, `*. zep.c` y `*. zep.h` antes de enviar su pull request

Before submit **new functionality**, please open a [NFR](/4.0/en/new-feature-request) as a new issue on GitHub to discuss the impact of including the functionality or changes in the core extension. Once the functionality is approved, make sure your PR contains the following:

- Una actualización al `CHANGELOG.md`
- Pruebas unitarias
- Documentación o ejemplos de uso

<a name='getting-support'></a>

## Obtener ayuda

If you have any questions about how to use Phalcon, please see the [support page](http://phalcon.link/support).

<a name='requesting-features'></a>

## Solicitar funcionalidades

If you have any changes or new features in mind, please fill an [NFR](new-feature-request).

Thanks!

<3 Phalcon Team