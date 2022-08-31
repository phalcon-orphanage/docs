---
layout: default
language: 'es-es'
version: '5.0'
title: 'Formularios'
upgrade: '#forms'
keywords: 'forms, renderizar html, validación, elementos'
---

# Formularios
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Resumen
Phalcon ofrece un componente bajo el espacio de nombres `Phalcon\Forms` que ayuda a los desarrolladores a crear y mantener formularios que se pueden usar para renderizar elementos HTML en pantalla además de realizar validaciones sobre los datos introducidos en esos elementos.

```php
<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Select;

$form = new Form();

$form->add(
    new Text(
        'nameLast'
    )
);

$form->add(
    new Text(
        'nameFirst'
    )
);

$form->add(
    new Select(
        'phoneType',
        [
            1 => 'Home',
            2 => 'Work',
            3 => 'Mobile',
        ]
    )
);
```

En la plantilla:

```php
<h1>
    Contacts
</h1>

<form method='post'>

    <p>
        <label>
            Last Name
        </label>

        <?php echo $form->render('nameLast'); ?>
    </p>

    <p>
        <label>
            First Name
        </label>

        <?php echo $form->render('nameFirst'); ?>
    </p>

    <p>
        <label>
            Gender
        </label>

        <?php echo $form->render('phoneType'); ?>
    </p>

    <p>
        <input type='submit' value='Save' />
    </p>

</form>
```

Cada elemento del formulario puede ser renderizado por el desarrollador como obligatorio. Internally, [Phalcon\Tag](tag) is used to produce the correct HTML for each element, and you can pass additional HTML attributes as the second parameter of `render()`:

```php
<p>
    <label>
        Name
    </label>

    <?php 
        echo $form->render(
            'nameFirst', 
            [
                'maxlength'   => 30, 
                'placeholder' => 'First Name',
            ]
        ); ?>
</p>
```

Los atributos HTML también se pueden definir en la definición del elemento:

```php
<?php

use Phalcon\Forms\Form;

$form = new Form();

$form->add(
    new Text(
        'nameFirst',
        [
            'maxlength'   => 30, 
            'placeholder' => 'First Name',
        ]
    )
);
```

## Métodos
[Phalcon\Forms\Form][forms-form] exposes a number of methods that help with setting up a form with the necessary elements so that it can be used for validation, rendering elements etc.

```php
public function __construct(
    mixed $entity = null, 
    array $userOptions = []
)
```
Constructor. Acepta opcionalmente un objeto `entity` que será leído internamente. Si las propiedades del objeto contienen propiedades que coinciden con los nombres de los elementos definidos en el formulario, esos elementos serán rellenados con los valores de las propiedades correspondientes de la entidad. La entidad puede ser un objeto [Phalcon\Mvc\Model](db-models) o incluso `\stdClass`. El segundo parámetro es `userOptions` un vector opcional con datos definidos por el usuario.

> **NOTE**: If the form has the `initialize` method present, the constructor will call it automatically with the same parameters 
> 
> {: .alert .alert-info }

```php
<?php

use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Form;

$form = new Form(
    null,
    [
        'phoneTypes' => [
            1 => 'Home',
            2 => 'Work',
            3 => 'Mobile',
        ],
    ]
);

$form->add(
    new Text(
        'nameLast'
    )
);

$form->add(
    new Text(
        'nameFirst'
    )
);

$options    = $this->getUserOptions();
$phoneTypes = $options['phoneTypes'] ?? [];
$form->add(
    new Select(
        'phoneType',
        $phoneTypes
    )
);
```

If the `entity` is passed, and it is not an object, a [Phalcon\Forms\Exception][forms-exception] will be thrown.


```php
public function add(
    ElementInterface $element, 
    string $position = null, 
    bool $type = null
): Form
```
Añade un elemento al formulario. El primer parámetro es un objeto `ElementInterface`. El segundo parámetro `position` (si se define) es el nombre del elemento existente al que nos dirigimos. El tercer parámetro booleano `type` es `true` el nuevo elemento será añadido antes del elemento definido en `position`. Si no establece o vale `null`/`false`, el nuevo elemento será añadido después del definido por el parámetro `position`.


```php
public function bind(
    array $data, 
    mixed $entity, 
    array $whitelist = []
): Form
```
Vincula los datos a la entidad. El primer parámetro `data` es un vector de clave/valores. Usualmente es el vector `$_POST`. El segundo parámetro `entity` es un objeto entidad. Si las propiedades del objeto contienen propiedades que coinciden con los nombres de los elementos de `datos` definidos en el formulario, esos elementos serán rellenados con los valores de las propiedades correspondientes de la entidad. La entidad puede ser un objeto [Phalcon\Mvc\Model](db-models) o incluso `\stdClass`. El tercer parámetro `whitelist` es un vector de elementos permitidos. Cualquier elemento del vector `whitelist` que tiene el mismo nombre que un elemento en el vector `data` será ignorado.

El método `bind` coge el primer vector (ej.`$_POST`) y un objeto entidad (ej. `Facturas`). Itera sobre el vector y si encuentra una clave que exista en el formulario, le aplica los filtros necesarios (definidos en el formulario) al valor del vector. Posteriormente, comprueba el objeto entidad (`Facturas`) y le asigna un valor a cualquier propiedad que coincida con la clave del vector. If a method exists as a setter with the same name as an array key, it will be called first (i.e. `name` -> `setName()`).  Este método permite filtrar rápidamente la entrada de datos y asignarlo al objeto entidad indicado.

```php
<?php

$form->bind($_POST, $customer);

if (true === $form->isValid()) {
    $customer->save();
}
```

If there are no elements in the form, a [Phalcon\Forms\Exception][forms-exception] will be thrown.

```php
public function clear(mixed $fields = null): Form
```
Limpia cada elemento del formulario a su valor por defecto. If the passed parameter `fields` is a string, only that field will be cleared. Si se indica un vector, todos los elementos del vector serán limpiados. Finalmente, si no se indica nada, todos los elementos serán limpiados.

```php
public function count(): int
```
Devuelve el número de elementos en la colección

```php
public function current(): ElementInterface | bool
```
Devuelve el elemento actual de la iteración

```php
public function get(string $name): ElementInterface
```
Devuelve un elemento añadido al formulario por su nombre. If the element is not found in the form, a [Phalcon\Forms\Exception][forms-exception] will be thrown.

```php
public function getAction(): string
```
Devuelve la acción del formulario

```php
public function getAttributes(): Attributes
```
Devuelve la colección de atributos del formulario. The object returned is [Phalcon\Html\Attributes][html-attributes].

```php
public function getElements(): ElementInterface[]
```
Devuelve los elementos añadidos al formulario

```php
public function getEntity()
```
Devuelve la entidad relacionada con el modelo


```php
public function getFilteredValue(string $name): mixed | null
```
Gets a value from the internal filtered data or calls getValue(name)

```php
public function getLabel(string $name): string
```
Devuelve una etiqueta para un elemento. If the element is not found in the form, a [Phalcon\Forms\Exception][forms-exception] will be thrown.

```php
public function getMessages(): Messages | array
```
Devuelve los mensajes generados en la validación.

```php
if (false === $form->isValid($_POST)) {
    $messages = $form->getMessages();
    foreach ($messages as $message) {
        echo $message, "<br>";
    }
}
```

```php
public function getMessagesFor(string $name): Messages
```
Devuelve los mensajes generados para un elemento específico

```php
public function getTagFactory(): TagFactory | null
```
Returns the `Phalcon\Html\TagFactory` object

```php
public function getUserOption(
    string option, 
    mixed defaultValue = null
): mixed
```
Devuelve el valor de una opción si está presente. Si la opción no está presente se devolverá `defaultValue`.

```php
public function getUserOptions(): array
```
Devuelve las opciones del elemento

```php
public function getValidation(): ValidationInterface
```
Devuelve el objeto validador registrado en el formulario

```php
public function getValue(string $name): mixed | null
```
Obtiene un valor de la entidad interna relacionada o del valor por defecto

```php
public function has(string $name): bool
```
Comprueba si el formulario contiene un elemento

```php
public function hasMessagesFor(string $name): bool
```
Comprueba si se han generado mensajes para un elemento específico

```php
public function isValid(
    array $data = null, 
    object $entity = null,
    array $whitelist = []
): bool
```
Valida un formulario. El primer elemento son los datos proporcionados por el usuario. Usualmente el vector `$_POST`.

El segundo parámetro opcional es `entity` (objeto). If passed, internally the component will call `bind()` which will:
- Loop through the passed `data`
- Check if the element from the `data` exists (with the same name) in the `entity`
- If yes, check the form's whitelist array. If the element exists there, it will not be changed
- The value of the element (from the `data` array) will be sanitized based on the defined filters (if any)
- Call any setters on the `entity` if present
- Assign the value to the property with the same name on the `entity`.

Una vez que el proceso `bind()` termina, la `entity` modificada se pasará al evento `beforeValidation` (si los eventos están activos) y después de que todos los validadores se hayan llamado en el formulario usando el objeto modificado `entity`.

> **NOTE**: Passing an `entity` object will result in the object being modified by the user input as described above. If you do not wish this behavior, you can clone the entity before passing it, to keep a copy of the original object 
> 
> {: .alert .alert-info }

```php
<?php

use MyApp\Models\Customers;
use Phalcon\Forms\Form;

$customer = Customers::findFirst();
$form = new Form($customer);

if (true === $form->isValid($_POST, $customer)) {
    $customer->save();
}
```

```php
public function key(): int
```
Devuelve la clave/posición actual del iterador

```php
public function label(
    string $name, 
    array $attributes = null
): string
```
Genera la etiqueta de un elemento añadido al formulario incluyendo HTML. El primer parámetro es el nombre del elemento mientras que el segundo es un vector con parámetros opcionales que necesitan ser añadidos a la etiqueta HTML `<label>`. Este parámetro puede ser clases CSS por ejemplo. If the element is not found in the form, a [Phalcon\Forms\Exception][forms-exception] will be thrown.

```php
public function next(): void
```
Mueve el puntero interno de iteración a la siguiente posición

```php
public function render(
    string $name, 
    array $attributes = []
): string
```
Renderiza un objeto específico en el formulario. El parámetro vector opcional `attributes` se puede usar para indicar parámetros adicionales para el elemento que va a ser renderizado. If the element is not found in the form, a [Phalcon\Forms\Exception][forms-exception] will be thrown.

```php
public function remove(string $name): bool
```
Elimina un elemento del formulario

```php
public function rewind(): void
```
Rebobina el iterador interno

```php
public function setAction(string $action): Form
```
Establece la acción del formulario

```php
public function setEntity(object $entity): Form
```
Establece la entidad relacionada con el modelo

```php
public function setAttributes(
    Attributes> $attributes
): AttributesInterface
```
Establece la colección de atributos del formulario

```php
public function setTagFactory(TagFactory $tagFactory): Form
```
Sets the `Phalcon\Html\TagFactory` for the form

```php
public function setValidation(
    ValidationInterface $validation
);
```
Establece el objeto de validación en el formulario.

```php
public function setUserOption(
    string $option, 
    mixed $value
): Form
```
Establece una opción del formulario definida por el usuario

```php
public function setWhitelist(array $whitelist): Form
```
Sets the default whitelist

```php
public function setUserOptions(array $options): Form
```
Establece opciones del formulario definidas por el usuario

```php
public function valid(): bool
```
Devuelve si el elemento actual en el iterador es válido o no

## Inicialización
Los formularios pueden ser inicializados fuera de la clase del formulario añadiéndole elementos. However, you can reuse code or organize your form classes by implementing forms in their own classes:

```php
<?php

use MyApp\Models\PhoneTypes;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;

class CustomersForm extends Form
{
    public function initialize()
    {
        $this->add(
            new Text(
                'nameLast'
            )
        );

        $this->add(
            new Text(
                'nameFirst'
            )
        );

        $this->add(
            new Select(
                'phoneType',
                PhoneTypes::find(),
                [
                    'emptyText'  => 'Select one...',
                    'emptyValue' => '',
                    'useEmpty'   => true,
                    'using'      => [
                        'typ_id',
                        'typ_name',
                    ],
                ]
            )
        );
    }
}
```

También podemos pasar en el constructor un vector de opciones definidas por el usuario, que ofrecerá más funcionalidad.

```php
<?php

use MyApp\Models\Customers;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;

class CustomersForm extends Form
{
    public function initialize(
        Customers $customer,
        array $options
    ) {
        $mode = $options['mode'] ?? 'view';
        if ('edit' === $mode) {
            $this->add(
                new Hidden(
                    'id'
                )
            );
        }

        $this->add(
            new Text(
                'nameLast'
            )
        );

        $this->add(
            new Text(
                'nameFirst'
            )
        );
    }
}
```

El la instanciación del formulario usarás:

```php
<?php

use MyApp\Models\Customers;

$form = new CustomersForm(
    new Customers(),
    [
        'mode' => 'edit',
    ]
);
```
El código anterior comprobará el vector `options` durante el método `initialize`. El código comprobará el elemento `mode` en el vector y si no está presente por defecto será `view`. If the `mode` is `edit`, we are going to add a [Phalcon\Forms\Element\Hidden][forms-element-hidden] element with the entity's ID in the form. Usando el vector `option` podemos crear formularios reutilizables y también pasar datos adicionales en nuestros formularios que pueden ser requeridos.

## Entidades
Una entidad como [Phalcon\Mvc\Model](db-models), una clase PHP o incluso un objeto `\stdClass` se pueden pasar al formulario para establecer los valores por defecto, o para asignar los valores del formulario al objeto.

```php
<?php

use MyApp\Models\Customers;
use Phalcon\Forms\Form;

$customer = Customers::findFirst();
$form = new Form($customer);

$form->add(
    new Text(
        'nameFirst'
    )
);

$form->add(
    new Text(
        'nameLast'
    )
);
```

Una vez que el formulario se ha renderizado, si no hay valores por defecto asignados a los elementos, se usarán los proporcionados por la entidad:

```php
<?php echo $form->render('nameLast'); ?>
```

Puede validar el formulario y asignar a la entidad los valores introducidos por el usuario como sigue:

```php
<?php

use MyApp\Models\Customers;
use Phalcon\Forms\Form;

$customer = Customers::findFirst();
$form = new Form($customer);

$form->bind($_POST, $customer);

if (true === $form->isValid()) {
    $customer->save();
}
```

En el ejemplo anterior, obtenemos el primer registro `Customer`. Pasamos ese objeto a nuestro formulario para rellenarlo con valores iniciales. A continuación llamamos al método `bind` con la entidad y el vector `$_POST`. El formulario automáticamente filtrará la entrada desde `$_POST` y la asignará al objeto entidad (`Customers`). Podemos guardar el objeto si el formulario ha superado la validación.

También podemos usar una clase PHP como entidad:

```php
<?php

class Preferences
{
    public string $timezone = 'Europe/Amsterdam';

    public string $receiveEmails = 'No';
}
```

Usando esta clase como entidad, permite al formulario coger los valores por defecto de ella:

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
            'Yes' => 'Yes, please!',
            'No'  => 'No, thanks',
        ]
    )
);
```

Las entidades pueden implementar `getters`, que son más prioritarios que las propiedades públicas. Estos métodos ofrecen más flexibilidad para generar valores:

```php
<?php

class Preferences
{
    public string $timezone;

    public string $receiveEmails;

    public function getTimezone(): string
    {
        return 'Europe/Amsterdam';
    }

    public function getReceiveEmails(): string
    {
        return 'No';
    }
}
```
Para la clase de la entidad anterior, se usarán los métodos `getReceiveEmails` y `getTimezone` en lugar de las propiedades `receiveEmails` y `timezone`.


## Elementos
Phalcon provee un conjunto de elementos integrados para usar en sus formularios, todos esos elementos se localizan en el espacio de nombres `Phalcon\Forms\Element`:

| Nombre                                                      | Descripción                                   |
| ----------------------------------------------------------- | --------------------------------------------- |
| [Phalcon\Forms\Element\Check][forms-element-check]       | Genera elementos `input[type=check]`          |
| [Phalcon\Forms\Element\Date][forms-element-date]         | Genera elementos `input[type=date]`           |
| [Phalcon\Forms\Element\Email][forms-element-email]       | Genera elementos `input[type=email]`          |
| [Phalcon\Forms\Element\File][forms-element-file]         | Genera elementos `input[type=file]`           |
| [Phalcon\Forms\Element\Hidden][forms-element-hidden]     | Genera elementos `input[type=hidden]`         |
| [Phalcon\Forms\Element\Numeric][forms-element-numeric]   | Genera elementos `input[type=number]`         |
| [Phalcon\Forms\Element\Password][forms-element-password] | Genera elementos `input[type=password]`       |
| [Phalcon\Forms\Element\Radio][forms-element-radio]       | Genera elementos `radio`                      |
| [Phalcon\Forms\Element\Select][forms-element-select]     | Genera elementos `select` basados en opciones |
| [Phalcon\Forms\Element\Submit][forms-element-submit]     | Genera elementos `input[type=submit]`         |
| [Phalcon\Forms\Element\Text][forms-element-text]         | Genera elementos `input[type=text]`           |
| [Phalcon\Forms\Element\TextArea][forms-element-textarea] | Genera elementos `textarea`                   |

These elements use the [Phalcon\Html\TagFactory](tagfactory) component transparently.

> **NOTE**: For more information regarding HTML elements, you can check our [TagFactory document](tagfactory) 
> 
> {: .alert .alert-info }

> **NOTE**: The `Phalcon\Forms\Element\Check` and `Phalcon\Forms\Element\Radio` classes now use the `Phalcon\Html\Helper\Input\Checkbox` and `Phalcon\Html\Helper\Input\Radio` respectively. The classes use `checked` and `unchecked` parameters to set the state of each control. If the `checked` parameter is identical to the `$value` then the control will be checked. If the `unchecked` parameter is present, it will be set if the `$value` is not the same as the `checked` parameter. [more](html-helper) 
> 
> {: .alert .alert-warning }

The [Phalcon\Forms\Element\Select][forms-element-select] supports the `useEmpty` option to enable the use of a blank element within the list of available options. Las opciones `emptyText` y `emptyValue` son opcionales, las cuales le permiten personalizar, respectivamente, el texto y el valor del elemento vacío

You can also create your own elements by extending the [Phalcon\Forms\Element\ElementInterface][forms-element-elementinterface] interface.

```php
<?php

use Phalcon\Forms\Element;

class MyElement extends Element
{
    public function render($attributes = null)
    {
        $html = '';// HTML

        return $html;
    }
}
```

## Filtrando
Un formulario también es capaz de filtrar los datos antes de ser validado. Puede configurar filtros para cada elemento:

```php
<?php

use Phalcon\Filter\Filter;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;

$form = new Form();

$name = new Text('nameLast');
$name->setFilters(
    [
        'string', // Filter::FILTER_STRING
        'trim',   // Filter::FILTER_TRIM
    ]
);
$form->add($name);

$email = new Text('email');
$email->setFilters(
    'email'
);
$form->add($email);
```

> **NOTE**: For more information regarding filters, you can check our [Filter document](filters) 
> 
> {: .alert .alert-info }

## Validación
Phalcon forms are integrated with the [validation](filter-validation) component to offer instant validation. Los validadores integrados o personalizados se pueden configurar para cada elemento:

```php
<?php

use Phalcon\Forms\Element\Text;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

$name = new Text(
    'nameLast'
);

$name->addValidator(
    new PresenceOf(
        [
            'message' => 'The name is required',
        ]
    )
);

$name->addValidator(
    new StringLength(
        [
            'min'            => 10,
            'messageMinimum' => 'The name is too short',
        ]
    )
);

$form->add($name);
```

Entonces puede validar el formulario acorde a los datos introducidos por el usuario:

```php
<?php

if (false === $form->isValid($_POST)) {
    $messages = $form->getMessages();

    foreach ($messages as $message) {
        echo $message, '<br>';
    }
}
```

Los validadores son ejecutados en el mismo orden en el que fueron registrados.

By default, messages generated by all the elements in the form are joined, so they can be traversed using a single `foreach`. También puede obtener mensajes específicos de un elemento:

```php
<?php

$messages = $form->getMessagesFor('nameLast');

foreach ($messages as $message) {
    echo $message, '<br>';
}
```

## Renderizado
Puede renderizar el formulario con total flexibilidad, el siguiente ejemplo muestra como renderizar cada elemento usando un procedimiento estándar:

```php
<form method='post'>
    <?php

        // Traverse the form
        foreach ($form as $element) {
            // Get any generated messages for the current element
            $messages = $form->getMessagesFor(
                $element->getName()
            );

            if (count($messages)) {
                // Print each element
                echo '<div class="messages">';

                foreach ($messages as $message) {
                    echo $message;
                }

                echo '</div>';
            }

            echo '<p>';
            echo '<label for="' . 
                    $element->getName() .
                 '">' .
                 $element->getLabel() .
                 '</label>' 
             ;

            echo $element;
            echo '</p>';
        }
    ?>

    <input type='submit' value='Send' />
</form>
```

O reutilizar la lógica de tu clase formulario:

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
        $messages = $this->getMessagesFor(
            $element->getName()
        );

        if (count($messages)) {
            echo "<div class='messages'>";

            foreach ($messages as $message) {
                echo $this->flash->error($message);
            }

            echo '</div>';
        }

        echo '<p>';
        echo '<label for="' .
                $element->getName() .
             '">' .
             $element->getLabel() .
             '</label>';

        echo $element;
        echo '</p>';
    }
}
```

En la vista:

```php
<?php

echo $element->renderDecorated('nameLast');
echo $element->renderDecorated('nameFirst');
```

## Eventos
Cuando los formularios se implementan como clases, las llamadas de retorno: los métodos `beforeValidation()` y `afterValidation()` se pueden implementar en la clase del formulario para ejecutar pre-validaciones y post-validaciones:

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

## Manager
This component provides the [Phalcon\Forms\Manager][forms-manager] that can be used by the developer to register forms and access them via the service locator:

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Forms\Manager;

$container = new FactoryDefault();
$container->set(
    'forms',
    function () {
        return new Manager();
    }
);
```

Los formularios se añaden al gestor de formularios y se referencian por un nombre único:

```php
<?php

$this
    ->forms
    ->set(
        'login',
        new LoginForm()
    )
;
```

Usando el nombre único, se puede acceder a los formularios desde cualquier parte de la aplicación:

```php
<?php

$loginForm = $this->forms->get('login');

echo $loginForm->render();
```

If a form is not found in the manager, a [Phalcon\Forms\Exception][forms-exception] will be thrown.

## Excepciones
Any exceptions thrown in the `Phalcon\Forms` namespace will be [Phalcon\Forms\Exception][forms-exception]. Puede usar estas excepciones para capturar selectivamente sólo las excepciones lanzadas desde este componente.

```php
<?php

use Phalcon\Forms\Exception;
use Phalcon\Forms\Manager;
use Phalcon\Mvc\Controller;

/**
 * @property Manager $forms
 */
class IndexController extends Controller
{
    public function index()
    {
        try {
            $this->forms->get('unknown-form');
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
```

## Inyección de Dependencias
[Phalcon\Forms\Form][forms-form] extends [Phalcon\Di\Injectable][di-injectable], so you have access to the application services if needed:

```php
<?php

use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;
use Phalcon\Security;

/**
 * @property Security $security
 */
class ContactForm extends Form
{
    public function initialize()
    {
        // Set the same form as entity
        $this->setEntity($this);

        // Add a text element to capture the 'email'
        $this->add(
            new Text(
                'email'
            )
        );

        // Add a text element to put a hidden CSRF
        $this->add(
            new Hidden(
                'csrf'
            )
        );
    }

    public function getCsrf()
    {
        return $this->security->getToken();
    }
}
```

## Recursos Adicionales
* [Vökuró](https://github.com/phalcon/vokuro), es una aplicación de ejemplo que usa el constructor de formularios para crear y gestionar formularios, [[GitHub](https://github.com/phalcon/vokuro)]

[di-injectable]: api/phalcon_di#di-injectable
[forms-element-check]: api/phalcon_forms#forms-element-check
[forms-element-date]: api/phalcon_forms#forms-element-date
[forms-element-elementinterface]: api/phalcon_forms#forms-element-elementinterface
[forms-element-email]: api/phalcon_forms#forms-element-email
[forms-element-file]: api/phalcon_forms#forms-element-file
[forms-element-hidden]: api/phalcon_forms#forms-element-hidden
[forms-element-numeric]: api/phalcon_forms#forms-element-numeric
[forms-element-password]: api/phalcon_forms#forms-element-password
[forms-element-radio]: api/phalcon_forms#forms-element-radio
[forms-element-select]: api/phalcon_forms#forms-element-select
[forms-element-submit]: api/phalcon_forms#forms-element-submit
[forms-element-text]: api/phalcon_forms#forms-element-text
[forms-element-textarea]: api/phalcon_forms#forms-element-textarea
[forms-exception]: api/phalcon_forms#forms-exception
[forms-form]: api/phalcon_forms#forms-form
[forms-manager]: api/phalcon_forms#forms-manager
[html-attributes]: api/phalcon_html#html-attributes
