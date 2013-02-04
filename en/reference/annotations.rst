Annotations Parser
==================
It is the first time that an annotations parser component is written in C for the PHP world. Phalcon\Annotations is a general purpose component
that provides ease of parsing and caching annotations in PHP classes to be used in applications.

Annotations are read from docblocks in classes, methods and properties. An annotation can be placed at any position in the docblock:

.. code-block:: php

	<?php

	/**
	 * This is the class description
	 *
	 * @AmazingClass(true)
	 */
	class Example
	{

		/**
		 * This a property with a special feature
		 *
		 * @SpecialFeature
		 */
		protected $someProperty;

		/**
		 * This is a method
		 *
		 * @SpecialFeature
		 */
		public function someMethod()
		{
			// ...
		}

	}

In the above example we find some annotations in the comments, an annotation has the following syntax:

@Annotation-Name[(param1, param2, ...)]

Also, an annotation could be placed at any part of a docblock:

.. code-block:: php

	<?php

	/**
	 * This a property with a special feature
	 *
	 * @SpecialFeature
     *
	 * More comments
     *
	 * @AnotherSpecialFeature(true)
	 */

The parser is highly flexible, the following docblock is valid:

.. code-block:: php

	<?php

	/**
	 * This a property with a special feature @SpecialFeature({
	someParameter="the value", false

	 })  More comments @AnotherSpecialFeature(true) @MoreAnnotations
	 **/

However, to make the code more maintainable and understandable it is recommended to place annotations at the end of the docblock:

.. code-block:: php

	<?php

	/**
	 * This a property with a special feature
	 * More comments
	 *
	 * @SpecialFeature({someParameter="the value", false})
	 * @AnotherSpecialFeature(true)
	 */

Reading Annotations
-------------------
A reflector is implemented to easily get the annotations defined on a class using an object oriented interface:

.. code-block:: php

	<?php

	$reader = new \Phalcon\Annotations\Adapter\Memory();

	//Reflect the annotations in the class Example
	$reflector = $reader->get('Example');

	//Read the annotations in the class' docblock
	$annotations = $reflector->getClassAnnotations();

	//Traverse the annotations
	foreach ($annotations as $annotation) {

		//Print the annotation name
		echo $annotation->getName(), PHP_EOL;

		//Print the number of arguments
		echo $annotation->numberArguments(), PHP_EOL;

		//Print the arguments
		print_r($annotation->getArguments());
	}

:doc:`Phalcon\Annotations\Adapter\Memory <../api/Phalcon_Annotations_Adapter_Memory>` was used in the above example. This adapter
only caches the annotations while the request is running, for this reason this adapter is more suitable for development.

The annotation reading process is very fast, however, for performance reasons it is recommended to store the parsed annotations using an adapter.
Adapters cache the processed annotations avoiding the need of parse the annotations.

Types of Annotations
--------------------
Annotations may have parameters or not. A parameter could be a simple literal (strings, number, boolean, null), an arrays, a hashed list or other annotation:

.. code-block:: php

	<?php

	/**
	 * Simple Annotation
	 *
	 * @SomeAnnotation
	 */

	/**
	 * Annotation with parameters
	 *
	 * @SomeAnnotation("hello", "world", 1, 2, 3, false, true)
	 */

	/**
	 * Annotation with named parameters
	 *
	 * @SomeAnnotation(first="hello", second="world", third=1)
	 * @SomeAnnotation(first: "hello", second: "world", third: 1)
	 */

	/**
	 * Passing an array
	 *
	 * @SomeAnnotation([1, 2, 3, 4])
	 * @SomeAnnotation({1, 2, 3, 4})
	 */

	/**
	 * Passing a hash as parameter
	 *
	 * @SomeAnnotation({first=1, second=2, third=3})
	 * @SomeAnnotation({'first': 1, 'second': 2, 'third': 3})
	 * @SomeAnnotation({'first'=1, 'second'=2, 'third'=3})
	 */

	 /**
	 * Nested arrays
	 *
	 * @SomeAnnotation({"name"="SomeName", "other"={
	 *		"foo1": "bar1", "foo2": "bar2",
	 * }})
	 */

Let’s pretend we’ve the following controller and the developer wants to create a plugin that automatically starts the
cache if the latest action executed is marked as cacheable:

