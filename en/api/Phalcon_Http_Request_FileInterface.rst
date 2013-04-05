Interface **Phalcon\\Http\\Request\\FileInterface**
===================================================

Methods
---------

abstract public  **__construct** (*array* $file)

Phalcon\\Http\\Request\\FileInterface constructor



abstract public *int*  **getSize** ()

Returns the file size of the uploaded file



abstract public *string*  **getName** ()

Returns the real name of the uploaded file



abstract public *string*  **getTempName** ()

Returns the temporal name of the uploaded file



abstract public *boolean*  **moveTo** (*string* $destination)

Move the temporary file to a destination



