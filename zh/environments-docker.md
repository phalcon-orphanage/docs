<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">概述</a> 
      <ul>
        <li>
          <a href="#dependencies">依赖项</a>
        </li>
        <li>
          <a href="#services">服务</a>
        </li>
        <li>
          <a href="#installation">安装</a> 
          <ul>
            <li>
              <a href="#installation-composer">使用 Composer (推荐)</a>
            </li>
            <li>
              <a href="#installation-git">使用 Git</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#configuration">配置</a>
        </li>
        <li>
          <a href="#usage">使用</a>
        </li>
        <li>
          <a href="#setup">设置</a>
        </li>
        <li>
          <a href="#logs">日志</a>
        </li>
        <li>
          <a href="#environment-variables">环境变量</a> 
          <ul>
            <li>
              <a href="#environment-variables-web">Web 环境</a>
            </li>
            <li>
              <a href="#environment-variables-phpmyadmin">phpMyAdmin 变量</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#xdebug">Xdebug 远程调试器 (PhpStorm)</a>
        </li>
        <li>
          <a href="#troubleshooting">疑难解答</a> <ul>
            <li>
              <a href="#troubleshooting-startup">启动或链接错误</a>
            </li>
            <li>
              <a href="#troubleshooting-full-reset">完全重置</a>
            </li>
            <li>
              <a href="#troubleshooting-dependencies">更新依赖项</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#versions">版本</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# 总览

Phalcon Compose 是社区驱动的，为Phalcon项目打造的，在Docker运行的样板开发环境。 其目的是，使它更易于引导Phalcon应用和在开发或生产环境中运行它们。

<a name='dependencies'></a>

## 依赖项

To run this stack on your machine, you need at least:

* Operating System: Windows, Linux, or OS X
* [Docker Engine](https://docs.docker.com/installation/) >= 1.10.0
* [Docker Compose](https://docs.docker.com/compose/install/) >= 1.6.2

<a name='services'></a>

## 服务

服务包括有：

| 服务名称          | 描述                                        |
| ------------- | ----------------------------------------- |
| mongo         | MongoDB 服务容器。                             |
| postgres      | PostgreSQL 服务容器。                          |
| mysql         | MySQL 数据库容器。                              |
| phpmyadmin    | MySQL 和 MariaDB 的 web 界面。                 |
| memcached     | Memcached 服务容器。                           |
| queue         | Beanstalk 队列服务容器.                         |
| aerospike     | Aerospike — — 可靠、 高性能、 分布式数据库优化的闪存和 RAM。  |
| redis         | Redis数据库容器。                               |
| app           | PHP 7、 Apache 2 和Composer的容器。             |
| elasticsearch | Elasticsearch 是一个功能强大的开源搜索和分析引擎，使得数据容易搜索。 |

<a name='installation'></a>

## 安装

<a name='installation-composer'></a>

### 使用 Composer (推荐)

使用Composer，你可以创建一个如下的新项目：

$ `composer create-project phalcon/compose --prefer-dist <folder name>`

您的输出应该与此类似：

```php
Example
 Installing phalcon/compose (version)
  - Installing phalcon/compose (version)
    Loading from cache

Created project in folderName
> php -r "copy('variables.env.example', 'variables.env');"
Loading composer repositories with package information
Updating dependencies (including require-dev)
Nothing to install or update
Generating autoload files
```

<a name='installation-git'></a>

### 使用 Git

另一种方法来初始化您的项目是通过Git。

$ `git clone git@github.com:phalcon/phalcon-compose.git`

<div class="alert alert-warning">
    <p>
        Make sure that you copy <code>variables.env.example</code> to <code>variables.env</code> and adjust the settings in that file.
    </p>
</div>

将您Phalcon的应用程序，添加到 `application` 文件夹。

<a name='configuration'></a>

## 配置

添加`Phalcon.local` （或您首选的主机名 `）到您的 <o>/etc/hosts` 文件，如下所示：

$ `127.0.0.1 www.phalcon.local phalcon.local`

<a name='usage'></a>

## 用法

You can now build, create, start, and attach to containers to the environment for your application. To build the containers use following command inside the project root:

$ `docker-compose build`

要启动应用程序并在后台运行容器，可以在项目的根目录内，使用以下命令：

You can use here your prefered project name with `-p <my-app>` parameter

$ `docker-compose up -d`

Now setup your project in the app container using the Phalcon Developer Tools

Replace project in **<project_app_1>** with the name of your project/directory (shown in the output of `docker-compose up -d`)

$ `docker exec -t <project_app_1> phalcon project application simple`

Now you can now launch your application in your browser visiting `http://phalcon.local` (or the host name you chose above).

<a name='setup'></a>

## 设置

如果您的应用程序使用文件缓存，或将日志写入到文件，你可以设置你的缓存和日志文件夹，如下所示：

| 目录    | 路径               |
| ----- | ---------------- |
| Cache | `/project/cache` |
| Logs  | `/project/log`   |

<a name='logs'></a>

## 日志

对于大多数容器，您可以使用 `docker logs 1` 命令，访问在您的主机上的日志。

<a name='environment-variables'></a>

## 环境变量

你可以通过编辑 `variables.env` 文件，从外部文件传递多个环境变量到服务容器。

<a name='environment-variables-web'></a>

### Web 环境

| 环境变量                 | 描述                 | 默认              |
| -------------------- | ------------------ | --------------- |
| `WEB_DOCUMENT_ROOT`  | Web服务器的文档根目录（容器内）。 | /project/public |
| `WEB_DOCUMENT_INDEX` | 索引文件。              | index.php       |
| `WEB_ALIAS_DOMAIN`   | 域名别名               | *.vm            |
| `WEB_PHP_SOCKET`     | PHP FPM 套接字地址。     | 127.0.0.1:9000  |
| `APPLICATION_ENV`    | 应用程序环境。            | development     |
| `APPLICATION_CACHE`  | 应用程序缓存的目录 （容器内）。   | /project/cache  |
| `APPLICATION_LOGS`   | 应用程序日志的目录 （容器内）。   | /project/logs   |

<a name='environment-variables-phpmyadmin'></a>

### phpMyAdmin 变量

| 环境变量               | 描述                                                                                                        | 默认      |
| ------------------ | --------------------------------------------------------------------------------------------------------- | ------- |
| `PMA_ARBITRARY`    | 当设置为1时，只有1个被允许到服务器的连接。                                                                                    | 1       |
| `PMA_HOST`         | 定义MySQL服务器地址/主机名。                                                                                         | mysql   |
| `PMA_HOSTS`        | Define comma separated list of address/host names of the MySQL servers. Used only if `PMA_HOST` is empty. |         |
| `PMA_PORT`         | 定义MySQL服务器的端口。                                                                                            | 3306    |
| `PMA_VERBOSE`      | 定义MySQL服务器的详细名称。                                                                                          |         |
| `PMA_VERBOSES`     | Define comma separated list of verbose names of the MySQL servers. Used only if `PMA_VERBOSE` is empty.   |         |
| `PMA_USER`         | 定义用户名用于配置身份验证方法。                                                                                          | phalcon |
| `PMA_PASSWORD`     | 定义密码用于配置身份验证方法。                                                                                           | secret  |
| `PMA_ABSOLUTE_URI` | 完全限定的路径 (例如 https://pma.example.net/) 在反向代理使 phpMyAdmin 可用。                                               |         |

*See also*

* https://docs.phpmyadmin.net/en/latest/setup.html#installing-using-docker
* https://docs.phpmyadmin.net/en/latest/config.html#config
* https://docs.phpmyadmin.net/en/latest/setup.html

<a name='xdebug'></a>

## Xdebug 远程调试器 (PhpStorm)

出于调试目的，您可以设置 Xdebug 通过传递所需的参数 （见 variables.env）。

| 环境变量                         | 描述                                                | 默认             |
| ---------------------------- | ------------------------------------------------- | -------------- |
| `XDEBUG_REMOTE_HOST`         | `php.ini` value for `xdebug.remote_host`.         | (your host IP) |
| `XDEBUG_REMOTE_PORT`         | `php.ini` value for `xdebug.remote_port`.         | 9000           |
| `XDEBUG_REMOTE_AUTOSTART`    | `php.ini` value for `xdebug.remote_autostart`.    | Off            |
| `XDEBUG_REMOTE_CONNECT_BACK` | `php.ini` value for `xdebug.remote_connect_back`. | Off            |

*注意*你可以找到你本地的 IP 地址，如下所示：

**Linux/macOS**

$ `ifconfig en1 | grep inet | awk '{print $2}' | sed 's/addr://' | grep .`

**Windows**

&gt; `ipconfig`

<a name='troubleshooting'></a>

## 疑难解答

<a name='troubleshooting-startup'></a>

### 启动或链接错误

If you got any startup issues you can try to rebuild app container. There will be no loss of data., it is a safe reset:

```bash
docker-compose stop
docker-compose rm --force app
docker-compose build --no-cache app
docker-compose up -d
```

<a name='troubleshooting-full-reset'></a>

### 完全重置

要重置所有容器，请删除所有数据 （mysql、 elasticsearch 等），但不是 `application` 文件夹中的项目文件：

```bash
docker-compose stop
docker-compose rm --force
docker-compose build --no-cache
docker-compose up -d
```

<a name='troubleshooting-dependencies'></a>

### 更新依赖项

有时，基础的镜像 (例如 `phalconphp/php-apache:ubuntu-16.04`) 已经更新。 Phalcon Compose 取决于这些镜像. 你因此将需要更新它们，它始终是好事，确保您有可用的最新功能。 对这些镜像的从属容器，将需要更新和重建：

```bash
docker pull mongo:3.4
docker pull postgres:9.5-alpine
docker pull mysql:5.7
docker pull phpmyadmin/phpmyadmin:4.6
docker pull memcached:1.4-alpine
docker pull phalconphp/beanstalkd:1.10
docker pull aerospike:latest
docker pull redis:3.2-alpine
docker pull elasticsearch:5.2-alpine
docker pull phalconphp/php-apache:ubuntu-16.04
```

Linux/苹果 Mac 用户可以使用 `make` 执行任务：

$ `make pull`

然后你必须重置所有容器、 删除所有数据，重建服务并重新启动应用程序。

Linux/苹果 Mac 用户可以使用 `make` 执行任务：

$ `make reset`