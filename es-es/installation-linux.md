---
layout: article
language: 'es-es'
version: '4.0'
category: 'installation'
---
# Instalación

* * *

## Linux

Para instalar Phalcon en Linux, necesitará agregar nuestro repositorio en su distribución y luego instalarlo.

### Distribuciones basadas en DEB (Debian, Ubuntu, etc)

#### Instalación desde el repositorio

Agregar el repositorio en su distribución:

**Versiones estables**

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.deb.sh | sudo bash
```

**Versiones nocturnas**

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.deb.sh | sudo bash
```

**Versiones principales (alpha, beta, etc.)**

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/mainline/script.deb.sh | sudo bash
```

> Esto sólo debe hacerse una sola vez, a menos que cambie su distribución o quiera cambiar de versiones estables a nocturnas. {: .alert .alert-warning }

#### Instalación de Phalcon

Para instalar Phalcon es necesario ejecutar los siguientes comandos en su terminal:

```bash
sudo apt-get update
sudo apt-get install php7.2-phalcon
```

#### PPAs adicionales

**Ondřej Surý**

Si no desea usar nuestro repositorio en [packagecloud.io](https://packagecloud.io/phalcon), puede utilizar uno ofrecido por [Ondřej Surý](https://launchpad.net/~ondrej/+archive/ubuntu/php/).

Instalación del repositorio:

```php
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
```

y Phalcon:

```php
sudo apt-get install php-phalcon
```

### Distribuciones basadas en RPM (CentOS, Fedora, etc.)

#### Instalación desde el repositorio

Agregar el repositorio en su distribución:

**Versiones estables**

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.rpm.sh | sudo bash
```

**Versiones nocturnas**

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.rpm.sh | sudo bash
```

**Versiones principales (alpha, beta, etc.)**

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/mainline/script.rpm.sh | sudo bash
```

> Esto sólo debe hacerse una sola vez, a menos que cambie su distribución o quiera cambiar de versiones estables a nocturnas. {; .alert .alert-warning }

#### Instalación de Phalcon

Para instalar Phalcon es necesario ejecutar los siguientes comandos en su terminal:

```bash
sudo yum update
sudo yum install php72u-phalcon
```

#### RPMs adicionales

**Remi**

[Remi Collet](https://github.com/remicollet) mantiene un excelente repositorio de RPM basado en instalaciones. Puede encontrar instrucciones sobre cómo activar en su distribución [aquí](https://blog.remirepo.net/pages/Config-en).

La instalación de Phalcon después de eso, es tan fácil como:

```bash
yum install php72-php-phalcon4
```

Versiones adicionales están disponibles para cada arquitectura específica (x86/x64), así como versiones específicas de PHP

### FreeBSD

Un puerto está disponible para FreeBSD. Para instalarlo deberá ejecutar los siguientes comandos:

#### pkg_add

```bash
pkg_add -r phalcon
```

#### Codigo fuente

```bash
export CFLAGS="-O2 --fvisibility=hidden"

cd /usr/ports/www/phalcon

make install clean
```

<a name='installation-gentoo'></a>

#### Gentoo

Un overlay para la instalación de Phalcon se puede encontrar [aquí](https://github.com/smoke/phalcon-gentoo-overlay)