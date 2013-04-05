Class **Phalcon\\Http\\Request\\File**
======================================

*implements* :doc:`Phalcon\\Http\\Request\\FileInterface <Phalcon_Http_Request_FileInterface>`

Methods
---------

public  **__construct** (*array* $file)

Phalcon\\Http\\Request\\File constructor



public *int*  **getSize** ()

Returns the file size of the uploaded file



public *string*  **getName** ()

Returns the real name of the uploaded file



public *string*  **getTempName** ()

Returns the temporal name of the uploaded file



public *boolean*  **moveTo** (*string* $destination)

Move the temporary file to a destination whithin the application



