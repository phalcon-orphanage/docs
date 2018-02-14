<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Resumen</a> <ul>
        <li>
          <a href="#phalcon">Descargar la versión correcta de Phalcon</a>
        </li>
        <li>
          <a href="#related">Guías Relacionadas</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Instalación en WAMP

[WampServer](http://www.wampserver.com/en/) es un entorno de desarrollo web para Windows. Te permite crear aplicaciones web con Apache2, PHP y una base de datos MySQL. A continuación te mostramos las instrucciones detalladas para instalar Phalcon en un servidor Wamp para Windows. Utilizar la última versión de WAMP Server es lo mas recomendable.

<a name='phalcon'></a>

## Descargar la versión correcta de Phalcon

WAMP tiene versiones de 32 y 64 bits. De la sección de descargas, puedes descargar la DLL de Phalcon que se adapte a tu instalación WAMPP.

Después de descargar la biblioteca Phalcon tendrás un archivo zip como se muestra a continuación:

![](/images/content/webserver-xampp-1.png)

Descomprime la biblioteca del archivo para obtener la DLL de Phalcon:

![](/images/content/webserver-xampp-2.png)

Copia el archivo `php_phalcon.dll` en la carpeta de extensiones de PHP. Si WAMP está instalado en la carpeta `C:\wamp`, la extensión debe ser ubicada en `C:\wamp\bin\php\php5.5.12\ext` (suponiendo que tu instalación de WAMP tiene instalado PHP 5.5.12).

![](/images/content/webserver-wamp-1.png)

Edita el archivo `php.ini`, se encuentra en `C:\wamp\bin\php\php5.5.12\php.ini`. Puedes editarlo con el Bloc de notas o un programa similar. Te recomendamos Notepad ++ para evitar problemas con los caracteres de fin de línea. Agrega esto al final del archivo:

```ini extension=php_phalcon.dll

    <br />y guarda los cambios.

    ![](/images/content/webserver-wamp-2.png)

    También edita el archivo `php.ini`, que se encuentra en `C:\wamp\bin\apache\apache2.4.9\bin\php.ini`. Append at the end of the file:

    ```ini
    extension=php_phalcon.dll

y guarda los cambios.

Reinicia el servidor Web Apache. Haz un clic en el icono de WampServer en la bandeja del sistema. Elije `Reiniciar todos los servicios` en el menú emergente. Espera a que ese icono vuelva a ser verde.

![](/images/content/webserver-wamp-3.png)

Abre el navegador para ve a http://localhost. Aparecerá la página de bienvenida de WAMP. Ve a la sección `extensiones cargadas` para asegurarte que phalcon fue cargado.

![](/images/content/webserver-wamp-4.png)

¡Felicitaciones! Ahora estás volando con Phalcon.

<a name='related'></a>

## Guías Relacionadas

- [Instalación en XAMPP](/[[language]]/[[version]]/webserver-xampp)