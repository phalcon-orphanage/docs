Universal Class Loader
======================
:doc:`Phalcon_Loader <../api/Phalcon_Loader>` is a component that allows you to load project classes automatically, based on some predefined rules. Since this component is written in C, it provides the lowest overhead in reading and interpreting external PHP files. 

The behavior of this component is based on the PHP's capability of `autoloading classes`_. If a class that does not exist is used in any part of the code, a special handler will try to load it. :doc:`Phalcon_Loader <../api/Phalcon_Loader>` serves as the special handler for this operation. By loading classes on a need to load basis, the overall performance is increased since the only file reads that occur are for the files needed. This technique is called `lazy initialization`_. 

:doc:`Phalcon_Loader <../api/Phalcon_Loader>` offers three options to autoload classes. You can use them one at a time or combine them. 

Registering Namespaces
----------------------
If you're organizing your code using namespaces, or external libraries do so, the registerNamespaces() provides the autoloading mechanism. It takes an associative array, which keys are namespace prefixes and their values are directories where the classes are located in. Remember always to add a trailing slash at the end of the paths. 

.. code-block:: php

	<?php
	
	// Creates the autoloader
	$loader = new Phalcon_Loader();
	
	//Register some namespaces
	$loader->registerNamespaces(
		array(
		   "Example\Base"    => "vendor/example/base/",
		   "Example\Adapter" => "vendor/example/adapter/",
		   "Example"         => "vendor/example/",
		)
	);
	
	// register autoloader
	$loader->register();
	
	// The required class will automatically include the 
	// file vendor/example/adapter/Some.php
	$some = new Example\Adapter\Some();

Registering Directories
-----------------------
The second option is to register directories, in which classes could be found. This option is not recommended in terms of performance, since Phalcon will need to perform a significant number of file stats on each folder, looking for the file with the same name as the class. It's important to register the directories in relevance order. Remember always add a trailing slash at the end of the paths. 

.. code-block:: php

	<?php
	
	// Creates the autoloader
	$loader = new Phalcon_Loader();
	
	// Register some directories
	$loader->registerDirs(
		array(
			"library/MyComponent/",
			"library/OtherComponent/Other/",
			"vendor/example/adapters/",
			"vendor/example/"
		)
	);
	
	// register autoloader
	$loader->register();
	
	// The required class will automatically include the file from 
	// the first directory where it has been located
	// i.e. library/OtherComponent/Other/Some.php
	$some = new Some();

Registering Classes
-------------------
The last option is to register the class name and its path. This autoloader can be very useful when the folder convention of the project does not allow for easy retrieval of the file using the path and the class name. This is the fastest method of autoloading. However the more your application grows, the more classes/files need to be added to this autoloader, which will effectively make maintenance of the class list very cumbersome and it is not recommended.

.. code-block:: php

	<?php
	
	// Creates the autoloader
	$loader = new Phalcon_Loader();
	
	// Register some directories
	$loader->registerClasses(
		array(
			"Some"         => "library/OtherComponent/Other/Some.php",
			"Example\Base" => "vendor/example/adapters/Example/BaseClass.php",
		)
	);
	
	// register autoloader
	$loader->register();
	
	// Requiring a class will automatically include the file it references
	// in the associative array
	// i.e. library/OtherComponent/Other/Some.php
	$some = new Some();


.. _autoloading classes: http://www.php.net/manual/en/language.oop5.autoload.php
.. _lazy initialization: http://en.wikipedia.org/wiki/Lazy_initialization
