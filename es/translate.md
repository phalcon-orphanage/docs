<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Soporte Multi Idioma</a> 
      <ul>
        <li>
          <a href="#adapters">Adaptadores</a>
        </li>
        <li>
          <a href="#usage">Uso del componente</a>
        </li>
        <li>
          <a href="#custom">Implementar tus propios adaptadores</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Soporte Multi Idioma

El componente `Phalcon\Translate` ayuda en la creación de aplicaciones multilingües. Aplicaciones que utilizan este componente, pueden mostrar el contenido en diferentes idiomas, basados en el idioma elegido por el usuario y soportado por la aplicación.

<a name='adapters'></a>

## Adaptadores

Este componente hace uso de adaptadores para leer los mensajes de traducción de diferentes fuentes en forma unificada.

| Adaptador                                  | Descripción                                                                                         |
| ------------------------------------------ | --------------------------------------------------------------------------------------------------- |
| `Phalcon\Translate\Adapter\NativeArray` | Utiliza arrays PHP para almacenar los mensajes. Esta es la mejor opción en términos de rendimiento. |

<a name='adapters-factory'></a>

### Factory

Carga una adaptador de traducción utilizando la opción `adapter`

```php
<?php

use Phalcon\Translate\Factory;

$options = [
    'locale'        => 'de_DE.UTF-8',
    'defaultDomain' => 'translations',
    'directory'     => '/path/to/application/locales',
    'category'      => LC_MESSAGES,
    'adapter'       => 'gettext',
];

$translate = Factory::load($options);
```

<a name='usage'></a>

## Uso del componente

Las cadenas de traducción se almacenan en archivos. La estructura de estos archivos puede variar dependiendo del adaptador utilizado. Phalcon te da la libertad para organizar tus cadenas de traducción. Una estructura simple podría ser:

```bash
app/messages/en.php
app/messages/es.php
app/messages/fr.php
app/messages/zh.php
```

Cada archivo contiene un arreglo de las traducciones en forma de clave/ valor. Para cada archivo de traducción, las llaves son únicas. El mismo arreglo se utiliza en archivos diferentes, donde las claves siguen siendo los mismos y valores contienen las cadenas traducidas dependiendo de cada idioma.

```php
<?php

// app/messages/en.php
$messages = [
    'hi'      => 'Hello',
    'bye'     => 'Good Bye',
    'hi-name' => 'Hello %name%',
    'song'    => 'This song is %song%',
];
```

```php
<?php

// app/messages/fr.php
$messages = [
    'hi'      => 'Bonjour',
    'bye'     => 'Au revoir',
    'hi-name' => 'Bonjour %name%',
    'song'    => 'La chanson est %song%',
];
```

Implementar el mecanismo de traducción en tu aplicación es trivial pero depende de cómo desees aplicarlo. Puedes utilizar la detección automática de idioma desde el navegador del usuario o puede proporcionar una página de configuración donde el usuario puede seleccionar su idioma.

Una forma sencilla de detectar el idioma del usuario es analizando el contenido de `$_SERVER['HTTP_ACCEPT_LANGUAGE']`, o si lo deseas, acceder a él directamente llamando al método `$this->request->getBestLanguage()` de una accion/controlador:

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Translate\Adapter\NativeArray;

class UserController extends Controller
{
    protected function getTranslation()
    {
        // Consultar al navegador cual es el mejor idioma
        $language = $this->request->getBestLanguage();
        $messages = [];

        $translationFile = 'app/messages/' . $language . '.php';

        // Verificar si tenemos un archivo de traducción para este idioma
        if (file_exists($translationFile)) {
            require $translationFile;
        } else {
            // Regresar valores por defecto
            require 'app/messages/en.php';
        }

        // Devolver un objeto de traducción $messages que viene del
        // requerimiento anterior
        return new NativeArray(
            [
                'content' => $messages,
            ]
        );
    }

    public function indexAction()
    {
        $this->view->name = 'Mike';
        $this->view->t    = $this->getTranslation();
    }
}
```

El método `_getTranslation()` está disponible para todas las acciones que requieran traducciones. La variable `$t` se pasa a las vistas, y con ella, podemos traducir cadenas en esa capa:

```php
<!-- welcome -->
<!-- String: hi => 'Hello' -->
<p><?php echo $t->_('hi'), ' ', $name; ?></p>
```

El método `_()` devuelve la cadena traducida basada en el índice pasado. Algunas cadenas necesitan incorporar marcadores de posición para datos calculados, por ejemplo: `Hola %name%`. Estos marcadores de posición pueden reemplazarse con parámetros pasados al método `_()`. Los parámetros pasados son en forma de un arreglo organizado mediante clave/valor, donde la clave coincide con el nombre de marcador de posición y el valor son los datos reales para ser sustituidos:

```php
<!-- welcome -->
<!-- String: hi-name => 'Hello %name%' -->
<p><?php echo $t->_('hi-name', ['name' => $name]); ?></p>
```

Algunas aplicaciones aplicación el soporte multilingüe en la URL como `http://www.mozilla.org/**es-ES**/firefox/`. Phalcon puede implementar esto mediante un [Router](/[[language]]/[[version]]/routing).

La implementación anterior es útil pero requiere un controlador base para implementar `_getTranslation()` y devolver el componente `Phalcon\Translate\Adapter\NativeArray`. Además el componente necesita ser agregado a la vista como se ve arriba, en la variable `$t`.

Siempre puede envolver esta funcionalidad en su propia clase y registrar esa clase en el contenedor de DI:

```php
<?php

use Phalcon\Mvc\User\Component;
use Phalcon\Translate\Adapter\NativeArray;

class Locale extends Component
{
    public function getTranslator()
    {
        // Consultar al navegador por el mejor idioma
        $language = $this->request->getBestLanguage();

        /**
         * Utilizamos archivos JSON para almacenar las traducciones. 
         * Usted tendrá que comprobar si existe el archivo! 
         */
        $translations = json_decode(
            file_get_contents('app/messages/' . $language . '.json'),
            true
        );

        // Regresamos el objecto $messages requerido en la declaración anterior
        return new NativeArray(
            [
                'content' => $translations,
            ]
        );
    }
}
```

De esta manera puede utilizar el componente en los controladores:

```php
<?php

use Phalcon\Mvc\Controller;

class MyController extends Controller
{
    public function indexAction()
    {
        $name = 'Mike';
        $text = $this->locale->_('hi-name', ['name' => $name]);

        $this->view->text = $text;
    }
}
```

o en una vista directamente

```php
<?php echo $locale->_('hi-name', ['name' => 'Mike']);
```

<a name='custom'></a>

## Implementar tus propios adaptadores

Debes implementar la interfaz `Phalcon\Translate\AdapterInterface` para crear tus propios adaptadores de traducciones o ampliar los que ya existen:

```php
<?php

use Phalcon\Translate\AdapterInterface;

class MyTranslateAdapter implements AdapterInterface
{
    /**
     * Constructor del adaptador
     *
     * @param array $options
     */
    public function __construct(array $options);

    /**
     * @param  string     $translateKey
     * @param  array|null $placeholders
     * @return string
     */
    public function t($translateKey, $placeholders = null);

    /**
     * Retorna el string de traducción para la clave dada
     *
     * @param   string $translateKey
     * @param   array $placeholders
     * @return  string
     */
    public function _(string $translateKey, $placeholders = null): string;

    /**
     * Retorna la traducción relacionada para la clave dada
     *
     * @param   string $index
     * @param   array $placeholders
     * @return  string
     */
    public function query(string $index, $placeholders = null): string;

    /**
     * Comprueba que este definida la clave de traducción en el array interno
     *
     * @param   string $index
     * @return  bool
     */
    public function exists(string $index): bool;
}
```

Hay disponibles mas adaptadores para estos componentes en la [Incubadora de Phalcon](https://github.com/phalcon/incubator/tree/master/Library/Phalcon/Translate/Adapter)