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

バイナリ インストール (推奨):

```bash
brew tap phalcon/extension https://github.com/phalcon/homebrew-tap
brew install phalcon
```

Phalconのコンパイル:

```bash
brew tap phalcon/extension https://github.com/phalcon/homebrew-tap
brew install phalcon --build-from-source 
```

#### MacPorts

```bash
sudo port install php72-phalcon
sudo port install php73-phalcon
```

php.ini ファイルを編集し、末尾に下記を追記します:

```ini
extension=php_phalcon.so
```

そして、Webサーバを再起動してください。

### PHPBrew (macOS/Linux)

PHPBrewは、システム上の複数のバージョンのPHPとPHP拡張を管理する優れた方法です。 PHPBrewのインストールの手順は [こちら](https://github.com/phpbrew/phpbrew/wiki/Quick-Start) です。

PHPBrewを使用している場合は、以下によりPhalconをインストールできます。

```bash
sudo phpbrew ext install phalcon
```

You can install the PSR dependency via phpbrew as well if needed:

```bash
sudo phpbrew ext install psr
```

### Windows

Windows で Phalcon を使用するためには、phalcon.dll をインストールする必要があります。 Phalconプロジェクトでは、プラットフォームに応じた複数の DLL ファイルをコンパイルしています。 DLL は、[ダウンロード](https://phalcon.io/en/download/windows) ページにあります。

アーキテクチャと同様に、PHP がインストールされているかを確認します。 間違った DLL をダウンロードした場合、Phalcon は動作しません。 `phpinfo()` にてこれらの情報が確認できます。 次の例では、DLLのNTS バージョンを必要としています:

![phpinfo](/assets/images/content/phpinfo-api.png)

利用可能な DLL は次のとおりです。

| アーキテクチャー | バージョン | Type           |
|:--------:|:-----:| -------------- |
|   x64    |  7.x  | スレッドセーフ        |
|   x64    |  7.x  | 非スレッドセーフ (NTS) |
|   x86    |  7.x  | スレッドセーフ        |
|   x86    |  7.x  | 非スレッドセーフ (NTS) |

php.ini ファイルを編集し、末尾に下記を追記します:

```ini
extension=php_phalcon.dll
```

そして、Webサーバを再起動してください。

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

次に、PHP ini ファイルに`extension=phalcon.so` と追記し、拡張モジュールが読み込まれるように、Webサーバを再起動する必要があります。

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

上記の手順はコンパイルを行い、**そして、さらに** システムにモジュールをインストールします。 拡張機能をコンパイルし、 `ini` ファイルに手動で追加することもできます。

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

上記のメソッドを使用する場合は、 `extension=phalconを追加する必要があります。 <code> php.ini` の `` で CLI （コマンドラインインターフェイス用）と Web サーバーの両方を指定します。

#### チューニングビルド（最適化オプションの指定されたコンパイル）

デフォルトでは、すべてのプロセッサ (`gcc -mtune=native -O2 -fomit-frame-pointer` ) と可能な限り互換性があるようにコンパイルします。 コンパイラーに現在実行中のプロセッサーに合う最適化されたマシンコードを生成するよう指示したい場合は、ビルドの前にCFLAGSをエクスポートすることで独自のコンパイルフラグを設定できます。 例えば、

    export CFLAGS="-march=native -O2 -fomit-frame-pointer"
    zephir build
    

これにより、そのチップセットに最適なコードが生成されますが、古いチップセットでコンパイルされたオブジェクトが壊れる可能性があります。

### 共有ホスティングサービス

共有ホスティングサービスでWEBアプリケーションを実行する場合、主にrootアクセス権限がない場合などにPhalconのインストールが制限される場合があります。 いくつかのWebホスティングコントロールパネルは幸運にもPhalconをサポートしています。

#### cPanel & WHM

cPanelとWHMは、Easy Apache 4(EA4)を用いてPhalconをサポートしています。 Easy Apache 4 (EA4) で [module](https://github.com/CpanelInc/scl-phalcon) を有効にすることで、Phalconをインストールできます。

#### Plesk

プレスクのコントロールパネルにはPhalconがサポートされていませんが、Plesk [ウェブサイト](https://support.plesk.com/hc/en-us/articles/115002186489-How-to-install-Phalcon-framework-for-a-PHP-supplied-by-Plesk-) にインストール手順があります。