---
layout: article
language: 'el-gr'
version: '4.0'
category: 'installation'
---
# Installation

* * *

## Compile from Sources

Compiling from source is similar to most environments (Linux/macOS).

### Προϋποθέσεις

* PHP 7.2.x/7.3.x development resources
* GCC compiler (Linux/Solaris/FreeBSD) or Xcode (macOS)
* re2c >= 0.13
* libpcre-dev

### Compilation

Download the latest `zephir.phar` from [here](https://github.com/phalcon/zephir/releases). Add it to a folder that can be accessed by your system.

Clone the repository

```bash
git clone https://github.com/phalcon/cphalcon
```

Compile Phalcon

```bash
cd cphalcon/
git checkout tags/v4.0.0-alpha1 ./
zephir fullclean
zephir build
```

Check the module

```bash
php -m | grep phalcon
```

You will now need to add `extension=phalcon.so` to your PHP ini and restart your web server, so as to load the extension.

```ini
# Suse: Add a file called phalcon.ini in /etc/php7/conf.d/ with this content:
extension=phalcon.so

# CentOS/RedHat/Fedora: Add a file called phalcon.ini in /etc/php.d/ with this content:
extension=phalcon.so

# Ubuntu/Debian with apache2: Add a file called 30-phalcon.ini in /etc/php7/apache2/conf.d/ with this content:
extension=phalcon.so

# Ubuntu/Debian with php7-fpm: Add a file called 30-phalcon.ini in /etc/php7/fpm/conf.d/ with this content:
extension=phalcon.so

# Ubuntu/Debian with php7-cli: Add a file called 30-phalcon.ini in /etc/php7/cli/conf.d/ with this content:
extension=phalcon.so
```