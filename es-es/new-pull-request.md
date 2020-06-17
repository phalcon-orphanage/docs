---
layout: default
language: 'es-es'
version: '4.0'
title: 'Nuevo <i>Pull Request (PR)</i>'
keywords: 'new pull request, pull request, pr'
---

# Nuevo *Pull Request (PR)* 

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

A pull request for Phalcon must be against our main repository [cphalcon](https://github.com/phalcon/cphalcon). It is a collection of changes to the code that:

- fix a bug (current issue)
- introduce new functionality or enhancement.

Your pull request must include:

- Target the correct branch.
- Update the relevant `CHANGELOG.md`
- Contain unit tests
- Updates to the documentation and usage examples as necessary
- Your code must abide by the coding standards that Phalcon uses. For PHP code we use [PSR-2](https://www.php-fig.org/psr/) while for Zephir code, we have an `.editorconfig` file available at the root of the repository to help you follow the standards.

> **NOTA:** **No se aceptan *Pull Requests* en la rama `master`**
{:.alert .alert-danger}

Si el *pull request* es para corregir un problema o error, se debe incluir el número de la incidencia (*issue*). En Github hay una plantilla disponible que se puede utilizar para presentar el *pull request*. Si la incidencia no existe aún, se debe crear primero.

Para una nueva funcionalidad, de nuevo, **necesitamos tener un tema creado y su número de referencia**. Si esta nueva funcionalidad choca con la filosofía e implementación de Phalcon, el *pull request* será rechazado.

También, si la nueva funcionalidad introduce cambios radicales no será aceptada para la versión actual: será necesario actualizarla para la siguiente versión principal.

Es muy recomendable discutir las Solicitudes de Nuevas Funcionalidades (NFR, por sus siglas en inglés) o PR con el equipo principal de Phalcon y, sobre todo, con la comunidad para obtener retroalimentación, orientación y establecer un plan de lanzamiento que beneficiará a todos.

## Rama y *Commits*

Se recomiendan los siguientes pasos, pero no son obligatorios.

Si está trabajando en un problema, tenga en cuenta el número del problema que está abajo. Supongamos que el problema es:

`#12345 - Create New Object`

- Checkout the `4.0.x` branch
- Create a branch: `T12345-create-new-object`

El nombre de la rama comienza con `T`, seguido por el número del problema y luego el título de la cuestión como un slug.

En tu carpeta `cphalcon` ir a `.git/hooks`

Crea un nuevo archivo llamado `commit-msg` y pega el código de abajo y guárdelo:

```bash
#!/bin/bash
# This Way You can Customize Which Branches Should be Skipped When
# Prepending Commit Message.
if [ -z "$BRANCHES_TO_SKIP" ]; then
  BRANCHES_TO_SKIP=(master develop)
fi
BRANCH_NAME=$(git symbolic-ref --short HEAD)
BRANCH_NAME="${BRANCH_NAME##*/}"
BRANCH_EXCLUDED=$(printf "%s\n" "${BRANCHES_TO_SKIP[@]}" | grep -c "^$BRANCH_NAME$")
BRANCH_IN_COMMIT=$(grep -c "\[$BRANCH_NAME\]" $1)
if [ -n "$BRANCH_NAME" ] && ! [[ $BRANCH_EXCLUDED -eq 1 ]] && ! [[ $BRANCH_IN_COMMIT -ge 1 ]]; then
  ISSUE="$(echo $BRANCH_NAME | cut -d'-' -f 1)"
  ISSUE="${ISSUE/T/#}"
  sed -i.bak -e "1s/^/[$ISSUE] - /" $1
fi
```

Asegúrese de que el archivo es ejecutable

```bash
chmod a+x commit-msg
```

Cualquier commit que añadas ahora a su rama aparecerá atado al problema `12345`.

Hacer lo anterior permite a todos ver qué commits se relacionan con qué problema.