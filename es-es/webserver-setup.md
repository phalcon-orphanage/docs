---
layout: default
title: 'Configuración de Servidor Web'
keywords: 'servidor web, servidor web, apache, nginx, lighttpd, xampp, wamp, cherokee, servidor integrado php'
---

# Configuración de Servidor Web
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen
Para que funcione la ruta de una aplicación de Phalcon necesitará configurar su servidor web de forma que procese las redirecciones correctamente. A continuación hay instrucciones para los servidores web populares:

## PHP *Built-in*
El servidor web integrado de PHP no es recomiendo para aplicaciones en producción. Puedes usarlo muy fácilmente para propósitos de desarrollo. La sintaxis es:

```bash
$(which php) -S <host>:<port> -t <directory> <setup file>
```

Si tu aplicación tiene su punto de entrada en `/public/index.php` o su proyecto ha sido creado por [Phalcon Devtools](devtools), entonces puedes iniciar el servidor web con el siguiente comando:

```bash
$(which php) -S localhost:8000 -t public .htrouter.php
```

El comando anterior lo hace:

| Command             | Descripción                                                                                                                         |
| ------------------- | ----------------------------------------------------------------------------------------------------------------------------------- |
| `$(which php)`      | will insert the absolute path to your PHP binary                                                                                    |
| `-S localhost:8000` | invokes server mode with the provided `host:port`                                                                                   |
| `-t public`         | defines the servers root directory, necessary for php to route requests to assets like JS, CSS, and images in your public directory |
| `.htrouter.php`     | the entry point that will be evaluated for each request                                                                             |

El archivo `.htrouter.php` debe contener:

```php
<?php

declare(strict_types=1);

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

if ($uri !== '/' && file_exists(__DIR__ . '/public' . $uri)) {
    return false;
}

$_GET['_url'] = $_SERVER['REQUEST_URI'];

require_once __DIR__ . '/public/index.php';
```

Si tu punto de entrada no es `public/index.php`, entonces ajusta el archivo `.htrouter.php` consecuentemente (la última línea) así como la llamada al *script*. También puede cambiar el puerto si lo desea, así como la interfaz de red a la que se une.

After executing the command above, navigating to `http://localhost:8000/` will show your site.

## PHP-FPM
The [PHP-FPM][php_fpm] (FastCGI Process Manager) is usually used to allow the processing of PHP files. Hoy en día PHP-FPM está incluído en todas las distribuciones Linux.

On **Windows** PHP-FPM is in the PHP distribution archive. El archivo `php-cgi.exe` puede utilizarse para iniciar el proceso y establecer las opciones. Windows no soporta sockets unix por lo que este script empezará fast-cgi en TCP en el puerto `9000`.

Crear el archivo `php-fcgi.bat` con el siguiente contenido:

```bat
@ECHO OFF
ECHO Starting PHP FastCGI...
set PATH=C:\PHP;%PATH%
c:\bin\RunHiddenConsole.exe C:\PHP\php-cgi.exe -b 127.0.0.1:9000
```

## nginx
[nginx][nginx] is a free, open-source, high-performance HTTP server and reverse proxy, as well as an IMAP/POP3 proxy server. A diferencia de los tradicionales servidores, nginx no se basa en hilos para procesar las solicitudes. Instead, it uses a much more scalable event-driven (asynchronous) architecture. Esta arquitectura utiliza pequeñas cantidades de memoria, pero más importante, predecibles bajo carga.

Phalcon con nginx y PHP-FPM proveen un set de herramientas poderoso para ofrecer el mejor desempeño para tus aplicaciones PHP.

### Instalar Nginx
[Sitio oficial de nginx][nginx_installation]

### Configuración de Phalcon
You can use following potential configuration to set up nginx with Phalcon:

```
server {
    # Port 80 will require nginx to be started with root permissions
    # Depending on how you install nginx to use port 80 you will need
    # to start the server with `sudo` ports about 1000 do not require
    # root privileges
    # listen      80;

    listen        8000;
    server_name   default;

    ##########################
    # In production require SSL
    # listen 443 ssl default_server;

    # ssl on;
    # ssl_session_timeout  5m;
    # ssl_protocols  SSLv2 SSLv3 TLSv1;
    # ssl_ciphers  ALL:!ADH:!EXPORT56:RC4+RSA:+HIGH:+MEDIUM:+LOW:+SSLv2:+EXP;
    # ssl_prefer_server_ciphers   on;

    # These locations depend on where you store your certs
    # ssl_certificate        /var/nginx/certs/default.cert;
    # ssl_certificate_key    /var/nginx/certs/default.key;
    ##########################

    # This is the folder that index.php is in
    root /var/www/default/public;
    index index.php index.html index.htm;

    charset utf-8;
    client_max_body_size 100M;
    fastcgi_read_timeout 1800;

    # Represents the root of the domain
    # https://localhost:8000/[index.php]
    location / {
        # Matches URLS `$_GET['_url']`
        try_files $uri $uri/ /index.php?_url=$uri&$args;
    }

    # When the HTTP request does not match the above
    # and the file ends in .php
    location ~ [^/]\.php(/|$) {
        # try_files $uri =404;

        # Ubuntu and PHP7.0-fpm in socket mode
        # This path is dependent on the version of PHP install
        fastcgi_pass  unix:/var/run/php/php7.0-fpm.sock;


        # Alternatively you use PHP-FPM in TCP mode (Required on Windows)
        # You will need to configure FPM to listen on a standard port
        # https://www.nginx.com/resources/wiki/start/topics/examples/phpfastcgionwindows/
        # fastcgi_pass  127.0.0.1:9000;

        fastcgi_index /index.php;

        include fastcgi_params;
        fastcgi_split_path_info ^(.+?\.php)(/.*)$;
        if (!-f $document_root$fastcgi_script_name) {
            return 404;
        }

        fastcgi_param PATH_INFO       $fastcgi_path_info;
        # fastcgi_param PATH_TRANSLATED $document_root$fastcgi_path_info;
        # and set php.ini cgi.fix_pathinfo=0

        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }

    location ~ /\.ht {
        deny all;
    }

    location ~* \.(js|css|png|jpg|jpeg|gif|ico)$ {
        expires       max;
        log_not_found off;
        access_log    off;
    }
}
```

### Iniciar
Dependiendo de su sistema, el comando para iniciar *nginx* podría ser uno de los siguientes:

```bash
start nginx
/etc/init.d/nginx start
service nginx start
```

## Apache
[Apache][apache] is a popular and well known web server available on many platforms.

### Configuración de Phalcon
The following are potential configurations you can use to set up Apache with Phalcon. Estas notas están principalmente enfocadas a la configuración del módulo `mod_rewrite` permitiendo usar URLs amigables y el [componente router](routing). Una estructura de directorio común para una aplicación es:

```bash
tutorial/
  app/
    controllers/
    models/
    views/
  public/
    css/
    img/
    js/
    index.php
```

**Document root** The most common case is for an application to be installed in a directory under the document root. Si ese es el caso, podemos usar archivos `.htaccess`.  La primera se utilizará para ocultar el código de la aplicación reenviando todas las solicitudes a la raíz de documentos de la aplicación (`public/`).

> **NOTE**: Note that using `.htaccess` files requires your apache installation to have the `AllowOverride All` option set. 
> 
> {: .alert .alert-warning}

```
# tutorial/.htaccess

<IfModule mod_rewrite.c>
    RewriteEngine on
    RewriteRule   ^$ public/    [L]
    RewriteRule   ((?s).*) public/$1 [L]
</IfModule>
```

Un segundo archivo `.htaccess` se encuentra en el directorio `public/`, este reescribe todas las URIs hacia el archivo `public/index.php`:

```
# tutorial/public/.htaccess

<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond   %{REQUEST_FILENAME} !-d
    RewriteCond   %{REQUEST_FILENAME} !-f
    RewriteRule   ^((?s).*)$ index.php?_url=/$1 [QSA,L]
</IfModule>
```

**International Characters** For users that are using the Persian letter 'م' (meem) in uri parameters, there is an issue with `mod_rewrite`. Para permitir que la coincidencia funcione como lo hace con los caracteres en inglés, deberá cambiar su archivo `.htaccess`:

```
# tutorial/public/.htaccess

<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond   %{REQUEST_FILENAME} !-d
    RewriteCond   %{REQUEST_FILENAME} !-f
    RewriteRule   ^([0-9A-Za-z\x7f-\xff]*)$ index.php?params=$1 [L]
</IfModule>
```

Si su uri contiene caracteres distintos al inglés, puede que necesite recurrir al cambio anterior para permitir que `mod_rewrite` coincida exactamente con su ruta.

#### Configuración de Apache
Si no desea utilizar archivos `.htaccess`, puede mover las directivas al archivo principal de configuración de Apache:

```
<IfModule mod_rewrite.c>

    <Directory "/var/www/test">
        RewriteEngine on
        RewriteRule  ^$ public/    [L]
        RewriteRule  ((?s).*) public/$1 [L]
    </Directory>

    <Directory "/var/www/tutorial/public">
        RewriteEngine On
        RewriteCond   %{REQUEST_FILENAME} !-d
        RewriteCond   %{REQUEST_FILENAME} !-f
        RewriteRule   ^((?s).*)$ index.php?_url=/$1 [QSA,L]
    </Directory>

</IfModule>
```

#### Hosts virtuales
La siguiente configuración es para cuando quiera instalar su aplicación en un host virtual:

```
<VirtualHost *:80>

    ServerAdmin    admin@example.host
    DocumentRoot   "/var/vhosts/tutorial/public"
    DirectoryIndex index.php
    ServerName     example.host
    ServerAlias    www.example.host

    <Directory "/var/vhosts/tutorial/public">
        Options       All
        AllowOverride All
        Require       all granted
    </Directory>

</VirtualHost>
```

## Lighttpd

[lighttpd](https://redmine.lighttpd.net/) (pronunciado "*lighty*", en español "ligereza") es un servidor web de código abierto optimizado para entornos críticos de velocidad, al tiempo que se mantienen estándares, seguridad y flexibilidad. Originalmente fue escrito por Jan Kneschke como una prueba del concepto del problema del c10k – cómo manejar 10.000 conexiones en paralelo en un servidor, pero ha ganado popularidad mundial. Su nombre es una combinación de "light" y "httpd".

### Instalar lighttpd

[Sitio oficial de lighttpd](https://redmine.lighttpd.net/projects/lighttpd/wiki/GetLighttpd)

You can use following potential configuration to set up lighttpd with Phalcon:

```nginx
server.modules = (
        "mod_indexfile",
        "mod_access",
        "mod_alias",
        "mod_redirect",
        "mod_rewrite",
)

server.document-root        = "/var/www/html/public"
server.upload-dirs          = ( "/var/cache/lighttpd/uploads" )
server.errorlog             = "/var/log/lighttpd/error.log"
server.pid-file             = "/var/run/lighttpd.pid"
server.username             = "www-data"
server.groupname            = "www-data"
server.port                 = 80

# strict parsing and normalization of URL for consistency and security
# https://redmine.lighttpd.net/projects/lighttpd/wiki/Server_http-parseoptsDetails
# (might need to explicitly set "url-path-2f-decode" = "disable"
#  if a specific application is encoding URLs inside url-path)
server.http-parseopts = (
  "header-strict"           => "enable",# default
  "host-strict"             => "enable",# default
  "host-normalize"          => "enable",# default
  "url-normalize-unreserved"=> "enable",# recommended highly
  "url-normalize-required"  => "enable",# recommended
  "url-ctrls-reject"        => "enable",# recommended
  "url-path-2f-decode"      => "enable",# recommended highly (unless breaks app)
 #"url-path-2f-reject"      => "enable",
  "url-path-dotseg-remove"  => "enable",# recommended highly (unless breaks app)
 #"url-path-dotseg-reject"  => "enable",
 #"url-query-20-plus"       => "enable",# consistency in query string
)

index-file.names            = ( "index.php", "index.html" )
url.access-deny             = ( "~", ".inc" )
static-file.exclude-extensions = ( ".php", ".pl", ".fcgi" )

compress.cache-dir          = "/var/cache/lighttpd/compress/"
compress.filetype           = ( "application/javascript", "text/css", "text/html", "text/plain" )

# default listening port for IPv6 falls back to the IPv4 port
include_shell "/usr/share/lighttpd/use-ipv6.pl " + server.port
include_shell "/usr/share/lighttpd/create-mime.conf.pl"
include "/etc/lighttpd/conf-enabled/*.conf"

#server.compat-module-load   = "disable"
server.modules += (
        "mod_compress",
        "mod_dirlisting",
        "mod_staticfile",
)

url.rewrite-once = ( "^(/(?!(favicon.ico$|css/|js/|img/)).*)" => "/index.php?_url=$1" )
# or
#url.rewrite-if-not-file = ( "/" => "/index.php?_rl=$1" )
```

## WAMP
[WampServer][wamp] is a Windows web development environment. Te permite crear aplicaciones web con Apache2, PHP y una base de datos MySQL. A continuación te mostramos las instrucciones detalladas para instalar Phalcon en un servidor Wamp para Windows. Utilizar la última versión de WAMP Server es lo mas recomendable.

> **NOTE** Paths in this guide should be relative, according to your installation WAMP 
> 
> {: .alert .alert-warning }

### Descargar Phalcon
Para que Phalcon funcione en Windows, debe instalar la versión correcta que coincida con su arquitectura y extensión construida. Load up the `phpinfo` page provided by WAMP and check the `Architecture` and `Extension Build` values. Esto le permitirá descargar la DLL correcta. For a thread safe, x64 using VS16 and PHP 8.1, you will need to download the following file:

```
phalcon-php8.1-ts-windows2019-vs16-x64.zip
```

If your system reports `NTS` (_Non Thread Safe_) then you should download that DLL.

WAMP tiene dos versiones 32 y 64 bits. De la sección de descargas, puedes descargar la DLL de Phalcon que se adapte a tu instalación WAMP.

Extract the `php_phalcon.dll` from the archive and copy the file `php_phalcon.dll` to the PHP extensions folder. If WAMP is installed in the `C:\wamp` folder, the extension needs to be in `C:\wamp\bin\php\php8.1.0\ext` (assuming your WAMP installation installed PHP 8.1.0).

Edit the `php.ini` file, it is located at `C:\wamp\bin\php\php8.1.0\php.ini`. Puedes editarlo con el Bloc de notas o un programa similar. We recommend [Notepad++][notepad_plus] to avoid issues with line endings. Agrega esto al final del archivo:

```ini
extension=php_phalcon.dll
```

y guardarlo.

También, editar el fichero `php.ini`, que se ubica en `C:\wamp\bin\apache\apache2.4.9\bin\php.ini`. Agrega esto al final del archivo:

```ini
extension=php_phalcon.dll 
```

y guardarlo.

> **NOTE**: The path above might differ depending on the apache installation you have for your web server. Ajústelo en consecuencia. 
> 
> {: .alert .alert-warning }

Reinicia el Servidor Web Apache. Haga un solo click en el icono de WampServer en la bandeja del sistema. Elija `Reiniciar Todos los Servicios` del menú pop-up. Compruebe que el icono de la bandeja se vuelve verde de nuevo.

Abra su navegador web para navegar a `https://localhost`. Aparecerá la página de bienvenida de WAMP. Compruebe la sección `extensiones cargadas` para asegurarse que Phalcon se ha cargado.

> **Congratulations! You are now phlying with Phalcon.** 
> 
> {: .alert .alert-info }

## XAMPP
[XAMPP][xampp] is an easy to install Apache distribution containing MySQL, PHP and Perl. Una vez descargado XAMPP, todo lo que tiene que hacer es extraerlo y empezar a usarlo. Abajo hay instrucciones detalladas de cómo instalar Phalcon en XAMPP para Windows. Se recomienda encarecidamente usar la última versión de XAMPP.

> **NOTE** Paths in this guide should be relative, according to your installation WAMP 
> 
> {: .alert .alert-warning }

### Descargar Phalcon
Para que Phalcon funcione en Windows, debe instalar la versión correcta que coincida con su arquitectura y extensión construida. Load up the `phpinfo` page provided by WAMP and check the `Architecture` and `Extension Build` values. Esto le permitirá descargar la DLL correcta. For a thread safe, x64 using VS16 and PHP 8.1, you will need to download the following file:

```
phalcon-php8.1-ts-windows2019-vs16-x64.zip
```

If your system reports `NTS` (_Non Thread Safe_) then you should download that DLL.

XAMPP offers both 32 and 64 bit versions of Apache and PHP: Phalcon has dlls for both, just choose the right dll for the installed version.

Extract the `php_phalcon.dll` from the archive and copy the file `php_phalcon.dll` to the PHP extensions directory. Si ha instalado XAMPP en la carpeta `C:\xampp`, la extensión necesita estar en `C:\xampp\php\ext`

Edit the `php.ini` file, it is located at `C:\wamp\bin\php\php8.1.0\php.ini`. Puedes editarlo con el Bloc de notas o un programa similar. We recommend [Notepad++][notepad_plus] to avoid issues with line endings. Agrega esto al final del archivo:

```ini
extension=php_phalcon.dll
```

y guardarlo.

Reinicia el Servidor Web Apache desde el Centro de Control de XAMPP. Esto cargará la nueva configuración PHP. Abra su navegador web para navegar a `https://localhost`. Aparecerá la página de bienvenida de XAMPP. Haga click en el enlace `phpinfo()`.

[phpinfo][phpinfo] will output a significant amount of information on screen about the current state of PHP. Desplázese hacia abajo para comprobar si la extensión Phalcon se ha cargado correctamente.

> **Congratulations! You are now phlying with Phalcon.** 
> 
> {: .alert .alert-info }


## Cherokee

[Cherokee][cherokee] is a high-performance web server. Es muy rápido, flexible y fácil de configurar.

### Configuración de Phalcon
Cherokee proporciona un interfaz gráfico amigable para configurar casi todos los ajustes disponibles en el servidor web.

Inicia el administrador cherokee ejecutando como root `/path-to-cherokee/sbin/cherokee-admin`

![](/assets/images/content/webserver-cherokee-1.jpg)

Cree un nuevo virtual host haciendo click sobre `vServers`, entonces añada un nuevo servidor virtual:

![](/assets/images/content/webserver-cherokee-2.jpg)

El servidor virtual añadido recientemente aparecerá en la barra izquierda de la pantalla. En la pestaña `Comportamientos` verá un conjunto de comportamientos por defecto para este servidor virtual. Haga click en el botón `Gestión de Reglas`. Elimine las etiquetadas como `Directory /cherokee_themes` y `Directory /icons`:

![](/assets/images/content/webserver-cherokee-3.jpg)

Añada el comportamiento `Lenguaje PHP` usando el asistente. Este comportamiento le permite ejecutar aplicaciones PHP:

![](/assets/images/content/webserver-cherokee-1.jpg)

Normalmente este comportamiento no requiere ajustes adicionales. Añada otro comportamiento, esta vez en la sección `Configuración Manual`. En `Tipo de Regla` elija `Existe Fichero`, luego asegúrese que está activa la opción `Coincidir con cualquier archivo`:

![](/assets/images/content/webserver-cherokee-5.jpg)

En la pestaña `Manejador` elegir `Listar & Enviar` como manejador:

![](/assets/images/content/webserver-cherokee-7.jpg)

Editar el comportamiento `Predeterminado` para activar el motor URL-rewrite. Cambie el manejador a `Redirección`, luego añada la siguiente expresión regular al motor `^(.*)$`:

![](/assets/images/content/webserver-cherokee-6.jpg)

Finalmente, asegúrese que los comportamientos están en el siguiente orden:

![](/assets/images/content/webserver-cherokee-8.jpg)

Ejecute la aplicación en un navegador:

![](/assets/images/content/webserver-cherokee-9.jpg)


[apache]: https://httpd.apache.org/
[cherokee]: https://www.cherokee-project.com/
[nginx]: https://wiki.nginx.org/Main
[nginx_installation]: https://www.nginx.com/resources/wiki/start/topics/tutorials/install/
[notepad_plus]: https://notepad-plus-plus.org/
[php_fpm]: https://php.net/manual/en/install.fpm.php
[wamp]: https://www.wampserver.com/en/
[xampp]: https://www.apachefriends.org/download.html
[phpinfo]: https://php.net/manual/en/function.phpinfo.php
