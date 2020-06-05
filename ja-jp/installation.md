---
layout: default
language: 'ja-jp'
version: '4.0'
title: 'インストール'
keywords: 'インストール, インストール方法, Phalconのインストール'
---

# インストール

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## 必要条件

### PHP 7.2

Phalcon v4 は、 PHP 7.2 もしくはそれ以降のバージョンのみをサポートしています。 2年前にリリースされたPHP 7.1は、[サポート](https://secure.php.net/supported-versions.php)が失効したため、継続的にサポートされているPHPバージョンに従うことにしました。

### PSR

Phalcon には PSR 拡張機能が必要です。 拡張機能は、[こちら](https://github.com/jbboehr/php-psr) のGitHubリポジトリからダウンロードしてコンパイルできます。 拡張機能のインストール手順は、リポジトリの` README `に記載されています。 拡張機能をコンパイルしてシステムで使用可能になったら、それを` php.ini `でロードする必要があります。 下記のように、1行を追加してください。

```ini
extension=psr.so
```

これは、下記の前に追加するようにしてください。

```ini
extension=phalcon.so
```

または、一部のディストリビューションでは、` ini `ファイル名に数字のプレフィックスが追加されます。 その場合は、Phalconに大きい数値を指定してください(例：` 50-phalcon.ini `)。

Peclを使用する場合は、この拡張機能が自動的にインストールされます。

### PDO

Phalconは疎結合であるため、追加の拡張機能を必要とせずに機能を公開できます。 ただし、特定のコンポーネントは追加の拡張機能に依存します。 データベースへの接続とアクセスが必要な場合は、` php_pdo `拡張機能をインストールする必要があります。 RDBMSが MySQL / MariaDB または Aurora の場合、`php_mysqlnd` 拡張機能も必要です。 同様に、PhalconでPostgreSQLデータベースを使用するには、`php_pgsql`拡張モジュールが必要です。

### ハードウェア

Phalconは、高いパフォーマンスを提供しつつ、可能な限り少ないリソースを使用するようにデザインされています。 さまざまなローエンド環境 (0.25GB RAM、0.5 CPUなど) でPhalconをテストしましたが、選択するハードウェアはアプリケーションのニーズによって異なります。

ここ数年、私たちは512 MBのRAMと1つのvCPUを備えたAmazon VMで、ウェブサイトとブログをホストしています。

### ソフトウェア

> **NOTE**: バグ、セキュリティ強化、パフォーマンスの為に常に最新のPhalconとPHPのバージョンを使う様にしてください。
{: .alert .alert-danger }

PHP 7.2または以降のバージョンと共に、あなたのアプリケーションとPhalconコンポーネントに応じて、次の拡張機能をインストールする必要があります。

* [curl](https://secure.php.net/manual/en/book.curl.php)
* [fileinfo](https://secure.php.net/manual/en/book.fileinfo.php)
* [gettext](https://secure.php.net/manual/en/book.gettext.php)
* [gd2](https://secure.php.net/manual/ja/book.image.php) ([Phalcon\Image\Adapter\Gd](api/Phalcon_Image_Adapter_Gd) classを使用する場合)
* [imagick](https://secure.php.net/manual/ja/book.imagick.php) ([Phalcon\Image\Adapter\Imagick](api/Phalcon_Image_Adapter_Imagick) classを使用する場合)
* [json](https://secure.php.net/manual/en/book.json.php)
* `libpcre3-dev` (Debian/Ubuntu), `pcre-devel` (CentOS), `pcre` (macOS)
* [PDO](https://php.net/manual/ja/book.pdo.php)および関連するRDBMS固有の拡張機能(つまり、[MySQL](https://php.net/manual/ja/ref.pdo-mysql.php)、[PostgreSql](https://php.net/manual/ja/ref.pdo-pgsql.php)など)
* [OpenSSL](https://php.net/manual/ja/book.openssl.php) 拡張機能
* [Mbstring](https://php.net/manual/ja/book.mbstring.php) 拡張機能
* [Memcached](https://php.net/manual/ja/book.memcached.php) 、またはキャッシュの使用状況に応じた他のキャッシュアダプター

> **NOTE**: これらのパッケージのインストールは、オペレーティングシステムと(存在する場合に) 使用するパッケージマネージャーによって異なります。 これらの拡張機能のインストール方法については関連ドキュメントを参照してください。
{: .alert .alert-info }

`libpcre3-dev`パッケージでは、次のコマンドを使用できます。

### Pecl

Windows、Linux、MacOSでは、Peclによるインストールを利用できます。 Windowsでは、コンパイル済みのdllファイルが使用されます。 LinuxとMacOSでは、Phalconをローカルでコンパイルします。このため、別のインストール方法を選択する方が早いかもしれません。 Peclを使用してインストールするには、 [pecl/pear](https://pear.php.net/manual/en/installation.getting.php) がインストールされていることを確認してください。

    pecl channel-update pecl.php.net
    pecl install phalcon
    

#### Debian

```bash
sudo apt-get install libpcre3-dev
```

その後、もう一度Phalconをインストールしてみてください。

#### CentOS

```bash
sudo yum install pcre-devel
```

#### Mac/Osx で Brew を使用する場合

```bash
brew install pcre
```

`brew`がない場合、[PCRE](https://www.pcre.org/)のWebサイトにアクセスし、最新のpcreをダウンロードする必要があります。

```bash
tar -xzvf pcre-8.42.tar.gz
cd pcre-8.42
./configure --prefix=/usr/local/pcre-8.42
make
make install
ln -s /usr/local/pcre-8.42 /usr/sbin/pcre
ln -s /usr/local/pcre-8.42/include/pcre.h /usr/include/pcre.h
```

Maverickの場合

```bash
brew install pcre
```

エラーが発生した場合、次のコマンドを実行してみてください。

```bash
sudo ln -s /opt/local/include/pcre.h /usr/include/
sudo pecl install apc 
```

## インストール プラットフォーム

PhalconはPHP拡張機能としてコンパイルされます。このため、他の従来のPHPフレームワークとはインストールの仕方が多少異なります。 Webサーバーにモジュールとしてインストールとロードをする必要があります。

### Linux

LinuxにPhalconをインストールする場合、リポジトリをディストリビューションに追加しておく必要があります。

#### DEBベースのディストリビューション(Debian, Ubuntu, その他)

##### リポジトリのインストール

ディストリビューションへのリポジトリの追加方法：

**安定版リリース**

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.deb.sh | sudo bash
```

**Nightly リリース**

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.deb.sh | sudo bash
```

**Mainlineリリース (alpha, beta, その他)**

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/mainline/script.deb.sh | sudo bash
```

> **NOTE**: ディストリビューションを変更したり安定板とNightly版を切り替えるといった事情がなければ、この作業の実施は一度だけしか必要ありません。
{: .alert .alert-warning }

##### Phalcon のインストール

次のコマンドを実行して、Phalcon をインストールします。

```bash
sudo apt-get update
sudo apt-get install php7.2-phalcon
```

##### 追加のPPA

**Ondřej Surý**

[packagecloud.io](https://packagecloud.io/phalcon)にて提供されるリポジトリを使用したくない場合、[OndřejSurý](https://launchpad.net/~ondrej/+archive/ubuntu/php/)が提供するリポジトリをいつでも使用できます。

リポジトリのインストール:

```php
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
```

Phalconのインストール:

```php
sudo apt-get install php-phalcon4
```

#### RPM ベースのディストリビューション (CentOS、Fedora 等)

##### リポジトリのインストール

ディストリビューションへのリポジトリの追加方法：

**安定版リリース**

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.rpm.sh | sudo bash
```

**Nightly リリース**

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.rpm.sh | sudo bash
```

**Mainlineリリース (alpha, beta, その他)**

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/mainline/script.rpm.sh | sudo bash
```

> **NOTE**: ディストリビューションを変更したり安定板とNightly版を切り替えるといった事情がなければ、この作業の実施は一度だけしか必要ありません。
{: .alert .alert-warning }


##### Phalcon のインストール

次のコマンドを実行して、Phalcon をインストールします。

```bash
sudo yum update
sudo yum install php72u-phalcon
```

##### 追加のRPM

**Remi**

[Remi Collet](https://github.com/remicollet)は、RPMベースのインストールのための素晴らしいリポジトリをメンテナンスしています。 ディストリビューションを有効にする方法については[こちら](https://blog.remirepo.net/pages/Config-en)をご覧ください。

その後、次のように簡単にPhalconをインストールできます:

```bash
yum install php72-php-phalcon4
```

追加のバージョンには、アーキテクチャー固有のもの (x86/x64) とPHP固有のものがあります

#### FreeBSD

FreeBSDではportsコレクションが利用できます。 インストールするには、次のコマンドを実行してください:

##### pkg_add

```bash
pkg_add -r phalcon4
```

##### ソースコードからコンパイル

```bash
cd /usr/ports/www/phalcon4

make install clean
```

##### Gentoo

Phalconをインストールするためのオーバーレイは、[こちら](https://github.com/smoke/phalcon-gentoo-overlay)にあります。

#### Raspberry Pi

```bash
macOS
```

It is also necessary to increase the swap file from the default 100 MB to at least 2000 MB. Because, the compiler lacks RAM.

```bash
sudo -s
nano /etc/dphys-swapfile
```

Replacing `CONF_SWAPSIZE=100` with `CONF_SWAPSIZE=2000`

After saving the setting, restart the daemon:

```bash
/etc/init.d/dphys-swapfile stop
/etc/init.d/dphys-swapfile start
```

### macOS

Brew includes binary packages so you don't need to compile Phalcon yourself. If you want to compile the extension yourself you need the following dependencies installed:

#### Compilation requirements

* PHP 7.x development resources
* XCode

#### Brew

Binary installation (preferred):

```bash
brew tap phalcon/extension https://github.com/phalcon/homebrew-tap
brew install phalcon
```

Compile phalcon:

```bash
brew tap phalcon/extension https://github.com/phalcon/homebrew-tap
brew install phalcon --build-from-source 
```

#### MacPorts

```bash
sudo port install php72-phalcon
sudo port install php73-phalcon
```

Edit your php.ini file and then append at the end:

```ini
extension=php_phalcon.so
```

Restart your webserver.

### PHPBrew (macOS/Linux)

PHPBrew is an excellent way to manage multiple versions of PHP and PHP extensions on your system(s). Installation instructions for PHPBrew can be found [here](https://github.com/phpbrew/phpbrew/wiki/Quick-Start)

If you're using PHPBrew, you can install Phalcon using the following:

```bash
sudo phpbrew ext install phalcon
```

You can install the PSR dependency via phpbrew as well if needed:

```bash
sudo phpbrew ext install psr
```

### Windows

To use Phalcon on Windows, you will need to install the phalcon.dll. We have compiled several DLLs depending on the target platform. The DLLs can be found in our [download](https://phalcon.io/en/download/windows) page.

Identify your PHP installation as well as architecture. If you download the wrong DLL, Phalcon will not work. `phpinfo()` contains this information. In the example below, we will need the NTS version of the DLL:

![phpinfo](/assets/images/content/phpinfo-api.png)

The available DLLs are:

| アーキテクチャー | バージョン | Type           |
|:--------:|:-----:| -------------- |
|   x64    |  7.x  | スレッドセーフ        |
|   x64    |  7.x  | 非スレッドセーフ (NTS) |
|   x86    |  7.x  | スレッドセーフ        |
|   x86    |  7.x  | 非スレッドセーフ (NTS) |

Edit your php.ini file and then append at the end:

```ini
extension=php_phalcon.dll
```

Restart your webserver.

### ソースコードからコンパイル

ソースコードからのコンパイルは、ほとんどの環境 (Linux/macOS) で同じ様に行えます。

#### Requirements

* PHP 7.2.x/7.3.x の開発環境
* GCCコンパイラ (Linux/Solaris/FreeBSD) または Xcode (macOS)
* re2c >= 0.13
* libpcre-dev

#### コンパイル

最新の `zephir.phar` を [からダウンロードする](https://github.com/phalcon/zephir/releases)。 システムからアクセスできるフォルダに追加します。

このリポジトリのクローンを作成

```bash
git clone https://github.com/phalcon/cphalcon
```

Phalconのコンパイル

```bash
cd cphalcon/
git checkout tags/v4.0.0 ./
zephir fullclean
zephir build
```

モジュールをチェック

```bash
php -m | grep phalcon
```

You will now need to add `extension=phalcon.so` to your PHP ini and restart your web server, so as to load the extension.

```ini
; Suse: Add a File Called Phalcon.ini in /etc/php7/conf.d/ with This Content:
extension=phalcon.so

; CentOS/RedHat/Fedora: Add a File Called Phalcon.ini in /etc/php.d/ with This Content:
extension=phalcon.so

; Ubuntu/Debian with Apache2: Add a File Called 30-phalcon.ini in /etc/php7/apache2/conf.d/ with This Content:
extension=phalcon.so

; Ubuntu/Debian with Php7-fpm: Add a File Called 30-phalcon.ini in /etc/php7/fpm/conf.d/ with This Content:
extension=phalcon.so

; Ubuntu/Debian with Php7-cli: Add a File Called 30-phalcon.ini in /etc/php7/cli/conf.d/ with This Content:
extension=phalcon.so
```

The instructions above will compile **and** install the module on your system. You can also compile the extension and then add it manually in your `ini` file:

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

If you use the above method you will need to add the `extension=phalcon.so` in your `php.ini` both for CLI and web server.

#### Tuning Build

By default we compile to be as compatible as possible with all processors (`gcc -mtune=native -O2 -fomit-frame-pointer`). If you would like instruct the compiler to generate optimized machine code that matches the processor where it is currently running on you can set your own compile flags by exporting CFLAGS before the build. For example

    export CFLAGS="-march=native -O2 -fomit-frame-pointer"
    zephir build
    

This will generate the best possible code for that chipset but will likely break the compiled object on older chipsets.

### Shared Hosting

Running your application on shared hosting might restrict you in installing Phalcon, especially if you do not have root access. Some web hosting control panels luckily have Phalcon support.

#### cPanel & WHM

cPanel & WHM support Phalcon using Easy Apache 4 (EA4). You can install Phalcon by enabling the [module](https://github.com/CpanelInc/scl-phalcon) in Easy Apache 4 (EA4).

#### Plesk

The plesk control panel doesn't have Phalcon support but you can find installation instructions on the Plesk [website](https://support.plesk.com/hc/en-us/articles/115002186489-How-to-install-Phalcon-framework-for-a-PHP-supplied-by-Plesk-)