Class **Phalcon\\Http\\Request\\File**
======================================

*extends* SplFileInfo

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

public  **__construct** (*array* $file)

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



public *boolean*  **isUploadedFile** ()

Checks whether the file has been uploaded via Post.



public *boolean*  **moveTo** (*string* $destination)

Moves the temporary file to a destination within the application



public static  **__set_state** (*unknown* $params)

...


public *string*  **getExtension** ()

Returns the file extension



public  **getPath** () inherited from SplFileInfo

...


public  **getFilename** () inherited from SplFileInfo

...


public  **getBasename** ([*unknown* $suffix]) inherited from SplFileInfo

...


public  **getPathname** () inherited from SplFileInfo

...


public  **getPerms** () inherited from SplFileInfo

...


public  **getInode** () inherited from SplFileInfo

...


public  **getOwner** () inherited from SplFileInfo

...


public  **getGroup** () inherited from SplFileInfo

...


public  **getATime** () inherited from SplFileInfo

...


public  **getMTime** () inherited from SplFileInfo

...


public  **getCTime** () inherited from SplFileInfo

...


public  **isWritable** () inherited from SplFileInfo

...


public  **isReadable** () inherited from SplFileInfo

...


public  **isExecutable** () inherited from SplFileInfo

...


public  **isFile** () inherited from SplFileInfo

...


public  **isDir** () inherited from SplFileInfo

...


public  **isLink** () inherited from SplFileInfo

...


public  **getLinkTarget** () inherited from SplFileInfo

...


public  **getRealPath** () inherited from SplFileInfo

...


public  **getFileInfo** ([*unknown* $class_name]) inherited from SplFileInfo

...


public  **getPathInfo** ([*unknown* $class_name]) inherited from SplFileInfo

...


public  **openFile** ([*unknown* $open_mode], [*unknown* $use_include_path], [*unknown* $context]) inherited from SplFileInfo

...


public  **setFileClass** ([*unknown* $class_name]) inherited from SplFileInfo

...


public  **setInfoClass** ([*unknown* $class_name]) inherited from SplFileInfo

...


final public  **_bad_state_ex** () inherited from SplFileInfo

...


public  **__toString** () inherited from SplFileInfo

...


