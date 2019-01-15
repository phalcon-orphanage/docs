* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# Installation on XAMPP

[XAMPP](https://www.apachefriends.org/download.html) je jednoduše instalovatelná distribuce Apache web serveru obsahující MySQL, PHP a Perl. Jakmile stáhnete XAMPP, jediné co je potřeba udělat před používáním je extrahovat archív a spustit. Níže jsou podrobné informace jak nainstalovat Phalcon framework pro XAMPP pro Windows. Použití nejnovější verze XAMPP je vysoce doporučeno.

<a name='phalcon'></a>

## Stažení správné verze Phalcon frameworku

XAMPP je vždy vydáván jako 32bitová verze Apache a PHP. Musíte tedy stáhnout x86 verzi Phalcon frameworku pro Windows ze sekce "Stažení".

Po stažení knihovny Phalcon frameworku budete mít ZIP soubor podobný ukázanému níže:

![](/assets/images/content/webserver-xampp-1.png)

Extrahujte knihovnu z archivu a budete mít Phalcon framework jako DLL soubor:

![](/assets/images/content/webserver-xampp-2.png)

Copy the file `php_phalcon.dll` to the PHP extensions directory. If you have installed XAMPP in the `C:\xampp` folder, the extension needs to be in `C:\xampp\php\ext`

![](/assets/images/content/webserver-xampp-3.png)

Edit the `php.ini` file, it is located at `C:\xampp\php\php.ini`. Soubor může být upraven v libovolném textovém editoru. We recommend [Notepad++](https://notepad-plus-plus.org/) to avoid issues with line endings. Přidejte následující řádek na konec souboru:

```ini
extension=php_phalcon.dll
```

a uložte soubor.

![](/assets/images/content/webserver-xampp-4.png)

Restartujte web server Apache z ovládacího panelu XAMPP. To způsobí načtení nové PHP konfigurace.

![](/assets/images/content/webserver-xampp-5.png)

Open your browser to navigate to `https://localhost`. The XAMPP welcome page will appear. Click on the link `phpinfo()`.

![](/assets/images/content/webserver-xampp-6.png)

[phpinfo](https://php.net/manual/en/function.phpinfo.php) will output a significant amount of information on screen about the current state of PHP. Scroll down to check if the phalcon extension has been loaded correctly.

![](/assets/images/content/webserver-xampp-7.png)

Pokud vidíte verzi Phalcon frameworku ve výstupu `phpinfo()`, gratulujeme. Nyní je Phalcon framework připraven.

<a name='screencast'></a>

## Video

Následující video Vás provede krok za krokem instalací Phalcon frameworku pro Windows:

<div align="center">
  <iframe src="https://player.vimeo.com/video/40265988" 
          width="500" 
          height="266" 
          frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen>
  </iframe>
</div>

<a name='related'></a>

## Související průvodci

* [General Installation](/4.0/en/installation)
* [Instalace: WAMP](/4.0/en/webserver-wamp)