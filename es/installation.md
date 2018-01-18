<div class="article-menu">
    <ul>
        <li><a href="#requirements">Requerimientos</a>
            <ul>
                <li><a href="#requirements-hardware">Hardware</a></li>
                <li><a href="#requirements-software">Software</a>
                    <ul>
                        <li>
                            <a href="#requirements-software-optional">Opcional, dependiendo de las necesidades de su aplicación</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        <li><a href="#installation">Instalación</a>
            <ul>
                <li><a href="#installation-linux">Linux</a>
                    <ul>
                        <li>
                            <a href="#installation-linux-debian">Distribuciones basadas en DEB (Debian, Ubuntu, etc)</a>
                            <ul>
                                <li>
                                    <a href="#installation-linux-debian-repository">Instalación desde el repositorio</a>
                                    <ul>
                                        <li>
                                            <a href="#installation-linux-debian-repository-stable">Versiones estables</a>
                                        </li>
                                        <li>
                                            <a href="#installation-linux-debian-repository-nightly">Versiones nocturnas</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#installation-linux-debian-phalcon">Instalación de Phalcon</a>
                                    <ul>
                                        <li>
                                            <a href="#installation-linux-debian-phalcon-php5">PHP 5.x</a>
                                        </li>
                                        <li>
                                            <a href="#installation-linux-debian-phalcon-php7">PHP 7</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#installation-linux-debian-other-ppa">PPAs adicionales</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#installation-linux-rpm">Distribuciones basadas en RPM (CentOS, Fedora, etc.)</a>
                            <ul>
                                <li>
                                    <a href="#installation-linux-rpm-repository">Instalación desde el repositorio</a>
                                    <ul>
                                        <li>
                                            <a href="#installation-linux-rpm-repository-stable">Versiones estables</a>
                                        </li>
                                        <li>
                                            <a href="#installation-linux-rpm-repository-nightly">Versiones nocturnas</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#installation-linux-rpm-phalcon">Instalación de Phalcon</a>
                                    <ul>
                                        <li>
                                            <a href="#installation-linux-rpm-phalcon-php5">PHP 5.x</a>
                                        </li>
                                        <li>
                                            <a href="#installation-linux-rpm-phalcon-php7">PHP 7</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="installation-linux-rpm-other-rpm">RPMs adicionales</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#installation-freebsd">FreeBSD</a>
                        </li>
                        <li>
                            <a href="#installation-linux-gentoo">Gentoo</a>
                        </li>
                    </ul>
                </li>
                <li><a href="#installation-macos">macOS</a>
                    <ul>
                        <li>
                            <a href="#installation-macos-brew">Brew</a>
                        </li>
                        <li>
                            <a href="#installation-macos-macports">MacPorts</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#installation-windows">Windows</a>
                </li>
                <li>
                    <a href="#installation-sources">Compilar desde fuentes</a>
                </li>
                <li>
                    <a href="#installation-sources-advanced">Compilación avanzada</a>
                </li>
            </ul>
        </li>
    </ul>
</div>

<a name='requirements'></a>

# Requerimientos

Phalcon necesita PHP para ejecutar. Su diseño ligeramente acoplado permite los desarrolladores instalar el Phalcon y utilizar su funcionalidad sin extensiones adicionales. Algunos componentes tienen dependencias de otras extensiones. Por ejemplo, para utilizar la conectividad de base de datos, la extensión `php_pdo` será requerida. Si su RDBMS es MySql/MariaDb o Aurora base de datos, también se necessita lá extensión `php_mysqlnd`. De manera similar, si utiliza una base de datos PostgreSQL con Phalcon, la extensión `php_pgsql` será requerida.

<a name='requirements-hardware'></a>

## Hardware

Phalcon fue diseñado para utilizar los menos recursos posibles, al tiempo que ofrece un alto rendimiento. Aunque hemos probado Phalcon en varios ambientes de bajo rendimiento, (por ejemplo 0.25GB RAM, 0.5 CPU), el hardware que usted elija dependerá de las necesidades de su aplicación.

Nuestro sitio web y blog (así como otros sitios) están alojados en una VM de Amazon con 512MB de RAM y 1 vCPU.

<a name='requirements-software'></a>

## Software

* PHP >= 5.5

<div class="alert alert-danger">
    <p>
        Siempre deberias utilizar la última versión de PHP y Phalcon para evitar bugs, mejorar la seguridad y el rendimento. PHP 5.5 será obsoleto en un futuro cercano, y Phalcon 4 sólo soportará PHP 7.
    </p>
</div>

Phalcon necesita las siguientes extensiones para ser ejecutado (mínimo):

* `curl`
* `gettext`
* `GD2` (para usar la clase `Phalcon\Image\Adapter\Gd`)
* `libpcre3-dev` (Debian/Ubuntu), `pcre-devel` (CentOS), `pcre` (en macOS)
* `json`
* `mbstring`
* `pdo_*`
* `fileinfo`
* `openssl`

<a name='requirements-software-optional'></a>

### Opcional, dependiendo de las necesidades de su aplicación

* La extensión [PDO](http://php.net/manual/en/book.pdo.php), así como la extensión específica pertinente a su RDBMS ([MySQL](http://php.net/manual/en/ref.pdo-mysql.php),[PostgreSQL](http://php.net/manual/en/ref.pdo-pgsql.php),etc.)
* La extensión [OpenSSL](http://php.net/manual/en/book.openssl.php)
* La extensión [Mbstring](http://php.net/manual/en/book.mbstring.php)
* [Memcache](http://php.net/manual/en/book.memcache.php), [Memcached](http://php.net/manual/en/book.memcached.php) u otros adaptadores de caché correspondientes dependiendo de su uso de caché

<a name='installation'></a>

# Instalación

Ya que Phalcon es compilado como una extensión PHP, su instalación es un poco diferente que cualquier otro framework PHP tradicional. Phalcon necesita ser instalado y cargado como un módulo en su servidor web.

<a name='installation-linux'></a>

## Linux

Para instalar Phalcon en Linux, necesitará agregar nuestro repositorio en su distribución y luego instalarlo.

<a name='installation-linux-debian'></a>

### Distribuciones basadas en DEB (Debian, Ubuntu, etc.)

<a name='installation-linux-debian-repository'></a>

#### Instalación desde el repositorio

Agregar el repositorio en su distribución:

<a name='installation-linux-debian-repository-stable'></a>

##### Versiones estables

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.deb.sh | sudo bash
```

o

<a name='installation-linux-debian-repository-nightly'></a>

##### Versiones nocturnas

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.deb.sh | sudo bash
```

<div class="alert alert-warning">
    <p>
        Esto sólo debe hacerse una sola vez, a menos que cambie su distribución o quiera cambiar de versiones estables a nocturnas.
    </p>
</div>

<a name='installation-linux-debian-phalcon'></a>

#### Instalación de Phalcon

Para instalar Phalcon es necesario ejecutar los siguientes comandos en su terminal:

<a name='installation-linux-debian-phalcon-php5'></a>

##### PHP 5.x

```bash
sudo apt-get update
sudo apt-get install php5-phalcon
```

<a name='installation-linux-debian-phalcon-php7'></a>

##### PHP 7

```bash
sudo apt-get update
sudo apt-get install php7.0-phalcon
```

<a name='installation-linux-debian-other-ppa'></a>

#### PPAs adicionales

#### Ondřej Surý

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

<a name='installation-linux-rpm'></a>

### Distribuciones basadas en RPM (CentOS, Fedora, etc.)

<a name='installation-linux-rpm-repository'></a>

#### Instalación desde el repositorio

Agregar el repositorio en su distribución:

<a name='installation-linux-rpm-repository-stable'></a>

##### Versiones estables

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.rpm.sh | sudo bash
```

o

<a name='installation-linux-rpm-repository-nightly'></a>

##### Versiones nocturnas

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.rpm.sh | sudo bash
```

<div class="alert alert-warning">
    <p>
        Esto sólo debe hacerse una sola vez, a menos que cambie su distribución o quiera cambiar de versiones estables a nocturnas.
    </p>
</div>

<a name='installation-linux-rpm-phalcon'></a>

#### Instalación de Phalcon

Para instalar Phalcon es necesario ejecutar los siguientes comandos en su terminal:

<a name='installation-linux-rpm-phalcon-php5'></a>

##### PHP 5.x

```bash
sudo yum update
sudo yum install php56u-phalcon
```

<a name='installation-linux-rpm-phalcon-php7'></a>

##### PHP 7

```bash
sudo yum update
sudo yum install php70u-phalcon
```

<a name='installation-linux-rpm-other-rpm'></a>

#### RPMs Adicionales

##### Remi

[Remi Collet](https://github.com/remicollet) mantiene un excelente repositorio de RPM basado en instalaciones. Puede encontrar instrucciones sobre cómo activar en su distribución [aquí](https://blog.remirepo.net/pages/Config-en).

La instalación de Phalcon después de eso, es tan fácil como:

```bash
yum install php56-php-phalcon3
```

Versiones adicionales están disponibles para cada arquitectura específica (x86/x64), así como versiones específicas de PHP (5.5, 5.6, 7.x)

<a name='installation-freebsd'></a>

## FreeBSD

Una versión alternativa está disponible para FreeBSD. Para instalarlo deberá ejecutar los siguientes comandos:

### `pkg_add`

```bash
pkg_add -r phalcon
```

### Codigo fuente

```bash
export CFLAGS="-O2 --fvisibility=hidden"

cd /usr/ports/www/phalcon

make install clean
```

<a name='installation-gentoo'></a>

## Gentoo

Un overlay para la instalación de Phalcon puede encontrarse aquí <https://github.com/smoke/phalcon-gentoo-overlay>

<a name='installation-macos'></a>

## macOS

En sistemas macOS puede compilar e instalar la extensión con `brew`, `macports` o el código fuente:

### Requerimientos

* Recursos para el desarrollo PHP 5.5.x/5.6.x/7.0.x/7.1.x
* XCode

<a name='installation-macos-brew'></a>

### Brew

```bash
brew tap homebrew/homebrew-php
brew install php55-phalcon
brew install php56-phalcon
brew install php70-phalcon
brew install php71-phalcon
```

<a name='installation-macos-macports'></a>

### MacPorts

```bash
sudo port install php55-phalcon
sudo port install php56-phalcon
```

Editar el archivo php.ini y luego añadir al final:

```ini
extension=php_phalcon.so
```

Reinicie su servidor Web.

<a name='installation-windows'></a>

## Windows

Para utilizar Phalcon en Windows, usted necesitará instalar el phalcon.dll. Hemos compilado varias DLLs dependiendo de la plataforma de destino. Los archivos dll pueden encontrarse en nuestra página de [descarga](https://phalconphp.com/en/download/windows).

Identifique su instalación de PHP, así como la arquitectura. Si descarga el archivo DLL erróneo, Phalcon no funcionará. `phpinfo()` contiene esta información. En el ejemplo siguiente, vamos a necesitar la versión NTS de la DLL:

![phpinfo](/images/content/phpinfo-api.png)

Las DLL disponibles son:

| Arquitectura | Versión | Tipo                  |
|:------------:|:-------:| --------------------- |
|     x64      |   7.x   | Thread safe           |
|     x64      |   7.x   | Non Thread safe (NTS) |
|     x86      |   7.x   | Thread safe           |
|     x86      |   7.x   | Non Thread safe (NTS) |
|     x64      |   5.6   | Thread safe           |
|     x64      |   5.6   | Non Thread safe (NTS) |
|     x86      |   5.6   | Thread safe           |
|     x86      |   5.6   | Non Thread safe (NTS) |
|     x64      |   5.5   | Thread safe           |
|     x64      |   5.5   | Non Thread safe (NTS) |
|     x86      |   5.5   | Thread safe           |
|     x86      |   5.5   | Non Thread safe (NTS) |

Editar el archivo php.ini y luego añadir al final:

```ini
extension=php_phalcon.dll
```

Reiniciar el servidor web.

<a name='installation-sources'></a>

## Compilar desde código fuente

Compilar desde código fuente es similar a la mayoría de los entornos (Linux/macOS).

### Requerimientos

* Recursos de desarollo de PHP 5.5.x/5.6.x/7.0.x/7.1.x
* Compilador GCC (Linux/Solaris/FreeBSD) o Xcode (macOS)
* re2c >= 0.13
* libpcre-dev

Puede instalar estos paquetes en su sistema con el gestor de paquetes relevantes. Las instrucciones para las distribuciones de linux populares están a continuación:

#### Ubuntu

```bash
sudo apt-get install php5-dev libpcre3-dev gcc make
```

#### Suse

```bash
sudo zypper install php5-devel gcc make
```

#### CentOS/Fedora/RHEL

```bash
sudo yum install php-devel pcre-devel gcc make
```

### Compilar Phalcon

Primero tenemos que clonar Phalcon desde el repositorio de Github

```bash
git clone https://github.com/phalcon/cphalcon
```

y ahora compilar la extensión

```bash
cd cphalcon/build
sudo ./install
```

Ahora usted tendrá que añadir `extension=phalcon.so` a su PHP ini y reiniciar su servidor web, para que la extensión sea cargada.

```ini
# Suse: Agregue un archivo llamado phalcon.ini en /etc/php5/conf.d/ con el siguiente contenido:
extension=phalcon.so

# CentOS/RedHat/Fedora: Agregue un archivo llamado phalcon.ini en /etc/php.d/ con el siguiente contenido:
extension=phalcon.so

# Ubuntu/Debian con apache2: Agregue un archivo llamado 30-phalcon.ini en /etc/php5/apache2/conf.d/ con el siguiente contenido:
extension=phalcon.so

# Ubuntu/Debian con php5-fpm: Agregue un archivo llamado 30-phalcon.ini en /etc/php5/fpm/conf.d/ con el siguiente contenido:
extension=phalcon.so

# Ubuntu/Debian con php5-cli: Agregue un archivo llamado 30-phalcon.ini en /etc/php5/cli/conf.d/ con el siguiente contenido:
extension=phalcon.so
```

<a name='installation-sources-advanced'></a>

## Compilación Avanzada

Phalcon detecta automáticamente su arquitectura, sin embargo, puede forzar la compilación para una arquitectura específica:

```bash
cd cphalcon/build

# Una de las siguientes:
sudo ./install --arch 32bits
sudo ./install --arch 64bits
sudo ./install --arch safe
```

Si el instalador automático falla, puedes generar la extensión manualmente:

```bash
git clone https://github.com/phalcon/cphalcon
# cd cphalcon/build/php5/32bits
cd cphalcon/build/php5/64bits

# NOTA: para PHP 7 debe usar
# cd cphalcon/build/php7/32bits
# o
# cd cphalcon/build/php7/64bits

make clean
phpize --clean

export CFLAGS="-O2 --fvisibility=hidden"
./configure --enable-phalcon

make
make install
```

Si tienes versiones específicas de php ejecutando:

```bash
git clone https://github.com/phalcon/cphalcon
# cd cphalcon/build/php5/32bits
cd cphalcon/build/php5/64bits

# NOTA: para PHP 7 debe usar
# cd cphalcon/build/php7/32bits
# o
# cd cphalcon/build/php7/64bits

make clean
/opt/php-5.6.15/bin/phpize --clean

export CFLAGS="-O2 --fvisibility=hidden"
./configure --with-php-config=/opt/php-5.6.15/bin/php-config --enable-phalcon

make
make install
```

Ahora usted tendrá que añadir `extension=phalcon.so` a su archivo PHP ini y reiniciar su servidor web, para que la extensión sea cargada.

<a name='installation-testing'></a>
Puede crear un pequeño script en la raíz del servidor web que tenga lo siguiente:

```php
<?php

phpinfo();
```

y cargarlo en su navegador web. Debería haber una sección para Phalcon. Si no la hay, asegúrese de que su extensión ha sido compilada correctamente, que hizo los cambios necesarios a su `php.ini` y también que ha reiniciado el servidor web.

También puede comprobar la instalación desde la línea de comandos:

```bash
php -r 'print_r(get_loaded_extensions());'
```

Esto devolverá algo similar a esto:

```php
Array
(
    [0] => Core
    [1] => libxml
    [2] => filter
    [3] => SPL
    [4] => standard
    [5] => phalcon
    [6] => pdo_mysql
)
```

También puede ver los módulos instalados mediante la CLI:

```bash
php -m
```

<div class="alert alert-danger">
    <p>
        Tenga en cuenta que en algunos sistemas basado en Linux, puede que necesite cambiar dos archivos <code>php.ini</code>, uno para el servidor web (Apache/Nginx) y otro para el CLI. Si Phalcon es cargado solamente para el servidor web, necesita localizar el <code>php.ini</code> del CLI y hacer las adiciones necesarias para que el módulo que se cargue.
    </p>
</div>
