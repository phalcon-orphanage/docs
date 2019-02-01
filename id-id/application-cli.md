---
layout: article
language: 'id-id'
version: '4.0'
---
**This article reflects v3.4 and has not yet been revised**

<a name='creating-cli-application'></a>

# Membuat Aplikasi Command Line (CLI)

CLI applications are executed from the command line. They are useful to create cron jobs, scripts, command utilities and more.

<a name='structure'></a>

## Struktur

A minimal structure of a CLI application will look like this:

* `app/config/config.php`
* `app/tugas/MainTask.php`
* ` app / cli.php </ 0> & lt; - file bootstrap utama</li>
</ul>

<p>

<a name='creating-bootstrap'></a>

</p>

<h2>Membuat Bootstrap</h2>

<p>As in regular MVC applications, a bootstrap file is used to bootstrap the application. Instead of the index.php bootstrapper in web applications, we use a cli.php file for bootstrapping the application.</p>

<p>Below is a sample bootstrap that is being used for this example.</p>

<pre><code class="php">& lt;? php

gunakan Phalcon \ Di \ FactoryDefault \ Cli sebagai CliDI;
gunakan Phalcon \ Cli \ Console sebagai ConsoleApp;
gunakan Phalcon \ Loader;

// Menggunakan wadah layanan bawaan pabrik CLI
$ di = new CliDI ();

/ **
 * Daftarkan autoloader dan suruh untuk mendaftarkan direktori tugas
 * /
$ loader = new Loader ();

$ loader- & gt; registerDirs
    [
        __DIR__.
 
Konteks | Permintaan Konteks. '/ tugas',
    ]
);

$ loader- & gt; register ();

/ / Load file konfigurasi (jika ada)
$ configFile = __DIR__. '/config/config.php';

jika (is_readable ($ configFile)) {
    $ config = sertakan $ configFile;

    $ di- & gt; set ('config', $ config);
}

// Buat aplikasi konsol
$ console = new ConsoleApp ();

$ console- & gt; setDI ($ di);

/ **
 * Proses argumen konsol
 * /
$ arguments = [];

foreach ($ argv as $ k = & gt; $ arg) {
    jika ($ k === 1) {
        $ argument ['task'] = $ arg;
    } elseif ($ k === 2) {
        $ argument ['action'] = $ arg;
    } elseif ($ k & gt; = 3) {
        $ arguments ['params'] [] = $ arg;
    }
}

coba {
    // Tangani argumen yang masuk
    $ console- & gt; handle ($ arguments);
} catch (\ Phalcon \ Exception $ e) {
    // Apakah hal-hal terkait Phalcon disini?
    // ..
    fwrite (STDERR, $e -> getMessage(). PHP_EOL);     Exit(1); } catch (\Throwable $throwable) {fwrite (STDERR, $throwable -> getMessage(). PHP_EOL);     Exit(1); } catch (\Throwable $exception) {fwrite (STDERR, $exception -> getMessage(). PHP_EOL);
    exit(1);
}
`</pre> 
    This piece of code can be run using:
    
    ```bash
    php app/cli.php
    ```
    
    

<a name='tasks'></a>

    
    ## Tugas
    
    Tasks work similar to controllers. Any CLI application needs at least a MainTask and a mainAction and every task needs to have a mainAction which will run if no action is given explicitly.
    
    Below is an example of the `app/tasks/MainTask.php` file:
    
    ```php
    & lt;? php
    
    gunakan Phalcon \ Cli \ Task;
    
    kelas MainTask meluas Tugas
    {
        fungsi publik mainAction ()
        {
            echo 'Ini adalah tugas default dan tindakan default'. Php_EOL. PHP_EOL;     } }
    ```
    
    

<a name='processing-action-parameters'></a>

    
    ## Memproses parameter tindakan
    
    It's possible to pass parameters to actions, the code for this is already present in the sample bootstrap.
    
    If you run the application with the following parameters and action:
    
    ```php
    & lt;? php
    
    gunakan Phalcon \ Cli \ Task;
    
    kelas MainTask meluas Tugas
    {
        fungsi publik mainAction ()
        {
            echo 'Ini adalah tugas default dan tindakan default'. Php_EOL. PHP_EOL;     } / ** * @param array $params * / public fungsi testAction (array $params) {echo sprintf ('Halo %s', $params[0]);          echo PHP_EOL;          echo sprintf ('best regards, %s', $params[1]);          echo PHP_EOL;     } }
    ```
    
    We can then run the following command:
    
    ```bash
    php app/cli.php tes utama dunia alam semesta Halo dunia salam, alam semesta
    ```
    
    

<a name='running-tasks-chain'></a>

    
    ## Menjalankan tugas dalam rantai
    
    It's also possible to run tasks in a chain if it's required. To accomplish this you must add the console itself to the DI:
    
    ```php
    <? php$di -> setShared ("konsol", $console);  mencoba {/ / menangani masuk argumen $console -> handle($arguments);} catch (\Phalcon\Exception $e) {/ / lakukan Phalcon terkait hal-hal berikut / /..
        fwrite (STDERR, $e -> getMessage(). PHP_EOL);     Exit(1); } catch (\Throwable $throwable) {fwrite (STDERR, $throwable -> getMessage(). PHP_EOL);     Exit(1); } catch (\Throwable $exception) {fwrite (STDERR, $exception -> getMessage(). PHP_EOL);
        exit(1);
    }
    ```
    
    Then you can use the console inside of any task. Below is an example of a modified MainTask.php:
    
    ```php
    & lt;? php
    
    gunakan Phalcon \ Cli \ Task;
    
    kelas MainTask meluas Tugas
    {
        fungsi publik mainAction ()
        {
            echo 'Ini adalah tugas default dan tindakan default'. Php_EOL. PHP_EOL;          $this -> konsol -> menangani (["tugas" = > "utama", "tindakan" = > "test",]);     } testAction() Umum fungsi {echo "Aku akan mendapatkan dicetak terlalu!". PHP_EOL;     } }
    ```
    
    However, it's a better idea to extend [Phalcon\Cli\Task](api/Phalcon_Cli_Task) and implement this kind of logic there.