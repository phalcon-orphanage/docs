---
layout: default
language: 'tr-tr'
version: '4.0'
category: 'installation'
---
# Kurulum

* * *

## macOS

On a macOS system you can compile and install the extension with `brew`, `macports` or the source code:

### Requirements

* PHP 7.2.x development resources
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

Edit your php.ini file and then append at the end:

```ini
extension=php_phalcon.so
```

Restart your webserver.