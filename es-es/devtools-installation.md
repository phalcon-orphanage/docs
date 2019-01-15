* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# Phalcon Developer Tools en Linux

These steps will guide you through the process of installing Phalcon Developer Tools for Linux.

<a name='prerequisites'></a>

## Prerequisitos

The Phalcon PHP extension is required to run Phalcon Tools. If you haven't installed it yet, please see the [Installation](/4.0/en//installation) section for instructions.

<a name='installation'></a>

## Instalación

Usted puede descargar un paquete multi plataforma que contiene las Herramientas del Desarrollador de desde [Github](https://github.com/phalcon/phalcon-devtools).

<a name='installation-linux'></a>

### Linux

Abra una terminal y escriba el comando siguiente:

```bash
git clone git://github.com/phalcon/phalcon-devtools.git
```

![](/assets/images/content/devtools-linux-1.png)

Luego ubique la carpeta donde las Herramientas del Desarrollador se clonaron y ejecute `. ./phalcon.sh`, (no olvide el punto al principio del comando):

```bash
cd phalcon-devtools/
. ./phalcon.sh
```

![](/assets/images/content/devtools-linux-2.png)

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

![](/assets/images/content/devtools-mac-1.png)

Luego ubique la carpeta donde las Herramientas del Desarrollador se clonaron y ejecute `. ./phalcon.sh`, (no olvide el punto al principio del comando):

```bash
cd phalcon-devtools/
. ./phalcon.sh
```

![](/assets/images/content/devtools-mac-2.png)

A continuación, vamos a crear un enlace simbólico al script `phalcon.php`. Sobre El Capitan y nuevas versiones de macOS:

```bash
ln -s ~/phalcon-devtools/phalcon.php /usr/local/bin/phalcon
chmod ugo+x /usr/local/bin/phalcon
```

si está ejecutando una versión anterior:

```bash
ln -s ~/phalcon-devtools/phalcon.php /usr/bin/phalcon
chmod ugo+x /usr/bin/phalcon
```

<a name='installation-windows'></a>

### Windows

En la plataforma de Windows, debe configurar el `PATH` del sistema para que incluya las herramientas de Phalcon, así como el ejecutable de PHP. Si descarga las herramientas de Phalcon como un archivo zip, entonces, descomprimalo en cualquier ruta de su disco local por ejemplo, `c:\phalcon-tools`. Usted necesitará esta ruta en los pasos siguientes. Edite el archivo `phalcon.bat` haciendo clic derecho sobre el archivo y seleccionando `Editar`:

![](/assets/images/content/devtools-windows-1.png)

Cambie la ruta de acceso a donde se instalo las herramientas de Phalcon (`set PTOOLSPATH = C:\phalcon-tools`):

![](/assets/images/content/devtools-windows-2.png)

Guarde los cambios.

<a name='installation-windows-system-path'></a>

#### Agregar PHP y DevTools al PATH del sistema

Debido a que los scripts están escritos en PHP, necesita tenerlo instalarlo en su equipo. Dependiendo de su instalación de PHP, el archivo ejecutable puede ubicarse en varios lugares. Busque el archivo `php.exe` y copie su dirección o camino. Por ejemplo, usando WAMPP localizaremos el ejecutable PHP en un lugar como este: `C:\wamp\bin\php\<php version>\php.exe` (donde `<php version>` es la versión de PHP que viene incluida con WAMPP).

From the Windows start menu, right mouse click on the `Computer` icon and select `Properties`:

![](/assets/images/content/devtools-windows-3.png)

Click the `Advanced` tab and then the button `Environment Variables`:

![](/assets/images/content/devtools-windows-4.png)

At the bottom, look for the section `System variables` and edit the variable `Path`:

![](/assets/images/content/devtools-windows-5.png)

Be very careful on this step! You need to append at the end of the long string the path where your `php.exe` was located and the path where Phalcon tools are installed. Use the `;` character to separate the different paths in the variable:

![](/assets/images/content/devtools-windows-6.png)

Accept the changes made by clicking `OK` and close the dialogs opened. From the start menu click on the option `Run`. If you can't find this option, press `Windows Key` + `R`.

![](/assets/images/content/devtools-windows-7.png)

Type `cmd` and press enter to open the windows command line utility:

![](/assets/images/content/devtools-windows-8.png)

Type the commands `php -v` and `phalcon` and you will see something like this:

![](/assets/images/content/devtools-windows-9.png)

Congratulations you now have Phalcon tools installed!