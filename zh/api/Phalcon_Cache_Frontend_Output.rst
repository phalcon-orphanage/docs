Class **Phalcon\\Cache\\Frontend\\Output**
==========================================

Allows to cache output fragments captured with ob_* functions 

.. code-block:: php

    <?php

     //Create an Output frontend. Cache the files for 2 days
     $frontCache = new Phalcon\Cache\Frontend\Output(array(
       "lifetime" => 172800
     ));
    
     // Create the component that will cache from the "Output" to a "File" backend
     // Set the cache file directory - it's important to keep the "/" at the end of
     // the value for the folder
     $cache = new Phalcon\Cache\Backend\File($frontCache, array(
         "cacheDir" => "../app/cache/"
     ));
    
     // Get/Set the cache file to ../app/cache/my-cache.html
     $content = $cache->start("my-cache.html");
    
     // If $content is null then the content will be generated for the cache
     if ($content === null) {
    
         //Print date and time
         echo date("r");
    
         //Generate a link to the sign-up action
         echo Phalcon\Tag::linkTo(
             array(
                 "user/signup",
                 "Sign Up",
                 "class" => "signup-button"
             )
         );
    
         // Store the output into the cache file
         $cache->save();
    
     } else {
    
         // Echo the cached output
         echo $content;
     }



Methods
---------

public  **__construct** (*array* $frontendOptions)

Phalcon\\Cache\\Frontend\\Output constructor



public *integer*  **getLifetime** ()

Returns cache lifetime



public  **isBuffering** ()

Check whether if frontend is buffering output



public  **start** ()

Starts output frontend



public *string*  **getContent** ()

Returns output cached content



public  **stop** ()

Stops output frontend



public  **beforeStore** (*mixed* $data)

Prepare data to be stored



public  **afterRetrieve** (*mixed* $data)

Prepares data to be retrieved to user



