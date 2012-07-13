Installation
============

PHP extensions require a different installation method of traditional php-based libraries or frameworks. You can either download a binary package for the system of your choice or build it from sources.  

For the last months we have made research on PHP behavior looking for small and big optimizations, studying deeply the Zend Engine to achieve the omission of unnecessary validations generating low-level solutions to get the best possible performance. 

.. highlights::
   Phalcon compiles from PHP 5.3.1, but due to old PHP bugs causing memory leaks, we highly recommend you to use at least PHP 5.3.8 or superior. 

Windows
^^^^^^^

To use phalcon on Windows you can download a DLL library. Edit your php.ini file and then append at the end:

    extension=php_phalcon.dll

Finally restart your webserver.

The following screencast is a step-by-step guide to install Phalcon on Windows: 

.. raw:: html

   <div align="center"><iframe src="http://player.vimeo.com/video/40265988" width="500" height="266" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>