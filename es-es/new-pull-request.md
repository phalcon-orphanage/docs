---
layout: default
language: 'es-es'
version: '5.0'
title: 'Nuevo <i>Pull Request (PR)</i>'
keywords: 'new pull request, pull request, pr'
---

# Nuevo *Pull Request (PR)*
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

A pull request for Phalcon must be against our main repository [cphalcon][cphalcon]. Es una colección de cambios en el código que:

- arreglar un error (problema actual)
- introducir nuevas funcionalidades o mejoras.

Tú *pull request* debe incluir:

* Apunte a la rama correcta.
* Una actualización al `CHANGELOG.md`
* Contiene pruebas unitarias
* Actualizaciones a la documentación y ejemplos de uso según sea necesario
* Su código debe respetar los estándares de codificación que utiliza Phalcon. For PHP code we use [PSR-12][psr-12] while for Zephir code, we have an `.editorconfig` file available at the root of the repository to help you follow the standards.

> **NOTE**: **We do not accept Pull Requests to the `master` branch** 
> 
> {:.alert .alert-danger}

Si el *pull request* es para corregir un problema o error, se debe incluir el número de la incidencia (*issue*). En Github hay una plantilla disponible que se puede utilizar para presentar el *pull request*. Si la incidencia no existe aún, se debe crear primero.

For new functionality, **we will need to have an issue created and referenced**. Si esta nueva funcionalidad choca con la filosofía e implementación de Phalcon, el *pull request* será rechazado.

Additionally, any new functionality that introduces breaking changes will not be accepted for the current release but instead will need to be updated to target the next major version.

It is highly recommended to discuss your NFR and PR with the core team and most importantly with the community to get feedback, guidance and to work on a release plan that will benefit everyone.

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

[cphalcon]: https://github.com/phalcon/cphalcon
[psr-12]: https://www.php-fig.org/psr/psr-12/
