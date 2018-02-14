<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Phalcon Developer Tools Installation</a> 
      <ul>
        <li>
          <a href="#prerequisites">Prerequisitos</a>
        </li>
        <li>
          <a href="#installation">Instalación</a> 
          <ul>
            <li>
              <a href="#installation-linux">Linux</a>
            </li>
            <li>
              <a href="#installation-mac">macOS</a>
            </li>
            <li>
              <a href="#installation-windows">Windows</a> 
              <ul>
                <li>
                  <a href="#installation-windows-system-path">Adding PHP and DevTools to your system PATH</a>
                </li>
              </ul>
            </li>
          </ul>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Phalcon Developer Tools Installation

These steps will guide you through the process of installing Phalcon Developer Tools for Linux, macOS and Windows.

<a name='prerequisites'></a>

## Prerequisitos

La extensión de PHP, Phalcon, es necesaria para ejecutar las Herramientas del Desarrollador de Phalcon. Si no la ha instalado aún, por favor consulte la sección [instalación](/[[language]]/[[version]]//installation) para obtener las instrucciones.

<a name='installation'></a>

## Instalación

You can download a cross platform package containing the developer tools from from [Github](https://github.com/phalcon/phalcon-devtools).

<a name='installation-linux'></a>

### Linux

Abra una terminal y escriba el comando siguiente:

```bash
git clone git://github.com/phalcon/phalcon-devtools.git
```

![](/images/content/devtools-linux-1.png)

Luego ubique la carpeta donde las Herramientas del Desarrollador se clonaron y ejecute `. ./phalcon.sh`, (no olvide el punto al principio del comando):

```bash
cd phalcon-devtools/
. ./phalcon.sh
```

![](/images/content/devtools-linux-2.png)

Debe crear un enlace simbólico al script phalcon.php:

```bash
ln -s ~/phalcon-devtools/phalcon.php /usr/bin/phalcon
chmod ugo+x /usr/bin/phalcon
```

<a name='installation-mac'></a>

### macOS

Abra una terminal y escriba el comando siguiente:

```bash
git clone git://github.com/phalcon/phalcon-devtools.git
```

![](/images/content/devtools-mac-1.png)

Luego ubique la carpeta donde las Herramientas del Desarrollador se clonaron y ejecute `. ./phalcon.sh`, (no olvide el punto al principio del comando):

```bash
cd phalcon-devtools/
. ./phalcon.sh
```

![](/images/content/devtools-mac-2.png)

Debe crear un enlace simbólico al script phalcon.php:

```bash
ln -s ~/phalcon-devtools/phalcon.php /usr/bin/phalcon
chmod ugo+x /usr/bin/phalcon
```

<a name='installation-windows'></a>

### Windows

En la plataforma de Windows, debe configurar el `PATH` del sistema para que incluya las herramientas de Phalcon, así como el ejecutable de PHP. Si descarga las herramientas de Phalcon como un archivo zip, entonces, descomprimalo en cualquier ruta de su disco local por ejemplo, `c:\phalcon-tools`. Usted necesitará esta ruta en los pasos siguientes. Edite el archivo `phalcon.bat` haciendo clic derecho sobre el archivo y seleccionando `Editar`:

![](/images/content/devtools-windows-1.png)

Change the path to the one you installed the Phalcon tools (`set PTOOLSPATH=C:\phalcon-tools`):

![](/images/content/devtools-windows-2.png)

Guarde los cambios.

<a name='installation-windows-system-path'></a>

#### Agregar PHP y DevTools al PATH del sistema

Because the scripts are written in PHP, you need to install it on your machine. Depending on your PHP installation, the executable can be located in various places. Search for the file `php.exe` and copy its path. For instance, using WAMPP you will locate the PHP executable in a location like this: `C:\wamp\bin\php\<php version>\php.exe` (where `<php version>` is the version of PHP that WAMPP comes bundled with).

Desde el menú Inicio de Windows, haga derecho con el ratón y haga clic en el icono `Computer` y seleccione `Propiedades`:

![](/images/content/devtools-windows-3.png)

Haga clic en la pestaña `Avanzado` y luego en el botón `Variables de Entorno`:

![](/images/content/devtools-windows-4.png)

En la parte inferior, busque la sección `Variables del Sistema` y edite la variable `Path`:

![](/images/content/devtools-windows-5.png)

¡Tenga mucho cuidado en este paso! Al final de la cadena es necesario agregar la ruta donde se encontraba el `php.exe` y la ruta donde están instaladas las herramientas de Phalcon. Utilice el carácter `;` para separar las diferentes rutas en la variable:

![](/images/content/devtools-windows-6.png)

Acepte los cambios haciendo clic en `Aceptar` y cierre los cuadros de diálogo abiertos. Desde el inicio menú haga clic en la opción `Ejecutar`. Si no puede encontrar esta opción, presione la `Tecla de Windows` + `R`.

![](/images/content/devtools-windows-7.png)

Debe teclear `cmd` y luego presione enter para abrir la utilidad de línea de comandos de windows:

![](/images/content/devtools-windows-8.png)

Escriba los comandos `php - v` y `phalcon` y verá algo como esto:

![](/images/content/devtools-windows-9.png)

¡Felicidades ahora tienes las herramientas de Phalcon instaladas!