%{install_c0277e63a218ee84b1414b2c467dfbe2}%
============
%{install_c872ae13f816fd7dfbfc1f7781ddd782}%

.. highlights::
    Phalcon compiles from PHP 5.3.1, but because of old PHP bugs causing memory leaks, we highly recommend you use at least PHP 5.3.11 or greater.

.. highlights::
    PHP versions below 5.3.9 have several security flaws and these aren't recommended for production web sites. `Learn more <http://www.infoworld.com/d/security/php-539-fixes-hash-collision-dos-vulnerability-183947>`_



%{install_8458efd5cfb7e32b7a48fe0ab64285af}%
-------
%{install_ff1363bcd28f96670272daf6d775d72f}%

%{install_44f00144e8778ea8ed7917345caa3bd3}%

%{install_6a49732434aa0c102cc05c6a55e1879f}%

%{install_94b7a1e85a5e5275e9d2cc04f8023598}%

.. raw:: html

    <div align="center"><iframe src="http://player.vimeo.com/video/40265988" width="500" height="266" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>



%{install_7a752ac7821139893d4b7d8eb762a483}%
^^^^^^^^^^^^^^
.. toctree::
    :maxdepth: 1

    xampp
    wamp



%{install_dda3a9c60b475b60966aa176def7e97b}%
-----------------
%{install_715c1caf8effafa7bca2e6fad2aef37b}%

%{install_72a3660e8fa5fbfc8034c2e330a6f573}%
^^^^^^^^^^^^
%{install_70a4fa2ec4a0a6356164c746dc431647}%

* {%install_6a17ca0ee031283ea5d3a812cfb19285%}
* {%install_d99ea35b57fc4e0a65d005b0a751c744%}
* {%install_c4bd9f7964fd692c23f751f60b83c4eb%}

%{install_6e2d310434cb02d415fcff3819ca2f0b}%

.. code-block:: bash

    #Ubuntu
    sudo apt-get install git-core gcc autoconf
    sudo apt-get install php5-dev php5-mysql

    #Suse
    sudo yast -i gcc make autoconf2.13
    sudo yast -i php5-devel php5-pear php5-mysql

    #CentOS/RedHat
    sudo yum install gcc make
    sudo yum install php-devel

    #Solaris
    pkg install gcc-45
    pkg install php-53 apache-php53


%{install_9bae46c938052c986789bce50ddc11c1}%
^^^^^^^^^^^
%{install_7277a5ce5aea3f76cacc10e144264e7f}%

.. code-block:: bash

    git clone git://{%install_33fb7441b040e39278820011290bc5c4%}
    cd cphalcon/build
    sudo ./install


%{install_ddf369d0a475a6c8b618f59910f37ec7}%

.. code-block:: bash
    
    #Ubuntu: Add this line in your php.ini
    extension=phalcon.so
    
    #Centos/RedHat: Add a file called phalcon.ini in /etc/php.d/ with this content:
    extension=phalcon.so


%{install_c6ca645f3bcde844f8ec6f8c99f61167}%

%{install_10d3ab0887312140a685f66b49109538}%

.. code-block:: bash

    sudo ./install 32bits
    sudo ./install 64bits
    sudo ./install safe


%{install_b2f5cb7e2747e60a61390100a08e8376}%
-------
%{install_d43da86ea091d3cd812a33429d570ae8}%

.. code-block:: bash

    pkg_add -r phalcon


%{install_6899336ad02d327ac9b4d1670f72a18c}%

.. code-block:: bash

    export CFLAGS="-O2 -fno-delete-null-pointer-checks"
    cd /usr/ports/www/phalcon && make install clean


%{install_23a4a0eeaa8c65b1110e8da55a261fe4}%
------------------
%{install_4c62f4f5d780cac9af64cb12a7120d75}%

