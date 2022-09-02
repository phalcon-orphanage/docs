---
layout: default
language: 'es-es'
version: '4.0'
title: 'Configuración de Servidor Web'
keywords: 'servidor web, servidor web, apache, nginx, lighttpd, xampp, wamp, cherokee, servidor integrado php'
---

# Configuración de Servidor Web

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Preámbulo

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

- `$(which php)` insertará la ruta absoluta a su PHP binario
- `-S localhost:8000` invoca el modo de servidor con `host:puerto` proporcionado
- `-t public` define el directorio raíz de los servidores, es necesario para php para las solicitudes de ruta a activos como JS, CSS e imágenes en el directorio público
- `.htrouter.php` el punto de entrada que será evaluado para cada solicitud

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

Después de ejecutar el comando anterior, al navegar a `http://localhost:8000/` mostrará su sitio.

## PHP-FPM

Generalmente se usa [PHP-FPM](https://php.net/manual/en/install.fpm.php) (FastCGI Process Manager) para procesar archivos PHP. Hoy en día PHP-FPM está incluído en todas las distribuciones Linux.

En **Windows** PHP-FPM está en el archivo de distribución de PHP. El archivo `php-cgi.exe` puede utilizarse para iniciar el proceso y establecer las opciones. Windows no soporta sockets unix por lo que este script empezará fast-cgi en TCP en el puerto `9000`.

Crear el archivo `php-fcgi.bat` con el siguiente contenido:

```bat
@ECHO OFF
ECHO Starting PHP FastCGI...
set PATH=C:\PHP;%PATH%
c:\bin\RunHiddenConsole.exe C:\PHP\php-cgi.exe -b 127.0.0.1:9000
```

## nginx

[nginx](https://wiki.nginx.org/Main) es un servidor y proxy inverso gratuito y de código abierto de alto desempeño, así como un servidor proxy para IMAP/POP3. A diferencia de los tradicionales servidores, nginx no se basa en hilos para procesar las solicitudes. En lugar de esto, utiliza una arquitectura basada en eventos (asíncrona) que es más escalable. Esta arquitectura utiliza pequeñas cantidades de memoria, pero más importante, predecibles bajo carga.

Phalcon con nginx y PHP-FPM proveen un set de herramientas poderoso para ofrecer el mejor desempeño para tus aplicaciones PHP.

### Instalar Nginx

[Sitio oficial de nginx](https://www.nginx.com/resources/wiki/start/topics/tutorials/install/)

### Configuración de Phalcon

Puede utilizar la siguiente configuración posible para configurar Nginx con Phalcon:

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
    

### Comienzar

Dependiendo de su sistema, el comando para iniciar *nginx* podría ser uno de los siguientes:

```bash
start nginx
/etc/init.d/nginx start
service nginx start
```

## Apache

[Apache](https://httpd.apache.org/) es un servidor web popular y bien conocido disponible en muchas plataformas.

### Configuración de Phalcon

Las siguientes son posibles configuraciones que puedes usar para configurar Apache con Phalcon. Estas notas están principalmente enfocadas a la configuración del módulo `mod_rewrite` permitiendo usar URLs amigables y el [componente router](routing). Una estructura de directorio común para una aplicación es:

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

**Raíz de documentos** El caso más común es que una aplicación se instale en un directorio bajo la raíz del documento. Si ese es el caso, podemos usar archivos `.htaccess`. La primera se utilizará para ocultar el código de la aplicación reenviando todas las solicitudes a la raíz de documentos de la aplicación (`public/`).

> **NOTA:** Tenga en cuenta que la utilización de archivos `.htaccess` requiere que la instalación de apache tenga la opción `AllowOverride All`.
 {: .alert .alert-warning}

# tutorial/.htaccess
    
    <IfModule mod_rewrite.c>
        RewriteEngine on
        RewriteRule   ^$ public/    [L]
        RewriteRule   ((?s).*) public/$1 [L]
    </IfModule>
    

Un segundo archivo `.htaccess` se encuentra en el directorio `public/`, este reescribe todas las URIs hacia el archivo `public/index.php`:

    # tutorial/public/.htaccess
    
    <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteCond   %{REQUEST_FILENAME} !-d
        RewriteCond   %{REQUEST_FILENAME} !-f
        RewriteRule   ^((?s).*)$ index.php?_url=/$1 [QSA,L]
    </IfModule>
    

**Caracteres Internacionales** Para los usuarios que usan la letra persa 'م' (meem) en los parámetros uri, existe un problema con `mod_rewrite`. Para permitir que la coincidencia funcione como lo hace con los caracteres en inglés, deberá cambiar su archivo `.htaccess`:

    # tutorial/public/.htaccess
    
    <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteCond   %{REQUEST_FILENAME} !-d
        RewriteCond   %{REQUEST_FILENAME} !-f
        RewriteRule   ^([0-9A-Za-z\x7f-\xff]*)$ index.php?params=$1 [L]
    </IfModule>
    

Si su uri contiene caracteres distintos al inglés, puede que necesite recurrir al cambio anterior para permitir que `mod_rewrite` coincida exactamente con su ruta.

#### Configuración de Apache

Si no desea utilizar archivos `.htaccess`, puede mover las directivas al archivo principal de configuración de Apache:

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
    

#### Hosts virtuales

La siguiente configuración es para cuando quiera instalar su aplicación en un host virtual:

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
    

## Lighttpd

[lighttpd](https://redmine.lighttpd.net/) (pronunciado "*lighty*", en español "ligereza") es un servidor web de código abierto optimizado para entornos críticos de velocidad, al tiempo que se mantienen estándares, seguridad y flexibilidad. Originalmente fue escrito por Jan Kneschke como una prueba del concepto del problema del c10k – cómo manejar 10.000 conexiones en paralelo en un servidor, pero ha ganado popularidad mundial. Su nombre es una combinación de "light" y "httpd".

### Instalar lighttpd

[Sitio oficial de lighttpd](https://redmine.lighttpd.net/projects/lighttpd/wiki/GetLighttpd)

Puede utilizar la siguiente configuración posible para configurar lighttpd con Phalcon:

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

[WampServer](https://www.wampserver.com/en/) es un entorno de desarrollo web para Windows. Te permite crear aplicaciones web con Apache2, PHP y una base de datos MySQL. A continuación te mostramos las instrucciones detalladas para instalar Phalcon en un servidor Wamp para Windows. Utilizar la última versión de WAMP Server es lo mas recomendable.

> **NOTA** Desde v4, debe instalar la extensión `PSR` desde PECL. Visita [esta URL](https://pecl.php.net/package/psr/0.7.0/windows) para obtener las DLL y seguir los mismos pasos para instalar la extensión al igual que con las DLL de Phalcon.
{: .alert .alert-warning }

> 
> **NOTA** Las rutas de esta guía deben ser relativas, de acuerdo a tu instalación de WAMP
{: .alert .alert-warning }

### Descargar Phalcon

Para que Phalcon funcione en Windows, debe instalar la versión correcta que coincida con su arquitectura y extensión construida. Carga la página `phpinfo` proporcionada por WAMP:

![](/assets/images/content/webserver-architecture.png)

Compruebe los valores de `Architecture` y `Extension Build`. Esto le permitirá descargar la DLL correcta. En el ejemplo anterior debería descargar el archivo:

    phalcon_x86_vc15_php7.2_4.0.0+4237.zip
    

que coincidirá con `x86`, `vc15` y `TS` que es *Thread Safe*. Si su sistema reporta `NTS` (*Non Thread Safe*) entonces debería descargar esa DLL.

WAMP tiene dos versiones 32 y 64 bits. De la sección de descargas, puedes descargar la DLL de Phalcon que se adapte a tu instalación WAMP.

Después de descargar la biblioteca Phalcon tendrás un archivo zip como se muestra a continuación:

![](/assets/images/content/webserver-zip-icon.png)

Descomprime la biblioteca del archivo para obtener la DLL de Phalcon:

![](/assets/images/content/webserver-extracted-dlls.png)

Copia el archivo `php_phalcon.dll` en la carpeta de extensiones de PHP. Si WAMP está instalado en la carpeta `C:\wamp`, la extensión debe ser ubicada en `C:\wamp\bin\php\php7.2.18\ext` (suponiendo que tu instalación de WAMP tiene instalado PHP 7.2.18).

![](/assets/images/content/webserver-wamp-phalcon-psr-ext-folder.png)

Edita el archivo `php.ini`, se encuentra en `C:\wamp\bin\php\php7.2.18\php.ini`. Puedes editarlo con el Bloc de notas o un programa similar. Te recomendamos *Notepad++* para evitar problemas con los caracteres de fin de línea. Agrega esto al final del archivo:

```ini
 extension=php_phalcon.dll
```

y guardarlo.

![](/assets/images/content/webserver-wamp-phalcon-php-ini.png)

También, editar el fichero `php.ini`, que se ubica en `C:\wamp\bin\apache\apache2.4.9\bin\php.ini`. Agrega esto al final del archivo:

```ini
extension=php_phalcon.dll 
```

y guardarlo.

> **NOTA**: La ruta anterior se puede diferir dependiendo de la instalación de apache que tengas para tu servidor web. Ajústelo en consecuencia.
{: .alert .alert-warning }

> 
> **NOTA**: Como se mencionó anteriormente la extensión `PSR` necesita ser instalada y cargada antes de Phalcon. Agregue la línea `extension=php_psr.dll` antes de la línea de Phalcon, como se muestra en la imagen anterior.
{: .alert .alert-warning }

![](/assets/images/content/webserver-wamp-apache-phalcon-php-ini.png)

Reinicia el Servidor Web Apache. Haga un solo click en el icono de WampServer en la bandeja del sistema. Elija `Reiniciar Todos los Servicios` del menú pop-up. Compruebe que el icono de la bandeja se vuelve verde de nuevo.

![](/assets/images/content/webserver-wamp-manager.png)

Abra su navegador web y navegue a https://localhost. Aparecerá la página de bienvenida de WAMP. Compruebe la sección `extensiones cargadas` para asegurarse que Phalcon se ha cargado.

![](/assets/images/content/webserver-wamp-phalcon.png)

> **¡Felicidades! Ahora está volando con Phalcon.**
{: .alert .alert-info }

## XAMPP

[XAMPP](https://www.apachefriends.org/download.html) es una distribución Apache fácil de instalar que contiene MySQL, PHP y Perl. Una vez descargado XAMPP, todo lo que tiene que hacer es extraerlo y empezar a usarlo. Abajo hay instrucciones detalladas de cómo instalar Phalcon en XAMPP para Windows. Se recomienda encarecidamente usar la última versión de XAMPP.

> **NOTA** Desde v4, debe instalar la extensión `PSR` desde PECL. Visita [esta URL](https://pecl.php.net/package/psr/0.7.0/windows) para obtener las DLL y seguir los mismos pasos para instalar la extensión al igual que con las DLL de Phalcon.
{: .alert .alert-warning }

> 
> **NOTA** Las rutas de esta guía deben ser relativas, de acuerdo a tu instalación de WAMP
{: .alert .alert-warning }

### Descargar Phalcon

Para que Phalcon funcione en Windows, debe instalar la versión correcta que coincida con su arquitectura y extensión construida. Carga la página `phpinfo` proporcionada por XAMPP:

![](/assets/images/content/webserver-architecture.png)

Compruebe los valores de `Architecture` y `Extension Build`. Esto le permitirá descargar la DLL correcta. En el ejemplo anterior debería descargar el archivo:

    phalcon_x86_vc15_php7.2_4.0.0+4237.zip
    

que coincidirá con `x86`, `vc15` y `TS` que es *Thread Safe*. Si su sistema reporta `NTS` (*Non Thread Safe*) entonces debería descargar esa DLL.

Tenga en cuenta que XAMPP ofrece versiones de 32 y 64 bit de Apache y PHP (5.6+): Phalcon tiene dlls para ambos, simplemente elija el dll correcto para la versión instalada.

Después de descargar la biblioteca Phalcon tendrás un archivo zip como se muestra a continuación:

![](/assets/images/content/webserver-zip-icon.png)

Descomprime la biblioteca del archivo para obtener la DLL de Phalcon:

![](/assets/images/content/webserver-extracted-dlls.png)

Copie el fichero `php_phalcon.dll` al directorio de extensiones PHP. Si ha instalado XAMPP en la carpeta `C:\xampp`, la extensión necesita estar en `C:\xampp\php\ext`

![](/assets/images/content/webserver-xampp-phalcon-psr-ext-folder.png)

Edite el fichero `php.ini`, ubicado en `C:\xampp\php\php.ini`. Puedes editarlo con el Bloc de notas o un programa similar. Recomendamos [Notepad++](https://notepad-plus-plus.org/) para evitar problemas con los finales de línea. Agrega esto al final del archivo:

```ini
extension=php_phalcon.dll
```

y guardarlo.

> **NOTA**: Como se mencionó anteriormente la extensión `PSR` necesita ser instalada y cargada antes de Phalcon. Agregue la línea `extension=php_psr.dll` antes de la línea de Phalcon, como se muestra en la imagen anterior.
{: .alert .alert-warning }

![](/assets/images/content/webserver-xampp-phalcon-php-ini.png)

Reinicia el Servidor Web Apache desde el Centro de Control de XAMPP. Esto cargará la nueva configuración PHP. Abra su navegador web para navegar a `https://localhost`. Aparecerá la página de bienvenida de XAMPP. Haga click en el enlace `phpinfo()`.

![](/assets/images/content/webserver-xampp-phpinfo.png)

[phpinfo](https://php.net/manual/en/function.phpinfo.php) mostrará una cantidad significativa de información en pantalla sobre el estado actual de PHP. Desplázese hacia abajo para comprobar si la extensión Phalcon se ha cargado correctamente.

![](/assets/images/content/webserver-xampp-phpinfo-phalcon.png)

> **¡Felicidades! Ahora está volando con Phalcon.**
{: .alert .alert-info }


## Cherokee

[Cherokee](https://www.cherokee-project.com/) es un servidor web de alto rendimiento. Es muy rápido, flexible y fácil de configurar.

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
