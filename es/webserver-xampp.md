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
          <a href="#related">Guías Relacionadas</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Resumen

[XAMPP](https://www.apachefriends.org/download.html) es una distribución fácil de instalar que contiene Apache, MySQL, PHP y Perl. Al descargar XAMPP, todo lo que tiene que hacer es descomprimirlo y empezar a usarlo. A continuación se muestran instrucciones detalladas para instalar Phalcon en XAMPP para Windows, utilizando la última versión XAMPP que es siempre lo más recomendable.

<a name='phalcon'></a>

## Descargar la versión correcta de Phalcon

XAMPP es siempre liberado en versiones de 32 bits de Apache y PHP. Es necesario que descargue la versión x86 de Phalcon para Windows de la sección de descargas.

Después de descargar la biblioteca Phalcon, tendrá un archivo zip como se muestra a continuación:

![](/images/content/webserver-xampp-1.png)

Extraiga la biblioteca del archivo para obtener la DLL de Phalcon:

![](/images/content/webserver-xampp-2.png)

Copia el archivo `php_phalcon.dll` en la carpeta de extensiones de PHP. Si tiene instalado XAMPP en la carpeta `C:\xampp`, la extensión debe ir en el directorio `C:\xampp\php\ext`:

![](/images/content/webserver-xampp-3.png)

Edite el archivo `php.ini`, que se encuentra en `C:\xampp\php\php.ini`. Pueden editarse con el Bloc de notas o un programa similar. Le recomendamos [Notepad++](https://notepad-plus-plus.org/) para evitar problemas con finales de línea. Añada el siguiente texto al final del archivo:

```ini
extension=php_phalcon.dll
```

y guarde los cambios.

![](/images/content/webserver-xampp-4.png)

Reiniciar el servidor web Apache desde el control de control de XAMPP. Esto cargará la nueva configuración de PHP.

![](/images/content/webserver-xampp-5.png)

Abra su navegador web y navegué a `http://localhost`. Aparecerá la página de bienvenida de XAMPP. Haga clic en el link `phpinfo()`.

![](/images/content/webserver-xampp-6.png)

La función [phpinfo](http://php.net/manual/en/function.phpinfo.php) producirá una cantidad significativa de información en pantalla sobre el estado actual de PHP. Desplácese hacia abajo para comprobar si la extensión Phalcon ha sido cargada correctamente.

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

* [Instalación General](/[[language]]/[[version]]/installation)
* [Instalación en WAMP](/[[language]]/[[version]]/webserver-wamp)