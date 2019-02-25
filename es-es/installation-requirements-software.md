---
layout: article
language: 'es-es'
version: '4.0'
category: 'installation'
---
# Instalación

* * *

## Requerimentos

### Software

> Siempre deberias utilizar la última versión de PHP y Phalcon para evitar bugs, mejorar la seguridad y el rendimento. {: .alert .alert-danger }

Junto con PHP 7.2 o mayor, dependiendo de las necesidades de su aplicación y de los componentes de Phalcon que necesites, podrías necesitar instalar algunas de las siguientes extensiones:

* [curl](https://secure.php.net/manual/en/book.curl.php)
* [fileinfo](https://secure.php.net/manual/en/book.fileinfo.php)
* [gettext](https://secure.php.net/manual/en/book.gettext.php)
* [gd2](https://secure.php.net/manual/en/book.image.php) (para usar la clase [Phalcon\Image\Adapter\Gd](api/Phalcon_Image_Adapter_Gd))
* [imagick](https://secure.php.net/manual/en/book.imagick.php) (para usar la clase [Phalcon\Image\Adapter\Imagick](api/Phalcon_Image_Adapter_Imagick))
* [json](https://secure.php.net/manual/en/book.json.php)
* `libpcre3-dev` (Debian/Ubuntu), `pcre-devel` (CentOS), `pcre` (en macOS)
* La extensión [PDO](https://php.net/manual/en/book.pdo.php), así como la extensión específica pertinente a su RDBMS ([MySQL](https://php.net/manual/en/ref.pdo-mysql.php),[PostgreSQL](https://php.net/manual/en/ref.pdo-pgsql.php),etc.)
* La extensión [OpenSSL](https://php.net/manual/en/book.openssl.php)
* La extensión [Mbstring](https://php.net/manual/en/book.mbstring.php)
* [Memcached](https://php.net/manual/en/book.memcached.php) u otros adaptadores de caché relevantes en función de su uso de caché

> La instalación de estos paquetes variará en función de su sistema operativo, así como del gestor de paquetes que utilice (si corresponde). Por favor consulte la documentación pertinente sobre cómo instalar estas extensiones. {: .alert .alert-info }

Para el paquete `libpcre3-dev` puedes usar los siguientes comandos:

#### Debian

```bash
sudo apt-get install libpcre3-dev
and then try and install Phalcon again
```

#### CentOS

```bash
sudo yum install pcre-devel
```

#### Mac

```bash
brew install pcre
```

sin brew

Ir al sitio web de [PCRE](https://www.pcre.org/) y descargar la última pcre:

```bash
tar -xzvf pcre-8.42.tar.gz
cd pcre-8.42
./configure --prefix=/usr/local/pcre-8.42
make
make install
ln -s /usr/local/pcre-8.42 /usr/sbin/pcre
ln -s /usr/local/pcre-8.42/include/pcre.h /usr/include/pcre.h
```

Para Maverick

```bash
brew install pcre
```

si te da error, puedes usar

```bash
sudo ln -s /opt/local/include/pcre.h /usr/include/
sudo pecl install apc 
```