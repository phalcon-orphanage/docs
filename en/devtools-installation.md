<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Phalcon Developer Tools Installation</a> 
      <ul>
        <li>
          <a href="#prerequisites">Prerequisites</a>
        </li>
        <li>
          <a href="#installation">Installation</a> 
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
## Prerequisites
The Phalcon PHP extension is required to run Phalcon Tools. If you haven't installed it yet, please see the [Installation](/[[language]]/[[version]]//installation) section for instructions.

<a name='installation'></a>
## Installation
You can download a cross platform package containing the developer tools from from [Github](https://github.com/phalcon/phalcon-devtools).

<a name='installation-linux'></a>
### Linux
Open a terminal and type the command below:

```bash
git clone git://github.com/phalcon/phalcon-devtools.git
```

![](/images/content/devtools-linux-1.png)

Then enter the folder where the tools were cloned and execute `. ./phalcon.sh`, (don't forget the dot at beginning of the command):

```bash
cd phalcon-devtools/
. ./phalcon.sh
```

![](/images/content/devtools-linux-2.png)

Create a symbolic link to the phalcon.php script:

```bash
ln -s ~/phalcon-devtools/phalcon.php /usr/bin/phalcon
chmod ugo+x /usr/bin/phalcon
```

<a name='installation-mac'></a>
### macOS
Open a terminal and type the command below:

```bash
git clone git://github.com/phalcon/phalcon-devtools.git
```

![](/images/content/devtools-mac-1.png)

Then enter the folder where the tools were cloned and execute `. ./phalcon.sh`, (don't forget the dot at beginning of the command):

```bash
cd phalcon-devtools/
. ./phalcon.sh
```

![](/images/content/devtools-mac-2.png)

Create a symbolink link to the phalcon.php script:

```bash
ln -s ~/phalcon-devtools/phalcon.php /usr/bin/phalcon
chmod ugo+x /usr/bin/phalcon
```

<a name='installation-windows'></a>
### Windows
On the Windows platform, you need to configure the system `PATH` to include Phalcon tools as well as the PHP executable. If you download the Phalcon tools as a zip archive, extract it on any path of your local drive i.e. `c:\phalcon-tools`. You will need this path in the steps below. Edit the file `phalcon.bat` by right clicking on the file and selecting `Edit`:

![](/images/content/devtools-windows-1.png)

Change the path to the one you installed the Phalcon tools (`set PTOOLSPATH=C:\phalcon-tools\`):

![](/images/content/devtools-windows-2.png)

Save the changes.

<a name='installation-windows-system-path'></a>
#### Adding PHP and Tools to your system PATH
Because the scripts are written in PHP, you need to install it on your machine. Depending on your PHP installation, the executable can be located in various places. Search for the file `php.exe` and copy its path. For instance, using WAMPP you will locate the PHP executable in a location like this: `C:\wamp\bin\php\<php version>\php.exe` (where `<php version>` is the version of PHP that WAMPP comes bundled with).

From the Windows start menu, right mouse click on the `Computer` icon and select `Properties`:

![](/images/content/devtools-windows-3.png)

Click the `Advanced` tab and then the button `Environment Variables`:

![](/images/content/devtools-windows-4.png)

At the bottom, look for the section `System variables` and edit the variable `Path`:

![](/images/content/devtools-windows-5.png)

Be very careful on this step! You need to append at the end of the long string the path where your `php.exe` was located and the path where Phalcon tools are installed. Use the `;` character to separate the different paths in the variable:

![](/images/content/devtools-windows-6.png)

Accept the changes made by clicking `OK` and close the dialogs opened. From the start menu click on the option `Run`. If you can't find this option, press `Windows Key` + `R`.

![](/images/content/devtools-windows-7.png)

Type `cmd` and press enter to open the windows command line utility:

![](/images/content/devtools-windows-8.png)

Type the commands `php -v` and `phalcon` and you will see something like this:

![](/images/content/devtools-windows-9.png)

Congratulations you now have Phalcon tools installed!
