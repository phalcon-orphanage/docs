<div class='article-menu'>
  <ul>
    <li>
      <a href="#setup">Configuración de Servidor Web</a> 
      <ul>
        <li>
          <a href="#php-built-in">Servidor web incorporado</a> 
          <ul>
            <li>
              <a href="#php-built-in-phalcon-configuration">Configuración de Phalcon</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#nginx">Nginx</a> 
          <ul>
            <li>
              <a href="#nginx-phalcon-configuration">Configuración de Phalcon</a> <ul>
                <li>
                  <a href="#nginx-phalcon-configuration-basic">Configuración básica</a>
                </li>
              </ul>
            </li>
          </ul>
        </li>
        <li>
          <a href="#apache">Apache</a> 
          <ul>
            <li>
              <a href="#apache-phalcon-configuration">Configuración de Phalcon</a> 
              <ul>
                <li>
                  <a href="#apache-document-root">Raíz de documentos</a>
                </li>
                <li>
                  <a href="#apache-apache-configuration">Configuración de Apache</a>
                </li>
                <li>
                  <a href="#apache-virtual-hosts">Hosts virtuales</a>
                </li>
              </ul>
            </li>
          </ul>
        </li>
        <li>
          <a href="#cherokee">Cherokee</a> 
          <ul>
            <li>
              <a href="#cherokee-phalcon-configuration">Configuración de Phalcon</a>
            </li>
          </ul>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='setup'></a>

# Configuración de Servidor Web

Para que el esquema de rutas de una aplicación Phalcon funcione, será necesario que configures tu servidor web para procesar las redirecciones adecuadamente. Las instrucciones de configuración de servidores web populares son:

<a name='php-fpm'></a>

## PHP-FPM

Generalmente se usa [PHP-FPM](http://php.net/manual/en/install.fpm.php) (FastCGI Process Manager) para procesar archivos PHP. Hoy en día PHP-FPM está incluído en todas las distribuciones Linux.

En **Windows** PHP-FPM está en el archivo de distribución de PHP a través del archivo `php-cgi.exe` y puede iniciarlo con este script para ayudarlo a configurar las opciones. Windows no soporta sockets unix por lo que este script empezará fast-cgi en TCP en el puerto `9000`.

Crear el archivo `php-fcgi.bat` con el siguiente contenido:

```bat
@ECHO OFF
ECHO Iniciando PHP FastCGI...
set PATH=C:\PHP;%PATH%
c:\bin\RunHiddenConsole.exe C:\PHP\php-cgi.exe -b 127.0.0.1:9000
```

<a name='php-built-in'></a>

## PHP servidor Web incorporado (para desarrolladores)

Para acelerar la ejecución de su aplicación Phalcon en desarrollo, la forma más fácil es utilizar este servidor PHP incorporado. No use este servidor en producción. Las siguientes configuraciones para [Nginx](#nginx) y [Apache](#apache) son las que necesita.

<a name='php-built-in-phalcon-configuration'></a>

### Configuración de Phalcon

Para habilitar la reescritura de URI dinámicas, sin Apache o Nginx, que Phalcon necesita que usted utilice el siguiente archivo: <a href="https://github.com/phalcon/phalcon-devtools/blob/master/templates/.htrouter.php" target="_blank">.htrouter.php</a>

Si ha creado su aplicación con [Phalcon Devtools](/[[language]]/[[version]]/devtools-installation) este archivo ya debe existir en el directorio raíz de tu proyecto y puede iniciar el servidor con el siguiente comando:

```bash
$(which php) -S localhost:8000 -t public .htrouter.php
```

La anatomía de este comando:

- `$(which php)` insertará la ruta absoluta a su PHP binario
- `-S localhost:8000` invoca el modo de servidor con `host:puerto` proporcionado
- `-t public` define el directorio raíz de los servidores, es necesario para php para las solicitudes de ruta a activos como JS, CSS e imágenes en el directorio público
- `.htrouter.php` el punto de entrada que será evaluado para cada solicitud

Luego dirija su navegador a http://localhost:8000/ para comprobar si todo está funcionando.

<a name='nginx'></a>

## Nginx

[Nginx](http://wiki.nginx.org/Main) es un servidor y proxy inverso gratuito y de código abierto de alto desempeño, así como un servidor proxy para IMAP/POP3. A diferencia de los tradicionales servidores, Nginx no se basa en hilos para procesar las solicitudes. En lugar de esto, utiliza una arquitectura basada en eventos (asíncrona) que es más escalable. Esta arquitectura utiliza pequeñas cantidades de memoria, pero más importante, predecibles bajo carga.

Phalcon con Nginx y PHP-FPM proveen un set de herramientas poderoso para ofrecer el mejor desempeño para tus aplicaciones PHP.

### Instalar Nginx

<a href="https://www.nginx.com/resources/wiki/start/topics/tutorials/install/" target="_blank">Sitio oficial de NginX</a>

<a name='nginx-phalcon-configuration'></a>

### Configuración de Phalcon

Puede utilizar la siguiente configuración posible para configurar Nginx con Phalcon:

```nginx
server {
    # El puerto 80 requerirá que Nginx se inicie con permisos de root
    # Dependiendo de cómo instale Nginx para usar el puerto 80, deberá iniciar
    # el servidor con puertos `sudo` cerca de 1000 no requieren 
    # privilegios de root
    # escuchar      80;

    listen        8000;
    server_name   default;

    ##########################
    # En producción es requerido SSL
    # escuchar 443 ssl default_server;

    # ssl on;
    # ssl_session_timeout  5m;
    # ssl_protocols  SSLv2 SSLv3 TLSv1;
    # ssl_ciphers  ALL:!ADH:!EXPORT56:RC4+RSA:+HIGH:+MEDIUM:+LOW:+SSLv2:+EXP;
    # ssl_prefer_server_ciphers   on;

    # Estas ubicaciones dependerán de donde se ubiquen los certificados
    # ssl_certificate        /var/nginx/certs/default.cert;
    # ssl_certificate_key    /var/nginx/certs/default.key;
    ##########################

    # Esta es la carpeta donde esta el index.php
    root /var/www/default/public;
    index index.php index.html index.htm;

    charset utf-8;
    client_max_body_size 100M;
    fastcgi_read_timeout 1800;

    # Representación del dominio raíz 
    # http://localhost:8000/[index.php]
    location / {
        # Coincidir URLS `$_GET['_url']`
        try_files $uri $uri/ /index.php?_url=$uri&$args;
    }

    # Cuando la consulta HTTP no coincide con lo anterior
    # y el archivo termina en .php
    location ~ [^/]\.php(/|$) {
        # try_files $uri =404;

        # Ubuntu y PHP7.0-fpm en modo socket
        # Este camino depende de la versión instalada de PHP
        fastcgi_pass  unix:/var/run/php/php7.0-fpm.sock;


        # También puede usar PHP-FPM en modo TCP (Necesario en Windows)
        # Debe configurar al FPM para escuchar el puerto estándar
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

### Iniciar Nginx

Usar `start nginx` desde la línea de comandos, pero esto depende del método de instalación.

<a name='apache'></a>

## Apache

[Apache](http://httpd.apache.org/) es un servidor web popular y bien conocido disponible en muchas plataformas.

<a name='apache-phalcon-configuration'></a>

### Configuración de Phalcon

Las siguientes son posibles configuraciones que puedes usar para configurar Apache con Phalcon. Estas notas están principalmente enfocadas a la configuración del módulo `mod_rewrite` permitiendo usar URLs amigables y el [componente router](/[[language]]/[[version]]/routing). Comúnmente una aplicación tiene la siguiente estructura:

```bash
test/
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

<a name='apache-document-root'></a>

#### Raíz de documentos

Este es el caso más común, la aplicación se instala en un directorio bajo la raíz del documento. En este caso, utilizamos dos archivos `.htaccess`, el primero de ellos para ocultar el código de la aplicación reenviando todas las solicitudes a la raíz de documentos (`public/`).

<div class="alert alert-warning">
    <p>
        Ten en cuenta que usar archivos <code>.htaccess</code> requiere que la instalación de apache tenga la opción 'AllowOverride All' configurada.
    </p>
</div>

```apacheconfig
# test/.htaccess

<IfModule mod_rewrite.c>
    RewriteEngine on
    RewriteRule   ^$ public/    [L]
    RewriteRule   ((?s).*) public/$1 [L]
</IfModule>
```

Un segundo archivo `.htaccess` se encuentra en el directorio `public/`, este reescribe todas las URIs hacia el archivo `public/index.php`:

```apacheconfig
# test/public/.htaccess

<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond   %{REQUEST_FILENAME} !-d
    RewriteCond   %{REQUEST_FILENAME} !-f
    RewriteRule   ^((?s).*)$ index.php?_url=/$1 [QSA,L]
</IfModule>
```

<a name='apache-apache-configuration'></a>

#### Configuración de Apache

Si no desea utilizar los archivos `.htaccess` puede mover estas configuraciones al archivo de configuración principal de apache:

```apacheconfig
<IfModule mod_rewrite.c>

    <Directory "/var/www/test">
        RewriteEngine on
        RewriteRule  ^$ public/    [L]
        RewriteRule  ((?s).*) public/$1 [L]
    </Directory>

    <Directory "/var/www/test/public">
        RewriteEngine On
        RewriteCond   %{REQUEST_FILENAME} !-d
        RewriteCond   %{REQUEST_FILENAME} !-f
        RewriteRule   ^((?s).*)$ index.php?_url=/$1 [QSA,L]
    </Directory>

</IfModule>
```

<a name='apache-virtual-hosts'></a>

#### Hosts virtuales

Y esta segunda configuración le permite instalar una aplicación de Phalcon en un virtual host:

```apacheconfig
<VirtualHost *:80>

    ServerAdmin    admin@example.host
    DocumentRoot   "/var/vhosts/test/public"
    DirectoryIndex index.php
    ServerName     example.host
    ServerAlias    www.example.host

    <Directory "/var/vhosts/test/public">
        Options       All
        AllowOverride All
        Require       all granted
    </Directory>

</VirtualHost>
```

<a name='cherokee'></a>

## Cherokee

[Cherokee](http://www.cherokee-project.com/) es un servidor web de alto rendimiento. Es muy rápido, flexible y fácil de configurar.

<a name='cherokee-phalcon-configuration'></a>

### Configuración de Phalcon

Cherokee ofrece una interfaz gráfica amigable para configurar cada opción disponible en el servidor web.

Iniciar el administrador del cherokee ejecutando como root `/ruta-hacia-cherokee/sbin/cherokee-admin`

![](/images/content/webserver-cherokee-1.jpg)

Crea un nuevo host virtual haciendo clic en `vServers`, y agrega un nuevo servidor virtual:

![](/images/content/webserver-cherokee-2.jpg)

El servidor virtual recientemente añadido debe aparecer en la barra izquierda de la pantalla. En la ficha `Behaviors o Comportamientos` verá un conjunto de comportamientos por defecto para este servidor virtual. Haz clic en el botón `Gestión de reglas`. Elimine las que estén marcadas como `Directorio /cherokee_themes` y `Directorio /icons`:

![](/images/content/webserver-cherokee-3.jpg)

Añade el comportamiento de `Lenguaje PHP` utilizando el asistente. Este comportamiento permite ejecutar aplicaciones de PHP:

![](/images/content/webserver-cherokee-1.jpg)

Normalmente este comportamiento no requiere configuración adicional. Añade otro comportamiento, esta vez en la sección de `Configuración Manual`. En `Rule Type` elige `File Exists`, luego asegúrate que la opción `Match any file` esté habilitada:

![](/images/content/webserver-cherokee-5.jpg)

En la ficha 'Controlador' elegir `Listar y enviar` como controlador:

![](/images/content/webserver-cherokee-7.jpg)

Edita el comportamiento `Default` para habilitar el motor de reescritura de URLs. Cambiar el controlador a `Redirection`, luego agrega la siguiente expresión regular para el motor `^(.*)$`:

![](/images/content/webserver-cherokee-6.jpg)

Por último, asegúrate de que los comportamientos tienen el siguiente orden:

![](/images/content/webserver-cherokee-8.jpg)

Ejecuta la aplicación en un navegador:

![](/images/content/webserver-cherokee-9.jpg)