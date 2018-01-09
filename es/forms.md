<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Formularios</a>
      <ul>
        <li>
          <a href="#initializing">Inicializando formularios</a>
        </li>
        <li>
          <a href="#validation">Validación</a>
        </li>      
        <li>
          <a href="#filtering">Filtering</a>
        </li>
        <li>
          <a href="#entities">Forms + Entities</a>
        </li>
        <li>
          <a href="#elements">Form Elements</a>
        </li>
        <li>
          <a href="#event-callback">Event Callbacks</a>
        </li>
        <li>
          <a href="#rendering">Rendering Forms</a>
        </li>
        <li>
          <a href="#creating-elements">Creating Form Elements</a>
        </li>
        <li>
          <a href="#forms-manager">Forms Manager</a>
        </li>
        <li>
          <a href="#external-resources">External Resources</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Formularios

`Phalcon\Forms\Form` es un componente que ayuda a la creación y mantenimiento de formularios en aplicaciones web.

En el ejemplo siguiente se muestra su uso básico:

```php
<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Select;

$form = new Form();

$form->add(
    new Text(
        'name'
    )
);

$form->add(
    new Text(
        'telephone'
    )
);

$form->add(
    new Select(
        'telephoneType',
        [
            'H' => 'Hogar',
            'C' => 'Movil',
        ]
    )
);
```

Los formularios se pueden representar en función de la definición del formulario:

```php
<h1>
    Contactos
</h1>

<form method='post'>

    <p>
        <label>
            Nombre
        </label>

        <?php echo $form->render('name'); ?>
    </p>

    <p>
        <label>
            Teléfono
        </label>

        <?php echo $form->render('telephone'); ?>
    </p>

    <p>
        <label>
            Tipo
        </label>

        <?php echo $form->render('telephoneType'); ?>
    </p>

    <p>
        <input type='submit' value='Guardar' />
    </p>

</form>
```

Cada elemento en el formulario se puede representar como sea requerido por el desarrollador. Internamente, se utiliza `Phalcon\Tag` para producir el código HTML correcto de cada elemento y los atributos HTML adicionales se pueden pasar como segundo parámetro del método `render()`:

```php
<p>
    <label>
        Nombre
    </label>

    <?php echo $form->render('name', ['maxlength' => 30, 'placeholder' => 'Escribe tu nombre']); ?>
</p>
```

Los atributos HTML también se pueden definir en la definición del elemento:

```php
<?php

$form->add(
    new Text(
        'name',
        [
            'maxlength'   => 30,
            'placeholder' => 'Escribe tu nombre',
        ]
    )
);
```

<a name='initializing'></a>

## Inicializando formularios

Como hemos visto anteriormente, los formularios se pueden inicializar fuera de la clase formulario agregando elementos en él. Puede reutilizar código u organizar tus formularios en clases e implementar el formulario en un archivo separado:

```php
<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Select;

class ContactForm extends Form
{
    public function initialize()
    {
        $this->add(
            new Text(
                'name'
            )
        );

        $this->add(
            new Text(
                'telephone'
            )
        );

        $this->add(
            new Select(
                'telephoneType',
                TelephoneTypes::find(),
                [
                    'using' => [
                        'id',
                        'name',
                    ]
                ]
            )
        );
    }
}
```

`Phalcon\Forms\Form` extiende de `Phalcon\Di\Injectable` para tener acceso a los servicios de aplicación si es necesario:

```php
<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;

class ContactForm extends Form
{
    /**
     * Este método retorna el valor por defecto del campo 'csrf'
     */
    public function getCsrf()
    {
        return $this->security->getToken();
    }

    public function initialize()
    {
        // Configurar el mismo formulario como entidad
        $this->setEntity($this);

        // Agregamos un elemento de texto para capturar el 'email'
        $this->add(
            new Text(
                'email'
            )
        );

        // Agregamos un elemento oculto para poner el código CSRF
        $this->add(
            new Hidden(
                'csrf'
            )
        );
    }
}
```

La entidad asociada al formulario en la inicialización y las opciones de usuario se pasan al constructor del formulario:

```php
<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;

class UsersForm extends Form
{
    /**
     * Inicializador de formulario
     *
     * @param Users $user
     * @param array $options
     */
    public function initialize(Users $user, array $options)
    {
        if ($options['edit']) {
            $this->add(
                new Hidden(
                    'id'
                )
            );
        } else {
            $this->add(
                new Text(
                    'id'
                )
            );
        }

        $this->add(
            new Text(
                'name'
            )
        );
    }
}
```

En la creación de instancias del formulario debe utilizar:

```php
<?php

$form = new UsersForm(
    new Users(),
    [
        'edit' => true,
    ]
);
```

<a name='validation'></a>

## Validación

Los formularios en Phalcon se integran con el componente de [validación](/[[language]]/[[version]]/validation) para ofrecer una validación instantánea. Los validadores integrados o personalizados se pueden asignar a cada elemento:

```php
<?php

use Phalcon\Forms\Element\Text;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

$name = new Text(
    'name'
);

$name->addValidator(
    new PresenceOf(
        [
            'message' => 'El nombre es obligatorio',
        ]
    )
);

$name->addValidator(
    new StringLength(
        [
            'min'            => 10,
            'messageMinimum' => 'El nombre es demasiado corto',
        ]
    )
);

$form->add($name);
```

Then you can validate the form according to the input entered by the user:

```php
<?php

if (!$form->isValid($_POST)) {
    $messages = $form->getMessages();

    foreach ($messages as $message) {
        echo $message, '<br>';
    }
}
```

Validators are executed in the same order as they were registered.

By default messages generated by all the elements in the form are joined so they can be traversed using a single foreach, you can change this behavior to get the messages separated by the field:

```php
<?php

foreach ($form->getMessages(false) as $attribute => $messages) {
    echo 'Mensajes generados para ', $attribute, ':', "\n";

    foreach ($messages as $message) {
        echo $message, '<br>';
    }
}
```

Or get specific messages for an element:

```php
<?php

$messages = $form->getMessagesFor('name');

foreach ($messages as $message) {
    echo $message, '<br>';
}
```

<a name='filtering'></a>

## Filtering

A form is also able to filter data before it is validated. You can set filters in each element:

```php
<?php

use Phalcon\Forms\Element\Text;

$name = new Text(
    'name'
);

// Configurar múltiples filtros
$name->setFilters(
    [
        'string',
        'trim',
    ]
);

$form->add($name);

$email = new Text(
    'email'
);

// Agregar solo un filtro
$email->setFilters(
    'email'
);

$form->add($email);
```

<div class='alert alert-info'>
    <p>
        Para más información sobre filtrado en Phalcon puede continuar leyendo la <a href="/[[language]]/[[version]]/filter">documentación de filtrado de datos</a>.
    </p>
</div>

<a name='entities'></a>

## Forms + Entities

An entity such as a model/collection/plain instance or just a plain PHP class can be linked to the form in order to set default values in the form's elements or assign the values from the form to the entity easily:

```php
<?php

$robot = Robots::findFirst();

$form = new Form($robot);

$form->add(
    new Text(
        'name'
    )
);

$form->add(
    new Text(
        'year'
    )
);
```

Once the form is rendered if there is no default values assigned to the elements it will use the ones provided by the entity:

```php
<?php echo $form->render('name'); ?>
```

You can validate the form and assign the values from the user input in the following way:

```php
<?php

$form->bind($_POST, $robot);

// Comprobar si el formulario es válido
if ($form->isValid()) {
    // Guardar la entidad
    $robot->save();
}
```

Setting up a plain class as entity also is possible:

```php
<?php

class Preferences
{
    public $timezone = 'Europe/Amsterdam';

    public $receiveEmails = 'No';
}
```

Using this class as entity, allows the form to take the default values from it:

```php
<?php

$form = new Form(
    new Preferences()
);

$form->add(
    new Select(
        'timezone',
        [
            'America/New_York'  => 'New York',
            'Europe/Amsterdam'  => 'Amsterdam',
            'America/Sao_Paulo' => 'Sao Paulo',
            'Asia/Tokyo'        => 'Tokyo',
        ]
    )
);

$form->add(
    new Select(
        'receiveEmails',
        [
            'Yes' => 'Si, por favor!',
            'No'  => 'No, gracias',
        ]
    )
);
```

Entities can implement getters, which have a higher precedence than public properties. These methods give you more freedom to produce values:

```php
<?php

class Preferences
{
    public $timezone;

    public $receiveEmails;

    public function getTimezone()
    {
        return 'Europe/Amsterdam';
    }

    public function getReceiveEmails()
    {
        return 'No';
    }
}
```

<a name='elements'></a>

## Form Elements

Phalcon provides a set of built-in elements to use in your forms, all these elements are located in the `Phalcon\Forms\Element` namespace:

| Nombre                              | Descripción                                  |
| ----------------------------------- | -------------------------------------------- |
| `Phalcon\Forms\Element\Text`     | Genera elementos `INPUT[type=text]`          |
| `Phalcon\Forms\Element\Password` | Genera elementos `INPUT[type=password]`      |
| `Phalcon\Forms\Element\Select`   | Genera elementos `SELECT` basado en opciones |
| `Phalcon\Forms\Element\Check`    | Genera elementos `INPUT[type=check]`         |
| `Phalcon\Forms\Element\TextArea` | Genera elementos `TEXTAREA`                  |
| `Phalcon\Forms\Element\Hidden`   | Genera elementos `INPUT[type=hidden]`        |
| `Phalcon\Forms\Element\File`     | Genera elementos `INPUT[type=file]`          |
| `Phalcon\Forms\Element\Date`     | Genera elementos `INPUT[type=date]`          |
| `Phalcon\Forms\Element\Numeric`  | Genera elementos `INPUT[type=number]`        |
| `Phalcon\Forms\Element\Submit`   | Genera elementos `INPUT[type=submit]`        |

<a name='event-callback'></a>

## Event Callbacks

Whenever forms are implemented as classes, the callbacks: `beforeValidation()` and `afterValidation()` can be implemented in the form's class to perform pre-validations and post-validations:

```php
<?php

use Phalcon\Forms\Form;

class ContactForm extends Form
{
    public function beforeValidation()
    {

    }
}
```

<a name='rendering'></a>

## Rendering Forms

You can render the form with total flexibility, the following example shows how to render each element using a standard procedure:

```php
<br />&lt;form method='post'&gt;
    &lt;?php

        // Recorrer elementos del formulario
        foreach ($form as $element) {
            // Obtener cualquier mensaje generado para el elemento actual
            $messages = $form-&gt;getMessagesFor(
                $element-&gt;getName()
            );

            if (count($messages)) {
                // Imprimir cada elemento
                echo '&lt;div class="messages"&gt;';

                foreach ($messages as $message) {
                    echo $message;
                }

                echo '&lt;/div&gt;';
            }

            echo '&lt;p&gt;';

            echo '&lt;label for="', $element-&gt;getName(), '"&gt;', $element-&gt;getLabel(), '&lt;/label&gt;';

            echo $element;

            echo '&lt;/p&gt;';
        }

    ?&gt;

    &lt;input type='submit' value='Send' /&gt;
&lt;/form&gt;
```

Or reuse the logic in your form class:

```php
<?php

use Phalcon\Forms\Form;

class ContactForm extends Form
{
    public function initialize()
    {
        // ...
    }

    public function renderDecorated($name)
    {
        $element  = $this->get($name);

        // Obtener cualquier mensaje generado por el elemento actual
        $messages = $this->getMessagesFor(
            $element->getName()
        );

        if (count($messages)) {
            // Imprimir cada elemento
            echo "<div class="messages">";

            foreach ($messages as $message) {
                echo $this->flash->error($message);
            }

            echo '</div>';
        }

        echo '<p>';

        echo '<label for="', $element->getName(), '">', $element->getLabel(), '</label>';

        echo $element;

        echo '</p>';
    }
}
```

In the view:

```php
<?php

echo $element->renderDecorated('name');

echo $element->renderDecorated('telephone');
```

<a name='creating-elements'></a>

## Creating Form Elements

In addition to the form elements provided by Phalcon you can create your own custom elements:

```php
<?php

use Phalcon\Forms\Element;

class MyElement extends Element
{
    public function render($attributes = null)
    {
        $html = // ... Producir algún HTML

        return $html;
    }
}
```

<a name='forms-manager'></a>

## Forms Manager

This component provides a forms manager that can be used by the developer to register forms and access them via the service locator:

```php
<?php

use Phalcon\Forms\Manager as FormsManager;

$di['forms'] = function () {
    return new FormsManager();
};
```

Forms are added to the forms manager and referenced by a unique name:

```php
<?php

$this->forms->set(
    'login',
    new LoginForm()
);
```

Using the unique name, forms can be accessed in any part of the application:

```php
<?php

$loginForm = $this->forms->get('login');

echo $loginForm->render();
```

<a name='external-resources'></a>

## External Resources

* [Vökuró](http://vokuro.phalconphp.com), es una aplicación de ejemplo que utiliza el generador de formularios para crear y administrar formularios, [Código fuente en Github](https://github.com/phalcon/vokuro)