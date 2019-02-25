---
layout: article
language: 'es-es'
version: '4.0'
category: 'installation'
---
# Instalación

* * *

## macOS

En sistemas macOS puede compilar e instalar la extensión con `brew`, `macports` o el código fuente:

### Requerimentos

* Recursos de desarrollo para PHP 7.2.x
* XCode

<a name='installation-macos-brew'></a>

### Brew

```bash
brew tap tigerstrikemedia/homebrew-phalconphp
brew install php72-phalcon
brew install php73-phalcon
```

<a name='installation-macos-macports'></a>

### MacPorts

```bash
sudo port install php72-phalcon
sudo port install php73-phalcon
```

Editar el archivo php.ini y luego añadir al final:

```ini
extension=php_phalcon.so
```

Reiniciar tu navegador web.