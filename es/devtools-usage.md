<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Herramientas para desarrolladores de Phalcon</a> <ul>
        <li>
          <a href="#download">Descargar</a>
        </li>
        <li>
          <a href="#installation">Instalación</a>
        </li>
        <li>
          <a href="#available-commands">Comandos disponibles</a>
        </li>
        <li>
          <a href="#project-skeleton">Generar un esqueleto de proyecto</a>
        </li>
        <li>
          <a href="#generating-controllers">Generando controladores</a>
        </li>
        <li>
          <a href="#database-settings">Preparando la configuración de la base de datos</a>
        </li>
        <li>
          <a href="#generating-models">Generando modelos</a>
        </li>
        <li>
          <a href="#crud">Andamiaje CRUD</a>
        </li>
        <li>
          <a href="#web-interface">Interfaz web para herramientas</a>
        </li>
        <li>
          <a href="#phpstorm-ide">Integrando las herramientas en PhpStorm IDE</a>
        </li>
        <li>
          <a href="#conclusion">Conclusión</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Herramientas para desarrolladores de Phalcon

Estas herramientas son una colección de útiles secuencias de comandos para generar el código del esqueleto. Los componentes básicos de su aplicación pueden ser generados con un simple comando, lo que le permite desarrollar fácilmente aplicaciones usando Phalcon.

<h5 class='alert alert-danger'>If you prefer to use the web version instead of the console, this <a href="https://blog.phalconphp.com/post/dont-like-command-line-and-consoles-no-problem">blog post</a> offers more information. </h5>

<a name='download'></a>

## Descargar

Usted puede descargar o clonar el paquete multi plataforma que contiene las Herramientas del Desarrollador desde [Github](https://github.com/phalcon/phalcon-devtools).

<a name='installation'></a>

## Instalación

Estas son las instrucciones detalladas sobre cómo instalar las herramientas de Desarrollador en diferentes plataformas:

[Linux](/[[language]]/[[version]]devtools-installation#installation-linux) : [MacOS](/[[language]]/[[version]]devtools-installation#installation-macos) : [Windows](/[[language]]/[[version]]devtools-installation#installation-windows)

<a name='available-commands'></a>

## Comandos disponibles

Puede obtener una lista de comandos disponibles en herramientas de Phalcon escribiendo: `phalcon commands`

```bash
$ phalcon commands

Phalcon DevTools (3.0.0)

Comandos disponibles:
  commands         (alias de: list, enumerate)
  controller       (alias de: create-controller)
  module           (alias de: create-module)
  model            (alias de: create-model)
  all-models       (alias de: create-all-models)
  project          (alias de: create-project)
  scaffold         (alias de: create-scaffold)
  migration        (alias de: create-migration)
  webtools         (alias de: create-webtools)
```

<a name='project-skeleton'></a>

## Generar un esqueleto de proyecto

Puede utilizar herramientas de Phalcon para generar los esqueletos de proyecto previamente definidos para las aplicaciones con framework Phalcon. Por defecto el generador de esqueleto de proyecto utiliza mod_rewrite para Apache. Escriba el siguiente comando en la raíz del documento web server:

```bash
$ pwd

/Applications/MAMP/htdocs

$ phalcon create-project store
```

La estructura de proyecto recomendada anteriormente fue generada:

![](/images/content/devtools-usage-01.png)

Puede añadir el parámetro `--help` para obtener ayuda sobre el uso de un determinado script:

```bash
$ phalcon project --help

Phalcon DevTools (3.0.0)

Ayuda:
  Crear un proyecto

Uso:
  project [name] [type] [directory] [enable-webtools]

Argumentos:
  help    Muestra este texto de ayuda

Ejemplo
  phalcon project store simple

Opciones:
 --name               Nombre del nuevo proyecto
 --enable-webtools    Determina si las webtools deben estar activas [opcional]
 --directory=s        Directorio donde el proyecto debe ser creado [opcional]
 --type=s             El tipo de aplicación a generar, opciones: cli, micro, simple, modules
 --template-path=s    Especificar la ruta del template [opcional]
 --use-config-ini     Usar un archivo ini como archivo de configuración [opcional]
 --trace              Mostrar las trazas del framework en caso de alguna excepción. [opcional]
 --help               Muestra esta ayuda[optional]
```

Accediendo al proyecto desde el servidor web le mostrará lo siguiente:

![](/images/content/devtools-usage-02.png)

<a name='generating-controllers'></a>

## Generando controladores

El comando `create-controller` genera estructuras de esqueleto de controlador. Es importante invocar este comando dentro de un directorio que cuenta ya con un proyecto Phalcon.

```bash
$ phalcon create-controller --name prueba
```

El siguiente código es generado por la secuencia de comandos:

```php
<?php

use Phalcon\Mvc\Controller;

class PruebaController extends Controller
{
    public function indexAction()
    {

    }
}
```

<a name='database-settings'></a>

## Preparando la configuración de la base de datos

Cuando se genera un proyecto utilizando herramientas de desarrollador. Un archivo de configuración puede encontrarse en `app/config/config.ini`. Para generar modelos o andamios, usted necesitará cambiar la configuración utilizada para conectarse a la base de datos.

Cambiar la sección de base de datos en el archivo config.ini:

```ini
[database]
adapter  = Mysql
host     = "127.0.0.1"
username = "root"
password = "secret"
dbname   = "store_db"

[phalcon]
controllersDir = "../app/controllers/"
modelsDir      = "../app/models/"
viewsDir       = "../app/views/"
baseUri        = "/store/"
```

<a name='generating-models'></a>

## Generando modelos

Hay varias formas de crear modelos. Puede crear todos los modelos de la conexión de base de datos predeterminada o algunos selectivamente. Los modelos pueden tener atributos públicos para las representaciones de los campos o puede ser utilizados setters y getters.

```bash
Opciones:
 --name=s             Nombre de la tabla
 --schema=s           Nombre del esquema. [opcional]
 --namespace=s        Espacio de nombres de los modelos [opcional]
 --get-set            Los atributos deben ser protegidos y tener setters y getters. [opcional]
 --extends=s          Los modelos extienden del nombre de clase dado [opcional]
 --excludefields=l    Excluir campos definidos en la lista separada por comas [opcional]
 --doc                Ayuda a la mejorar el completado de código en IDEs [opcional]
 --directory=s        Directorio base donde se creará el proyecto [opcional]
 --force              Reescribir el modelo. [opcional]
 --trace              Muestra la traza en caso de excepción del framework. [opcional]
 --mapcolumn          Obtener un código para el mapa de columnas. [opcional]
 --abstract           Modelo abstracto [opcional]
```

La forma más sencilla de generar un modelo es:

```bash
$ phalcon model products
```

```bash
$ phalcon model --name nombreDeLaTabla
```

Todos los campos de tabla se declaran públicos para acceso directo.

```php
<?php

use Phalcon\Mvc\Model;

class Products extends Model
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var integer
     */
    public $typesId;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $price;

    /**
     * @var integer
     */
    public $quantity;

    /**
     * @var string
     */
    public $status;
}
```

Mediante la adición del argumento `--get-set` puede generar los campos como variables protegidas y métodos setter/getter públicos. Estos métodos pueden ayudar en la implementación de lógica de negocio dentro de los métodos setter/getter.

```php
<?php

use Phalcon\Mvc\Model;

class Products extends Model
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var integer
     */
    protected $typesId;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $price;

    /**
     * @var integer
     */
    protected $quantity;

    /**
     * @var string
     */
    protected $status;

    /**
     * Este método establece el valor del campo id
     *
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Este método establece el valor del campo typesId
     *
     * @param integer $typesId
     */
    public function setTypesId($typesId)
    {
        $this->typesId = $typesId;
    }

    // ...

    /**
     * Returna el valor del campo status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
}
```

Una buena característica del generador de modelos es que mantiene los cambios realizados por el desarrollador entre las generaciones de código. Esto permite agregar o quitar campos y propiedades, sin el temor de perder los cambios hechos en el modelo. El siguiente video tutorial muestra cómo funciona:

<div align="center">
    <iframe src="https://player.vimeo.com/video/39213020" width="500" height="266" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
</div>

<a name='crud'></a>

## Andamiaje CRUD

El scaffolding o andamiaje es una manera simple de generar algunas de las grandes piezas de una aplicación. Si desea crear los modelos, visas y controladores para un nuevo recurso en una simple operación, el andamiaje es la herramienta para este trabajo.

Una vez que el código está generado, debe modificarse para cumplir con sus necesidades. Muchos desarrolladores evitan el andamiaje por completo, optando por escribir todo o la mayor parte del código fuente desde cero. El código generado puede servir como guía para un mejor entendimiento de como trabaja el framework o los prototipos de desarrollo. El siguiente código muestra el andamiaje basado en la tabla `products`:

```bash
$ phalcon scaffold --table-name products
```

El generador de andamios produce varias archivos en su aplicación, junto con algunas carpetas. Aquí un resumen rápido de lo que se generará:

| Archivo                                  | Propósito                                 |
| ---------------------------------------- | ----------------------------------------- |
| `app/controllers/ProductsController.php` | El controlador de productos               |
| `app/models/Products.php`                | El modelo de productos                    |
| `app/views/layout/products.phtml`        | La plantilla del controlador de productos |
| `app/views/products/new.phtml`           | La vista de la acción `new`               |
| `app/views/products/edit.phtml`          | La vista de la acción `edit`              |
| `app/views/products/search.phtml`        | La vista de la acción `search`            |

Cuando navegamos al controlador recién generado, verá un formulario de búsqueda y un enlace a crear un nuevo producto:

![](/images/content/devtools-usage-03.png)

La `página crear` permite crear productos aplicando los validadores en el modelo Products. Phalcon automáticamente validará los campos no nulos produciendo advertencias si alguno de ellos es obligatorio.

![](/images/content/devtools-usage-04.png)

Después de realizar una búsqueda, el componente de paginado esta disponible para mostrar los resultados en páginas. Utilice los enlaces "Editar" o "Borrar" de cada resultado para realizar dichas acciones.

![](/images/content/devtools-usage-05.png)

<a name='web-interface'></a>

## Interfaz web para herramientas

Además, si Ud. prefiere, es posible usar las Herramientas de Desarrollador de Phalcon desde una interfaz web. Revise el siguiente video tutorial para ver como funciona:

<div align="center">
<iframe src="https://player.vimeo.com/video/42367665" width="500" height="266" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen mark="crwd-mark"></iframe>
</div>

<a name='phpstorm-ide'></a>

## Integrando las herramientas en PhpStorm IDE

El siguiente video tutorial muestra como integrar las herramientas de desarrollo con [PhpStorm IDE](http://www.jetbrains.com/phpstorm/). Los pasos para la configuración pueden ser fácilmente adaptados para cualquier otro IDE para PHP.

<div align="center">
<iframe width="560" height="315" src="https://www.youtube.com/embed/UbUx_6Cs6r4" frameborder="0" allowfullscreen mark="crwd-mark"></iframe>
</div>

<a name='conclusion'></a>

## Conclusión

Las Herramientas del Desarrollador de Phalcon proveen una forma sencilla de generar código para su aplicación, reduciendo tiempo de desarrollo y potenciales errores de codificación.