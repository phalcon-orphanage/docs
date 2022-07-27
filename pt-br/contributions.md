---
layout: default
language: 'pt-br'
version: '5.0'
title: 'Contribuições'
keywords: 'contribuindo, pull request, nova solicitação de recurso'
---

# Contribuições
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

# Contribuindo para o Phalcon
Phalcon é um projeto de código aberto e depende fortemente dos esforços e contribuições voluntárias. Nós agradecemos as contribuições de todos!

Por favor, dedique alguns instantes a rever este documento para compreender o processo de contribuição e torná-lo tão eficiente quanto possível para todos. By following these guidelines, we can have faster resolution of issues, better communication, and we can all move the project forward!

The Phalcon source code (along with documentation, websites etc.) is stored in [GitHub][github]. You can browse our repositories in our [organization page][phalcon-org].

If you wish to contribute to Phalcon, you can do so by issuing a [GitHub pull request][github-pr].

Quando você cria uma pull request, nós temos um modelo bastante útil para ajudá-lo a descrever qual é o escopo da pull request. É muito importante e útil para a comunidade que você adicione testes ao seu pull request. Cada pull request será revisado por um colaborador principal (alguém com permissões para mesclar pull requests). Based on the type and content of the pull request, it could be:

* merged immediately or
* put on hold, where the reviewer requires changes (styling, tests etc.)
* put on hold, if discussion is necessary (community, core team etc.)
* rejected

> **NOTE**: If your pull request is a new feature, it is best to discuss with the core team first, to ensure that it will align with the evolution of the framework. 
> 
> {:.alert .alert-warning}

> **NOTE**: Please make sure that the target branch that you send your pull request is correct and that you have already rebased your code. Pull requests to the **master** branch are not allowed 
> 
> {:.alert .alert-danger}

## Documentação
Se a programação em Zephir parece assustadora, há várias áreas para as quais você pode contribuir. Você pode sempre checar a documentação em busca de erros de tipografia ou contexto. Você também pode melhorar a documentação com mais exemplos nas respectivas páginas.

All you have to do is go to our [docs][phalcon-docs] repository, fork it, make the changes and send us a pull request.

> **NOTE**: Note that changes to the `docs` repository are allowed **only** to the English documents (`en` folder). 
> 
> {:.alert .alert-warning}

## Traduções
If you wish to contribute to Phalcon by translating our documents in your native tongue, you can utilize the excellent service of our friends at [Crowdin][crowdin]. Our project is located [here][phalcon-docs]. Se o seu idioma não estiver listado, por favor nos envie uma mensagem para que possamos adicioná-lo.

## Perguntas e Suporte

> **NOTE**: We only accept bug reports, new feature requests and pull requests in GitHub. For questions regarding the usage of the framework or support requests please visit the [official forum][phalcon-forum] or our [Discord][phalcon-discord] server. 
> 
> {:.alert .alert-danger}

## Lista de Problemas Encontrados
- Make sure you are using the latest released version of Phalcon before creating an issue in GitHub.
- Only bugs found in the latest released version of Phalcon will be addressed.
- We have a handy template when creating an issue to help you provide as much information for the core team to reproduce and address. Being able to reproduce a bug significantly reduces the time to find the cause and fix it. Scripts of even failing tests are more than appreciated. Please check how to create the [reproducible tests][tests] page for more information.
- As part of your report, please include additional information such as the OS, PHP version, Phalcon version, web server, memory etc.
- If you're submitting a [Segmentation Fault][segfault] error, we require a backtrace. Please check the [Generating a Backtrace](#generating-a-backtrace) section for more information.

### Geração de Backtrace
Sometimes due to [Segmentation Fault][segfault] error, Phalcon could crash some of your web server processes. Para nos ajudar a encontrar a causa desta falha de segmentação, precisaremos do backtrace do acidente.

Confira os seguintes links para obter instruções sobre como gerar o backtrace:

* [Generating a gdb backtrace][gdb]
* [Generating a backtrace, with a compiler, on Win32][gdb-w32]
* [Debugging Symbols][symbols]
* [Building PHP][building-php]

## Listas do Pull Request
- Pull requests to the `master` branch are not accepted. Please fork the repository and create your branch from the necessary "source" branch, for instance `4.0.x` and if need be rebase your branch before submitting your pull request. If there are collisions, we will ask you to rebase your branch again.
- Add tests to your pull request or adjust existing ones. This is very important since it helps justify your pull request. Please check our [testing][env] page for more information on how to set up a test environment and how to write tests.
- Since Phalcon is written in [Zephir][zephir], please do not submit commits that modify the C generated files directly
- Phalcon follows a specific coding style. Please install the `editorconfig` plugin in your favorite IDE to take advantage of the supplied `.editorconfig` file that comes with this repository and not to have to worry about coding standards. All tests (PHP code), follow the [PSR-2][psr-2] standard
- Remove any change to `ext/kernel`, `*.zep.c` and `*.zep.h` files before submitting the pull request
- More information [here][pr].

Before submitting **new functionality**, please open a [NFR][nfr] as a new issue on GitHub to discuss the impact of including the functionality or changes in the core extension. Uma vez aprovada a funcionalidade, certifique-se de que sua PR contenha o seguinte:

- An update to the `CHANGELOG.md`
- Unit Tests
- Documentation or Usage Examples

## Obtendo Suporte
If you have any questions about how to use Phalcon, please see the [support page][support].

## Solicitando Recursos
If you have any changes or new features in mind, please fill an [NFR][nfr].

Obrigado!


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
