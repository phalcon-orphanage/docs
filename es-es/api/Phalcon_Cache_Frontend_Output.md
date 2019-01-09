* * *

layout: default language: 'en' version: '3.4' title: 'Phalcon\Cache\Frontend\Output'

* * *

# Class **Phalcon\Cache\Frontend\Output**

*implements* [Phalcon\Cache\FrontendInterface](/3.4/en/api/Phalcon_Cache_FrontendInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v3.4.0/phalcon/cache/frontend/output.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Allows to cache output fragments captured with ob_* functions

```php <?php</p> 

*

- use Phalcon\Tag;
- use Phalcon\Cache\Backend\File;
- use Phalcon\Cache\Frontend\Output;
- 
- // Create an Output frontend. Cache the files for 2 days
- $frontCache = new Output(
- [
- "lifetime" => 172800,
- ]
- );
- 
- // Crea el componente para cachear desde la salida a un archivo en el backend
- // Establece el directorio del archivo. Es importante mantener la "/" barra al final
- // del valor del directorio
- $cache = new File(
- $frontCache,
- [
- "cacheDir" => "../app/cache/",
- ]
- );
- 
- // Obtiene o establece el archivo de cache en ../app/cache/my-cache.html
- $content = $cache->start("my-cache.html");
- 
- // Si $content es nulo entonces el contenido de be ser generado para el cache
- if (null === $content) {
- // Imprime fecha y hora
- echo date("r");
- 
- // Genera un enlace a la acción de registro
- echo Tag::linkTo(
- [
- "user/signup",
- "Registrar"
- "class" => "signup-button",
- ]
- );
- 
- // Almacena la salida en un archivo de cache
- $cache->save();
- } else {
- // Imprime la salida cacheada
- echo $content;
- }

*```

## Methods

public **__construct** ([*array* $frontendOptions])

Phalcon\Cache\Frontend\Output constructor

public **getLifetime** ()

Returns the cache lifetime

public **isBuffering** ()

Check whether if frontend is buffering output

public **start** ()

Starts output frontend. Currently, does nothing

public *string* **getContent** ()

Returns output cached content

public **stop** ()

Stops output frontend

public **beforeStore** (*mixed* $data)

Serializes data before storing them

public **afterRetrieve** (*mixed* $data)

Unserializes data after retrieval