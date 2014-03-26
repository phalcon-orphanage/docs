Interface **Phalcon\\Http\\Request\\FileInterface**
===================================================

Phalcon\\Http\\Request\\FileInterface initializer


Methods
-------
<<<<<<< HEAD
=======

abstract public  **__construct** (*array* $file)

Phalcon\\Http\\Request\\FileInterface constructor


>>>>>>> master

abstract public *int*  **getSize** ()

Returns the file size of the uploaded file



abstract public *string*  **getName** ()

Returns the real name of the uploaded file



abstract public *string*  **getTempName** ()

Returns the temporal name of the uploaded file



abstract public *string*  **getType** ()

Returns the mime type reported by the browser This mime type is not completely secure, use getRealType() instead



abstract public *string*  **getRealType** ()

Gets the real mime type of the upload file using finfo



abstract public *boolean*  **moveTo** (*string* $destination)

Move the temporary file to a destination



