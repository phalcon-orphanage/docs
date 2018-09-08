<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Entorno de Consulta</a> 
      <ul>
        <li>
          <a href="#getting-values">Obteniendo Valores</a>
        </li>
        <li>
          <a href="#controller-access">Accediendo a la Consulta desde los Controladores</a>
        </li>
        <li>
          <a href="#uploading-files">Subiendo Archivos</a>
        </li>
        <li>
          <a href="#working-with-headers">Trabajando con Cabeceras</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Entorno de Consulta

Cada petición HTTP (normalmente originada por un navegador) contiene información adicional sobre la petición, tal como datos de cabecera, archivos, variables, etcétera. Una aplicación basada en web necesita analizar esa información para proporcionar la respuesta correcta al solicitante. `Phalcon\Http\Request` encapsula la información de la solicitud, lo que le permite acceder de una manera orientada a objetos.

```php
<?php

use Phalcon\Http\Request;

// Obteniendo una instancia de la consulta
$request = new Request();

// Comprobar que la consulta este hecha por el método POST
if ($request->isPost()) {
    // Comprobar si la consulta esta hecha con Ajax
    if ($request->isAjax()) {
        echo 'La consulta fue hecha utilizando POST y AJAX';
    }
}
```

<a name='getting-values'></a>

## Obteniendo Valores

PHP automáticamente llena los arreglos superglobales `$_GET` y `$_POST` dependiendo del tipo de solicitud. Estos arrays contienen los valores presentes en los formularios o los parámetros enviados por la URL. Las variables en las matrices no son desinfectadas y puede contener caracteres ilegales o incluso códigos malintencionados, que pueden conducir a la [inyección de SQL](http://en.wikipedia.org/wiki/SQL_injection) o ataques de [Cross Site Scripting (XSS)](http://en.wikipedia.org/wiki/Cross-site_scripting).

`Phalcon\Http\Request` le permite acceder a los valores almacenados en `$_REQUEST`, `$_GET` y `$_POST` y desinfectarlos o filtrarlos con el servicio [filter](/[[language]]/[[version]]/filter), (por defecto `Phalcon\Filter`). Los siguientes ejemplos ofrecen el mismo comportamiento:

```php
<?php

use Phalcon\Filter;

$filter = new Filter();

// Filtros aplicados manualmente
$email = $filter->sanitize($_POST['user_email'], 'email');

// Aplicando manualmente el filtro a un valor
$email = $filter->sanitize($request->getPost('user_email'), 'email');

// Aplicar automáticamente el filtro
$email = $request->getPost('user_email', 'email');

// Establecer un valor por defecto si el parámetro es nulo
$email = $request->getPost('user_email', 'email', 'some@example.com');

// Estableciendo un valor por defeccto si el parámetro es nulo sin filtrado
$email = $request->getPost('user_email', null, 'some@example.com');
```

<a name='controller-access'></a>

## Accediendo a la Consulta desde los Controladores

El lugar más común para acceder el ambiente de la petición es en una acción de un controlador. Para tener acceso al objeto `Phalcon\Http\Request` desde un controlador necesita utilizar la propiedad pública `$this->request` del controlador:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {

    }

    public function saveAction()
    {
        // Comprobar si la consulta fue hecha con POST
        if ($this->request->isPost()) {
            // Acceder a los datos POST
            $customerName = $this->request->getPost('name');
            $customerBorn = $this->request->getPost('born');
        }
    }
}
```

<a name='uploading-files'></a>

## Subiendo Archivos

Otra tarea común es la subida de archivos. `Phalcon\Http\Request` ofrece una forma orientada a objetos para realizar esta tarea:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function uploadAction()
    {
        // Comprobar si el usuario ha subido archivos
        if ($this->request->hasFiles()) {
            $files = $this->request->getUploadedFiles();

            // Imprimir el nombre real y el tamaño del archivo
            foreach ($files as $file) {
                // Imprimir detalles del archivo
                echo $file->getName(), ' ', $file->getSize(), '\n';

                // Mover el archivo dentro de la aplicación
                $file->moveTo(
                    'files/' . $file->getName()
                );
            }
        }
    }
}
```

Cada objeto retornado por `Phalcon\Http\Request::getUploadedFiles()` es una instancia de la clase `Phalcon\Http\Request\File`. Utilizar el arreglo superglobal `$_FILES` ofrece el mismo comportamiento. `Phalcon\Http\Request\File` encapsula solo la información relacionada con cada archivo subido en la consulta.

<a name='working-with-headers'></a>

## Trabajando con Cabeceras

Como se mencionó anteriormente, los encabezados de la solicitud contienen información útil que nos permite dar la respuesta adecuada al usuario. Los siguientes ejemplos muestran los usos de esa información:

```php
<?php

// Obtener la cabecera Http-X-Requested-With
$requestedWith = $request->getHeader('HTTP_X_REQUESTED_WITH');

if ($requestedWith === 'XMLHttpRequest') {
    echo 'La consulta fue hecha con Ajax';
}

// Igual que lo anterior
if ($request->isAjax()) {
    echo 'La consulta fue hecha con Ajax';
}

// Comprobar la capa de la consulta
if ($request->isSecure()) {
    echo 'La consulta fue hecha utilizando una capa de seguridad';
}

// Obtener la dirección IP del servidor. Por ejemplo: 192.168.0.100
$ipAddress = $request->getServerAddress();

// Obtener la dirección IP del cliente. Por ejemplo: 201.245.53.51
$ipAddress = $request->getClientAddress();

// Obtener el agente del usuario (HTTP_USER_AGENT)
$userAgent = $request->getUserAgent();

// Obtener el mejor contenido aceptable por el navegador. Por ejemplo: text/xml
$contentType = $request->getAcceptableContent();

// Obtener el mejor conjunto de caracteres aceptados por el navegador. Por ejemplo: utf-8
$charset = $request->getBestCharset();

// Obtener el mejor idioma aceptado configurado por el navegador. Por ejemplo: en-us
$language = $request->getBestLanguage();

// Comprueba si existe una cabecera
if ($request->hasHeader('my-header')) {
    echo "María tenia un corderito";
}
```