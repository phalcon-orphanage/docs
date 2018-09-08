<div class="article-menu">
    <ul>
        <li><a href="#requirements">必要条件</a>
            <ul>
                <li><a href="#requirements-hardware">ハードウェア</a></li>
                <li><a href="#requirements-software">ソフトウェア</a>
                    <ul>
                        <li>
                            <a href="#requirements-software-optional">アプリケーションのニーズに応じた追加依存</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        <li><a href="#installation">インストール</a>
            <ul>
                <li><a href="#installation-linux">Linux</a>
                    <ul>
                        <li>
                            <a href="#installation-linux-debian">debベースのディストリビューション (Debian、Ubuntu など)</a>
                            <ul>
                                <li>
                                    <a href="#installation-linux-debian-repository">リポジトリのインストール</a>
                                    <ul>
                                        <li>
                                            <a href="#installation-linux-debian-repository-stable">安定版</a>
                                        </li>
                                        <li>
                                            <a href="#installation-linux-debian-repository-nightly">Nightly リリース</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#installation-linux-debian-phalcon">Phalcon のインストール</a>
                                    <ul>
                                        <li>
                                            <a href="#installation-linux-debian-phalcon-php5">PHP 5.x</a>
                                        </li>
                                        <li>
                                            <a href="#installation-linux-debian-phalcon-php7">PHP 7</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#installation-linux-debian-other-ppa">追加のPPA</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#installation-linux-rpm">RPM ベースのディストリビューション (CentOS、Fedora 等)</a>
                            <ul>
                                <li>
                                    <a href="#installation-linux-rpm-repository">リポジトリのインストール</a>
                                    <ul>
                                        <li>
                                            <a href="#installation-linux-rpm-repository-stable">安定版</a>
                                        </li>
                                        <li>
                                            <a href="#installation-linux-rpm-repository-nightly">Nightly リリース</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#installation-linux-rpm-phalcon">Phalcon のインストール</a>
                                    <ul>
                                        <li>
                                            <a href="#installation-linux-rpm-phalcon-php5">PHP 5.x</a>
                                        </li>
                                        <li>
                                            <a href="#installation-linux-rpm-phalcon-php7">PHP 7</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="installation-linux-rpm-other-rpm">追加のRPM</a>
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
                <li><a href="#installation-macos">macOS</a>
                    <ul>
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
                    <a href="#installation-sources">ソースコードからコンパイル</a>
                </li>
                <li>
                    <a href="#installation-sources-advanced">高度なコンパイル</a>
                </li>
            </ul>
        </li>
    </ul>
</div>

<a name='requirements'></a>

# 必要条件

Phalcon needs PHP to run. Its loosely coupled design allows developers to install Phalcon and use its functionality without additional extensions. Certain components have dependencies to other extensions. For instance using database connectivity will require the `php_pdo` extension. If your RDBMS is MySql/MariaDb or Aurora databases you will need the `php_mysqlnd` extension also. Similarly, using a PostgreSql database with Phalcon requires the `php_pgsql` extension.

<a name='requirements-hardware'></a>

## ハードウェア

Phalcon is designed to use as little resources as possible, while offering high performance. Although we have tested Phalcon in various low end environments, (such as 0.25GB RAM, 0.5 CPU), the hardware that you will choose will depend on your application needs.

Our website and blog (as well as other sites) are hosted on an Amazon VM with 512MB RAM and 1 vCPU.

<a name='requirements-software'></a>

## ソフトウェア

* PHP >= 5.5

<div class="alert alert-danger">
    <p>
        You should always try and use the latest version of Phalcon and PHP as both address bugs, security enhancements as well as performance. PHP 5.5 は近い将来にサポートされなくなり、Phalcon 4 では PHP 7 のみがサポートされるようになります。
    </p>
</div>

Phalcon を実行するためには、最低限以下の拡張機能が必要です。

* `curl`
* `gettext`
* `gd2` (to use the `Phalcon\Image\Adapter\Gd` class)
* `libpcre3-dev` (Debian/Ubuntu), `pcre-devel` (CentOS), `pcre` (macOS)
* `json`
* `mbstring`
* `pdo_*`
* `fileinfo`
* `openssl`

<a name='requirements-software-optional'></a>

### Optional depending on the needs of your application

* [PDO](http://php.net/manual/en/book.pdo.php) 拡張や、関連するRDBMSの拡張 ([MySQL](http://php.net/manual/en/ref.pdo-mysql.php)や[PostgreSql](http://php.net/manual/en/ref.pdo-pgsql.php)など)
* [OpenSSL](http://php.net/manual/en/book.openssl.php) 拡張
* [Mbstring](http://php.net/manual/en/book.mbstring.php) 拡張
* [Memcache](http://php.net/manual/en/book.memcache.php), [Memcached](http://php.net/manual/en/book.memcached.php) または使用するキャッシュに応じたキャッシュアダプタ

<a name='installation'></a>

# インストール

PhalconはPHP拡張モジュールとしてコンパイルされているため、インストールは他の従来のPHPフレームワークとは多少異なります。 Phalconは、Webサーバー上にモジュールとしてインストールしてロードする必要があります。

<a name='installation-linux'></a>

## Linux

Linux で Phalcon をインストールするためには、使用しているディストリビューションにリポジトリを追加する必要があります。

<a name='installation-linux-debian'></a>

### DEB based distributions (Debian, Ubuntu, etc.)

<a name='installation-linux-debian-repository'></a>

#### リポジトリのインストール

Add the repository to your distribution:

<a name='installation-linux-debian-repository-stable'></a>

##### 安定版

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.deb.sh | sudo bash
```

または

<a name='installation-linux-debian-repository-nightly'></a>

##### Nightly リリース

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.deb.sh | sudo bash
```

<div class="alert alert-warning">
    <p>
        この作業は、あなたがディストリビューションを変更したり安定板とナイトリーを切り替えるといった事情がなければ、実施は一度だけしか必要ありません。
    </p>
</div>

<a name='installation-linux-debian-phalcon'></a>

#### Phalcon のインストール

次のコマンドを実行して、Phalcon をインストールします。

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

#### 追加のPPA

#### Ondřej Surý

[packagecloud.io](https://packagecloud.io/phalcon)でリポジトリを使用したくない場合は、[OndřejSurý](https://launchpad.net/~ondrej/+archive/ubuntu/php/)が提供するリポジトリをいつでも使用できます。

リポジトリのインストール:

```php
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
```

Phalconのインストール:

```php
sudo apt-get install php-phalcon
```

<a name='installation-linux-rpm'></a>

### RPM ベースのディストリビューション (CentOS、Fedora 等)

<a name='installation-linux-rpm-repository'></a>

#### リポジトリのインストール

ディストリビューションにリポジトリを追加します。

<a name='installation-linux-rpm-repository-stable'></a>

##### 安定版

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.deb.sh | sudo bash
```

または

<a name='installation-linux-rpm-repository-nightly'></a>

##### Nightly リリース

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.rpm.sh | sudo bash
```

<div class="alert alert-warning">
    <p>
        この作業は、あなたがディストリビューションを変更したり安定板とナイトリーを切り替えるといった事情がなければ、実施は一度だけしか必要ありません。
    </p>
</div>

<a name='installation-linux-rpm-phalcon'></a>

#### Phalcon のインストール

次のコマンドを実行して、Phalcon をインストールします。

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

#### 追加のRPM

##### Remi

[Remi Collet](https://github.com/remicollet)は、RPMベースのインストールのための優れたリポジトリをメンテナンスしています。 You can find instructions on how to enable it for your distribution [here](https://blog.remirepo.net/pages/Config-en).

Installing Phalcon after that is as easy as:

```bash
yum install php56-php-phalcon3
```

Additional versions are available both architecture specific (x86/x64) as well as PHP specific (5.5, 5.6, 7.x)

<a name='installation-freebsd'></a>

## FreeBSD

A port is available for FreeBSD. To install it you will need to issue the following commands:

### `pkg_add`

```bash
pkg_add -r phalcon
```

### ソースコード

```bash
export CFLAGS="-O2 --fvisibility=hidden"

cd /usr/ports/www/phalcon

make install clean
```

<a name='installation-gentoo'></a>

## Gentoo

An overlay for installing Phalcon can be found here <https://github.com/smoke/phalcon-gentoo-overlay>

<a name='installation-macos'></a>

## macOS

macOS では、`brew`、`macports` またはソースコードから拡張機能をコンパイルしたりインストールしたりすることが可能です。

### 必要条件

* PHP 5.5.x/5.6.x/7.0.x/7.1.x
* XCode

<a name='installation-macos-brew'></a>

### Brew

As the [homebrew/php tap has been deprecated](https://brew.sh/2018/01/19/homebrew-1.5.0/) and is in the process of being removed, A custom repository for Phalcon has been created.

PHP 5.5 has not been ported to homebrew/core and as such no longer exists. PHP 7.2 on the other hand has been added.

```bash
brew tap tigerstrikemedia/homebrew-phalconphp
brew install php56-phalcon
brew install php70-phalcon
brew install php71-phalcon
brew install php72-phalcon
```

<a name='installation-macos-macports'></a>

### MacPorts

```bash
sudo port install php55-phalcon
sudo port install php56-phalcon
```

php.ini ファイルを編集し、末尾に下記を追記します:

```ini
extension=php_phalcon.so
```

Webサーバを再起動します。

<a name='installation-windows'></a>

## Windows

Windows で Phalcon を使用するためには、phalcon.dll をインストールする必要があります。 プラットフォームに応じて、複数の DLL ファイルをコンパイルしています。 Dll は、[ダウンロード](https://phalconphp.com/en/download/windows) のページで見つけることができます。

アーキテクチャと同様に、PHP がインストールされているかを識別します。 間違った DLL をダウンロードした場合、Phalcon は動作しません。 この情報は `phpinfo()` に含まれています。 In the example below, we will need the NTS version of the DLL:

![phpinfo](/images/content/phpinfo-api.png)

利用可能な DLL は次のとおりです。

| Architecture | バージョン | Type                  |
|:------------:|:-----:| --------------------- |
|     x64      |  7.x  | スレッドセーフ               |
|     x64      |  7.x  | Non Thread safe (NTS) |
|     x86      |  7.x  | Thread safe           |
|     x86      |  7.x  | Non Thread safe (NTS) |
|     x64      |  5.6  | Thread safe           |
|     x64      |  5.6  | Non Thread safe (NTS) |
|     x86      |  5.6  | Thread safe           |
|     x86      |  5.6  | Non Thread safe (NTS) |
|     x64      |  5.5  | Thread safe           |
|     x64      |  5.5  | Non Thread safe (NTS) |
|     x86      |  5.5  | Thread safe           |
|     x86      |  5.5  | Non Thread safe (NTS) |

php.ini ファイルを編集し、末尾に下記を追記します:

```ini
extension=php_phalcon.dll
```

Webサーバを再起動します。

<a name='installation-sources'></a>

## ソースコードからコンパイル

ソースコードからのコンパイルは、ほとんどの環境 (Linux/macOS) で同様に行えます。

### 必要条件

* PHP 5.5.x/5.6.x/7.0.x/7.1.x
* GCC compiler (Linux/Solaris/FreeBSD) or Xcode (macOS)
* re2c >= 0.13
* libpcre-dev

これらのパッケージは、システムに応じたパッケージマネージャでインストールすることができます。多く使用されている Linux ディストリビューションでの手順は以下の通りです。

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

### Compile Phalcon

We first need to clone Phalcon from the Github repository

```bash
git clone https://github.com/phalcon/cphalcon
```

and now build the extension

```bash
cd cphalcon/build
sudo ./install
```

You will now need to add `extension=phalcon.so` to your PHP ini and restart your web server, so as to load the extension.

```ini
# Suse の場合: /etc/php5/conf.d/ に下記内容が書いてある phalcon.ini を追加します:
extension=phalcon.so

# CentOS/RedHat/Fedora の場合: /etc/php.d/ に下記内容が書いてある phalcon.ini を追加します:
extension=phalcon.so

# Ubuntu/Debian、Apache2 で構成している場合: /etc/php5/apache2/conf.d/ に、下記内容の 30-phalcon.ini を追加します:
extension=phalcon.so

# Ubuntu/Debian、php5-fpm で構成している場合: /etc/php5/fpm/conf.d/ に、下記内容の 30-phalcon.ini を追加します:
extension=phalcon.so

# Ubuntu/Debian、php5-cli で構成している場合: /etc/php5/cli/conf.d/ に、下記内容の 30-phalcon.ini を追加します:
extension=phalcon.so
```

<a name='installation-sources-advanced'></a>

## 高度なコンパイル

Phalcon は自動的にシステムのアーキテクチャを判定しますが、指定したアーキテクチャ向けにコンパイルすることを強制することができます:

```bash
cd cphalcon/build

# 次のどれか一つ:
sudo ./install --arch 32bits
sudo ./install --arch 64bits
sudo ./install --arch safe
```

自動判別インストーラが失敗する場合は手動でビルドしてみます:

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

If you have specific php versions running:

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

You will now need to add `extension=phalcon.so` to your PHP ini and restart your web server, so as to load the extension.

<a name='installation-testing'></a>
You can create a small script in your web server root that has the following in it:

```php
<?php

phpinfo();
```

and load it on your web browser. There should be a section for Phalcon. If there is not, make sure that your extension has been compiled properly, that you made the necessary changes to your `php.ini` and also that you have restarted your web server.

You can also check your installation from the command line:

```bash
php -r 'print_r(get_loaded_extensions());'
```

This will output something similar to this:

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

You can also see the modules installed using the CLI:

```bash
php -m
```

<div class="alert alert-danger">
    <p>
        一部のLinuxベースのシステムでは、Webサーバー(Apache/Nginx)用とCLI用の2つの<code>php.ini</code>ファイルを変更する必要があります。 PhalconがWebサーバーだけにロードされている場合は、CLI <code>php.ini</code>を探して、ロードするモジュールに必要な追加を行う必要があります。
    </p>
</div>
