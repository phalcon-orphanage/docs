Tutorial 2: Introducing INVO
============================
En este segundo tutorial, explicaremos una aplicación más completa con el objetivo de profundizar en el desarrollo
con Phalcon.

INVO es una de las aplicaciones que hemos creado como ejemplo. INVO es un pequeño sitio web que permite a sus clientes
generar facturas, además de otras tareas como administrar clientes y productos. Puedes clonar su código fuente de Github_.

Adicionalmente, INVO fue creada con `Twitter Bootstrap`_ como framework en el cliente. A pesar que la aplicación
no genera facturas sirve como ejemplo para entender muchos aspectos y funcionalidades en el framework.

Estructura del Proyecto
-----------------------
Una vez clones el proyecto en tu raíz de directorios verás la siguiente estructura:

.. code-block:: bash

    invo/
        app/
            app/config/
            app/controllers/
            app/library/
            app/models/
            app/plugins/
            app/views/
        public/
            public/bootstrap/
            public/css/
            public/js/
        schemas/

Como sabes, Phalcon no te impone una estructura de directorios en particular. Este proyecto tiene una
estructura de directorios para un MVC sencillo y una raíz pública de documentos.

Una vez abres la aplicación en tu navegador: http://localhost/invo verás algo como:

.. figure:: ../_static/img/invo-1.png
   :align: center

La aplicación está dividida en dos partes, un frontend, que es la parte pública donde los visitante pueden recivir
información además de solicitar información de contácto.

La segunda parte es el backend, un área administrativa donde un usuario registrado puede administrar
sus productos y clientes.

Enrutamiento
------------
INVO usa la forma estándar de enrutar que viene con el componente de enrutamiento. Estas rutas
usán el patrón que viene con el componente Router. El patrón es: /:controller/:action/:params.
Esto significa que la primera parte de la URI es el controlador, la segunda la acción y el resto
son los parámetros.

La ruta /session/register ejecuta el controlador "SessionController" y su acción "registerAction".

Configuración
-------------
INVO tiene un archivo de configuración que establece parametros generales en la aplicación.
Este archivo es leído en las primeras líneas del bootstrap (public/index.php):

.. code-block:: php

    <?php

    // Leer la configuración
    $config = new Phalcon\Config\Adapter\Ini('../app/config/config.ini');

:doc:`Phalcon\\Config <config>` nos permite manipular el archivo usando programación orientada a objetos.
El archivo de configuración contiene la siguiente configuración.

.. code-block:: ini

    [database]
    host     = localhost
    username = root
    password = secret
    name     = invo

    [application]
    controllersDir = /../app/controllers/
    modelsDir      = /../app/models/
    viewsDir       = /../app/views/
    pluginsDir     = /../app/plugins/
    libraryDir     = /../app/library/
    baseUri        = /invo/

    ;[metadata]
    ;adapter = "Apc"
    ;suffix = my-suffix
    ;lifetime = 3600

Phalcon no tiene convenciones de configuración predeterminadas. Las secciones en el archivo nos ayudan a organizar la configuración
de manera apropiada. En este archivo hay trés secciones que se usarán luego.

Autocargadores
-----------
Una segunda parte que aparece en el bootstrap (public/index.php) es el autocargador (autoloader). Este registra un conjunto
de directorios que la aplicación utilizará para cargar las clases que eventualmente necesitará.

.. code-block:: php

    <?php

    $loader = new \Phalcon\Loader();

    $loader->registerDirs(
        array(
            $config->application->controllersDir,
            $config->application->pluginsDir,
            $config->application->libraryDir,
            $config->application->modelsDir,
        )
    )->register();

Lo que se ha hecho es registrar los directorios que están definidos en el archivo de configuración. El único
directorio que no está registrado es el viewsDir', porque estas no contienen clases sino HTML y PHP.

Atendiendo la petición
----------------------
Vallamos mucho más adelante, al final del archivo, la petición es finalmente atendida por Phalcon\\Mvc\\Application,
esta clase inicializa y ejecuta todo lo necesario para que la aplicación sea ejecutada:

.. code-block:: php

    <?php

    $app = new \Phalcon\Mvc\Application($di);

    echo $app->handle()->getContent();

Inyección de Dependencias
-------------------------
En el código anterior, la variable $di es pasada al constructor de Phalcon\\Mvc\\Application.
¿Cuál es el proposito de esta variable? Como Phalcon es un framework altamente desacoplado, necesitamos un componente
que actúe como intermediario entre los distintos componentes para hacer que todo trabaje junto de una manera sencilla.
Este componente es Phalcon\\DI. Es un contenedor de servicios que también permite injeccción de dependencias,
instanciando e inicializando todos los componentes a medida que son requeridos por la aplicación.

Hay muchas formas de registrar servicios en el contenedor. En INVO, la mayoría de servicios han sido registrados
usando funciones anonimas. Gracias a esto, Los objetos son instanciados solo cuando son requeridos, reduciendo
la cantidad de recursos requeridos por la aplicación.

Por ejemplo, en el siguiente codigo, el servicio de sesión es registrado, la función anónima solo es ejecutada
si la aplicación requiere acceder a datos de sessión:

.. code-block:: php

    <?php

    // Iniciar la sesión solamente la primera vez que un componente requiera el servicio de sesión
    $di->set('session', function () {
        $session = new Phalcon\Session\Adapter\Files();
        $session->start();
        return $session;
    });

Gracias a esto, tenemos la libertad de cambiar el adaptador, ejecutar inicializaciones adicionales y mucho más.
Ten en cuenta que el servicio se registró usando el nombre "session". Esta es una convención que ayudará a los demás
componentes a solicitar el servicio correcto en el contenedor de servicios.

Una petición puede usar muchos servicios, registrar cada servicio puede ser tedioso. Por esta razón,
el framework proporciona una variante Phalcon\\DI llamada Phalcon\\DI\\FactoryDefault cuyo objetivo es registrar
todos los servicios proporcionados por un framework full-stack.

.. code-block:: php

    <?php

    // El FactoryDefault Dependency Injector registra automáticamente
    // todos los servicios proporcionando un framework full stack
    $di = new \Phalcon\DI\FactoryDefault();

Así se registran la mayoria de servicios con componentes proporcionados por el framework como estándar. Si queremos
reemplazar la definición de un servicio podemos hacerla como hicimos antes con el servicio "session". Esta es la razón
de la existencia de la variable $di.

In next chapter, we will see how to authentication and authorization is implemented in INVO.

.. _Github: https://github.com/phalcon/invo
.. _Twitter Bootstrap: http://bootstrap.github.com/
