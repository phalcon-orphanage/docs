Class **Phalcon_Request_File**
==============================

Provides OO wrappers to the $_FILES superglobal  

.. code-block:: php

    <?php
    
    class PostsController extends Phalcon_Controller
    {

        public function uploadAction()
        {
            // Check if the user has uploaded files
            if ($this->request->hasFiles() == true) {
                // Print the real file names and sizes
                foreach ($this->request->getUploadedFiles() as $file) {
                    echo $file->getName(), " ", $file->getSize(), "\n";
                }
            }
        }
    
    }

Methods
---------

**__construct** (array $file)

Phalcon_Request_File constructor

**int** **getSize** ()

Returns the file size of the uploaded file

**string** **getName** ()

Returns the real name of the uploaded file

**string** **getTempName** ()

Returns the temporal name of the uploaded file

**moveTo** (string $destination)

Move the temporary file to a destination

