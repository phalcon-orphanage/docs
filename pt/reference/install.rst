Instalação
============
A instalação de uma extensão PHP é levemente diferente dos métodos tradicionais de instalação das bibliotecas de um framework baseado em PHP. Você pode fazer o download dos pacotes binários construído para o seu sistema de sua escolha ou compilar-los a partir das fontes.

.. highlights::
    Phalcon é compilado do PHP 5.3.1, como as versões antigas do PHP causavam bugs relacionados à falha de memória, recomendamos fortemente utilizar pelo menos uma versão 5.3.11 ou maior.

.. highlights::
    Versões do PHP abaixo da 5.3.9 tem várias falhas de segurança e essas versões não são recomendadas para sites em produção.`Saiba Mais <http://www.infoworld.com/d/security/php-539-fixes-hash-collision-dos-vulnerability-183947>`_

Windows
-------
Para utilizar o phalcon no Windows você pode fazer o download da biblioteca DLL. Editar o seu php.ini adicionando no final a seguinte instrução:

    extension=php_phalcon.dll

Reinicie seu servidor web.

O seguinte screencast é um passo-a-passo para instalação do Phalcon no Windows:

.. raw:: html

    <div align="center"><iframe src="http://player.vimeo.com/video/40265988" width="500" height="266" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>

Guias Relacionados
^^^^^^^^^^^^^^
.. toctree::
    :maxdepth: 1

    xampp
    wamp

Linux/Solaris/Mac
-----------------
Nos sistemas Linux/Solaris/Mac você pode facilmente compilar e instalar a extensão diretamente dos códigos fontes:

Requerimentos
^^^^^^^^^^^^
Os pacotes pré-requisitos são:

* PHP 5.3.x/5.4.x/5.5.(recursos de desenvolvimento)
* Compilador GCC (Linux/Solaris) ou Xcode (Mac)
* Git (caso ainda não esteja instalado no seu sistema - a menos que você faça o download do pacote no GitHub e depois o upload para o seu servidor via FTP/SFTP)

Pacotes específicos para plataformas em comum:

.. code-block:: bash

    #Ubuntu
    sudo apt-get install git-core gcc autoconf
    sudo apt-get install php5-dev php5-mysql

    #Suse
    sudo yast -i gcc make autoconf2.13
    sudo yast -i php5-devel php5-mysql

    #CentOS/RedHat
    sudo yum install gcc make
    sudo yum install php-devel

    #Solaris
    pkg install gcc-45
    pkg install php-53 apache-php53

Compilação
^^^^^^^^^^^
Criando a extensão:

.. code-block:: bash

    git clone git://github.com/phalcon/cphalcon.git
    cd cphalcon/build
    sudo ./install

Adicione a extensão ao seu php.ini

.. code-block:: bash

    extension=phalcon.so

Reinicie o servidor web.

Phalcon automaticamente detecta a sua arquitetura, no entanto, você poderá força a compilação para uma arquitetura especifica:

.. code-block:: bash

    sudo ./install 32bits
    sudo ./install 64bits
    sudo ./install safe

FreeBSD
-------
Um port esta disponível para o FreeBSD. Basta um simples comando na linha de comando para instalar-lo:

.. code-block:: bash

    pkg_add -r phalcon

ou

.. code-block:: bash

    export CFLAGS="-O2 -fno-delete-null-pointer-checks"
    cd /usr/ports/www/phalcon && make install clean

Notas de Instalação
------------------
Notas de Instalação para os Servidores Web:

.. toctree::
    :maxdepth: 1

    apache
    nginx
    cherokee
    built-in
