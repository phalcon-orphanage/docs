---
layout: default
language: 'es-es'
version: '4.0'
title: 'Entornos - Devilbox'
keywords: 'entorno, devilbox, docker'
---

# Entornos

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen

[Devilbox](https://devilbox.org) es una pila PHP acoplada moderna y altamente personalizable que soporta completamente LAMP y MEAN y se ejecuta en la mayoría de plataformas. El objetivo principal es fácilmente cambiar y combinar cualquier versión requerida para el desarrollo local. Soporta un número de proyectos ilimitado para vhosts, certificados SSL y registros DNS que se crean automáticamente. Se admiten proxies inversos por proyecto para garantizar que también se pueda acceder a un servidor de escucha como NodeJS. Las herramientas de desarrollo populares y de correo electrónico también estarán a su servicio. No será necesaria su configuración, ya que todo está preconfigurado.

Además, Devilbox proporciona un entorno de desarrollo idéntico y reproducible para diferentes sistemas operativos anfitriones.

Este ejemplo usará `phalcon` para instalar Phalcon desde el contenedor PHP Devilbox. Una vez completados los pasos listados a continuación, tendrá una configuración funcional de Phalcon lista para ser servida a través de http y https.

## Configuración

Se puede usar la siguiente configuración:

| Project name | `my-phalcon` | | VirtualHost directory | `/shared/httpd/my-phalcon` | | Database | n.a. | | `TLD_SUFFIX` | loc | | Project URL | `http://my-phalcon.loc`, `https://my-phalcon.loc` |

> * Dentro del contenedor PHP Devilbox, los proyectos siempre están en `/shared/httpd/`.
> * En su sistema operativo anfitrión, por defecto los proyectos están en `./data/www/` dentro del directorio git de Devilbox. Esta ruta puede ser cambiada mediante `HOST_PATH_HTTPD_DATADIR`.
{: .alert .alert-info }

## Activación

Su entorno estará listo en seis sencillos pasos:

- Introducir el contenedor PHP
- Crear un nuevo directorio VirtualHost
- Instalar Phalcon
- Enlace simbólico al directorio webroot
- Configurar registro DNS
- Visitar `http://my-phalcon.loc` en su navegador
- (Nginx) Crear archivo de configuración personalizado vhost

### Introducir Contenedor PHP

Todo el trabajo se realizará dentro del contenedor PHP ya que ofrece todas las herramientas necesarias. Vaya al directorio git de Devilbox y ejecute `./shell.sh` (o `shell.bat` en Windows) para entrar al contenedor PHP en ejecución.

```bash
host> ./shell.sh
```

### Crear Nuevo Directorio Vhost

El directorio vhost define el nombre bajo el cual estará disponible su proyecto. (`<vhost dir>.TLD_SUFFIX` será la URL final).

```bash
devilbox@php-7.3 in /shared/httpd $ mkdir my-phalcon
```

### Instalar Phalcon

Vaya a su recién creado directorio vhost e instale Phalcon con el cliente `phalcon`.

```bash
devilbox@php-7.3 in /shared/httpd $ cd my-phalcon
devilbox@php-7.3 in /shared/httpd/my-phalcon $ phalcon project phalconphp
```

La estructura del directorio se ve así después de la instalación:

```bash
devilbox@php-7.3 in /shared/httpd/my-phalcon $ tree -L 1
.
└── phalconphp

1 directory, 0 files
```

### Enlace Simbólico al Webroot

Es importante enlazar simbólicamente el actual directorio webroot a `htdocs`. El servidor web espera que cada document root de un proyecto esté en `<vhost dir>/htdocs/`. Esta es la ruta donde servirá los ficheros. Esta también es la ruta donde debe existir el punto de entrada de su aplicación (normalmente `index.php`).

Sin embargo algunos *frameworks*, almacenan ficheros y contenido en directorios anidados de niveles desconocidos. Por lo tanto, es imposible establecer esto como preconfiguración en el entorno. Por eso tendrá que establecer manualmente un enlace simbólico a la ruta esperada que requiera su *framework*.

```bash
devilbox@php-7.3 in /shared/httpd/my-phalcon $ ln -s phalconphp/public/ htdocs
```

La estructura del directorio se ve así después de la instalación:

```bash
devilbox@php-7.3 in /shared/httpd/my-phalcon $ tree -L 1
.
├── phalconphp
└── htdocs -> phalconphp/public

2 directories, 0 files
```

Como puede ver en el listado anterior, la carpeta `htdocs` requerida por el servidor web está apuntando ahora al punto de entrada de su *framework*.

> **NOTA**: Cuando se usa **Docker Toolbox**, necesita **permitir explícitamente** el uso de **enlaces simbólicos**.
{: .alert .alert-warning }

### Registro DNS

Si ya **tiene** Auto DNS configurado, puede omitir esta sección, porque las entradas DNS estarán disponibles automáticamente por el servidor DNS incluido.

Si **no tiene** configurado Auto DNS, necesitará añadir la siguiente línea al fichero `/etc/hosts` (o `C:\Windows\System32\drivers\etc` en Windows) de su sistema operativo anfitrión:

```bash
127.0.0.1 my-phalcon.loc
```

### Abrir Navegador

Abra su navegador y vaya a `http://my-phalcon.loc` o `https://my-phalcon.loc`

### Crear Fichero de Configuración Personalizado Vhost (Sólo Nginx)

Por defecto las rutas no funcionarán si usa Nginx. Para solucionarlo, necesitará crear una configuración personalizada vhost.

En su carpeta de proyecto, necesitará crear una carpeta llamada `.devilbox`, a no ser que cambie `HTTPD_TEMPLATE_DIR` en `.env`

Copie la configuración por defecto de `./cfg/vhost-gen/nginx.yml-example-vhost` a `./data/www/my-project/.devilbox/nginx.yml`

Edite con cuidado el fichero nginx.yml y cambie:

`try_files $uri $uri/ /index.php$is_args$args;`

a

`try_files $uri $uri/ /index.php?_url=$uri&$args;`

y

`location ~ \.php?$ {`

a

`location ~ [^/]\.php(/|$) {`

Guarde el fichero como `nginx.yml` y asegúrese de no usar ningún tabulador en el fichero o devilbox no usará la configuración personalizada. Puede usar `yamllint nginx.yml` desde dentro del shell de Devilbox para comprobar el fichero antes de reiniciar devilbox.

## Referencias

- [Devilbox.com](https://devilbox.org)
- [Documentación Devilbox](https://devilbox.readthedocs.io/en/latest/examples/setup-phalcon.html)
- [HOST_PATH_HTTPD_DATADIR](https://devilbox.readthedocs.io/en/latest/configuration-files/env-file.html#env-httpd-datadir)
- [Introducir el contenedor PHP](https://devilbox.readthedocs.io/en/latest/getting-started/enter-the-php-container.html#enter-the-php-container) 
- [Trabajar dentro de contenedor PHP](https://devilbox.readthedocs.io/en/latest/intermediate/work-inside-the-php-container.html#work-inside-the-php-container)
- [Herramientas disponibles](https://devilbox.readthedocs.io/en/latest/readings/available-tools.html#available-tools) 
- [TLD_SUFFIX](https://devilbox.readthedocs.io/en/latest/configuration-files/env-file.html#env-tld-suffix)
- [Herramientas Docker y Enlaces simbólicos](https://devilbox.readthedocs.io/en/latest/howto/docker-toolbox/docker-toolbox-and-the-devilbox.html#howto-docker-toolbox-and-the-devilbox-windows-symlinks)
- [Añadir entrada hosts de proyecto en MacOS](https://devilbox.readthedocs.io/en/latest/howto/dns/add-project-dns-entry-on-mac.html#howto-add-project-hosts-entry-on-mac)
- [Añadir entrada hosts de proyecto en Windows](https://devilbox.readthedocs.io/en/latest/howto/dns/add-project-dns-entry-on-win.html#howto-add-project-hosts-entry-on-win)
- [Configurar Auto DNS](https://devilbox.readthedocs.io/en/latest/intermediate/setup-auto-dns.html#setup-auto-dns)
