---
layout: default
language: 'es-es'
version: '4.0'
title: 'Nuevo <code>Pull Request (PR)</code>'
keywords: 'new pull request, pull request, pr'
---

# Nuevo *Pull Request (PR)* 

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

Un *pull request* para Phalcon debe ser hecho en nuestro repositorio principal [cphalcon](https://github.com/phalcon/cphalcon). Es una colección de cambios en el código que:

- arreglar un error (problema actual)
- introducir nuevas funcionalidades o mejoras.

Tú *pull request* debe incluir:

- Apunte a la rama correcta.
- Una actualización al `CHANGELOG.md`
- Contiene pruebas unitarias
- Actualizaciones a la documentación y ejemplos de uso según sea necesario
- Su código debe respetar los estándares de codificación que utiliza Phalcon. Para PHP, [PSR-2](https://www.php-fig.org/psr/); para Zephir, los estándares se encuentran en el archivo `.editorconfig` en la raíz del repositorio.

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

- Cambiarse la rama `4.0.x`
- Crear una nueva rama: `T12345-create-new-object`

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
