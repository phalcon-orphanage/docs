* * *

layout: default language: 'en' version: '3.4'

* * *

<a name='overview'></a>

# Phalcon Developer Tools en Linux

Estos pasos le guiarán por el proceso de instalación de las Herramientas del Desarrollador de Phalcon para Linux.

<a name='prerequisites'></a>

## Prerequisitos

The Phalcon PHP extension is required to run Phalcon Tools. If you haven't installed it yet, please see the [Installation](/3.4/en//installation) section for instructions.

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

Then enter the folder where the tools were cloned and execute `. ./phalcon.sh`, (don't forget the dot at beginning of the command):

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

Then enter the folder where the tools were cloned and execute `. ./phalcon.sh`, (don't forget the dot at beginning of the command):

```bash
cd phalcon-devtools/
. ./phalcon.sh
```

![](/assets/images/content/devtools-mac-2.png)

Next, we'll create a symbolic link to the `phalcon.php` script. On El Capitan and newer versions of macOS:

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

Desde el menú Inicio de Windows, haga derecho con el ratón y haga clic en el icono `Computer` y seleccione `Propiedades`:

![](/assets/images/content/devtools-windows-3.png)

Haga clic en la pestaña `Avanzado` y luego en el botón `Variables de Entorno`:

![](/assets/images/content/devtools-windows-4.png)

En la parte inferior, busque la sección `Variables del Sistema` y edite la variable `Path`:

![](/assets/images/content/devtools-windows-5.png)

¡Tenga mucho cuidado en este paso! Al final de la cadena es necesario agregar la ruta donde se encontraba el `php.exe` y la ruta donde están instaladas las herramientas de Phalcon. Utilice el carácter `;` para separar las diferentes rutas en la variable:

![](/assets/images/content/devtools-windows-6.png)

Acepte los cambios haciendo clic en `Aceptar` y cierre los cuadros de diálogo abiertos. Desde el inicio menú haga clic en la opción `Ejecutar`. Si no puede encontrar esta opción, presione la `Tecla de Windows` + `R`.

![](/assets/images/content/devtools-windows-7.png)

Debe teclear `cmd` y luego presione enter para abrir la utilidad de línea de comandos de windows:

![](/assets/images/content/devtools-windows-8.png)

Escriba los comandos `php - v` y `phalcon` y verá algo como esto:

![](/assets/images/content/devtools-windows-9.png)

¡Felicidades ahora tienes las herramientas de Phalcon instaladas!