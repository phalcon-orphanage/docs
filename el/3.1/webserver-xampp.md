<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Overview</a> <ul>
        <li>
          <a href="#phalcon">Κατεβάστε την σωστή έκδοση του Phalcon</a>
        </li>
        <li>
          <a href="#screencast">Screencast</a>
        </li>
        <li>
          <a href="#related">Related</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Εγκατάσταση σε XAMPP

[XAMPP](https://www.apachefriends.org/download.html) is an easy to install Apache distribution containing MySQL, PHP and Perl. Once you download XAMPP, all you have to do is extract it and start using it. Below are detailed instructions on how to install Phalcon on XAMPP for Windows. Using the latest XAMPP version is highly recommended.

<a name='phalcon'></a>

## Κατεβάστε την σωστή έκδοση του Phalcon

XAMPP is always releasing 32 bit versions of Apache and PHP. You will need to download the x86 version of Phalcon for Windows from the download section.

After downloading the Phalcon library you will have a zip file like the one shown below:

![](/images/content/webserver-xampp-1.png)

Extract the library from the archive to get the Phalcon DLL:

![](/images/content/webserver-xampp-2.png)

Copy the file `php_phalcon.dll` to the PHP extensions directory. If you have installed XAMPP in the `C:\xampp` folder, the extension needs to be in `C:\xampp\php\ext`

![](/images/content/webserver-xampp-3.png)

Edit the php.ini file, it is located at `C:\xampp\php\php.ini`. It can be edited with Notepad or a similar program. We recommend Notepad++ to avoid issues with line endings. Append at the end of the file:

```ini
extension=php_phalcon.dll
```

and save it.

![](/images/content/webserver-xampp-4.png)

Restart the Apache Web Server from the XAMPP Control Center. This will load the new PHP configuration.

![](/images/content/webserver-xampp-5.png)

Open your browser to navigate to `http://localhost`. The XAMPP welcome page will appear. Click on the link `phpinfo()`.

![](/images/content/webserver-xampp-6.png)

`phpinfo()` will output a significant amount of information on screen about the current state of PHP. Scroll down to check if the phalcon extension has been loaded correctly.

![](/images/content/webserver-xampp-7.png)

If you can see the phalcon version in the `phpinfo()` output, congratulations!, You are now phlying with Phalcon.

<a name='screencast'></a>

## Screencast

Το παρακάτω screencast είναι ένας βήμα προς βήμα οδηγός για να εγκαταστήσετε το Phalcon στα Windows:

<div align="center">
  <iframe src="https://player.vimeo.com/video/40265988" 
          width="500" 
          height="266" 
          frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen>
  </iframe>
</div>

<a name='related'></a>

## Related Guides

- [Εγκατάσταση σε WAMP](/[[language]]/[[version]]/webserver-wamp)