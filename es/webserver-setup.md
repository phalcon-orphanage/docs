<div class='article-menu'>
  <ul>
    <li>
      <a href="#setup">Configuración de Servidor Web</a> <ul>
        <li>
          <a href="#nginx">Nginx</a> <ul>
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
          <a href="#apache">Apache</a> <ul>
            <li>
              <a href="#apache-phalcon-configuration">Configuración de Phalcon</a> <ul>
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
          <a href="#cherokee">Cherokee</a> <ul>
            <li>
              <a href="#cherokee-phalcon-configuration">Configuración de Phalcon</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#php-built-in">Servidor web incorporado</a> <ul>
            <li>
              <a href="#php-built-in-phalcon-configuration">Configuración de Phalcon</a>
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

<a name='nginx'></a>

## Nginx

[Nginx](http://wiki.nginx.org/Main) es un servidor y proxy inverso gratuito y de código abierto de alto desempeño, así como un servidor proxy para IMAP/POP3. A diferencia de los tradicionales servidores, Nginx no se basa en hilos para procesar las solicitudes. En lugar de esto, utiliza una arquitectura basada en eventos (asíncrona) que es más escalable. Esta arquitectura utiliza pequeñas cantidades de memoria, pero más importante, predecibles bajo carga.

Generalmente se usa [PHP-FPM](http://php-fpm.org/) (FastCGI Process Manager) para permitir a Nginx procesar archivos PHP. Hoy en día PHP-FPM está incluído en todas las distribuciones Linux. Phalcon con Nginx y PHP-FPM proveen un set de herramientas poderoso para ofrecer el mejor desempeño para tus aplicaciones PHP.

<a name='nginx-phalcon-configuration'></a>

### Configuración de Phalcon

Las siguientes son posibles configuraciones que puedes usar para configurar Nginx con Phalcon:

<a name='nginx-phalcon-configuration-basic'></a>

#### Configuración básica

Usando `$_GET['_url']` como fuente para las URIs:

```nginx
server {
    listen      80;
    server_name localhost.dev;

    # Este es el directorio donde se encuentra el archivo index.php
    root /var/www/phalcon/public;
    index index.php index.html index.htm;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?_url=$uri&$args;
    }

    location ~ \.php {
        fastcgi_pass  unix:/run/php-fpm/php-fpm.sock;
        fastcgi_index /index.php;

        include fastcgi_params;
        fastcgi_split_path_info       ^(.+\.php)(/.+)$;
        fastcgi_param PATH_INFO       $fastcgi_path_info;
        fastcgi_param PATH_TRANSLATED $document_root$fastcgi_path_info;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

Usando `$_SERVER['REQUEST_URI']` como fuente para las URIs:

```nginx
server {
    listen      80;
    server_name localhost.dev;

    # Este es el directorio donde se encuentra el archivo index.php
    root /var/www/phalcon/public;
    index index.php index.html index.htm;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php;
    }

    location ~ \.php$ {
        try_files $uri =404;

        fastcgi_pass  127.0.0.1:9000;
        fastcgi_index /index.php;

        include fastcgi_params;
        fastcgi_split_path_info       ^(.+\.php)(/.+)$;
        fastcgi_param PATH_INFO       $fastcgi_path_info;
        fastcgi_param PATH_TRANSLATED $document_root$fastcgi_path_info;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

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

<h5 class='alert alert-warning'>Tenga en cuenta que la utilización de archivos <code>.htaccess</code> requiere que la instalación de apache tenga la opción <code>AllowOverride All</code>. </h5>

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

<a name='php-built-in'></a>

## Servidor web incorporado en PHP

Puede utilizar servidor de web [incorporado](http://php.net/manual/en/features.commandline.webserver.php) en PHP para tu desarrollo. Para iniciar el servidor ejecuta:

```bash
php -S localhost:8000 -t /public
```

<a name='php-built-in-phalcon-configuration'></a>

### Configuración de Phalcon

Para habilitar reescrituras de identificador URI que Phalcon requiere, puedes usar el siguiente archivo de ruteo (`.htrouter.php`):

```php
<?php

if (!file_exists(__DIR__ . '/' . $_SERVER['REQUEST_URI'])) {
    $_GET['_url'] = $_SERVER['REQUEST_URI'];
}

return false;
```

y luego iniciar el servidor desde el directorio base del proyecto con:

```bash
php -S localhost:8000 -t /public .htrouter.php
```

Luego dirija su navegador a http://localhost:8000/ para comprobar si todo está funcionando.