---
layout: default
language: 'es-es'
version: '5.0'
title: 'Entornos - Nanobox'
keywords: 'environment, nanobox, docker'
---

# Entornos
- - -
![](/assets/images/document-status-under-review-red.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Resumen
[Nanobox][nanobox] is a portable, micro platform for developing and deploying apps. Cuando trabajamos localmente, Nanobox utiliza Docker de girar y configurar un entorno de desarrollo virtual configurado a sus necesidades específicas. Cuando esté listo para implementar servidores en vivo, Nanobox tomará ese mismo entorno y los girará para arriba en su proveedor de la nube de elección, donde puede gestionar y ampliar su aplicación a través de la consola de Nanobox.

## Desarrollo local
Nanobox se puede utilizar para el desarrollo local en cualquier número de proyectos (no sólo en PHP). To start working with nanobox you will first [create a free Nanobox account][nanobox_account], then [download and run the Nanobox installer][nanobox_installer]. La cuenta se usa sólo para iniciar sesión en nanobox usando el comando de consola. Nanobox recordará sus credenciales por lo que sólo tendrá que hacerlo una vez. Si su intención es usar nanobox localmente, no necesita hacer otra cosa. Sin embargo, el mismo inicio de sesión puede utilizarse más tarde si desea desplegar su aplicación en un entorno en vivo.

### Crear un Nuevo Proyecto
Crear una carpeta de proyecto y utilizar el comando `cd` en él:

```bash
mkdir nanobox-phalcon && cd nanobox-phalcon
```

### Añadir un `boxfile.yml`
Nanobox uses the [`boxfile.yml`][boxfile] to build and configure your app's runtime and environment. En la raíz de su proyecto, crear un archivo `boxfile.yml` con lo siguiente:

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

- Use the PHP [engine][engine], a set of scripts that build your app's runtime.
- Utilizar PHP 7.2.
- Establezca la raíz de documento de Apache en `public`.
- Incluir la extensión de Phalcon. *Nanobox takes a bare-bones approach to extensions, so you'll likely need to include other extensions. More information can be found [here][php_extensions].*
- Install the required [PSR][psr] extension
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

> **NOTE** The order of the extensions **does** matter. Ciertas extensiones no se cargarán si no se cargan sus prerequisitos. Por ejemplo `igbinary` tiene que ser cargado antes de `redis` etc. 
> 
> {: .alert .alert-warning }

### Añadir Phalcon Devtools a su `composer.json`
Cree un archivo `composer.json` en la raíz de su proyecto y agregue el paquete de `phalcon/devtools` a sus requisitos de dev:

```json
{
    "require-dev": {
        "phalcon/devtools": "~3.0.3"
    }
}
```

> **NOTE**: The version of Phalcon Devtools depends on which PHP version as well as Phalcon version you're using. 
> 
> {: .alert .alert-warning }

### Iniciar Nanobox y generar una nueva aplicación de Phalcon
From the root of your project, run the following commands to start Nanobox and generate a new Phalcon app. As Nanobox starts, the PHP engine will automatically install and enable the Phalcon extension, run a `composer install` which will install Phalcon Devtools, then drop you into an interactive console inside the virtual environment. El directorio de trabajo está montado en el directorio `/app` de la máquina virtual, los cambios que se hagan, se verán reflejados en la VM y en el directorio de trabajo local.

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

[nanobox]: https://nanobox.io
[nanobox_account]: https://dashboard.nanobox.io/users/register
[nanobox_installer]: https://dashboard.nanobox.io/download
[boxfile]: https://docs.nanobox.io/boxfile/
[engine]: https://docs.nanobox.io/engines/
[php_extensions]: https://guides.nanobox.io/php/phalcon/php-extensions/
[psr]: https://github.com/jbboehr/php-psr.git