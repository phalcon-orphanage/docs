Class **Phalcon\\Http\\Request\\File**
======================================

*implements* :doc:`Phalcon\\Http\\Request\\FileInterface <Phalcon_Http_Request_FileInterface>`

Provides OO wrappers to the $_FILES superglobal  

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
-------

public  **__construct** (*array* $file, [*unknown* $key])

Phalcon\\Http\\Request\\File constructor



public *int*  **getSize** ()

Returns the file size of the uploaded file



public *string*  **getName** ()

Returns the real name of the uploaded file



public *string*  **getTempName** ()

Returns the temporary name of the uploaded file



public *string*  **getType** ()

Returns the mime type reported by the browser This mime type is not completely secure, use getRealType() instead



public *string*  **getRealType** ()

Gets the real mime type of the upload file using finfo



public *string*  **getError** ()

Returns the error code



public *string*  **getKey** ()

Returns the file key



public  **isUploadedFile** ()

...


public *boolean*  **moveTo** (*string* $destination)

Moves the temporary file to a destination within the application



public static  **__set_state** (*unknown* $file, [*unknown* $key])

...


