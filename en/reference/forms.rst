Forms
-----
Phalcon\Forms is a component aids the developer in the creation and maintenance of forms in web applications.

The following example shows its basic usage:

.. code-block:: php

	use Phalcon\Forms\Form,
		Phalcon\Forms\Element\Text;

	$form = new Form();

	$form->add(new Text("name"));

	$form->add(new Text("telephone"));

	$form->add(new Select("telephoneType", array(
		'H' => 'Home',
		'C' => 'Cell'
	)));

Forms can be rendered based on the form definition:

.. code-block:: html+php

	<h1>Contacts</h1>

	<form method="post">

		<p>
			<label>Name</label>
			<?php echo $form->render("name") ?>
		</p>

		<p>
			<label>Telephone</label>
			<?php echo $form->render("name") ?>
		</p>

		<p>
			<label>Type</label>
			<?php echo $form->render("telephoneType") ?>
		</p>

		<p>
			<input type="submit" value="Save" />
		</p>

	</form>

Each element in the form can be rendered as required by the developer. Internally,
:doc:`Phalcon\\Tag <../api/Phalcon_Tag>` is used to produce the right HTML for each element,
you can pass additional html attributes as second parameter for render:

.. code-block:: html+php

	<p>
		<label>Name</label>
		<?php echo $form->render("name", array('maxlength' => 30, 'placeholder' => 'Type your name')) ?>
	</p>

HTML Attributes also can be set in the element's definition:

.. code-block:: php

	$form->add(new Text("name", array(
		'maxlength' => 30,
		'placeholder' => 'Type your name'
	)));

Validation
----------
Phalcon forms are integrated with the validation component to offer instant validation of forms. Built-in or
custom validators could be set to each element:

.. code-block:: php

	$text = new Text("name");

	$text->addValidator(new PresenceOf(

	));

	$form->add($text);

