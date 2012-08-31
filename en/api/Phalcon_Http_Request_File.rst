Class **Phalcon\\Http\\Request\\File**
======================================

Phalcon\\Http\\Request\\File   Provides OO wrappers to the $_FILES superglobal  

.. code-block:: php

    <?php

    
    class PostsController extends \Phalcon\Mvc\Controller
    {
    
     public function uploadAction()
     {
       //Check if the user has uploaded files
       if ($this->request->hasFiles() == true) {
          //Print the real file names and their sizes
          foreach ($this->request->getUploadedFiles() as $file){
             echo $file->getName(), " ", $file->getSize(), "\n";
          }
       }
     }
    
    }
    





Methods
---------

**__construct** (*array* **$file**)

*int* **getSize** ()

*string* **getName** ()

*string* **getTempName** ()

**moveTo** (*string* **$destination**)

