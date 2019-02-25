---
layout: article
language: 'es-es'
version: '4.0'
category: 'installation'
---
# Instalación

* * *

## Requerimentos

### PSR

Phalcon requires the PSR extension. The extension can be downloaded and compiled from [this](https://github.com/jbboehr/php-psr) GitHub repository. Installation instructions are available on the `README` of the repository. Once the extension has been compiled and is available in your system, you will need to load it to your `php.ini`. You will need to add this line:

```ini
extension=psr.so
```

before

```ini
extension=phalcon.so
```

Alternatively some distributions add a number prefix on `ini` files. If that is the case, choose a high number for Phalcon (e.g. `50-phalcon.ini`).