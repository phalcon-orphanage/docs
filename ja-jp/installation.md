* * *

layout: default language: 'en' version: '3.4'

* * *

<a name='requirements'></a>

# 必要条件

Phalconを利用するにはPHPが実行できる必要があります。 疎結合に設計されている為、開発者はPhalconをインストールし、追加の拡張モジュールなしに利用することができます。 特定のコンポーネントは他の拡張モジュールに依存します。 たとえば、データベース接続を使用するには、`php_pdo`拡張モジュールが必要です。 RDBMSがMySQL/MariaDBまたはAuroraデータベースの場合は、`php_mysqlnd`拡張モジュールも必要です。 同様に、PhalconでPostgreSQLデータベースを使用するには、`php_pgsql`拡張モジュールが必要です。

<a name='requirements-hardware'></a>

## ハードウェア

Phalconは、高いパフォーマンスを提供しながら、可能な限り少ないリソースを使用するように設計されています。 さまざまなローエンド環境 (0.25GB RAM、0.5 CPUなど) でPhalconをテストしましたが、選択するハードウェアはアプリケーションのニーズによって異なります。

当社のウェブサイトとブログ(および他のサイト) は、512MBのRAMと1つのvCPUを備えたAmazon VM上でホストされています。

<a name='requirements-software'></a>

## ソフトウェア

* PHP >= 5.5

<h5 class='alert alert-danger'>バグ、セキュリティ強化、パフォーマンスの為に常に最新のPhalconとPHPのバージョンを使う様にしてください。 PHP 5.5 は近い将来にサポートされなくなり、Phalcon 4 では PHP 7 のみがサポートされるようになります。 </h5>

Phalcon を実行するためには、最低限以下の拡張機能が必要です。

* `curl`
* `gettext`
* `gd2` (`Phalcon\Image\Adapter\Gd`クラスを使う場合)
* `libpcre3-dev` (Debian/Ubuntu), `pcre-devel` (CentOS), `pcre` (macOS)
* `json`
* `mbstring`
* `pdo_*`
* `fileinfo`
* `openssl`

<a name='requirements-software-optional'></a>

### アプリケーションのニーズに応じた追加の依存

* [PDO](http://php.net/manual/en/book.pdo.php) 拡張や、関連するRDBMSの拡張 ([MySQL](http://php.net/manual/en/ref.pdo-mysql.php)や[PostgreSql](http://php.net/manual/en/ref.pdo-pgsql.php)など)
* [OpenSSL](http://php.net/manual/en/book.openssl.php) 拡張
* [Mbstring](http://php.net/manual/en/book.mbstring.php) 拡張
* [Memcache](http://php.net/manual/en/book.memcache.php), [Memcached](http://php.net/manual/en/book.memcached.php) または使用するキャッシュに応じたキャッシュアダプタ

<a name='installation'></a>

# インストール

Since Phalcon is compiled as a PHP extension, its installation is somewhat different than any other traditional PHP framework. Phalcon needs to be installed and loaded as a module on your web server.

<a name='installation-linux'></a>

## Linux

Linux で Phalcon をインストールするためには、使用しているディストリビューションにリポジトリを追加する必要があります。

<a name='installation-linux-debian'></a>

### debベースのディストリビューション (Debian、Ubuntu など)

<a name='installation-linux-debian-repository'></a>

#### リポジトリのインストール

ディストリビューションにリポジトリを追加します。

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

<h5 class='alert alert-warning'>この作業は、あなたがディストリビューションを変更したり安定板とナイトリーを切り替えるといった事情がなければ、実施は一度だけしか必要ありません。 </h5>

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

<h5 class='alert alert-warning'>この作業は、あなたがディストリビューションを変更したり安定板とナイトリーを切り替えるといった事情がなければ、実施は一度だけしか必要ありません。 </h5>

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

[Remi Collet](https://github.com/remicollet)は、RPMベースのインストールのための優れたリポジトリをメンテナンスしています。 こちらのディストリビューションを有効にする方法については[こちら](https://blog.remirepo.net/pages/Config-en)をご覧ください。

それ以降、Phalconをインストールするのは簡単です:

```bash
yum install php56-php-phalcon3
```

追加のバージョンには、アーキテクチャー固有のもの (x86/x64) とPHP固有のもの (5.5, 5.6, 7.x) があります

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

Phalconをインストールするためのオーバーレイは、<https://github.com/smoke/phalcon-gentoo-overlay>にあります。

<a name='installation-macos'></a>

## macOS

macOS では、`brew`、`macports` またはソースコードから拡張機能をコンパイルしたりインストールしたりすることが可能です。

### 必要条件

* PHP 5.5.x/5.6.x/7.0.x/7.1.x
* XCode

<a name='installation-macos-brew'></a>

### Brew

[homebrew/phpタップが廃止され](https://brew.sh/2018/01/19/homebrew-1.5.0/)、削除されているので、Phalconのカスタムリポジトリが作成されました。

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

アーキテクチャと同様に、PHP がインストールされているかを識別します。 間違った DLL をダウンロードした場合、Phalcon は動作しません。 この情報は `phpinfo()` に含まれています。 次の例では、DLLのNTS バージョンを必要としています:

![phpinfo](/assets/images/content/phpinfo-api.png)

利用可能な DLL は次のとおりです。

| アーキテクチャー | バージョン | タイプ            |
|:--------:|:-----:| -------------- |
|   x64    |  7.x  | スレッドセーフ        |
|   x64    |  7.x  | 非スレッドセーフ (NTS) |
|   x86    |  7.x  | スレッドセーフ        |
|   x86    |  7.x  | 非スレッドセーフ (NTS) |
|   x64    |  5.6  | スレッドセーフ        |
|   x64    |  5.6  | 非スレッドセーフ (NTS) |
|   x86    |  5.6  | スレッドセーフ        |
|   x86    |  5.6  | 非スレッドセーフ (NTS) |
|   x64    |  5.5  | スレッドセーフ        |
|   x64    |  5.5  | 非スレッドセーフ (NTS) |
|   x86    |  5.5  | スレッドセーフ        |
|   x86    |  5.5  | 非スレッドセーフ (NTS) |

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
* GCCコンパイラ (Linux/Solaris/FreeBSD) または Xcode (macOS)
* re2c >= 0.13
* libpcre-dev

You can install these packages in your system with the relevant package manager. Instructions for popular linux distributions are below:

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

### Phalconのコンパイル

まず、GitHub のリポジトリから Phalcon のソースコードをクローンする必要があります。

```bash
git clone https://github.com/phalcon/cphalcon
```

その後、拡張機能をビルドします。

```bash
cd cphalcon/build
sudo ./install
```

次に、PHP ini ファイルに`extension=phalcon.so` と追記し、拡張機能が読み込まれるように、ウェブサーバを再起動する必要があります。

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

特定のPHPバージョンを実行している場合:

```bash
git clone https://github.com/phalcon/cphalcon
# cd cphalcon/build/php5/32bits
cd cphalcon/build/php5/64bits

# 注: PHP7の場合
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

次に、PHP ini ファイルに`extension=phalcon.so` と追記し、拡張機能が読み込まれるように、ウェブサーバを再起動する必要があります。

<a name='installation-testing'></a>
Webサーバのルートに次のような小さなスクリプトを作成します:

```php
<?php

phpinfo();
```

そしてウェブブラウザで読み込みます。 Phalconのセクションがあるはずです。 存在しない場合は、拡張モジュールが正しくコンパイルされていること、`php.ini`に必要な変更を加えたこと、そしてWebサーバーが再起動されていることを確認してください。

コマンドラインからインストール内容を確認することもできます:

```bash
php -r 'print_r(get_loaded_extensions());'
```

これは次のような内容を出力します:

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

CLIを使用してモジュールをインストールすることもできます:

```bash
php -m
```

<h5 class='alert alert-danger'>一部のLinuxベースのシステムでは、Webサーバー(Apache/Nginx)用とCLI用の2つの<code>php.ini</code>ファイルを変更する必要があります。 PhalconがWebサーバーだけにロードされている場合は、CLI <code>php.ini</code>を探して、ロードするモジュールに必要な追加を行う必要があります。 </h5>
