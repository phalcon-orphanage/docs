---
layout: default
language: 'es-es'
version: '4.0'
title: 'Devtools'
keywords: 'devtools, herramientas de desarrollo, modelos, controladores'
---

# Devtools de Phalcon

* * *

![](/assets/images/document-status-under-review-red.svg)

## Resumen

Estas herramientas le ayudarán a generar código esqueleto, a mantener su estructura de base de datos y a acelerar el desarrollo. Los componentes principales de su aplicación se pueden generar con un comando simple, permitiéndole desarrollar aplicaciones fácilmente usando Phalcon.

Las *Devtool* de Phalcon se pueden controlar usando la línea de comandos o el interfaz web.

## Instalación

Se pueden instalar las *Devtools* de Phalcon usando <composer>. Primero asegúrese de que las ha instalado.

Instalar las *Devtools* de Phalcon globalmente

```bash
composer global require phalcon/devtools
```

O sólo en su proyecto

```bash
composer require phalcon/devtools
```

Compruebe su instalación escribiendo: `phalcon`

```bash
$ phalcon

Phalcon DevTools (4.0.0)

Available commands:
  info             (alias of: i)
  commands         (alias of: list, enumerate)
  controller       (alias of: create-controller)
  module           (alias of: create-module)
  model            (alias of: create-model)
  all-models       (alias of: create-all-models)
  project          (alias of: create-project)
  scaffold         (alias of: create-scaffold)
  migration        (alias of: create-migration)
  webtools         (alias of: create-webtools)
  serve            (alias of: server)
  console          (alias of: shell, psysh)
```

Las *devtools* también están disponibles como descarga *phar* en nuestro [repositorio](github_devtools) git.

## Uso

### Comandos Disponibles

Puede obtener un listado de los comandos disponibles en las herramientas Phalcon escribiendo: `phalcon commands`

```bash
$ phalcon commands

Phalcon DevTools (4.0.0)

Available commands:
  info             (alias of: i)
  commands         (alias of: list, enumerate)
  controller       (alias of: create-controller)
  module           (alias of: create-module)
  model            (alias of: create-model)
  all-models       (alias of: create-all-models)
  project          (alias of: create-project)
  scaffold         (alias of: create-scaffold)
  migration        (alias of: create-migration)
  webtools         (alias of: create-webtools)
  serve            (alias of: server)
  console          (alias of: shell, psysh)
```

### Generando un Esqueleto de Proyecto

Puede usar las herramientas de Phalcon para generar esqueletos de proyecto predefinidos para sus aplicaciones con el *framework* Phalcon. Por defecto el generador de esqueletos de proyecto usarán mod_rewrite de Apache. Escriba el siguiente comando en el *document root* de su servidor web:

```bash
$ phalcon create-project store
```

Se generó la estructura de proyecto recomendada anterior:

![](/assets/images/content/v4/devtools-store-dirstructure.png)

Podría añadir el parámetro `--help` para obtener ayuda sobre el uso de un comando específico:

```bash
$ phalcon project --help

Phalcon DevTools (4.0.0)

Help:
  Creates a project

Usage:
  project [name] [type] [directory] [enable-webtools]

Arguments:
  help  Shows this help text

Example
  phalcon project store simple

Options:
 --name=s               Name of the new project
 --enable-webtools      Determines if webtools should be enabled [optional]
 --directory=s          Base path on which project will be created [optional]
 --type=s               Type of the application to be generated (cli, micro, simple, modules)
 --template-path=s      Specify a template path [optional]
 --template-engine=s    Define the template engine, default phtml (phtml, volt) [optional]
 --use-config-ini       Use a ini file as configuration file [optional]
 --trace                Shows the trace of the framework in case of exception [optional]
 --help                 Shows this help [optional]
```

Acceder al proyecto desde el servidor web le mostrará:

![](/assets/images/content/v4/devtools-store-localhost.png)

### Generación de Controladores

El comando `create-controller` genera estructuras esqueleto de controlador. Es importante invocar este comando dentro de un directorio que ya tenga un proyecto Phalcon.

```bash
$ phalcon create-controller --name test
```

Se genera el siguiente código por el *script*:

```php
<?php
declare(strict_types=1);

class TestController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {

    }

}

```

### Preparación de Ajustes de Base de Datos

Cuando se genera un proyecto usando las herramientas de desarrollo. Se puede encontrar un fichero de configuración en `app/config/config.php`. Para generar modelos o andamios, necesitará cambiar los ajustes usados para conectar con su base de datos.

Cambie la sección de base de datos de su fichero config.php:

```php
<?php

/*
 * Modified: prepend directory path of current file, because of this file own different ENV under between Apache and command line.
 * NOTE: please remove this comment.
 */
defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');

return new \Phalcon\Config([
    'database' => [
        'adapter'     => 'Mysql',
        'host'        => 'localhost',
        'username'    => 'root',
        'password'    => '',
        'dbname'      => 'test',
        'charset'     => 'utf8',
    ],
    'application' => [
        'appDir'         => APP_PATH . '/',
        'controllersDir' => APP_PATH . '/controllers/',
        'modelsDir'      => APP_PATH . '/models/',
        'migrationsDir'  => APP_PATH . '/migrations/',
        'viewsDir'       => APP_PATH . '/views/',
        'pluginsDir'     => APP_PATH . '/plugins/',
        'libraryDir'     => APP_PATH . '/library/',
        'cacheDir'       => BASE_PATH . '/cache/',
        'baseUri'        => '/',
    ]
]);
```

### Generación de Modelos

Hay varias maneras de crear modelos. Puede crear todos los modelos de la conexión de base de datos por defecto o algunos específicamente. Los modelos pueden tener atributos públicos como representación de los campos o se pueden usar *setters*/*getters*.

```bash
Opciones:
 --name=s             Nombre de la tabla
 --schema=s           Nombre del esquema [optional]
 --config=s           Fichero de configuración [optional]
 --namespace=s        Espacio de nombres del modelo [optional]
 --get-set            Los atributos serán <em>protected</em> y tendrán <em>setters</em>/<em>getters</em> [optional]
 --extends=s          El modelo extenderá el nombre de clase proporcionado [optional]
 --excludefields=l    Excluye los campos definidos en una lista separada por comas [optional]
 --doc                Ayuda a mejorar el completado de código en IDEs [optional]
 --directory=s        Ruta base en la que el proyecto se aloja [optional]
 --output=s           Carpeta donde residen los modelos [optional]
 --force              Reescribir el modelo [optional]
 --camelize           Las propiedades están en camelCase [optional]
 --trace              Muestra la traza del framework en caso de excepción [optional]
 --mapcolumn          Obtiene algo de código para el mapeado de columnas [optional]
 --abstract           Modelo <em>Abstract</em> [optional]
 --annotate           Anotaciones de Atributos [optional]
 --help               Muestra esta ayuda [optional]
```

La manera más simple de generar un modelo para una tabla llamada *users* es:

```bash
$ phalcon model users
```

Si su base de datos se ve así:

```sql
CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` char(60) NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`);

ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;
```

Resultará en

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\Email as EmailValidator;

class Users extends \Phalcon\Mvc\Model
{

    /**
     *

     * @var integer
     */
    public $id;

    /**
     *

     * @var string
     */
    public $name;

    /**
     *

     * @var string
     */
    public $email;

    /**
     *

     * @var string
     */
    public $password;

    /**
     *

     * @var string
     */
    public $active;

    /**
     * Validations and business logic
     *
     * @return boolean
     */
    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            'email',
            new EmailValidator(
                [
                    'model'   => $this,
                    'message' => 'Please enter a correct email address',
                ]
            )
        );

        return $this->validate($validator);
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("test");
        $this->setSource("users");
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Users[]|Users|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Users|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
```

Opciones para generar diferentes tipos de formatos de modelo se pueden encontrar usando

```bash
phalcon model --help
```

### Andamiaje CRUD

El *scaffolding* o andamiaje es una forma rápida de generar algunas de las piezas principales de una aplicación. Si quiere crear modelos, vistas y controladores para un nuevo recurso en una sola operación, el andamiaje es la herramienta para este trabajo.

Una vez se genera el código, debe adaptarlo para cumplir con sus necesidades. Muchos desarrolladores evitan completamente el andamiaje, optando por escribir todo o la mayoría de su código fuente desde cero. El código generado puede servir como guía para comprender mejor cómo trabaja el framework o los prototipos de desarrollo. El siguiente código muestra un andamio basado en la tabla `users`:

```bash
$ phalcon scaffold --table-name users
```

El generador del andamio construirá varios ficheros en su aplicación, además de algunas carpetas. Aquí hay un resumen breve de lo que se generará:

| Archivo                               | Propósito                           |
| ------------------------------------- | ----------------------------------- |
| `app/controllers/UsersController.php` | El controlador de Usuarios          |
| `app/models/Users.php`                | El modelo de Usuarios               |
| `app/views/layout/users.phtml`        | Disposición de la vista de Usuarios |
| `app/views/products/search.phtml`     | Vista para la acción `search`       |
| `app/views/products/new.phtml`        | Vista para la acción `new`          |
| `app/views/products/edit.phtml`       | View for the action `edit`          |

Si navega por el controlador recién generado, verá un formulario de búsqueda y un link para crear un nuevo Usuario:

![](/assets/images/content/devtools-usage-03.png)

El `create page` le permite crear usuarios aplicando validaciones sobre el modelo Usuarios. Phalcon automáticamente validará campos no nulos produciendo avisos si se requiere.

![](/assets/images/content/devtools-usage-04.png)

Después de realizar una búsqueda, hay un componente de paginado disponible para mostrar los resultados paginados. Use los enlaces "Edit" (Editar) or "Delete" (Borrar) delante de cada resultado para ejecutar esas acciones.

![](/assets/images/content/devtools-usage-05.png)

### Interfaz Web a las Herramientas

También, si lo prefiere, es posible usar las Herramientas de Desarrollo de Phalcon desde un interfaz web. Eche un vistazo al siguiente videotutorial para descubrir como funciona:

<div align="center">
<iframe src="https://player.vimeo.com/video/42367665" width="500" height="266" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
</div>

### Integrar Herramientas en IDE PhpStorm

El siguiente videotutorial muestra como integrar las herramientas de desarrollo con el [IDE PhpStorm](https://www.jetbrains.com/phpstorm/). Los pasos de configuración podrían adaptarse fácilmente a otros IDEs para PHP.

<div align="center">
<iframe width="560" height="315" src="https://www.youtube.com/embed/UbUx_6Cs6r4" frameborder="0" allowfullscreen></iframe>
</div>
