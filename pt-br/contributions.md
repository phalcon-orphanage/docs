---
layout: default
language: 'pt-br'
version: '4.0'
title: 'Contribuições'
keywords: 'contribuindo, pull request, nova solicitação de recurso'
---

# Contribuições

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

# Contribuindo para o Phalcon

Phalcon é um projeto de código aberto e depende fortemente dos esforços e contribuições voluntárias. Nós agradecemos as contribuições de todos!

Por favor, dedique alguns instantes a rever este documento para compreender o processo de contribuição e torná-lo tão eficiente quanto possível para todos. Seguindo estas orientações, poderemos ter uma resolução mais rápida das questões, uma melhor comunicação e poderemos todos fazer com que o projeto avance!

O código-fonte do Phalcon (junto com documentação, sites etc.) é armazenado no [GitHub](https://github.com). Você pode navegar em nossos repositórios na nossa página em [organização](https://github.com/phalcon).

Se você deseja contribuir com o Phalcon, você pode fazer isso emitindo um [pull request no GitHub](https://help.github.com/articles/using-pull-requests/).

Quando você cria uma pull request, nós temos um modelo bastante útil para ajudá-lo a descrever qual é o escopo da pull request. É muito importante e útil para a comunidade que você adicione testes ao seu pull request. Cada pull request será revisado por um colaborador principal (alguém com permissões para mesclar pull requests). Based on the type and content of the pull request, it could be:

- merged immediately or 
- put on hold, where the reviewer requires changes (styling, tests etc.)
- put on hold, if discussion is necessary (community, core team etc.)
- rejected

> **NOTA**: Certifique-se de que o branch de destino que você enviou seu pull request está correto e que você já atualizou seu código. Pull requests para a branch **master** não são permitidos
{:.alert .alert-danger}

## Documentação

Se a programação em Zephir parece assustadora, há várias áreas para as quais você pode contribuir. Você pode sempre checar a documentação em busca de erros de tipografia ou contexto. Você também pode melhorar a documentação com mais exemplos nas respectivas páginas.

Tudo o que você precisa fazer é ir para o repositório da nossa [documentação](https://crowdin.com/project/phalcon-documentation), fazer um fork, aplicar as alterações e nos enviar uma solicitação de pull request.

> **NOTA**: Observe que as alterações no repositório da `documentação` são permitidas **apenas** nos documentos em inglês (`en` pasta).
{:.alert .alert-warning}

## Traduções

Se você deseja contribuir para o Phalcon traduzindo nossos documentos em sua língua nativa, você pode utilizar o excelente serviço dos nossos amigos no [Crowdin](https://crowdin.com). Nosso projeto está localizado [aqui](https://crowdin.com/project/phalcon-documentation). Se o seu idioma não estiver listado, por favor nos envie uma mensagem para que possamos adicioná-lo.

## Perguntas e Suporte

> **NOTA**: Aceitamos apenas relatórios de bugs, novas solicitações de recursos e pull requests são no GitHub. For questions regarding the usage of the framework or support requests please visit the [github discussions](https://github.com/phalcon/cphalcon/discussions) or our [Discord](https://phalcon.io/discord) server.
{:.alert .alert-danger}

## Lista de Problemas Encontrados

- Make sure you are using the latest released version of Phalcon before creating an issue in GitHub.
- Only bugs found in the latest released version of Phalcon will be addressed.
- We have a handy template when creating an issue to help you provide as much information for the core team to reproduce and address. Being able to reproduce a bug significantly reduces the time to find the cause and fix it. Scripts of even failing tests are more than appreciated. Please check how to create the [reproducible tests](reproducible-tests) page for more information.
- As part of your report, please include additional information such as the OS, PHP version, Phalcon version, web server, memory etc.
- If you're submitting a [Segmentation Fault](https://en.wikipedia.org/wiki/Segmentation_fault) error, we require a backtrace. Please check the [Generating a Backtrace](#generating-a-backtrace) section for more information.

### Geração de Backtrace

Às vezes devido ao [erro](https://en.wikipedia.org/wiki/Segmentation_fault) de falha de segmentação, o Phalcon pode travar alguns dos processos do servidor web. Para nos ajudar a encontrar a causa desta falha de segmentação, precisaremos do backtrace do acidente.

Confira os seguintes links para obter instruções sobre como gerar o backtrace:

- [Generating a gdb backtrace](https://bugs.php.net/bugs-generating-backtrace.php)
- [Generating a backtrace, with a compiler, on Win32](https://bugs.php.net/bugs-generating-backtrace-win32.php)
- [Debugging Symbols](https://github.com/oerdnj/deb.sury.org/wiki/Debugging-symbols)
- [Building PHP](http://www.phpinternalsbook.com/build_system/building_php.html)

## Listas do Pull Request

- Pull requests to the `master` branch are not accepted. Please fork the repository and create your branch from the necessary "source" branch, for instance `4.0.x` and if need be rebase your branch before submitting your pull request. If there are collisions, we will ask you to rebase your branch again.
- Add tests to your pull request or adjust existing ones. This is very important since it helps justify your pull request. Please check our [testing](testing-environment) page for more information on how to set up a test environment and how to write tests.
- Since Phalcon is written in [Zephir](https://zephir-lang.com), please do not submit commits that modify the C generated files directly
- Phalcon follows a specific coding style. Please install the `editorconfig` plugin in your favorite IDE to take advantage of the supplied `.editorconfig` file that comes with this repository and not to have to worry about coding standards. All tests (PHP code), follow the [PSR-2](https://www.php-fig.org/psr/) standard
- Remove any change to `ext/kernel`, `*.zep.c` and `*.zep.h` files before submitting the pull request
- More information [here](new-pull-request).

Antes de enviar **novas funcionalidades**, abra uma [NFR](new-feature-request) como uma nova issue no GitHub para discutir o impacto de incluir a funcionalidade ou alterações na extensão nativa. Uma vez aprovada a funcionalidade, certifique-se de que sua PR contenha o seguinte:

- An update to the `CHANGELOG.md`
- Unit Tests
- Documentation or Usage Examples

## Obtendo Suporte

If you have any questions about how to use Phalcon, please see the [support page](https://phalcon.io/support).

## Solicitando Recursos

Se você tiver quaisquer alterações ou novos recursos em mente, preencha uma [NFR](new-feature-request).

Obrigado!

<3 Equipe Phalcon
