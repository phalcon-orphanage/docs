---
layout: article
language: 'zh-cn'
version: '4.0'
---
##### This article reflects v3.4 and has not yet been revised

{:.alert .alert-danger}

<a name='overview'></a>

# 概述

[Nanobox](https://nanobox.io) is a portable, micro platform for developing and deploying apps. When working locally, Nanobox uses Docker to spin up and configure a virtual development environment configured to your specific needs. When you're ready to deploy to live servers, Nanobox will take that same environment and spin it up on your cloud provider of choice, where you can then manage and scale your app through the Nanobox dashboard.

In this post, we'll walk through getting a brand new Phalcon app up and running locally, with nothing installed other than Nanobox. First [create a free Nanobox account](https://dashboard.nanobox.io/users/register), then [download and run the Nanobox installer](https://dashboard.nanobox.io/download).

<a name='create-project'></a>

## 创建新项目

Create a project folder and `cd` into it:

```bash
mkdir nanobox-phalcon& & cd nanobox-phalcon
```

<a name='boxfile-yml'></a>

## 添加 `boxfile.yml`

Nanobox uses the [`boxfile.yml`](https://docs.nanobox.io/boxfile/) to build and configure your app's runtime and environment. In the root of your project, create a `boxfile.yml` with the following:

```yaml
run.config:
  engine: php
  engine.config:
    runtime: php-7.1
    document_root: public
    extensions:
      - phalcon
  extra_steps:
    - echo "alias phalcon=\'phalcon.php\'" >> /data/var/home/gonano/.bashrc
```

This tells Nanobox to:

- 使用 PHP [引擎](https://docs.nanobox.io/engines/)，一组构建您的应用程序运行时的脚本。
- 使用 PHP 7.1。
- 设置为 `公共` 的 Apache 文档根目录。
- 包括Phalcon扩展名。 *Nanobox 的扩展，采用裸骨的方法，所以您可能需要包括其他扩展。 可以找到更多的信息 [在这里](https://guides.nanobox.io/php/phalcon/php-extensions/)。*
- 为Phalcon Devtools 添加 bash 别名，因此您可以只使用 `Phalcon` 命令。

<a name='add-devtools'></a>

## 将Phalcon Devtools 添加到您的 `composer.json`

Create a `composer.json` file in the root of your project and add the `phalcon/devtools` package to your dev requirements:

```json
{
    "require-dev": {
        "phalcon/devtools": "~3.0.3"
    }
}
```

<h5 class='alert alert-warning'><strong>NOTE</strong>: The version of Phalcon Devtools depends on which PHP version you're using </h5>

<a name='new-phalcon-app'></a>

## 启动 Nanobox 并生成一个新的Phalcon应用，

From the root of your project, run the following commands to start Nanobox and generate a new Phalcon app. As Nanobox starts, the PHP engine will automatically install and enable the Phalcon extension, run a `composer install` which will install Phalcon Devtools, then drop you into an interactive console inside the virtual environment. Your working directory is mounted into the `/app` directory in the VM, so as changes are made, they will be reflected both in the VM and in your local working directory.

```bash
# start nanobox and drop into a nanobox console
nanobox run

# cd into the /tmp directory
cd /tmp

# generate a new phalcon app
phalcon project myapp

# change back to the /app dir
cd -

# copy the generated app into your project
cp -a /tmp/myapp/* .

# 退出控制台
```

<a name='run-app'></a>

## 本地运行应用程序

Before actually running your new Phalcon app, we recommend using Nanobox to add a DNS alias. This will add an entry to your local `hosts` file pointing to your dev environment and provide a convenient way to access your app from a browser.

```bash
nanobox dns 添加本地 phalcon.dev
```

Nanobox provides a `php-server` helper script that starts both Apache (or Nginx depending on your `boxfile.yml` config) and PHP. When passed with the `nanobox run` command, it will start the local dev environment and immediately run your app.

```bash
nanobox 运行 php 服务器
```

Once running, you can visit your app at [phalcon.dev](https://phalcon.dev).

<a name='environment'></a>

## 查阅环境

Your virtual environment includes everything you need to run your Phalcon app. Feel free to poke around.

```bash
# drop into a Nanobox console
nanobox run

# check the php version
php -v

# check that phalcon devtools are available
phalcon info

# check that your local codebase is mounted
ls

# exit the console
exit
```

<a name='conclusion'></a>

## Phalcon和 Nanobox

Nanobox gives you everything you need develop and run your Phalcon app in an isolated virtual environment. With the `boxfile.yml` in your project, collaborators can get up and running in minutes simply by running `nanobox run`.

Nanobox has a [Phalcon Quickstart](https://github.com/nanobox-quickstarts/nanobox-phalcon) that includes everything covered in this post. They also have as guides for [using Phalcon with Nanobox](https://guides.nanobox.io/php/phalcon/). In future posts, we'd like to cover other aspects of using Phalcon with Nanobox, including adding and connecting to a database, deploying Phalcon into production, etc. If you're interested [let us know on Twitter](https://twitter.com/nanobox_io).