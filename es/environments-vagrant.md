<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Resumen</a> 
      <ul>
        <li>
          <a href="#requirements">Requerimentos</a>
        </li>
        <li>
          <a href="#packages-included">Paquetes incluidos</a>
        </li>
        <li>
          <a href="#installation">Instalación</a> <ul>
            <li>
              <a href="#installation-vagrant-box">Instalando una Caja Vagrant</a>
            </li>
            <li>
              <a href="#installation-phalcon-box">Instalando la Caja Phalcon</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#installation-configuration">Configuraciones</a> 
          <ul>
            <li>
              <a href="#installation-configuration-setting-provider">Establecer el Proveedor</a>
            </li>
            <li>
              <a href="#installation-configuration-memory-cpu">Memoria y CPU</a>
            </li>
            <li>
              <a href="#installation-configuration-shared-folders">Carpetas compartidas</a>
            </li>
            <li>
              <a href="#installation-configuration-nginx">Sitios Nginx</a> 
              <ul>
                <li>
                  <a href="#installation-configuration-custom-nginx">Configuración Personalizada de Nginx</a>
                </li>
                <li>
                  <a href="#installation-configuration-hosts">Configurando el archivo <code>hosts</code></a>
                </li>
              </ul>
            </li>
            <li>
              <a href="#installation-aditional-packages">Instalación de paquetes adicionales</a>
            </li>
            <li>
              <a href="#installation-launching-phalcon-box">Lanzando la Caja Phalcon</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#daily-usage">Uso diario</a> 
          <ul>
            <li>
              <a href="#daily-usage-accessing-box-globally">Accediendo a la Caja Phalcon de forma Global</a> 
              <ul>
                <li>
                  <a href="#daily-usage-accessing-box-globally-mac-linux">Mac o Linux</a>
                </li>
                <li>
                  <a href="#daily-usage-accessing-box-globally-windows">Windows</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="#daily-usage-ssh">Conectar Vía SSH</a>
            </li>
            <li>
              <a href="#daily-usage-databases">Conexión a Bases de Datos</a>
            </li>
            <li>
              <a href="#daily-usage-additional-sites">Agregando Sitios Adicionales</a>
            </li>
            <li>
              <a href="#daily-usage-environment-variables">Variables de Entorno</a> 
              <ul>
                <li>
                  <a href="#daily-usage-environment-global-variables">Variables Globales</a>
                </li>
                <li>
                  <a href="#daily-usage-environment-site-variables">Variables de Sitio</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="#daily-usage-ports">Puertos</a> 
              <ul>
                <li>
                  <a href="#daily-usage-ports-forwarding">Redirigir Puertos Adicionales</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="#daily-usage-sharing-environment">Compartiendo tu Entorno</a>
            </li>
            <li>
              <a href="#daily-usage-network-interfaces">Interfaces de Red</a>
            </li>
            <li>
              <a href="#daily-usage-updating-box">Actualizando la Caja Phalcon</a>
            </li>
            <li>
              <a href="#daily-usage-provider-settings">Configuración Específica del Proveedor</a> 
              <ul>
                <li>
                  <a href="#daily-usage-provider-settings-virtualbox">VirtualBox</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="#daily-usage-mail-catcher">Mail Catcher</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#troubleshooting">Resolución de problemas</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Resumen

La Caja de Phalcon o Phalcon Box utiliza por defecto la caja **phalcon/xenial64** de [Vagrant](https://atlas.hashicorp.com/phalconphp/boxes/xenial64/) por compatibilidad. Si usted decide usar un ISO de 64 bits puede que necesite actualizar el BIOS para habilitar la [ Virtualización](https://en.wikipedia.org/wiki/X86_virtualization) con `AMD-V`, `Intel VT-x` o `VIA VT`.

La primera vez que usted aprovisiona un nuevo ambiente con `vagrant up`, el proceso tomará mucho más tiempo ya que tendrá que descargar la caja (`phalconphp/xenial64`) en su equipo en primer lugar. Las posteriores disposiciones del entorno serán mucho más rápidas.

<a name='requirements'></a>

## Requerimentos

* Sistema Operativo: Windows, Linux, o macOS
* [Virtualbox](https://www.virtualbox.org/wiki/Downloads) >= 5.1 (si deseas construir la Caja VirtualBox)
* [VMware Fusion](http://www.vmware.com/products/fusion) (o Workstation - Si desea construir la Caja VMware)
* [Vagrant](https://www.vagrantup.com/downloads.html) >= 1.9.8

<a name='packages-included'></a>

## Paquetes incluidos

* Ansible
* Beanstalkd
* Blackfire
* Composer
* Git
* goreplace
* Mailhog
* Memcached
* MongoDB
* MySQL
* Nginx
* Ngrok
* Node.js (con Yarn, Bower, Grunt, y Gulp)
* PHIVE
* PHP 7.1
* PHPMD
* PHP_CodeSniffer
* Phalcon
* Phing
* PostgreSQL
* Redis
* Sqlite3
* Ubuntu 16.04
* Zephir

<a name='installation'></a>

## Instalación

<a name='installation-vagrant-box'></a>

### Instalando una Caja Vagrant

Antes de iniciar su entorno, la caja de Phalcon, deberá instalar VirtualBox, o VMWare como Vagrant. Todos estos paquetes de software proporcionan unos instaladores visuales fáciles de usar para todos los sistemas operativos populares.

Una vez que VirtualBox/VMware y Vagrant han sido instalados, se debe agregar la caja `phalconphp/xenial64` a la instalación de Vagrant, para esto se usa el siguiente comando desde una consola. Tomará algunos minutos para que la caja se descargue, esto dependerá de la velocidad de conexión a internet:

```bash
vagrant box add phalconphp/xenial64
```

Si este comando falla, asegúrese de que su instalación de Vagrant esté actualizada.

<div class="alert alert-warning">
    <p>
        To use the VMware provider, you will need to purchase both VMware Fusion / Workstation and the <a href="https://www.vagrantup.com/vmware">VMware Vagrant plug-in</a>. Though it is not free, VMware can provide faster shared folder performance out of the box.  
    </p>
</div>

<a name='installation-phalcon-box'></a>

### Instalando la Caja Phalcon

Es posibles instalar directamente la Caja de Phalcon o simplemente clonar el repositorio. Considere clonar el repositorio en una carpeta del `workspace` o espacio de trabajo, dentro del directorio `home`, así la Caja de Phalcon servirá de host para todos sus proyectos de Phalcon:

```bash
cd ~
git clone https://github.com/phalcon/box.git workspace
```

La rama `master` siempre contiene la última versión estable de Phalcon. Si usted desea consultar versiones anteriores o nuevas, actualmente en desarrollo, pase a la rama/etiqueta pertinente.

Puede encontrar la última versión estable en la [Página de Lanzamientos de Github](https://github.com/phalcon/box/releases):

```bash
# Clonar el lanzamiento deseado...
git checkout v2.4.0
```

Una vez que ha clonado el repositorio de la Caja de Phalcon, ejecute el comando de instalación desde el directorio raíz de Phalcon para crear el archivo de configuración `settings.yml`. En el directorio de la Caja de Phalcon, se colocará el archivo `settings.yml`:

```bash
# macOS o Linux
./install
```

```cmd
rem Windows
install.bat
```

Ahora que está listo para aprovisionar su Máquina Virtual, ejecute el siguiente comando:

```bash
vagrant up
```

<a name='installation-configuration'></a>

## Configuraciones

<a name='installation-configuration-setting-provider'></a>

### Establecer el Proveedor

La clave del proveedor en su archivo `settings.yml` indica qué proveedor Vagrant debe usarse: `virtualbox`, `vmware_fusion` o `vmware_workstation`. Puede configurar el proveedor que prefiera:

```yaml
provider: virtualbox
```

<a name='installation-configuration-memory-cpu'></a>

### Memoria y CPU

Por defecto se establece el uso de 2GB de memoria RAM. Es posible modificarlo en el archivo `settings.yml` y simplemente ejecutar `vagrant reload`:

```yaml
memory: 4096
```

Si lo desea, también puede utilizar más de un núcleo, simplemente cambie esta linea en el mismo archivo:

```yaml
cpus: 4
```

<a name='installation-configuration-shared-folders'></a>

### Carpetas compartidas

La propiedad `folders` del archivo `settings.yml` lista todas las carpetas que desea compartir con en ambiente de la Caja Phalcon. Tan pronto como se produzcan cambios en archivos en estos directorios, se sincronizarán entre tu máquina local y el entorno de la Caja Phalcon. Se pueden configurar tantas carpetas como sean necesarias:

```yaml
folders:

    - map: ~/workspace
      to: /home/vagrant/workspace
```

Para habilitar [NFS](https://www.vagrantup.com/docs/synced-folders/nfs.html), simplemente debe indicarse en la configuración de la carpeta a sincronizar:

```yaml
folders:

    - map: ~/workspace
      to: /home/vagrant/workspace
      type: "nfs"
```

Puede pasar cualquiera de las opciones soportadas por las [carpetas sincronizadas](https://www.vagrantup.com/docs/synced-folders/basic_usage.html) de Vagrant enumerándolas en la clave `options`:

```yaml
folders:

    - map: ~/workspace
      to: /home/vagrant/workspace
      type: "nfs"
      options:
            rsync__args: ["--verbose", "--archive", "--delete", "-zz"]
            rsync__exclude: ["node_modules"]
```

<div class="alert alert-danger">
    <p>
        macOS users probably will need to install <code>vagrant-bindfs</code> plugin to fix shared folder (NFS) permission issue:    
    </p>
</div>

```bash
vagrant plugin install vagrant-bindfs
```

<a name='installation-configuration-nginx'></a>

### Sitios Nginx

La propiedad `sites` permite de una manera sencilla mapear un "dominio" a una carpeta del entorno de desarrollo de la Caja de Phalcon. El archivo `settings.yml` incluye una configuración de ejemplo de un sitio. Puedes agregar cuantos sitios al entorno de la Caja de Phalcon como sean necesarios. La Caja de Phalcon puede servir como un entorno práctico y virtualizado para cada proyecto Phalcon en el que esté trabajando:

```yaml
sites:

    - map: phalcon.local
      to:  /home/vagrant/workspace/phalcon/public
```

Puede utilizar el parámetro `type` para especificar el tipo de configuración de Nginx para el sitio. Por ejemplo:

```yaml
sites:

    - map:  landing.local
      to:   /home/vagrant/workspace/landing/public
      type: spa
```

Por efecto el tipo es `phalcon`. Si el tipo deseado no esta permitido o disponible se utilizará `phalcon` como alternativa.

Tipos disponibles:

* `phalcon`
* `slayer`
* `phanbook`
* `proxy`
* `spa`
* `silverstripe`
* `symfony2`
* `statamic`
* `laravel`
* `zend`

Siéntase libre se sugerir un nuevo tipo de configuración de Nginx abriendo una [Solicitud de Nueva Característica](https://github.com/phalcon/box/issues/new).

<div class="alert alert-warning">
    <p>
        If you change the <code>sites</code> property after provisioning the Phalcon Box, you must re-run <code>vagrant reload --provision</code> to update the Nginx configuration on the virtual machine.
    </p>
</div>

<a name='installation-configuration-custom-nginx'></a>

#### Configuración Personalizada de Nginx

También puede crear sus propios tipos. Para hacer esto, tome como base cualquier plantilla de la carpeta `provisioning/templates/nginx` y haga los cambios necesarios. Es necesario colocar este archivo en la misma carpeta. Después de eso, usted puede utilizar su propio tipo personalizado:

```yaml
sites:

    - map:  my-site.local
      to:   /home/vagrant/workspace/my-site/public
      # provisioning/templates/nginx/phalcon-advanced.conf.j2
      type: phalcon-advanced
```

¿Necesita una configuración personalizada de tipo *global* para Nginx? Sí, esto es posible. Por ejemplo, vamos a crear la configuración de auto-índice.

Archivo `/home/user/nginx.d/00-autoindex.conf`:

```nginx
# Procesa solicitudes terminadas con una barra (‘/’) y produce un listado del directorio
autoindex on;
```

Añadir los ajustes deseados al archivo y luego añadirlo a la sección `copy`:

```yaml
copy:

    - from: /home/user/nginx.d/00-autoindex.conf
      to: /etc/nginx/conf.d/
```

<a name='installation-configuration-hosts'></a>

#### Configurando el archivo `hosts`

Debe agregar los "dominios" para sus sitios web en Nginx en el fichero `hosts` en su máquina. El archivo hosts redirige las peticiones a sus sitios de Phalcon en su máquina en la Caja de Phalcon. En Mac y Linux, este archivo esta ubicado en `/etc/hosts`. En Windows, se encuentra en `C:\Windows\System32\drivers\etc\hosts`. Las lineas que debes añadir a este archivo deben ser algo similar a esto:

    192.168.50.4  phalcon.local
    

Asegúrese de que la dirección IP listada es la misma que esta en el archivo `settings.yml`. Una vez haya agregado el domino a su fichero `hosts` y lanzado la Caja de Vagrant será capaz de acceder al sitio web a través de su navegador web:

    http://phalcon.local
    

<div class="alert alert-danger">
    <p>
        To enable adding new sites to the <code>hosts</code> file automatically use <code>vagrant-hostsupdater</code> plugin: 
    </p>
</div>

```bash
vagrant plugin install vagrant-hostsupdater
```

<a name='installation-aditional-packages'></a>

### Instalación de paquetes adicionales

Hicimos nuestro mejor esfuerzo para proporcionar una Caja Phalcon con todos los programas necesarios y bibliotecas. Sin embargo, debe entenderse que el usuario normal no necesita todos los paquetes posibles que se pueden instalar. La Caja de Phalcon debe ser de un tamaño razonable para que pueda ser utilizado incluso por aquellas personas que están experimentando dificultades con el ancho de banda del canal de Internet.

Debido a estas consideraciones, permitimos a los usuarios especificar qué paquetes personalizados necesitan por cada disposición. Para instalar los paquetes necesarios añadir sus nombres en la sección de `apt`:

```yaml
# Provisioning features
provision:
    # do full system update for each full provisoning
    update: true

    # Install wkhtmltopdf and libffi-dev packages
    apt:

        - wkhtmltopdf
        - libffi-dev
```

<a name='installation-launching-phalcon-box'></a>

### Lanzando la Caja Phalcon

Una vez han editado el archivo `settings.yml` a tu gusto, ejecuta el comando `vagrant up` desde el directorio de la caja de Phalcon (por ejemplo `$HOME/workspace`). Vagrant iniciará la máquina virtual y automáticamente configurará los directorios compartidos y los sitios Nginx.

Para destruir la máquina, utilizar el comando `vagrant destroy --force`.

<a name='daily-usage'></a>

## Uso diario

<a name='daily-usage-accessing-box-globally'></a>

### Accediendo a la Caja Phalcon de forma Global

A veces puede querer ejecutar `vagrant up` en su Caja de Phalcon desde cualquier punto de su sistema de ficheros. Usted puede hacer esto en sistemas Mac o Linux añadiendo una [función Bash](http://tldp.org/HOWTO/Bash-Prog-Intro-HOWTO-8.html) a tu perfil de Bash. En Windows, puede realizar esto agregando un fichero "batch" a su `PATH`. Estos scripts le permitirán ejecutar cualquier comando Vagrant desde cualquier punto de su sistema y ese comando apuntará automáticamente a su instalación de la Caja de Phalcon:

<a name='daily-usage-accessing-box-globally-mac-linux'></a>

#### Mac o Linux

```bash
function box()
{
    ( cd $HOME/workspace && vagrant $* )
}
```

<div class="alert alert-warning">
    <p>
        Make sure to tweak the <code>$HOME/workspace</code> path in the function to the location of your actual Phalcon Box installation. Once the function is installed, you may run commands like <code>box up</code> or <code>box ssh</code> from anywhere on your system. 
    </p>
</div>

<a name='daily-usage-accessing-box-globally-windows'></a>

#### Windows

Cree un fichero batch `box.bat`, en cualquier parte de su máquina, con el siguiente contenido:

```cmd
@echo off

set cwd=%cd%
set box=C:\workspace

cd /d %box% && vagrant %*
cd /d %cwd%

set cwd=
set box=
```

<div class="alert alert-warning">
    <p>
        Make sure to tweak the example <code>C:\workspace</code> path in the script to the actual location of your Phalcon Box installation. After creating the file, add the file location to your <code>PATH</code>. You may then run commands like <code>box up</code> or <code>box ssh</code> from anywhere on your system.
    </p>
</div>

<a name='daily-usage-ssh'></a>

### Conectar Vía SSH

Se puede acceder a la máquina virtual utilizando SSH introduciendo el comando `vagrant ssh` desde su directorio de la Caja de Phalcon.

Pero, puesto que probablemente necesitará SSH en la máquina de la Caja de Phalcon con frecuencia, considere agregar la "función" [descrita anteriormente](#daily-usage-accessing-box-globally) a su máquina host para acceder rápidamente por SSH en la Caja de Phalcon.

<a name='daily-usage-databases'></a>

### Conexión a Bases de Datos

Para conectar con su base de datos MySQL, PostgreSQL o MongoDB desde su cliente de base de datos en su sistema anfitrión, debería conectar a `127.0.0.1` por el puerto `33060` para MySQL, `54320` para PostgreSQL o `27017` para MongoDB. El nombre de usuario y la contraseña para las bases de datos es `phalcon` y `secret` respectivamente.

<div class="alert alert-danger">
    <p>
        You should only use these non-standard ports when connecting to the databases from your host machine. Se utilizará el puerto predeterminado <code>330</code> y '' en su archivo de configuración de base de datos de Phalcon si Phalcon está funcionando dentro de la máquina Virtual.
    </p>
</div>

Para acceder a la consola interactiva dependiendo del tipo de la base de datos desde la Caja de Phalcon:

* **Postgres:** `psql -U phalcon -h localhost` (contraseña `secret`)
* **MySQL:** `mysql` (La contraseña no es necesaria para la herramienta CLI)
* **MondoDB:** `mongo` (La contraseña no es necesaria para la herramienta CLI)

<a name='daily-usage-additional-sites'></a>

### Agregando Sitios Adicionales

Una vez que tu entorno de la Caja de Phalcon está aprovisionado y funcionando, quizá quieras añadir sitios Nginx adicionales para tus aplicaciones. Puedes correr tantos projectos Phalcon como desees en un entorno simple de Caja de Phalcon. Para agregar un sitio adicional, simplemente agregue el sitio a su fichero `settings.yaml`:

```yaml
sites:

    - map: phalcon.local
      to:  /home/vagrant/workspace/phalcon/public
    - map: pdffiller.local
      to:  /home/vagrant/workspace/pdffiller/public
    - map: blog.local
      to:  /home/vagrant/workspace/blog/public
```

Si Vagrant no está gestionando su fichero "hosts" automáticamente, además deberá añadir el nuevo sitio a ese fichero:

    192.168.50.4  phalcon.local
    192.168.50.4  pdffiller.local
    192.168.50.4  blog.local
    

<div class="alert alert-danger">
    <p>
        To enable adding new sites to the <code>hosts</code> file automatically use <code>vagrant-hostsupdater</code> plugin:
    </p>
</div>

```bash
vagrant plugin install vagrant-hostsupdater
```

Una vez que el sitio ha sido agregado, ejecute el comando `vagrant reload --provision` desde su directorio de la Caja de Phalcon.

<a name='daily-usage-environment-variables'></a>

### Variables de entorno

<a name='daily-usage-environment-global-variables'></a>

#### Variables Globales

Fácilmente puede registrar variables de entorno globales. Simplemente agregue la variable y el valor en la sección `variables`:

```yaml
variables:

    - key: TEST_DB_MYSQL_USER
      value: phalcon

    - key: TEST_DB_MYSQL_PASSWD
      value: secret

    - key: TEST_DB_MYSQL_DSN
      value: "mysql:host=127.0.0.1;dbname=phalcon_test"
```

De esta manera es posible habilitar el uso de variables en sus aplicaciones o códigos. Por ejemplo, al configurar [Codeception](http://codeception.com) de esta manera:

```yaml
# File codeception.yml
params:
    # Get params from environment

    - env
```

Usted podrá configurar el conjunto de unidades de la siguiente manera:

```yaml
# File tests/unit.suite.yml
class_name: UnitTester
modules:
    enabled:

        - Db
    config
        Db:
            dsn: %TEST_DB_MYSQL_DSN%
            user: %TEST_DB_MYSQL_USER%
            password: %TEST_DB_MYSQL_PASSWD%
            populate: true
            cleanup: false
            dump: tests/_data/schemas/mysql/mysql.dump.sql
```

<a name='daily-usage-environment-site-variables'></a>

#### Variables de Sitio

Las variables del sitio se pueden agregar fácilmente con los valores de `fastcgi_param` en la configuración del host de su sitio dentro de la Caja de Phalcon. Por ejemplo, podemos agregar una variable `APP_ENV` con el valor `development`:

```yaml
sites:

    - map: phalconbox.local
      to: /var/www/phalconbox/public
      variables:
          - key: APP_ENV
            value: development
          # Yet another example
          - key: AMQP_DEBUG
            value: true
```

<a name='daily-usage-ports'></a>

### Puertos

Por defecto, los siguientes puertos se redirigen al entorno de tu Caja Phalcon:

| Puerto redireccinado | Caja Phalcon | Sistema de Host |
| -------------------- |:------------:|:---------------:|
| **SSH**              |     `22`     |     `2222`      |
| **HTTP**             |     `80`     |     `8000`      |
| **HTTPS**            |    `443`     |     `44300`     |
| **MySQL**            |    `3306`    |     `33060`     |
| **Postgres**         |    `5432`    |     `54320`     |
| **MailHog**          |    `8025`    |     `8025`      |

<a name='daily-usage-ports-forwarding'></a>

#### Redirigir Puertos Adicionales

Si quieres, puedes redirigir puertos adicionales a la Caja Phalcon, así como especificar su protocolo:

```yaml
ports:

    - send: 63790
      to: 6379
    - send: 50000
      to: 5000
    - send: 7777
      to: 777
      protocol: udp
```

<a name='daily-usage-sharing-environment'></a>

### Compartiendo tu Entorno

A veces usted puede desear compartir lo que está trabajando con otros compañeros o con un cliente. Vagrant incorpora un sistema a través de `vagrant share` que soporta esto, no obstante, esto no funcionará si tiene multiples sitios configurados en el fichero `settings.yml`.

Para resolver este problema, la Caja de Phalcon incluye su propio comando `share`. Para empezar, ingresar por SSH al sistema de la Caja de Phalcon via `vagrant ssh` y `share <su-sitio-aqui>`, por ejemplo: `share blog.local`. Esto compartirá su sitio desde el archivo de configuración `settings.yml`. Por supuesto, puede sustituir cualquiera de sus otros sitios configurados por `blog.local`:

```bash
share blog.local
```

Después de ejecutar el comando, usted verá una pantalla de [Ngrok](https://ngrok.com) que contiene el registro de actividades y las URL de acceso público del sitio compartido. Si quisiera especificar una region especifica, subdominio o cualquier otra opción Ngrok en tiempo de ejecución, puede agregarlas a su comando `share`:

```bash
share blog.local -region=eu -subdomain=phalcongelist
```

<div class="alert alert-danger">
    <p>
        Vagrant is inherently insecure and you are exposing your virtual machine to the Internet when running the <code>share</code> command.
    </p>
</div>

<a name='daily-usage-network-interfaces'></a>

### Interfaces de Red

La propiedad `networks` del `settings.yml` configura los interfaces de red para su entorno de Caja Phalcon. Usted puede configurar tantas interfaces como sean necesarias:

```yaml
networks:

    - type: "private_network"
      ip: "192.168.50.99"
```

Para activar una interfaz [enlazada](https://www.vagrantup.com/docs/networking/public_network.html), configure una configuración de `bridge` y cambie el tipo red a `public_network`:

```yaml
networks:

    - type: "private_network"
      ip: "192.168.50.99"
      bridge: "en1: Wi-Fi (AirPort)"
```

Para activar [DHCP](https://www.vagrantup.com/docs/networking/public_network.html), sólo elimine la opción `ip` de su configuración:

```yaml
networks:

    - type: "private_network"
      bridge: "en1: Wi-Fi (AirPort)"
```

<a name='daily-usage-updating-box'></a>

### Actualizando la Caja Phalcon

Puede actualizar la Caja de Phalcon en dos sencillos pasos.

1. En primer lugar, usted tendrá que actualizar la Caja de Vagrant utilizando el comando `vagrant box update`:

```bash
vagrant box update
```

1. A continuación, necesitará actualizar el código de fuente de la Caja de Phalcon. Si clonaron el repositorio puede simplemente

```bash
git pull origin master
```

en el lugar que originalmente clonado el repositorio.

The new version of Phalcon Box will contain updated or amended configuration files:

* `settings.yml`
* `.bash_aliases`
* `after_provision.sh`

Al ejecutar el comando `./install` (o `install.bat`) la Caja de Phalcon crea estos archivos en el directorio raíz. Sin embargo, si los archivos ya existen, ellos no se sobrescribirán.

Le recomendamos que siempre realice backups de esos archivos y eliminarlos del proyecto para que se puedan copiar los nuevos. Entonces puede comparar sus propios archivos con los de la Caja de Phalcon para aplicar los cambios personalizados y aprovechar las nuevas características ofrecidas por la actualización.

<a name='daily-usage-provider-settings'></a>

### Configuración Específica del Proveedor

<a name='daily-usage-provider-settings-virtualbox'></a>

#### VirtualBox

Por defecto, la Caja de Phalcon establece la configuración `natdnshostresolver` en `on`. Esto permite a la Caja de Phalcon utilizar las configuración del DNS de su sistema operativo anfitrión. Si usted quisiera sobreeescribir este comportamiento, agregue las siguientes líneas a su fichero `settings.yml`:

```yaml
natdnshostresolver: off
```

<a name='daily-usage-mail-catcher'></a>

### Mail Catcher

Por defecto, la Caja de Phalcon redirecciona todos los emails de PHP a [MailHog](https://github.com/mailhog/MailHog) (en lugar de enviarlos al mundo exterior). Puede acceder a la UI de MailHog en `http://localhost:8025/` (o el dominio que haya configurado en `settings.yml`).

<a name='troubleshooting'></a>

## Resolución de problemas

**Problema:**

> Se produjo un error en la biblioteca subyacente de SSH que usa Vagrant. A continuación se muestra el mensaje de error. En muchos casos, los errores de esta biblioteca son causados por problemas del ssh-agent. Intente desactivar su agente SSH o eliminar de algunas claves y vuelva a intentarlo. Si el problema persiste, por favor notificar un error al proyecto net-ssh. El tiempo de espera durante la negociación de versión de servidor

**Solución:**

```bash
vagrant plugin install vagrant-vbguest
```

**Problema:**

> Vagrant era incapaz de montar las carpetas compartidas de VirtualBox. Esto sucede generalmente porque el sistema de archivos "vboxsf" no está disponible. Este sistema de archivos está a su disposición mediante el VirtualBox Guest Additions y el módulo de núcleo. Por favor verifique que estas adiciones de invitado adecuadamente estén instaladas en el huésped. Esto no es un error en Vagrant y generalmente es causado por una caja defectuosa de Vagrant. En contexto, el comando intentado fue:
> 
> mount -t vboxsf -o uid=900,gid=900 vagrant /vagrant

**Solución:**

```bash
vagrant plugin install vagrant-vbguest
```

**Problema:**

> Se produjo un error mientras se ejecuta el `VBoxManage`, un CLI utilizado por Vagrant para el control de VirtualBox. A continuación se muestra el comando y el stderr.
> 
> Comando: `["startvm", "9d2b95e1-0fdd-40f4-ad65-4b56eb4315f8", "--type", "headless"]`
> 
> Stderr: VBoxManage.exe: error: VT-x is not available (VERR_VMX_NO_VMX) VBoxManage.exe: error: Details: code E_FAIL (0x80004005), component ConsoleWrap, interface IConsole

**Solución:**

Necesita actualizar su BIOS para habilitar la [Virtualización](https://en.wikipedia.org/wiki/X86_virtualization) con `Intel VT-x`.