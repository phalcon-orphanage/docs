* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# Instalación en XAMPP

[XAMPP](https://www.apachefriends.org/download.html) es una distribución fácil de instalar que contiene Apache, MySQL, PHP y Perl. Al descargar XAMPP, todo lo que tiene que hacer es descomprimirlo y empezar a usarlo. A continuación se muestran instrucciones detalladas para instalar Phalcon en XAMPP para Windows, utilizando la última versión XAMPP que es siempre lo más recomendable.

<a name='phalcon'></a>

## Descargar la versión correcta de Phalcon

Los desarrollos de XAMPP siempre lanzan versiones de 32 bits de Apache y PHP. Usted tendrá que descargar el versión x86 de Phalcon para Windows desde la sección de descargas.

Después de descargar la biblioteca Phalcon tendrás un archivo zip como se muestra a continuación:

![](/assets/images/content/webserver-xampp-1.png)

Descomprime la biblioteca del archivo para obtener la DLL de Phalcon:

![](/assets/images/content/webserver-xampp-2.png)

Copy the file `php_phalcon.dll` to the PHP extensions directory. If you have installed XAMPP in the `C:\xampp` folder, the extension needs to be in `C:\xampp\php\ext`

![](/assets/images/content/webserver-xampp-3.png)

Edite el archivo `php.ini`, que se encuentra en `C:\xampp\php\php.ini`. Puedes editarlo con el Bloc de notas o un programa similar. Le recomendamos [Notepad++](https://notepad-plus-plus.org/) para evitar problemas con finales de línea. Agrega esto al final del archivo:

```ini
extension=php_phalcon.dll
```

y guarda los cambios.

![](/assets/images/content/webserver-xampp-4.png)

Reinicie el servidor de Web Apache desde el centro de Control de XAMPP. Esto cargará la nueva configuración de PHP.

![](/assets/images/content/webserver-xampp-5.png)

Open your browser to navigate to `https://localhost`. The XAMPP welcome page will appear. Click on the link `phpinfo()`.

![](/assets/images/content/webserver-xampp-6.png)

[phpinfo](https://php.net/manual/en/function.phpinfo.php) will output a significant amount of information on screen about the current state of PHP. Desplácese hacia abajo para comprobar si la extensión Phalcon ha sido cargada correctamente.

![](/assets/images/content/webserver-xampp-7.png)

Si ves la versión de phalcon en la pagina `phpinfo()`, ¡Felicidades!, ahora está volando con Phalcon.

<a name='screencast'></a>

## Video tutorial

El siguiente video tutorial es una guía paso a paso para instalar Phalcon en Windows:

<div align="center">
  <iframe src="https://player.vimeo.com/video/40265988" 
          width="500" 
          height="266" 
          frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen>
  </iframe>
</div>

<a name='related'></a>

## Guías Relacionadas

* [Instalación General](/4.0/en/installation)
* [Instalación en WAMP](/4.0/en/webserver-wamp)