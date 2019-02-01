---
layout: article
language: 'en'
version: '4.0'
category: 'installation'
---
# Installation
<hr/>

## Requirements

### Software

> You should always try and use the latest version of Phalcon and PHP as both address bugs, security enhancements as well as performance.
{: .alert .alert-danger }

Along with PHP 7.2 or greater, depending on your application needs and the Phalcon components you need, you might need to install the following extensions:

* [curl][curl]
* [fileinfo][fileinfo]
* [gettext][gettext]
* [gd2][gd2] (to use the [Phalcon\Image\Adapter\Gd](api/Phalcon_Image_Adapter_Gd) class)
* [imagick][imagick] (to use the [Phalcon\Image\Adapter\Imagick](api/Phalcon_Image_Adapter_Imagick) class)
* [json][json]
* `libpcre3-dev` (Debian/Ubuntu), `pcre-devel` (CentOS), `pcre` (macOS)
* [PDO][pdo] Extension as well as the relevant RDBMS specific extension (i.e. [MySQL][mysql], [PostgreSql][postgresql] etc.)
* [OpenSSL][openssl] Extension
* [Mbstring][mbstring] Extension
* [Memcached][memcached] or other relevant cache adapters depending on your usage of cache

> Installing these packages will vary based on your operating system as well as the package manager you use (if any). Please consult the relevant documentation on how to install these extensions.
{: .alert .alert-info }

For the `libpcre3-dev` package you can use the following commands:

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

without brew

Go to the [PCRE][pcre] website and download the latest pcre:

```bash
tar -xzvf pcre-8.42.tar.gz
cd pcre-8.42
./configure --prefix=/usr/local/pcre-8.42
make
make install
ln -s /usr/local/pcre-8.42 /usr/sbin/pcre
ln -s /usr/local/pcre-8.42/include/pcre.h /usr/include/pcre.h
```

For Maverick
```bash
brew install pcre
```
if it gives you error, you can use

```bash
sudo ln -s /opt/local/include/pcre.h /usr/include/
sudo pecl install apc 
```

[curl]: https://secure.php.net/manual/en/book.curl.php
[fileinfo]: https://secure.php.net/manual/en/book.fileinfo.php
[gettext]: https://secure.php.net/manual/en/book.gettext.php
[gd2]: https://secure.php.net/manual/en/book.image.php
[imagick]: https://secure.php.net/manual/en/book.imagick.php
[json]: https://secure.php.net/manual/en/book.json.php
[mbstring]: https://php.net/manual/en/book.mbstring.php
[memcached]: https://php.net/manual/en/book.memcached.php 
[mysql]: https://php.net/manual/en/ref.pdo-mysql.php
[openssl]: https://php.net/manual/en/book.openssl.php
[pcre]: https://www.pcre.org/
[pdo]: https://php.net/manual/en/book.pdo.php
[php-support]: https://secure.php.net/supported-versions.php
[postgresql]: https://php.net/manual/en/ref.pdo-pgsql.php
[psr-3]: https://www.php-fig.org/psr/psr-3/
[psr-extension]: https://github.com/jbboehr/php-psr
