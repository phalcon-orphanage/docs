---
layout: default
language: 'pt-br'
version: '4.0'
title: 'Instalação'
keywords: 'instalação, instalando o Phalcon'
---

# Instalação

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Requisitos

### PHP 7.2

Phalcon v4 suporta apenas PHP 7.2 e superior. O PHP 7.1 foi liberado há 2 anos e o seu [suporte](https://secure.php.net/supported-versions.php) expirou. Então, nós decidimos utilizar apenas as versões do PHP que são suportadas.

### PSR

Phalcon requer a extensão PSR. A extensão pode ser baixada e compilada a partir [deste](https://github.com/jbboehr/php-psr) repositório do GitHub. As instruções de instalação estão disponíveis no arquivo `README` do repositório. Uma vez que a extensão foi compilada e está disponível em seu sistema, você precisará carregá-la para seu `php.ini`. Você precisará adicionar esta linha:

```ini
extension=psr.so
```

antes de

```ini
extension=phalcon.so
```

> **NOTE**: You will need the PSR 1.0 extension installed.
{: .alert .alert-danger }

Como alternativa, algumas distribuições adicionam um prefixo de número nos arquivos `ini`. Se for esse o caso, escolha um número alto para Phalcon (ex.: `50-phalcon.ini`).

Usando Pecl esta extensão será instalada automaticamente.

### PDO

Uma vez que o Phalcon tem baixa dependência, ele expõe suas funcionalidade sem a necessidade de extensões adicionais. No entanto, certos componentes dependem de extensões adicionais para funcionar. Quando uma conexão com o banco de dados precisa ser feita, você precisará instalar a extensão `php_pdo`. Se seu SGBD é MySQL/MariaDB ou Aurora, você também precisará da extensão `php_mysqlnd`. Da mesma forma que usar um banco de dados PostgreSQL com Phalcon requer a extensão `php_pgsql`.

### Hardware

O Phalcon foi projetado para usar o mínimo de recursos possível e ainda assim oferecer alto desempenho. Embora tenhamos testado Phalcon em vários ambientes de baixo custo, (como 0.25GB de RAM, 0.5 CPU), o hardware que você escolherá dependerá das necessidades da sua aplicação.

Nós hospedamos nosso site e blog nos últimos anos em uma VM na Amazon com 512MB de RAM e 1 vCPU.

### Software

> **NOTE**: You should always try and use the latest version of Phalcon and PHP as both address bugs, security enhancements as well as performance.
{: .alert .alert-danger }

Juntamente com PHP 7.2 ou superior, dependendo das necessidades da sua aplicação e dos componentes do Phalcon que você precisa, talvez seja necessário instalar as seguintes extensões:

* [curl](https://secure.php.net/manual/en/book.curl.php)
* [fileinfo](https://secure.php.net/manual/en/book.fileinfo.php)
* [gettext](https://secure.php.net/manual/en/book.gettext.php)
* [gd2](https://secure.php.net/manual/en/book.image.php) (para usar a classe [Phalcon\Image\Adapter\Gd](api/Phalcon_Image_Adapter_Gd))
* [imagick](https://secure.php.net/manual/en/book.imagick.php) (para usar a classe [Phalcon\Image\Adapter\Imagick](api/Phalcon_Image_Adapter_Imagick))
* [json](https://secure.php.net/manual/en/book.json.php)
* `libpcre3-dev` (Debian/Ubuntu), `pcre-devel` (CentOS), `pcre` (macOS)
* [PDO](https://php.net/manual/en/book.pdo.php) bem como as extensões relevantes do SGDB específico (ex. [MySQL](https://php.net/manual/en/ref.pdo-mysql.php), [PostgreSQL](https://php.net/manual/en/ref.pdo-pgsql.php) etc.)
* [OpenSSL](https://php.net/manual/en/book.openssl.php)
* [Mbstring](https://php.net/manual/en/book.mbstring.php)
* [Memcached](https://php.net/manual/en/book.memcached.php) ou outro adaptador de cache relevante, dependendo do seu uso de cache

> **NOTE**: Installing these packages will vary based on your operating system as well as the package manager you use (if any). Please consult the relevant documentation on how to install these extensions.
{: .alert .alert-info }

Para o pacote `libpcre3-dev` você pode usar os seguintes comandos:

### Pecl

O método de instalação do Pecl está disponível para Windows, Linux e MacOS. Em Windows as DLLs pré-compiladas serão utilizadas. No Linux e no MacOS, o Phalcon será compilado localmente, então talvez seja mais rápido utilizar uma forma de instalação diferente nestas plataformas. Para instalar usando Pecl verifique se você tem o [pecl/pear](https://pear.php.net/manual/en/installation.getting.php) instalado.

    pecl channel-update pecl.php.net
    pecl install phalcon
    

#### Debian

```bash
sudo apt-get install libpcre3-dev
```

e então tente instalar o Phalcon novamente

#### CentOS

```bash
sudo yum install pcre-devel
```

#### Mac/Osx usando Brew

```bash
brew install pcre
```

Sem o `brew` você precisa ir até o site [PCRE](https://www.pcre.org/) e baixar o último pcre:

```bash
tar -xzvf pcre-8.42.tar.gz
cd pcre-8.42
./configure --prefix=/usr/local/pcre-8.42
make
make install
ln -s /usr/local/pcre-8.42 /usr/sbin/pcre
ln -s /usr/local/pcre-8.42/include/pcre.h /usr/include/pcre.h
```

Para OsX Maverick

```bash
brew install pcre
```

se der um erro, você pode usar

```bash
sudo ln -s /opt/local/include/pcre.h /usr/include/
sudo pecl install apc 
```

## Plataformas de Instalação

Uma vez que Phalcon é compilado como uma extensão PHP, sua instalação é um pouco diferente de qualquer outro framework PHP tradicional. Phalcon precisa ser instalado e carregado como um módulo no seu servidor web.

### Linux

Para instalar o Phalcon no Linux, você precisará adicionar nosso repositório em sua distribuição e, em seguida, instalá-lo.

#### Distribuições Baseadas em DEB (Debian, Ubuntu, Etc.)

##### Instalação do repositório

Adicione o repositório à sua distribuição:

**Versões Estáveis**

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.deb.sh | sudo bash
```

**Versões Noturnas (mais frequentes)**

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.deb.sh | sudo bash
```

**Lançamentos em testes (alfa, beta etc.)**

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/mainline/script.deb.sh | sudo bash
```

> **NOTA**: Isto só precisa ser feito uma vez, a menos que sua distribuição mude ou você queira mudar de builds estáveis para versões noturnas.
{: .alert .alert-warning }

##### Instalação do Phalcon

Para instalar o Phalcon você precisa digitar os seguintes comandos em seu terminal:

```bash
sudo apt-get update
sudo apt-get install php7.2-phalcon
```

##### PPAs Adicionais

**Ondřej Surý**

Se você não deseja utilizar nosso repositório em [packagecloud.io](https://packagecloud.io/phalcon), você pode sempre usar o que foi oferecido por [Ondřej Surý](https://launchpad.net/~ondrej/+archive/ubuntu/php/).

Instalação do repositório:

```php
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
```

e do Phalcon:

```php
sudo apt-get install php-phalcon4
```

#### Distribuições baseadas em RPM (CentOS, Fedora, etc.)

##### Instalação do repositório

Adicione o repositório à sua distribuição:

**Versões Estáveis**

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.rpm.sh | sudo bash
```

**Versões Noturnas (mais frequentes)**

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.rpm.sh | sudo bash
```

**Lançamentos em testes (alfa, beta etc.)**

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/mainline/script.rpm.sh | sudo bash
```

> **NOTA**: Isto só precisa ser feito uma vez, a menos que sua distribuição mude ou você queira mudar de builds estáveis para versões noturnas.
{: .alert .alert-warning }


##### Instalação do Phalcon

Para instalar o Phalcon você precisa digitar os seguintes comandos em seu terminal:

```bash
sudo yum update
sudo yum install php72u-phalcon
```

##### RPMs Adicionais

**Remi**

[Remi Collet](https://github.com/remicollet) mantém um excelente repositório para instalações baseadas em RPM. Você pode encontrar instruções sobre como habilitá-lo para sua distribuição [aqui](https://blog.remirepo.net/pages/Config-en).

Instalar o Phalcon depois é muito fácil:

```bash
yum install php72-php-phalcon4
```

Versões adicionais estão disponíveis tanto para arquiteturas (x86/x64) como para versões específicas do PHP

#### FreeBSD

Binary package (pkg) and compile myself from source (ports) are available for FreeBSD. Para instalá-lo, você precisará digitar os seguintes comandos:

##### pkg

```bash
pkg install php74-phalcon4
```

##### ports

```bash
cd /usr/ports/www/phalcon4

make install clean
```

##### Gentoo

Uma descrição sobre como instalar o Phalcon pode ser encontrada [aqui](https://github.com/smoke/phalcon-gentoo-overlay)

#### Raspberry Pi

```bash
sudo -s
git clone https://github.com/phalcon/cphalcon
cd cphalcon/
git checkout tags/v4.0.0 ./
zephir fullclean
zephir build
```

Também é necessário aumentar o arquivo de swap do padrão 100 MB para pelo menos 2000 MB, porque faltará RAM para o compilador.

```bash
sudo -s
nano /etc/dphys-swapfile
```

Substituindo `CONF_SWAPSIZE=100` para `CONF_SWAPSIZE=2000`

Depois de salvar o configuração, reinicie o daemon:

```bash
/etc/init.d/dphys-swapfile stop
/etc/init.d/dphys-swapfile start
```

### macOS

Brew inclui pacotes binários para que você não precise compilar o Phalcon você mesmo. Se você deseja compilar a extensão por conta própria precisará das seguintes dependências instaladas:

#### Requisitos de compilação

* Recursos de desenvolvimento PHP 7.x
* XCode

#### Brew

Instalação binária (preferencial):

```bash
brew tap phalcon/extension https://github.com/phalcon/homebrew-tap
brew install phalcon
```

Compilar o Phalcon:

```bash
brew tap phalcon/extension https://github.com/phalcon/homebrew-tap
brew install phalcon --build-from-source 
```

#### MacPorts

```bash
sudo port install php72-phalcon
sudo port install php73-phalcon
```

Edite seu arquivo php.ini e, em seguida anexe no final:

```ini
extension=php_phalcon.so
```

Reinicie seu servidor web.

### PHPBrew (macOS/Linux)

PHPBrew é uma excelente maneira de gerenciar várias versões do PHP e extensões do PHP no(s) seu(s) sistema(s). Instruções de instalação para PHPBrew podem ser encontradas [aqui](https://github.com/phpbrew/phpbrew/wiki/Quick-Start)

Se você estiver usando PHPBrew, pode instalar Phalcon utilizando o seguinte comando:

```bash
sudo phpbrew ext install phalcon
```

Você pode instalar a dependência com a PSR via phpbrew também, se necessário:

```bash
sudo phpbrew ext install psr
```

### Windows

Para usar o Phalcon no Windows você precisará instalar o phalcon.dll. Compilamos várias DLLs para diferentes plataformas de destino. As DLLs podem ser encontradas em nossa página de [download](https://phalcon.io/en/download/windows).

Identifique sua instalação do PHP, bem como arquitetura. Se você baixar a DLL errada, o Phalcon não funcionará. `phpinfo()` contém esta informação. No exemplo abaixo, precisaremos da versão NTS da DLL:

![phpinfo](/assets/images/content/phpinfo-api.png)

As DLLLs disponíveis são:

| Arquitetura | Versão | Tipo                  |
|:-----------:|:------:| --------------------- |
|     x64     |  7.x   | Thread safe           |
|     x64     |  7.x   | Non Thread safe (NTS) |
|     x86     |  7.x   | Thread safe           |
|     x86     |  7.x   | Non Thread safe (NTS) |

Edite seu arquivo php.ini e, em seguida anexe no final:

```ini
extension=php_phalcon.dll
```

Reinicie seu servidor web.

### Compilar do Código Fonte

Compilar pelo código fonte é semelhante na maioria dos ambientes (Linux/macOS).

#### Requisitos

* Recursos de desenvolvimento PHP 7.2.x/7.3.x
* Compilador GCC (Linux/Solaris/FreeBSD) ou Xcode (macOS)
* re2c >= 0.13
* libpcre-dev

#### Compilação

Baixe o `zephir.phar` mais recente [daqui](https://github.com/phalcon/zephir/releases). Adicione-o a uma pasta que pode ser acessada pelo seu sistema.

Clone o repositório

```bash
git clone https://github.com/phalcon/cphalcon
```

Compilar o Phalcon

```bash
cd cphalcon/
git checkout tags/v4.0.0 ./
zephir fullclean
zephir build
```

Verifique o módulo

```bash
php -m | grep phalcon
```

Agora você precisará adicionar `extension=phalcon.so` ao seu PHP ini e reiniciar seu servidor web, de modo a carregar a extensão.

```ini
; Suse: adicionar um arquivo chamado phalcon.ini em /etc/php7/conf.d/ com o seguinte conteúdo:
extension=phalcon.so

; CentOS/RedHat/Fedora: adicionar um arquivo chamado phalcon.ini em /etc/php.d/ com o seguinte conteúdo:
extension=phalcon.so

; Ubuntu/Debian com Apache2: aicionar um arquivo chamado 30-phalcon.ini em /etc/php7/apache2/conf.d/ com o seguinte conteúdo:
extension=phalcon.so

; Ubuntu/Debian com php7-fpm: adicionar um arquivo chamado 30-phalcon.ini em /etc/php7/fpm/conf.d/ com o seguinte conteúdo:
extension=phalcon.so

; Ubuntu/Debian with php7-cli: adicionar um arquivo chamado 30-phalcon.ini em /etc/php7/cli/conf.d/ com o seguinte conteúdo:
extension=phalcon.so
```

As instruções acima irão compilar **e** instalar o módulo no seu sistema. Você também pode compilar a extensão e então adicioná-la manualmente no seu arquivo `ini`:

```bash
cd cphalcon/
git checkout tags/v4.0.0 ./
zephir fullclean
zephir compile
cd ext
phpize
./configure
make && make install
```

Se você usar o método acima, precisará adicionar a `extension=phalcon. o` no seu `php.ini` tanto para o CLI quanto para o servidor web.

#### Tuning da Compilação

Por padrão, compilamos para ser o mais compatível possível com todos os processadores (`gcc -mtune=native -O2 -fomit-frame-pointer`). Se você quiser instruir o compilador para gerar um código de máquina otimizado que corresponda ao processador onde ele está sendo executado atualmente, você pode definir suas próprias diretivas de compilação exportando CFLAGS antes da compilação. Por exemplo

    export CFLAGS="-march=native -O2 -fomit-frame-pointer"
    zephir build
    

Isto irá gerar o melhor código possível para esse chipset, mas provavelmente irá quebrar o objeto compilado em chipsets mais antigos.

### Hospedagem Compartilhada

Executar sua aplicação em uma hospedagem compartilhada pode restringir você em instalar o Phalcon, especialmente se você não tem acesso root. Alguns painéis de controle da hospedagem na web felizmente têm suporte ao Phalcon.

#### cPanel & WHM

cPanel & WHM suporta Phalcon utilizando o Easy Apache 4 (EA4). Você pode instalar o Phalcon ativando o [módulo](https://github.com/CpanelInc/scl-phalcon) no Easy Apache 4 (EA4).

#### Plesk

O painel de controle do plesk não tem suporte a Phalcon, mas você pode encontrar instruções de instalação no [site](https://support.plesk.com/hc/en-us/articles/115002186489-How-to-install-Phalcon-framework-for-a-PHP-supplied-by-Plesk-) do Plesk.