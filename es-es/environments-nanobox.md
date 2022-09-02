---
layout: default
language: 'es-es'
version: '4.0'
title: 'Entornos - Nanobox'
keywords: 'environment, nanobox, docker'
---

# Entornos Nanobox

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Preámbulo

[Nanobox](https://nanobox.io) es una micro plataforma portable, para desarrollar y desplegar aplicaciones. Cuando trabajamos localmente, Nanobox utiliza Docker de girar y configurar un entorno de desarrollo virtual configurado a sus necesidades específicas. Cuando esté listo para implementar servidores en vivo, Nanobox tomará ese mismo entorno y los girará para arriba en su proveedor de la nube de elección, donde puede gestionar y ampliar su aplicación a través de la consola de Nanobox.

## Desarrollo local

Nanobox se puede utilizar para el desarrollo local en cualquier número de proyectos (no sólo en PHP). Para comenzar a trabajar con Nanobox, primero deberá [crear una cuenta gratuita en Nanobox](https://dashboard.nanobox.io/users/register), luego [descargar y ejecutar el instalador de Nanobox](https://dashboard.nanobox.io/download). La cuenta se usa sólo para iniciar sesión en nanobox usando el comando de consola. Nanobox recordará sus credenciales por lo que sólo tendrá que hacerlo una vez. Si su intención es usar nanobox localmente, no necesita hacer otra cosa. Sin embargo, el mismo inicio de sesión puede utilizarse más tarde si desea desplegar su aplicación en un entorno en vivo.

### Crear un Nuevo Proyecto

Crear una carpeta de proyecto y utilizar el comando `cd` en él:

```bash
mkdir nanobox-phalcon && cd nanobox-phalcon
```

### Añadir un `boxfile.yml`

Nanobox utiliza el archivo [`boxfile.yml`](https://docs.nanobox.io/boxfile/) para construir y configurar su aplicación en tiempo de ejecución y entorno. En la raíz de su proyecto, crear un archivo `boxfile.yml` con lo siguiente:

```yaml
run.config:
  engine: php
  engine.config:
    runtime: php-7.2
    document_root: public
    extensions:
      - phalcon
  extra_steps:
    #===========================================================================
    # PSR extension compilation
    - |
      (
        CURRENT_FOLDER=$(pwd)
        rm -fR /tmp/php-psr
        cd /tmp/build
        git clone --depth=1 https://github.com/jbboehr/php-psr.git
        cd php-psr
        set -e
        phpize
        ./configure --with-php-config=$(which php-config)
        make -j"$(getconf _NPROCESSORS_ONLN)"
        make install
        cd $CURRENT_FOLDER
        rm -fR /tmp/php-psr
        unset CURRENT_FOLDER
      )
    - echo -e 'extension=psr.so' >> "/data/etc/php/dev_php.ini"
    - echo "alias phalcon=\'phalcon.php\'" >> /data/var/home/gonano/.bashrc
```

Esto le indicará a Nanobox:

- Utilizar el [motor](https://docs.nanobox.io/engines/) de PHP, un conjunto de *scripts* que se crean en tiempo de ejecución de la aplicación.
- Utilizar PHP 7.2.
- Establezca la raíz de documento de Apache en `public`.
- Incluir la extensión de Phalcon. *Nanobox adopta un enfoque básico para extensiones, así que es probable que necesite incluir otras extensiones. Puede encontrar más información [aquí](https://guides.nanobox.io/php/phalcon/php-extensions/).*
- Instala la extensión [PSR](https://github.com/jbboehr/php-psr.git) necesaria
- Agregar un alias al bash para Phalcon Devtools por lo que se puede usar el comando `phalcon`.

Dependiendo de las necesidades de su aplicación, puede que necesite añadir extensiones adicionales. Por ejemplo, podría querer añadir `mbcrypt`, `igbinary`, `json`, `session` y `redis`. La sección `extensions` del `boxfile.yml` se verá así:

```yaml
run.config:
  engine: php
  engine.config:
    extensions:
      - json
      - mbstring
      - igbinary
      - session
      - phalcon
      - redis
```

> **NOTA** El orden de las extensiones **si importa**. Ciertas extensiones no se cargarán si no se cargan sus prerequisitos. Por ejemplo `igbinary` tiene que ser cargado antes de `redis` etc.
{: .alert .alert-warning }

### Añadir Phalcon Devtools a su `composer.json`

Cree un archivo `composer.json` en la raíz de su proyecto y agregue el paquete de `phalcon/devtools` a sus requisitos de dev:

```json
{
    "require-dev": {
        "phalcon/devtools": "~3.0.3"
    }
}
```

> **Nota**: la versión de Phalcon Devtools depende de qué versión PHP y Phalcon que estés utilizando.
{: .alert .alert-warning }

### Iniciar Nanobox y generar una nueva aplicación de Phalcon

Desde la raíz de su proyecto, ejecute los siguientes comandos para iniciar Nanobox y generar una nueva aplicación de Phalcon. Cuando Nanobox inicia, el motor de PHP automáticamente instalará y habilitará la extensión de Phalcon, ejecutar un `composer install` para instalar Phalcon Devtools, luego lo dejará en una consola interactiva dentro del entorno virtual. El directorio de trabajo está montado en el directorio `/app` de la máquina virtual, los cambios que se hagan, se verán reflejados en la VM y en el directorio de trabajo local.

```bash
# iniciar nanobox e ingresar a la consola
nanobox run

# cambiar al directorio /tmp
cd /tmp

# generar una nueva aplicación Phalcon
phalcon project myapp

# volver a cambiar al directorio /app
cd -

# copiar la aplicación generada en su projecto
cp -a /tmp/myapp/* .

# sailr de la consola
exit
```

### Ejecutar la aplicación

Antes de realmente ejecutar su nueva aplicación de Phalcon, recomendamos utilizar Nanobox para añadir un alias de DNS. Esto añade una entrada al archivo local `hosts` apuntando a su entorno dev y proporciona una manera conveniente de acceder a la aplicación desde un navegador.

```bash
nanobox dns add local phalcon.dev
```

También puede utilizar la dirección IP de su contenedor. La dirección IP se muestra cuando se ejecuta por primera vez el contenedor. Si lo olvidó o no lo notó, en un terminal separado, navega a la misma carpeta que donde esta tu proyecto y escribe

```bash
nanobox info local
```

La salida de este comando le mostrará todas las direcciones IP de sus contenedores/componentes así como contraseñas a bases de datos (si corresponde).

Nanobox proporciona un script de ayuda `php-server` que inicia tanto Apache (o Nginx dependiendo de su configuración de `boxfile.yml`) y PHP. Cuando se pasa el comando `nanobox run`, iniciará el entorno dev local y ejecutar inmediatamente su aplicación.

```bash
nanobox run php-server
```

Una vez en funcionamiento, puede visitar su aplicación en `https://phalcon.dev`.

### Revisar el entorno

El entorno virtual incluye todo que lo necesario para ejecutar su aplicación Phalcon.

```bash
# Ingresar a la consola de Nanobox
nanobox run

# Comprobar la versión de PHP
php -v

# Comprobar que versión de Phalcon Devtools esta disponible
phalcon info

# Comprobar que tu código base este montado
ls

# Salir de la consola
exit
```
