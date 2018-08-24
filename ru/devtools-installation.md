<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Установка Phalcon Developer Tools</a> 
      <ul>
        <li>
          <a href="#prerequisites">Требования</a>
        </li>
        <li>
          <a href="#installation">Установка</a> 
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
                  <a href="#installation-windows-system-path">Добавление PHP и DevTools в системную переменную PATH</a>
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

# Установка Phalcon Developer Tools

Эти шаги помогут вам установить Phalcon Developer Tools в Linux, macOS и Windows.

<a name='prerequisites'></a>

## Требования

The Phalcon extension is required to run Phalcon Tools. If you haven't installed it yet, please see the [Installation](/[[language]]/[[version]]//installation) section for instructions.

<a name='installation'></a>

## Установка

Вы можете скачать кроссплатформенный пакет инструментов разработчиков используя [публичный репозиторий на Github](https://github.com/phalcon/phalcon-devtools).

<a name='installation-linux'></a>

### Linux

Откройте терминал и введите следующую команду:

```bash
git clone git://github.com/phalcon/phalcon-devtools.git
```

![](/images/content/devtools-linux-1.png)

Затем откройте папку, в которую были скопированы инструменты, и выполните команду `. ./phalcon.sh`, (не забудьте точку в начале команды):

```bash
cd phalcon-devtools/
. ./phalcon.sh
```

![](/images/content/devtools-linux-2.png)

Создайте ссылку на файл phalcon.php:

```bash
ln -s ~/phalcon-devtools/phalcon.php /usr/bin/phalcon
chmod ugo+x /usr/bin/phalcon
```

<a name='installation-mac'></a>

### macOS

Откройте терминал и введите следующую команду:

```bash
git clone git://github.com/phalcon/phalcon-devtools.git
```

![](/images/content/devtools-mac-1.png)

Затем откройте папку, в которую были скопированы инструменты, и выполните команду `. ./phalcon.sh`, (не забудьте точку в начале команды):

```bash
cd phalcon-devtools/
. ./phalcon.sh
```

![](/images/content/devtools-mac-2.png)

Next, we'll create a symbolic link to the `phalcon.php` script. On El Capitan and newer versions of macOS:

```bash
ln -s ~/phalcon-devtools/phalcon.php /usr/local/bin/phalcon
chmod ugo+x /usr/local/bin/phalcon
```

if you are running an older version:

```bash
ln -s ~/phalcon-devtools/phalcon.php /usr/bin/phalcon
chmod ugo+x /usr/bin/phalcon
```

<a name='installation-windows'></a>

### Windows

На платформе Windows вам необходимо настроить системную переменную `PATH` для запуска инструментов разработчика и выполнения PHP. Если вы скачали инструменты разработчика в виде ZIP-архива, то его необходимо распаковать, например в `c:\phalcon-tools`. Запомните этот каталог, путь к нему понадобится ниже. Отредактируйте файл `phalcon.bat`, для этого кликните правой кнопкой мыши и выберите `Изменить`:

![](/images/content/devtools-windows-1.png)

Измените путь на тот, по которому были установлены инструменты разработчика Phalcon (`set PTOOLSPATH=C:\phalcon-tools`):

![](/images/content/devtools-windows-2.png)

Сохраните изменения.

<a name='installation-windows-system-path'></a>

#### Добавление PHP и Devtools в системную переменную PATH

Поскольку инструменты разработчика написаны на PHP, его необходимо установить на ваш компьютер. В зависимости от того, как был установлен PHP, его исполняемый файл может быть в разных местах. Найдите файл `php.exe` и запомните (скопируйте) путь к нему. Например, при использовании WAMPP, путь к PHP может быть похож на: `C:\wamp\bin\php\<php version>\php.exe` (где `<php version>` — версия PHP используемая в WAMPP).

From the Windows start menu, right mouse click on the `Computer` icon and select `Properties`:

![](/images/content/devtools-windows-3.png)

Click the `Advanced` tab and then the button `Environment Variables`:

![](/images/content/devtools-windows-4.png)

At the bottom, look for the section `System variables` and edit the variable `Path`:

![](/images/content/devtools-windows-5.png)

Be very careful on this step! You need to append at the end of the long string the path where your `php.exe` was located and the path where Phalcon tools are installed. Use the `;` character to separate the different paths in the variable:

![](/images/content/devtools-windows-6.png)

Accept the changes made by clicking `OK` and close the dialogs opened. From the start menu click on the option `Run`. If you can't find this option, press <kbd>Windows</kbd> + <kbd>R</kbd>.

![](/images/content/devtools-windows-7.png)

Type `cmd` and press <kbd>Enter</kbd> to open the Windows command line utility:

![](/images/content/devtools-windows-8.png)

Type the commands `php -v` and `phalcon` and you will see something like this:

![](/images/content/devtools-windows-9.png)

Congratulations you now have Phalcon tools installed!