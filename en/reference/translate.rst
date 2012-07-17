Multi-lingual Support
=====================
The component expects to help you creating multi-language applications. This type of applications require display content in multiple languages depending on the user's language. 

Adapters
--------
This component makes use of adapters to read translation messages from different sources in a unified way.

+---------+-----------------------------------------------------------------------------+
| Adapter | Description                                                                 | 
+=========+=============================================================================+
| Array   | Uses PHP arrays to store the messages. In terms of performance is the best. | 
+---------+-----------------------------------------------------------------------------+

Component Usage
---------------
Translation files are stored in files, the structure of these files could change depending of the adapter used. Phalcon gives you the freedom to organize your translation messages. A very simpler structure could be the following: 

.. code-block:: bash

    app/messages/en.php
    app/messages/es.php
    app/messages/fr.php
    app/messages/zh.php

Each file contains a hash with the translations, each message has a unique index that should be the samein other message files: 

.. code-block:: php

    <?php

    //app/messages/es.php
    $messages = array(
    	"hi" => "Hello",
    	"bye" => "Good Bye",
    	"hi-name" => "Hello %name%",
    	"song" => "This song is %song%"
    );

.. code-block:: php

    <?php

    //app/messages/fr.php
    $messages = array(
    	"hi" => "Bonjour",
    	"bye" => "Au revoir",
    	"hi-name" => "Bonjour %name%",
    	"song" => "La chanson est %song%"
    );

Now, it's time to load the correct translation file according to the user environment.A simpler way is getting this data from the $_SERVER['HTTP_ACCEPT_LANGUAGE'] header, or, If you prefer, access directly to that value by calling $this->request->getBestLanguage() inside an action/controller: 

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

We've implemented a method _getTranslation, it will be available for other actions that require translation too. The $t variable is passed to the views, with it, we can get translations for the messages file loaded previously: 

.. code-block:: html+php

    <!-- welcome -->
    <p><?php echo $t->_("hi"), " ", $name; ?></p>

The "_" function is the resposible to query the message according to the index given. Some translation messages could have placeholders, for example: Hello %name%. Those can be replaced using an extra parameter when getting the translation: 

.. code-block:: html+php

    <!-- welcome -->
    <p><?php echo $t->_("hi-name", array("name" => $name)); ?></p>

Note that "hi" and "hi-name" are related to different messages, but just only one of themrequire a placeholder. Some websites implement urls like http://www.mozilla.org/**es-ES**/firefox/, where the actual language/locale is passed as part of the uri. You can do this with Phalcon, implementing a regex router. 