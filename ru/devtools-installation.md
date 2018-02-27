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

Create a symbolic link to the phalcon.php script:

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

В меню Пуск правой кнопкой кликните на значок `Computer` и выберите `Properties`:

![](/images/content/devtools-windows-3.png)

Выберите вкладку `Advanced` и нажмите кнопку `Environment Variables`:

![](/images/content/devtools-windows-4.png)

В нижней части диалога обратите внимание на раздел `System variables` и отредактируйте переменную `Path`:

![](/images/content/devtools-windows-5.png)

Будьте осторожны на этом шаге! В конце этой длинной строки вам надо будет добавить путь к установленному файлу `php.exe` и путь к установленным инструментам разработчика Phalcon. Используйте символ `;` для разделения путей в этой строке:

![](/images/content/devtools-windows-6.png)

Примените изменения, нажав кнопку `OK` и закройте диалог. В меню Пуск выберите поле `Run`. If you can't find this option, press <kbd>Windows</kbd> + <kbd>R</kbd>.

![](/images/content/devtools-windows-7.png)

Type `cmd` and press <kbd>Enter</kbd> to open the Windows command line utility:

![](/images/content/devtools-windows-8.png)

Введите команды `php -v` и `phalcon`. Вы должны увидеть что-то вроде этого: 

![](/images/content/devtools-windows-9.png)

Поздравляем, инструменты разработчика Phalcon установлены!