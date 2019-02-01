---
layout: article
language: 'it-it'
version: '4.0'
category: 'installation'
---
# Installation

* * *

## Linux

To install Phalcon on Linux, you will need to add our repository in your distribution and then install it.

### Distribuzioni (Debian, Ubuntu, ecc.) basate su DEB

#### Installazione da repository

Add the repository to your distribution:

**Versioni stabili**

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.deb.sh | sudo bash
```

**Versioni "notturne"**

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.deb.sh | sudo bash
```

**Mainline releases (alpha, beta etc.)**

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/mainline/script.deb.sh | sudo bash
```

> This only needs to be done only once, unless your distribution changes or you want to switch from stable to nightly builds. {: .alert .alert-warning }

#### Installazione Phalcon

To install Phalcon you need to type the following commands in your terminal:

```bash
sudo apt-get update
sudo apt-get install php7.2-phalcon
```

#### Ulteriori PPAs

**Ondřej Surý**

If you do not wish to use our repository at [packagecloud.io](https://packagecloud.io/phalcon), you can always use the one offered by [Ondřej Surý](https://launchpad.net/~ondrej/+archive/ubuntu/php/).

Installation of the repo:

```php
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
```

and Phalcon:

```php
sudo apt-get install php-phalcon
```

### Distribuzioni (CentOS, Fedora, ecc.) basate su RPM

#### Installazione da repository

Add the repository to your distribution:

**Versioni stabili**

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.rpm.sh | sudo bash
```

**Versioni "notturne"**

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.rpm.sh | sudo bash
```

**Mainline releases (alpha, beta etc.)**

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/mainline/script.rpm.sh | sudo bash
```

> This only needs to be done only once, unless your distribution changes or you want to switch from stable to nightly builds. {; .alert .alert-warning }

#### Installazione Phalcon

To install Phalcon you need to issue the following commands in your terminal:

```bash
sudo yum update
sudo yum install php72u-phalcon
```

#### Ulteriori pacchetti RPM

**Remi**

[Remi Collet](https://github.com/remicollet) maintains an excellent repository for RPM based installations. You can find instructions on how to enable it for your distribution [here](https://blog.remirepo.net/pages/Config-en).

Installing Phalcon after that is as easy as:

```bash
yum install php72-php-phalcon4
```

Additional versions are available both architecture specific (x86/x64) as well as PHP version specific

### FreeBSD

A port is available for FreeBSD. To install it you will need to issue the following commands:

#### pkg_add

```bash
pkg_add -r phalcon
```

#### Codice Sorgente

```bash
export CFLAGS="-O2 --fvisibility=hidden"

cd /usr/ports/www/phalcon

make install clean
```

<a name='installation-gentoo'></a>

#### Gentoo

An overlay for installing Phalcon can be found [here](https://github.com/smoke/phalcon-gentoo-overlay)