* * *

layout: article language: 'en' version: '4.0'

* * *

##### This article reflects v3.4 and has not yet been revised

{:.alert .alert-danger}

<a name='overview'></a>

# Formularios

[Phalcon\Forms\Form](api/Phalcon_Forms_Form) is a component that helps with the creation and maintenance of forms in web applications.

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

Forms can be rendered based on the form definition:

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

Each element in the form can be rendered as required by the developer. Internally, [Phalcon\Tag](api/Phalcon_Tag) is used to produce the correct HTML for each element and you can pass additional HTML attributes as the second parameter of `render()`:

```php
<p>
    <label>
        Nombre
    </label>

    <?php echo $form->render('name', ['maxlength' => 30, 'placeholder' => 'Escribe tu nombre']); ?>
</p>
```

HTML attributes also can be set in the element's definition:

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

As seen before, forms can be initialized outside the form class by adding elements to it. You can re-use code or organize your form classes implementing the form in a separated file:

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
                    ],
                    'useEmpty'   => true,
                    'emptyText'  => 'Select one...',
                    'emptyValue' => '',
                ]
            )
        );
    }
}
```

Additionally, the Select elements support the `useEmpty` option to enable the use of a blank element within the list of available options. The options `emptyText` and`emptyValue` are optional, which allow you to customize, respectively, the text and the value of the empty element

[Phalcon\Forms\Form](api/Phalcon_Forms_Form) extends [Phalcon\Di\Injectable](api/Phalcon_Di_Injectable) so you have access to the application services if needed:

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

The associated entity added to the form in the initialization and custom user options are passed to the form constructor:

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

In the form's instantiation you must use:

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

Phalcon forms are integrated with the [validation](/4.0/en/validation) component to offer instant validation. Built-in or custom validators could be set to each element:

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

<h5 class='alert alert-info'>Learn more about filtering in Phalcon by reading the <a href="/4.0/en/filter">Filter documentation</a> </h5>

<a name='entities'></a>

## Formularios y Entidades

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

## Elementos de formulario

Phalcon provides a set of built-in elements to use in your forms, all these elements are located in the [Phalcon\Forms\Element](api/Phalcon_Forms_Element) namespace:

| Nombre                                                                  | Descripción                                  |
| ----------------------------------------------------------------------- | -------------------------------------------- |
| [Phalcon\Forms\Element\Text](api/Phalcon_Forms_Element_Text)         | Genera elementos `INPUT[type=text]`          |
| [Phalcon\Forms\Element\Password](api/Phalcon_Forms_Element_Password) | Genera elementos `INPUT[type=password]`      |
| [Phalcon\Forms\Element\Select](api/Phalcon_Forms_Element_Select)     | Genera elementos `SELECT` basado en opciones |
| [Phalcon\Forms\Element\Check](api/Phalcon_Forms_Element_Check)       | Genera elementos `INPUT[type=check]`         |
| [Phalcon\Forms\Element\TextArea](api/Phalcon_Forms_Element_TextArea) | Genera elementos `TEXTAREA`                  |
| [Phalcon\Forms\Element\Hidden](api/Phalcon_Forms_Element_Hidden)     | Genera elementos `INPUT[type=hidden]`        |
| [Phalcon\Forms\Element\File](api/Phalcon_Forms_Element_File)         | Genera elementos `INPUT[type=file]`          |
| [Phalcon\Forms\Element\Date](api/Phalcon_Forms_Element_Date)         | Genera elementos `INPUT[type=date]`          |
| [Phalcon\Forms\Element\Numeric](api/Phalcon_Forms_Element_Numeric)   | Genera elementos `INPUT[type=number]`        |
| [Phalcon\Forms\Element\Submit](api/Phalcon_Forms_Element_Submit)     | Genera elementos `INPUT[type=submit]`        |
| [Phalcon\Forms\Element\Text](api/Phalcon_Forms_Element_Text)         | Genera elementos `INPUT[type=text]`          |
| [Phalcon\Forms\Element\TextArea](api/Phalcon_Forms_Element_TextArea) | Genera elementos `TEXTAREA`                  |

<a name='event-callback'></a>

## Evento Callbacks

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

## Presentación de formularios

You can render the form with total flexibility, the following example shows how to render each element using a standard procedure:

```php
<form method='post'>
    <?php

        // Recorrer elementos del formulario
        foreach ($form as $element) {
            // Obtener cualquier mensaje generado para el elemento actual
            $messages = $form->getMessagesFor(
                $element->getName()
            );

            if (count($messages)) {
                // Imprimir cada elemento
                echo '<div class="messages">';

                foreach ($messages as $message) {
                    echo $message;
                }

                echo '</div>';
            }

            echo '<p>';

            echo '<label for="', $element->getName(), '">', $element->getLabel(), '</label>';

            echo $element;

            echo '</p>';
        }

    ?>

    <input type='submit' value='Send' />
</form>
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

## Creando elementos de formulario

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

<a name='manager'></a>

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

<a name='external'></a>

## Recursos externos

* [Vökuró](https://vokuro.phalconphp.com), is a sample application that uses the forms builder to create and manage forms, [[Github](https://github.com/phalcon/vokuro)]