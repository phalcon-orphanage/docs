<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Přehled</a> <ul>
        <li>
          <a href="#phalcon">Stažení správné verze Phalcon frameworku</a>
        </li>
        <li>
          <a href="#screencast">Video</a>
        </li>
        <li>
          <a href="#related">Související průvodci</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Instalace: XAMPP

[XAMPP](https://www.apachefriends.org/download.html) je jednoduše instalovatelná distribuce Apache web serveru obsahující MySQL, PHP a Perl. Jakmile stáhnete XAMPP, jediné co je potřeba udělat před používáním je extrahovat archív a spustit. Níže jsou podrobné informace jak nainstalovat Phalcon framework pro XAMPP pro Windows. Použití nejnovější verze XAMPP je vysoce doporučeno.

<a name='phalcon'></a>

## Stažení správné verze Phalcon frameworku

XAMPP je vždy vydáván jako 32bitová verze Apache a PHP. Musíte tedy stáhnout x86 verzi Phalcon frameworku pro Windows ze sekce "Stažení".

Po stažení knihovny Phalcon frameworku budete mít ZIP soubor podobný ukázanému níže:

![](/images/content/webserver-xampp-1.png)

Extrahujte knihovnu z archivu a budete mít Phalcon framework jako DLL soubor:

![](/images/content/webserver-xampp-2.png)

Copy the file `php_phalcon.dll` to the PHP extensions directory. If you have installed XAMPP in the `C:\xampp` folder, the extension needs to be in `C:\xampp\php\ext`

![](/images/content/webserver-xampp-3.png)

Edit the php.ini file, it is located at `C:\xampp\php\php.ini`. Soubor může být upraven v libovolném textovém editoru. My doporučujeme použít Notepad++ pro předejití problémů s konci řádků a kódováním. Přidejte následující řádek na konec souboru:

```ini
extension=php_phalcon.dll
```

a uložte soubor.

![](/images/content/webserver-xampp-4.png)

Restartujte web server Apache z ovládacího panelu XAMPP. To způsobí načtení nové PHP konfigurace.

![](/images/content/webserver-xampp-5.png)

Otevřete internetový prohlížeč a do řádku adresy zadejte `http://localhost`. Uvidíte uvítací stranku XAMPP. Klikněte na odkaz `phpinfo()`.

![](/images/content/webserver-xampp-6.png)

`phpinfo()` ukáže velké množství informací o aktuální stavu PHP. Skrolujte dolů a zkontrolujte že rozšíření phalcon je správně načtené.

![](/images/content/webserver-xampp-7.png)

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

- [Instalace: WAMP](/[[language]]/[[version]]/webserver-wamp)