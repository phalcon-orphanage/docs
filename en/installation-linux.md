---
layout: article
language: 'en'
version: '4.0'
category: 'installation'
---
# Installation
<hr/>

## Linux
To install Phalcon on Linux, you will need to add our repository in your distribution and then install it.

### DEB based distributions (Debian, Ubuntu, etc.)

#### Repository installation
Add the repository to your distribution:

**Stable releases**
```bash
curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.deb.sh | sudo bash
```

**Nightly releases**
```bash
curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.deb.sh | sudo bash
```

**Mainline releases (alpha, beta etc.)**
```bash
curl -s https://packagecloud.io/install/repositories/phalcon/mainline/script.deb.sh | sudo bash
```

> This only needs to be done only once, unless your distribution changes or you want to switch from stable to nightly builds.
{: .alert .alert-warning }

#### Phalcon installation
To install Phalcon you need to type the following commands in your terminal:

```bash
sudo apt-get update
sudo apt-get install php7.2-phalcon
```

#### Additional PPAs
**Ondřej Surý**

If you do not wish to use our repository at [packagecloud.io][packagecloud], you can always use the one offered by [Ondřej Surý][ondrej].

Installation of the repo:
```php
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
```

and Phalcon:

```php
sudo apt-get install php-phalcon
```


### RPM based distributions (CentOS, Fedora, etc.)

#### Repository installation
Add the repository to your distribution:

**Stable releases**
```bash
curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.rpm.sh | sudo bash
```

**Nightly releases**
```bash
curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.rpm.sh | sudo bash
```

**Mainline releases (alpha, beta etc.)**
```bash
curl -s https://packagecloud.io/install/repositories/phalcon/mainline/script.rpm.sh | sudo bash
```

> This only needs to be done only once, unless your distribution changes or you want to switch from stable to nightly builds.
{; .alert .alert-warning }


#### Phalcon installation
To install Phalcon you need to issue the following commands in your terminal:

```bash
sudo yum update
sudo yum install php72u-phalcon
```

#### Additional RPMs
**Remi**

[Remi Collet][remi] maintains an excellent repository for RPM based installations. You can find instructions on how to enable it for your distribution [here][remi-config].

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

#### Source
```bash
export CFLAGS="-O2 --fvisibility=hidden"

cd /usr/ports/www/phalcon

make install clean
```

<a name='installation-gentoo'></a>
#### Gentoo
An overlay for installing Phalcon can be found [here][gentoo-overlay]
 
[gentoo-overlay]: https://github.com/smoke/phalcon-gentoo-overlay
[packagecloud]: https://packagecloud.io/phalcon
[ondrej]: https://launchpad.net/~ondrej/+archive/ubuntu/php/
[remi]: https://github.com/remicollet
[remi-config]: https://blog.remirepo.net/pages/Config-en