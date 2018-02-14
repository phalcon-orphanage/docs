# Clase **Phalcon\\Cache\\Frontend\\Output**

*implementa* [Phalcon\Cache\FrontendInterface](/en/3.2/api/Phalcon_Cache_FrontendInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/cache/frontend/output.zep" class="btn btn-default btn-sm">Código fuente en GitHub</a>

Permite almacenar fragmentos en cache capturados con funciones ob_*

```php <?php</p> 

*

- use Phalcon\Tag;
- use Phalcon\Cache\Backend\File;
- use Phalcon\Cache\Frontend\Output;
- 
- // Crea una salida del frontend. Almacenar los archivos por 2 días
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

## Metodos

public **__construct** ([*array* $frontendOptions])

Constructor de Phalcon\\Cache\\Frontend\\Output

public **getLifetime** ()

Retorna el tiempo de vida del cache

public **isBuffering** ()

Comprueba si el frontend esta almacenando la salida

public **start** ()

Iniciar la salida del frontend. Actualmente no hace nada

public *string* **getContent** ()

Retorna el contenido cacheado de salida

public **stop** ()

Detiene la salida del frontend

public **beforeStore** (*mixed* $data)

Serializa los datos antes de almacenarlos

public **afterRetrieve** (*mixed* $data)

Deserializa los datos después de ser recuperados