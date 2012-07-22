Multi-lingual Support
=====================
The component :doc:`Phalcon_Translate <../api/Phalcon_Translate>` aids in creating multilingual applications. Applications using this component, display content in different languages, based on the user's chosen language supported by the application. 

Adapters
--------
This component makes use of adapters to read translation messages from different sources in a unified way.

+---------+-----------------------------------------------------------------------------------------+
| Adapter | Description                                                                             | 
+=========+=========================================================================================+
| Array   | Uses PHP arrays to store the messages. This is the best option in terms of performance. | 
+---------+-----------------------------------------------------------------------------------------+

Component Usage
---------------
Translation strings are stored in files. The structure of these files could vary depending of the adapter used. Phalcon gives you the freedom to organize your translation strings. A simple structure could be: 

.. code-block:: bash

    app/messages/en.php
    app/messages/es.php
    app/messages/fr.php
    app/messages/zh.php

Each file contains an array of the translations in a key/value manner. For each translation file, keys are unique. The same array is used in different files, where keys remain the same and values contain the translated strings depending on each language. 

.. code-block:: php

    <?php

    //app/messages/es.php
    $messages = array(
        "hi"      => "Hello",
        "bye"     => "Good Bye",
        "hi-name" => "Hello %name%",
        "song"    => "This song is %song%"
    );

.. code-block:: php

    <?php

    //app/messages/fr.php
    $messages = array(
        "hi"      => "Bonjour",
        "bye"     => "Au revoir",
        "hi-name" => "Bonjour %name%",
        "song"    => "La chanson est %song%"
    );

Implementing the translation mechanism in your application is trivial but depends on how you wish to implement it. You can use an automatic detection of the language from the user's browser or you can provide a settings page where the user can select their language. 

A simple way of detecting the user's language is to parse the $_SERVER['HTTP_ACCEPT_LANGUAGE'] contents, or if you wish, access it directly by calling $this->request->getBestLanguage() from an action/controller: 

.. code-block:: php

    <?php
    
    class UserController extends Phalcon_Controller
    {
    
      protected function _getTranslation()
      {
    
        //Ask browser what is the best language
        $language = $this->request->getBestLanguage();
    
        //Check if we have a translation file for that lang
        if (file_exists("app/messages/".$language.".php")) {
           require "app/messages/".$language.".php";
        } else {
           // fallback to some default
           require "app/messages/en.php";
        }
    
        //Return a translation object
        return new Phalcon_Translate("Array", array(
           "content" => $messages
        ));
    
      }
    
      function indexAction()
      {
        $this->view->setVar("name", "Mike");
        $this->view->setVar("t", $this->_getTranslation());
      }
    
    }

The _getTranslation method is available for all actions that require translations. The $t variable is passed to the views, and with it, we can translate strings in that layer: 

.. code-block:: html+php

    <!-- welcome -->
    <!-- String: hi => 'Hello' -->
    <p><?php echo $t->_("hi"), " ", $name; ?></p>

The "_" function is returning the translated string based on the index passed. Some strings need to incorporate placeholders for calculated data i.e. Hello %name%. These placeholders can be replaced with passed parameters in the "_ function. The passed parameters are in the form of a key/value array, where the key matches the placeholder name and the value is the actual data to be replaced: 

.. code-block:: html+php

    <!-- welcome -->
    <!-- String: hi-user => 'Hello %name%' -->
    <p><?php echo $t->_("hi-user", array("name" => $name)); ?></p>

Some applications implement multilingual on the URL such as http://www.mozilla.org/**es-ES**/firefox/. Phalcon can implement this by a :doc:`REGEX router <routing>`. 

