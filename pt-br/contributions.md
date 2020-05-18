---
layout: default
language: 'pt-br'
version: '4.0'
title: 'Contribuições'
keywords: 'contribuindo, pull request, nova solicitação de recurso'
---

# Contribuições

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

# Contribuindo para o Phalcon

Phalcon é um projeto de código aberto e depende fortemente dos esforços e contribuições voluntárias. Nós agradecemos as contribuições de todos!

Por favor, dedique alguns instantes a rever este documento para compreender o processo de contribuição e torná-lo tão eficiente quanto possível para todos. Seguindo estas orientações, poderemos ter uma resolução mais rápida das questões, uma melhor comunicação e poderemos todos fazer com que o projeto avance!

O código-fonte do Phalcon (junto com documentação, sites etc.) é armazenado no [GitHub](https://github.com). Você pode navegar em nossos repositórios na nossa página em [organização](https://github.com/phalcon).

Se você deseja contribuir com o Phalcon, você pode fazer isso emitindo um [pull request no GitHub](https://help.github.com/articles/using-pull-requests/).

Quando você cria uma pull request, nós temos um modelo bastante útil para ajudá-lo a descrever qual é o escopo da pull request. É muito importante e útil para a comunidade que você adicione testes ao seu pull request. Cada pull request será revisado por um colaborador principal (alguém com permissões para mesclar pull requests). Com base no tipo e conteúdo da pull request, ela pode ser: * mesclado imediatamente ou colocado em espera, pois o revisor requer alterações (estilo, testes, etc.) * colocado em espera, se a discussão for necessária (comunidade, equipe central etc.) * rejeitada

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

> **NOTA**: Aceitamos apenas relatórios de bugs, novas solicitações de recursos e pull requests são no GitHub. Para perguntas sobre o uso da estrutura ou pedidos de suporte por favor visite o [fórum oficial](https://phalcon.io/forum) ou nosso servidor [Discord](https://phalcon.io/discord).
{:.alert .alert-danger}

## Lista de Problemas Encontrados

- Certifique-se de estar usando a versão mais recente lançada do Phalcon antes de criar uma "issue" no GitHub.
- Apenas erros encontrados na versão mais recente lançada do Phalcon serão abordados.
- Temos um modelo bastante útil ao criar uma "issue" para ajudá-lo a fornecer informações suficientes para a equipe central reproduzí-lo e trabalhar na correção. Ser capaz de reproduzir um bug reduz significativamente o tempo para encontrar a causa e corrigi-lo. Scripts de testes das falhas são mais do que apreciados. Por favor, verifique na página [testes repoduzíveis](reproducible-tests) como criá-los para mais informações.
- Como parte do seu relatório, por favor inclua informações adicionais como o OS, versão do PHP, versão do Phalcon, servidor web, memória etc.
- Se estiver enviando um erro de [Falha de Segmentação](https://en.wikipedia.org/wiki/Segmentation_fault), nós precisaremos do backtrace. Por favor, verifique na seção [Gerar um Backtrace](#generating-a-backtrace) para obter mais informações.

### Geração de Backtrace

Às vezes devido ao [erro](https://en.wikipedia.org/wiki/Segmentation_fault) de falha de segmentação, o Phalcon pode travar alguns dos processos do servidor web. Para nos ajudar a encontrar a causa desta falha de segmentação, precisaremos do backtrace do acidente.

Confira os seguintes links para obter instruções sobre como gerar o backtrace:

- [Gerando um backtrace com gdb](https://bugs.php.net/bugs-generating-backtrace.php)
- [Gerando um backtrace, com um compilador, no Win32](https://bugs.php.net/bugs-generating-backtrace-win32.php)
- [Símbolos de depuração](https://github.com/oerdnj/deb.sury.org/wiki/Debugging-symbols)
- [Construindo PHP](http://www.phpinternalsbook.com/build_system/building_php.html)

## Listas do Pull Request

- Pull requests para a branch `master` não são permitidos. Por favor, faça fork no repositório e crie seu branch a partir do branch "source" necessário, por exemplo `4.0.x` e, se necessário, faça o rebase de seu branch antes de enviar seu pull request. Se houver colisões, pediremos que você faça o rebase de seu branch novamente.
- Adicione testes a sua pull request ou ajuste os já existentes. Isto é muito importante, pois ajuda a justificar seu pull request. Por favor, verifique nossa [página de testes](testing-environment) para obter mais informações sobre como configurar um ambiente de teste e como escrevê-los.
- Uma vez que o Phalcon é escrito em [Zephir](https://zephir-lang.com), por favor não envie commits que modifiquem os arquivos gerados pelo C diretamente.
- O Phalcon segue um estilo de codificação específico. Por favor, instale o plugin `editorconfig` no seu IDE favorito para aproveitar o arquivo `.editorconfig` que vem com este repositório e não precisar se preocupar com padrões de codificação. Todos os testes (código PHP), seguem o padrão da [PSR-2](https://www.php-fig.org/psr/).
- Remova qualquer alteração nos arquivos `ext/kernel`, `*.zep.c` e `*.zep.h` antes de enviar o pull request.
- Mais informações [aqui](new-pull-request).

Antes de enviar **novas funcionalidades**, abra uma [NFR](new-feature-request) como uma nova issue no GitHub para discutir o impacto de incluir a funcionalidade ou alterações na extensão nativa. Uma vez aprovada a funcionalidade, certifique-se de que sua PR contenha o seguinte:

- Uma atualização para o `CHANGELOG.md`
- Testes Unitários
- Exemplos de Documentação ou Uso

## Obtendo Suporte

Se você tiver alguma dúvida sobre como usar o Phalcon, por favor veja a [página de suporte](http://phalcon.io/support).

## Solicitando Recursos

Se você tiver quaisquer alterações ou novos recursos em mente, preencha uma [NFR](new-feature-request).

Obrigado!

<3 Equipe Phalcon