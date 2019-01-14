* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# Instalación en WAMP

[WampServer](https://www.wampserver.com/en/) is a Windows web development environment. Te permite crear aplicaciones web con Apache2, PHP y una base de datos MySQL. A continuación te mostramos las instrucciones detalladas para instalar Phalcon en un servidor Wamp para Windows. Utilizar la última versión de WAMP Server es lo mas recomendable.

<a name='phalcon'></a>

## Descargar la versión correcta de Phalcon

WAMP tiene versiones de 32 y 64 bits. De la sección de descargas, puedes descargar la DLL de Phalcon que se adapte a tu instalación WAMPP.

Después de descargar la biblioteca Phalcon tendrás un archivo zip como se muestra a continuación:

![](/assets/images/content/webserver-xampp-1.png)

Descomprime la biblioteca del archivo para obtener la DLL de Phalcon:

![](/assets/images/content/webserver-xampp-2.png)

Copia el archivo `php_phalcon.dll` en la carpeta de extensiones de PHP. If WAMP is installed in the `C:\wamp` folder, the extension needs to be in `C:\wamp\bin\php\php5.5.12\ext` (assuming your WAMP installation installed PHP 5.5.12).

![](/assets/images/content/webserver-wamp-1.png)

Edita el archivo `php.ini`, se encuentra en `C:\wamp\bin\php\php5.5.12\php.ini`. Puedes editarlo con el Bloc de notas o un programa similar. Te recomendamos Notepad ++ para evitar problemas con los caracteres de fin de línea. Agrega esto al final del archivo:

```ini extension=php_phalcon.dll

    <br />y guarda los cambios.
    
    ![](/assets/images/content/webserver-wamp-2.png)
    
    Also edit the `php.ini` file, which is located at `C:\wamp\bin\apache\apache2.4.9\bin\php.ini`. Append at the end of the file: 
    
    ```ini
    extension=php_phalcon.dll 
    

y guarda los cambios.

Restart the Apache Web Server. Do a single click on the WampServer icon at system tray. Choose `Restart All Services` from the pop-up menu. Check out that tray icon will become green again.

![](/assets/images/content/webserver-wamp-3.png)

Open your browser to navigate to https://localhost. The WAMP welcome page will appear. Check the section `extensions loaded` to ensure that phalcon was loaded.

![](/assets/images/content/webserver-wamp-4.png)

Congratulations! You are now phlying with Phalcon.

<a name='related'></a>

## Guías Relacionadas

* [Instalación General](/4.0/en/installation)
* [Instalación en XAMPP](/4.0/en/webserver-xampp)