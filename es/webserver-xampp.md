<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Resumen</a>
      <ul>
        <li>
          <a href="#phalcon">Descargar la versión correcta de Phalcon</a>
        </li>
        <li>
          <a href="#screencast">Video tutorial</a>
        </li>
        <li>
          <a href="#related">Related Guides</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Overview

[XAMPP](https://www.apachefriends.org/download.html) es una distribución fácil de instalar que contiene Apache, MySQL, PHP y Perl. Al descargar XAMPP, todo lo que tiene que hacer es descomprimirlo y empezar a usarlo. A continuación se muestran instrucciones detalladas para instalar Phalcon en XAMPP para Windows, utilizando la última versión XAMPP que es siempre lo más recomendable.

<a name='phalcon'></a>

## Descargar la versión correcta de Phalcon

Los desarrollos de XAMPP siempre lanzan versiones de 32 bits de Apache y PHP. Usted tendrá que descargar el versión x86 de Phalcon para Windows desde la sección de descargas.

Después de descargar la biblioteca Phalcon, tendrá un archivo zip como se muestra a continuación:

![](/images/content/webserver-xampp-1.png)

Extraiga la biblioteca del archivo para obtener la DLL de Phalcon:

![](/images/content/webserver-xampp-2.png)

Copy the file `php_phalcon.dll` to the PHP extensions directory. If you have installed XAMPP in the `C:\xampp` folder, the extension needs to be in `C:\xampp\php\ext`:

![](/images/content/webserver-xampp-3.png)

Edit the `php.ini` file, it is located at `C:\xampp\php\php.ini`. Pueden editarse con el Bloc de notas o un programa similar. We recommend [Notepad++](https://notepad-plus-plus.org/) to avoid issues with line endings. Añada el siguiente texto al final del archivo:

```ini
extension=php_phalcon.dll
```

y guarde los cambios.

![](/images/content/webserver-xampp-4.png)

Reinicie el servidor de Web Apache desde el centro de Control de XAMPP. Esto cargará la nueva configuración de PHP.

![](/images/content/webserver-xampp-5.png)

Abra el navegador para ir a `http://localhost`. Aparecerá la página de bienvenida de XAMPP. Haga clic en el enlace `phpinfo()`.

![](/images/content/webserver-xampp-6.png)

[phpinfo](http://php.net/manual/en/function.phpinfo.php) will output a significant amount of information on screen about the current state of PHP. Scroll down to check if the phalcon extension has been loaded correctly.

![](/images/content/webserver-xampp-7.png)

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

* [General Installation](/[[language]]/[[version]]/installation)
* [Instalación en WAMP](/[[language]]/[[version]]/webserver-wamp)