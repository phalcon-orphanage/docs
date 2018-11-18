<div class='article-menu'>
  <ul>
    <li>
      <a href="#安装要求">安装要求</a> <ul>
        <li>
          <a href="#安装要求-硬件篇">硬件</a>
        </li>
        <li>
          <a href="#安装要求-软件篇">软件</a>
        </li>
      </ul>
    </li>
    <li>
      <a href="#安装">Installation</a> <ul>
        <li>
          <a href="#安装-Linux">Linux</a> <ul>
            <li>
              <a href="#安装-linux-debian">DEB 用于分布 （Debian，Ubuntu 等）</a> <ul>
                <li>
                  <a href="#安装-linux-debian-repository">储存库安装</a> <ul>
                    <li>
                      <a href="#安装-linux-debian-repository-stable">稳定版</a>
                    </li>
                    <li>
                      <a href="#installation-linux-debian-repository-nightly">Nightly 版本</a>
                    </li>
                  </ul>
                </li>
                <li>
                  <a href="#installation-linux-debian-phalcon">Phalcon 安装</a> <ul>
                    <li>
                      <a href="#installation-linux-debian-phalcon-php5">PHP 5.x</a>
                    </li>
                    <li>
                      <a href="#installation-linux-debian-phalcon-php7">PHP 7</a>
                    </li>
                  </ul>
                </li>
                <li>
                  <a href="#installation-linux-debian-other-ppa">其他PPAs</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="#installation-linux-rpm">基于RPM的发行版(CentOS, Fedora等)</a> <ul>
                <li>
                  <a href="#installation-linux-rpm-repository">储存库安装</a> <ul>
                    <li>
                      <a href="#installation-linux-rpm-repository-stable">稳定版</a>
                    </li>
                    <li>
                      <a href="#installation-linux-rpm-repository-nightly">Nightly 版本</a>
                    </li>
                  </ul>
                </li>
                <li>
                  <a href="#installation-linux-rpm-phalcon">Phalcon installation</a> <ul>
                    <li>
                      <a href="#installation-linux-rpm-phalcon-php5">PHP 5.x</a>
                    </li>
                    <li>
                      <a href="#installation-linux-rpm-phalcon-php7">PHP 7</a>
                    </li>
                  </ul>
                </li>
                <li>
                  <a href="installation-linux-rpm-other-rpm">其他PPAs</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="#installation-freebsd">FreeBSD</a>
            </li>
            <li>
              <a href="#installation-linux-gentoo">Gentoo</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#installation-macos">MacOS</a> <ul>
            <li>
              <a href="#installation-macos-brew">Brew</a>
            </li>
            <li>
              <a href="#installation-macos-macports">MacPorts</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#installation-windows">Windows</a>
        </li>
        <li>
          <a href="#installation-sources">Compile from sources</a>
        </li>
        <li>
          <a href="#installation-sources-advanced">Advanced Compilation</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='requirements'></a>

# 安装要求

Phalcon在运行的时候需要PHP。 它松散耦合的设计允许开发人员安装Phalcon，并使用它的功能，而不需要额外的扩展。 某些组件依赖于其他扩展。 例如，使用数据库连接将需要`php_pdo`扩展。 如果你的RDBMS是MySql/MariaDb或Aurora数据库，你将需要`php_mysqlnd`扩展。 类似地，使用带有Phalcon的PostgreSql数据库需要使用`php_pgsql`扩展。

<a name='requirements-hardware'></a>

## 硬件

Phalcon 设计用于尽可能少的资源, 同时提供高性能。 尽管我们已经在各种低端环境 (如 0.25GB RAM、0.5 CPU) 中测试了 Phalcon, 但您将选择的硬件将取决于您的应用程序需求。

我们的网站和博客 (以及其他网站) 托管在一个 512MB RAM 和 1 vCPU 的亚马逊虚拟机上。

<a name='requirements-software'></a>

## 软件

- PHP 5.5

<h5 class='alert alert-danger'>您应该始终尝试使用最新版本的Phalcon和PHP作为解决bug、增强安全性和提高性能的工具。 在不久的将来 PHP 5.5 版本会被遗弃， Phalcon 4 会只支持 PHP 7 版本。 </h5>

Phalcon 需要以下扩展来运行 (最小):

- `curl`
- `gettext`
- `gd2` (for the Image class)
- `libpcre3-dev` (Debian/Ubuntu), `pcre-devel` (CentOS), `pcre` (Mac OS)
- `json`
- `mbstring`
- `pdo_*`
- `fileinfo`
- `openssl`

### 根据应用程序的需要可选

- [PDO](http://php.net/manual/en/book.pdo.php)扩展以及相关RDBMS特异性扩展(如[MySQL](http://php.net/manual/en/ref.pdo-mysql.php)， [PostgreSql](http://php.net/manual/en/ref.pdo-pgsql.php)等)
- [OpenSSL](http://php.net/manual/en/book.openssl.php) 扩展
- [Mbstring](http://php.net/manual/en/book.mbstring.php) 扩展
- [Memcache](http://php.net/manual/en/book.memcache.php)， [Memcached](http://php.net/manual/en/book.memcached.php)或其他相关的缓存适配器，取决于您对缓存的使用。

<a name='installation'></a>

# 安装

由于 Phalcon 被编译为 PHP 扩展, 它的安装与任何其他传统的 php 框架有所不同。Phalcon 需要在 web 服务器上作为模块进行安装和加载。

<a name='installation-linux'></a>

## Linux

要在 linux 上安装 Phalcon, 您将需要在分发中添加我们的存储库, 然后安装它。

<a name='installation-linux-debian'></a>

### 基于 DEB 的发行版本 (Debian，Ubuntu 等）

<a name='installation-linux-debian-repository'></a>

#### 储存库安装

将存储库添加到您的发行版中:

<a name='installation-linux-debian-repository-stable'></a>

##### 稳定版

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.deb.sh | sudo bash
```

或

<a name='installation-linux-debian-repository-nightly'></a>

##### Nightly 版本

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.deb.sh | sudo bash
```

<h5 class='alert alert-warning'>这只需要执行一次，除非您的发行版发生了更改，或者您想从稳定版本切换到nightly 版本。 </h5>

<a name='installation-linux-debian-phalcon'></a>

#### Phalcon 安装

要安装Phalcon，您需要在您的终端发出以下命令:

<a name='installation-linux-debian-phalcon-php5'></a>

##### PHP 5.x

```bash
sudo apt-get update
sudo apt-get install php5-phalcon
```

<a name='installation-linux-debian-phalcon-php7'></a>

##### PHP 7

```bash
sudo apt-get update
sudo apt-get install php7.0-phalcon
```

<a name='installation-linux-debian-other-ppa'></a>

#### 其他PPAs

#### Ondřej Surý

如果您不希望使用我们的 packagecloud 存储库, 则您始终可以使用 [ Ondřej Surý ](https://launchpad.net/~ondrej/+archive/ubuntu/php/) 提供的知识库。

存储库的安装:

```php
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
```

接着 Phalcon:

```php
sudo apt-get install php-phalcon
```

https://launchpad.net/~ondrej/+archive/ubuntu/php/

<a name='installation-linux-rpm'></a>

### 基于RPM的发行版(CentOS, Fedora等)

<a name='installation-linux-rpm-repository'></a>

#### 储存库安装

将存储库添加到您的发行版中:

<a name='installation-linux-rpm-repository-stable'></a>

##### 稳定版

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.rpm.sh | sudo bash
```

或

<a name='installation-linux-rpm-repository-nightly'></a>

##### Nightly 版本

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.rpm.sh | sudo bash
```

<h5 class='alert alert-warning'>这只需要执行一次，除非您的发行版发生了更改，或者您想从稳定版本切换到nightly 版本。 </h5>

<a name='installation-linux-rpm-phalcon'></a>

#### Phalcon 安装

要安装Phalcon，您需要在您的终端发出以下命令:

<a name='installation-linux-rpm-phalcon-php5'></a>

##### PHP 5.x

```bash
sudo yum update
sudo yum install php56u-phalcon
```

<a name='installation-linux-rpm-phalcon-php7'></a>

##### PHP 7

```bash
sudo yum update
sudo yum install php70u-phalcon
```

<a name='installation-linux-rpm-other-rpm'></a>

#### 其他的 RPMs

##### Remi

Remi为基于RPM的安装维护了一个优秀的存储库。您可以在这里找到关于如何为您的描述[here ](https://blog.remirepo.net/pages/Config-en)启用它的说明

在那之后安装Phalcon是非常容易的:

```bash
yum install php56-php-phalcon3
```

其他版本既支持特定于体系结构的版本(x86/x64)，也支持特定于PHP的版本(5.5、5.6、7.x)

<a name='installation-freebsd'></a>

## FreeBSD

FreeBSD可以使用pkg。要安装它，您需要发出以下命令:

### `pkg_add`

```bash
pkg_add -r phalcon
```

### 源码

```bash
export CFLAGS="-O2 --fvisibility=hidden"

cd /usr/ports/www/phalcon

make install clean
```

<a name='installation-gentoo'></a>

## Gentoo

安装Phalcon的覆盖层可以在这里找到<https://github.com/smoke/phalcon-gentoo-overlay>

<a name='installation-macos'></a>

## Mac OS X

在Mac OS X系统上，你可以使用`brew`， `macports`或源代码编译和安装扩展:

### 安装要求

- PHP 5.5.x/5.6.x/7.0.x/7.1.x development resources
- XCode

<a name='installation-macos-brew'></a>

### Brew

```bash
brew tap homebrew/homebrew-php
brew install php55-phalcon
brew install php56-phalcon
brew install php70-phalcon
brew install php71-phalcon
```

<a name='installation-macos-macports'></a>

### MacPorts

```bash
sudo port install php55-phalcon
sudo port install php56-phalcon
```

编辑 php.ini，然后追加在结束:

```ini
extension=php_phalcon.so
```

重启你的web服务器.

<a name='installation-windows'></a>

## Windows

要在Windows上使用Phalcon，您需要安装Phalcon.dll。 我们根据目标平台编译了几个dll。 Dll可以在[下载页](https://phalconphp.com/en/download/windows)中找到。

标识PHP安装和体系结构。 如果你下载了错误的DLL, Phalcon无法工作。 `phpinfo()`包含此信息。 在下面的示例中，我们将需要DLL的NTS版本:

![phpinfo](/images/content/phpinfo-api.png)

可用的dll有:

| 架构  | 版本  | 类型                    |
|:---:|:---:| --------------------- |
| x64 | 7.x | Thread safe           |
| x64 | 7.x | Non Thread safe (NTS) |
| x86 | 7.x | Thread safe           |
| x86 | 7.x | Non Thread safe (NTS) |
| x64 | 5.6 | Thread safe           |
| x64 | 5.6 | Non Thread safe (NTS) |
| x86 | 5.6 | Thread safe           |
| x86 | 5.6 | Non Thread safe (NTS) |

编辑 php.ini，然后追加在结束:

```ini
extension=php_phalcon.dll
```

重启你的web服务器.

<a name='installation-sources'></a>

## 编译源代码安装

从源代码编译类似于大多数环境(Linux/Mac)。

### 安装要求

- PHP 5.5.x/5.6.x/7.0.x/7.1.x development resources
- GCC compiler (Linux/Solaris/FreeBSD) or Xcode (MacOS)
- re2c >= 0.13
- libpcre-dev

您可以使用相关的包管理器在系统中安装这些包。流行linux发行版的说明如下:

#### Ubuntu

```bash
sudo apt-get install php5-dev libpcre3-dev gcc make
```

#### Suse

```bash
sudo zypper install php5-devel gcc make
```

#### CentOS/Fedora/RHEL

```bash
sudo yum install php-devel pcre-devel gcc make
```

### 编译 Phalcon

我们首先需要从Github库中克隆Phalcon

```bash
git clone https://github.com/phalcon/cphalcon
```

现在构建扩展

```bash
cd cphalcon/build
sudo ./install
```

现在需要添加`extension=phalcon.so`到您的PHP ini，并重新启动您的web服务器，以便加载扩展。

```ini
# Suse: Add a file called phalcon.ini in /etc/php5/conf.d/ with this content:
extension=phalcon.so

# CentOS/RedHat/Fedora: Add a file called phalcon.ini in /etc/php.d/ with this content:
extension=phalcon.so

# Ubuntu/Debian with apache2: Add a file called 30-phalcon.ini in /etc/php5/apache2/conf.d/ with this content:
extension=phalcon.so

# Ubuntu/Debian with php5-fpm: Add a file called 30-phalcon.ini in /etc/php5/fpm/conf.d/ with this content:
extension=phalcon.so

# Ubuntu/Debian with php5-cli: Add a file called 30-phalcon.ini in /etc/php5/cli/conf.d/ with this content:
extension=phalcon.so
```

<a name='installation-sources-advanced'></a>

## 先进的编译

然而，Phalcon自动检测您的架构，您可以强制编译一个特定的架构:

```bash
cd cphalcon/build

# One of the following:
sudo ./install --arch 32bits
sudo ./install --arch 64bits
sudo ./install --arch safe
```

如果自动安装程序失败，您可以手动构建扩展

```bash
git clone https://github.com/phalcon/cphalcon
# cd cphalcon/build/php5/32bits
cd cphalcon/build/php5/64bits

# NOTE: for PHP 7 you have to use
# cd cphalcon/build/php7/32bits
# or
# cd cphalcon/build/php7/64bits

make clean
phpize --clean

export CFLAGS="-O2 --fvisibility=hidden"
./configure --enable-phalcon

make
make install
```

如果运行特定的php版本

```bash
git clone https://github.com/phalcon/cphalcon
# cd cphalcon/build/php5/32bits
cd cphalcon/build/php5/64bits

# NOTE: for PHP 7 you have to use
# cd cphalcon/build/php7/32bits
# or
# cd cphalcon/build/php7/64bits

make clean
/opt/php-5.6.15/bin/phpize --clean

export CFLAGS="-O2 --fvisibility=hidden"
./configure --with-php-config=/opt/php-5.6.15/bin/php-config --enable-phalcon

make
make install
```

现在需要添加`extension=phalcon.so`到您的PHP ini，并重新启动您的web服务器，以便加载扩展。

<a name='installation-testing'></a>
您可以在web服务器根目录中创建一个包含以下内容的小脚本:

```php
<?php

phpinfo();
```

然后在你的web浏览器中访问它. 应该有一节关于 Phalcon 的。 如果没有，请确保您的扩展已经正确编译，并且对`php.ini`进行了必要的更改，并且您已经重新启动了web服务器。

你也可以检查你的安装从命令行:

```bash
php -r 'print_r(get_loaded_extensions());'
```

这将输出类似于以下内容:

```php
Array
(
    [0] => Core
    [1] => libxml
    [2] => filter
    [3] => SPL
    [4] => standard
    [5] => phalcon
    [6] => pdo_mysql
)
```

您还可以看到使用CLI安装的模块:

```bash
php -m
```

<h5 class='alert alert-danger'>注意，在一些基于Linux的系统中，您可能需要更改两个<code>php.ini</code>文件，一个用于web服务器(Apache/Nginx)，一个用于CLI文件。 如果只为web服务器加载了Phalcon，那么您需要找到CLI <code> php.ini </code>。并对要加载的模块进行必要的添加。 </h5>
