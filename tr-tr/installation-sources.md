---
layout: default
language: 'tr-tr'
version: '4.0'
category: 'installation'
---
# Kurulum

* * *

## Compile from Sources

Compiling from source is similar to most environments (Linux/macOS).

### Requirements

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

The instructions above will compile **and** install the module on your system. You can also compile the extension and then add it manually in your `ini` file:

```bash
cd cphalcon/
git checkout tags/v4.0.0-alpha1 ./
zephir fullclean
zephir compile
cd ext
phpize
./configure
make && make install
```

If you use the above method you will need to add the `extension=phalcon.so` in your `php.ini` both for CLI and web server.

### Tuning build

By default we compile to be as compatible as possible with all processors (`gcc -mtune=native -O2 -fomit-frame-pointer`). If you would like instruct the compiler to generate optimized machine code that matches the processor where it is currently running on you can set your own compile flags by exporting CFLAGS before the build. For example

    export CFLAGS="-march=native -O2 -fomit-frame-pointer"
    zephir build
    

This will generate the best possible code for that chipset but will likely break the compiled object on older chipsets.