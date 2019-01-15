* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

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

Cada elemento en el formulario se puede representar como sea requerido por el desarrollador. Internally, [Phalcon\Tag](api/Phalcon_Tag) is used to produce the correct HTML for each element and you can pass additional HTML attributes as the second parameter of `render()`:

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

Ademas, los elementos Select soportan la opción `useEmpty` para habilitar el uso de un elemento en blanco en la lista de opciones disponibles. Las opciones `emptyText` y `emptyValue` son opcionales, pero le permiten personalizar el texto y el valor del elemento en blanco, respectivamente.

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

Entonces usted puede validar el formulario según la entrada introducida por el usuario:

```php
<?php

if (!$form->isValid($_POST)) {
    $messages = $form->getMessages();

    foreach ($messages as $message) {
        echo $message, '<br>';
    }
}
```

Los validadores se ejecutan en el mismo orden como fueron registrados.

Por defecto, los mensajes generados por todos que los elementos del formulario se unen, por lo que pueden ser recorridos usando un simple `foreach`, además, si desea obtener los mensajes separados por campo deberá pasar el valor `false` en el método `getMessages()`:

```php
<?php

foreach ($form->getMessages(false) as $attribute => $messages) {
    echo 'Mensajes generados para ', $attribute, ':', "\n";

    foreach ($messages as $message) {
        echo $message, '<br>';
    }
}
```

U obtener los mensajes específicos de un elemento:

```php
<?php

$messages = $form->getMessagesFor('name');

foreach ($messages as $message) {
    echo $message, '<br>';
}
```

<a name='filtering'></a>

## Filtering

Un formulario también es capaz de filtrar los datos antes de validarlos. Puede definir los filtros en cada elemento:

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

Una entidad como una instancia de un modelo, una colección, una instancia plana o una simple clase de PHP puede ser vinculada al formulario con el fin de establecer valores predeterminados en los elementos del formulario o asignar fácilmente los valores del formulario a la entidad:

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

Una vez que el formulario es representado, si no hay ningún valor por defecto asignado a los elementos, se usarán los provistos por la entidad:

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

Asignar una clase simple como entidad, también es posible:

```php
<?php

class Preferences
{
    public $timezone = 'Europe/Amsterdam';

    public $receiveEmails = 'No';
}
```

Al utilizar esta clase como entidad, permite al formulario tomar los valores por defecto de ella:

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

Las entidades pueden implementar getters, que tienen una precedencia mayor que propiedades públicas. Estos métodos dan más libertad para producir valores:

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

Cuando se implementan formularios como clases, las devoluciones de llamadas: `beforeValidation()` y `afterValidation()` se pueden implementar en la clase del formulario para realizar validaciones previas y posteriores:

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

Puede representar formularios con total flexibilidad, en el ejemplo siguiente se muestra cómo representar cada elemento mediante un procedimiento estándar:

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

O reutilizar la lógica en la clase del formulario:

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

En la vista:

```php
<?php

echo $element->renderDecorated('name');

echo $element->renderDecorated('telephone');
```

<a name='creating-elements'></a>

## Creando elementos de formulario

Además de los elementos del formulario proporcionados por Phalcon, usted puede crear sus propios elementos personalizados:

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

Este componente proporciona un gestor de formularios que puede utilizar el desarrollador para registrar formularios y acceder a ellos mediante el localizador de servicios:

```php
<?php

use Phalcon\Forms\Manager as FormsManager;

$di['forms'] = function () {
    return new FormsManager();
};
```

Los formularios se agregan al administrador de formularios y es referenciado por un nombre único:

```php
<?php

$this->forms->set(
    'login',
    new LoginForm()
);
```

Usando el nombre único, los formularios pueden consultarse en cualquier parte de la aplicación:

```php
<?php

$loginForm = $this->forms->get('login');

echo $loginForm->render();
```

<a name='external'></a>

## Recursos externos

* [Vökuró](https://vokuro.phalconphp.com), is a sample application that uses the forms builder to create and manage forms, [[Github](https://github.com/phalcon/vokuro)]