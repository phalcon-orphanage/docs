---
layout: default
language: 'it-it'
version: '4.0'
title: 'Environments - Nanobox'
---

# Environments

* * *

![](/assets/images/document-status-stable-success.svg)

## Overview

[Nanobox](https://nanobox.io) is a portable, micro platform for developing and deploying apps. When working locally, Nanobox uses Docker to spin up and configure a virtual development environment configured to your specific needs. When you're ready to deploy to live servers, Nanobox will take that same environment and spin it up on your cloud provider of choice, where you can then manage and scale your app through the Nanobox dashboard.

## Local Development

Nanobox can be used for local development on any number of projects (not only restricted to PHP). To start working with nanobox you will first [create a free Nanobox account](https://dashboard.nanobox.io/users/register), then [download and run the Nanobox installer](https://dashboard.nanobox.io/download). The account is used only to login to nanobox using the console command. Nanobox will remember your credentials so you only have to do this once. If your intent is only to use nanobox locally, you do not need to do anything else. The same login however can be used later on if you wish to deploy your application to a live environment.

### Create a New Project

Create a project folder and `cd` into it:

```bash
mkdir nanobox-phalcon && cd nanobox-phalcon
```

### Add a `boxfile.yml`

Nanobox uses the [`boxfile.yml`](https://docs.nanobox.io/boxfile/) to build and configure your app's runtime and environment. In the root of your project, create a `boxfile.yml` with the following:

```yaml
run.config:
  engine: php
  engine.config:
    runtime: php-7.2
    document_root: public
    extensions:
      - phalcon
  extra_steps:
    #===========================================================================
    # PSR extension compilation
    - |
      (
        CURRENT_FOLDER=$(pwd)
        rm -fR /tmp/php-psr
        cd /tmp/build
        git clone --depth=1 https://github.com/jbboehr/php-psr.git
        cd php-psr
        set -e
        phpize
        ./configure --with-php-config=$(which php-config)
        make -j"$(getconf _NPROCESSORS_ONLN)"
        make install
        cd $CURRENT_FOLDER
        rm -fR /tmp/php-psr
        unset CURRENT_FOLDER
      )
    - echo -e 'extension=psr.so' >> "/data/etc/php/dev_php.ini"
    - echo "alias phalcon=\'phalcon.php\'" >> /data/var/home/gonano/.bashrc
```

This tells Nanobox to:

- Use the PHP [engine](https://docs.nanobox.io/engines/), a set of scripts that build your app's runtime.
- Use PHP 7.2.
- Set the Apache document root to `public`.
- Include the Phalcon extension. *Nanobox takes a bare-bones approach to extensions, so you'll likely need to include other extensions. More information can be found [here](https://guides.nanobox.io/php/phalcon/php-extensions/).*
- Install the required [PSR](https://github.com/jbboehr/php-psr.git) extension
- Add a bash alias for Phalcon Devtools so you can just use the `phalcon` command.

Depending on the needs of your application, you might need to add additional extensions. For instance you might want to add `mbcrypt`, `igbinary`, `json`, `session` and `redis`. Your `extensions` section in the `boxfile.yml` will look like this:

```yaml
run.config:
  engine: php
  engine.config:
    extensions:
      - json
      - mbstring
      - igbinary
      - session
      - phalcon
      - redis
```

> **NOTE** The order of the extensions **does** matter. Certain extensions will not load if their prerequisites are not loaded. For instance `igbinary` has to be loaded before `redis` etc.
{: .alert .alert-warning }

### Add Phalcon Devtools to your `composer.json`

Create a `composer.json` file in the root of your project and add the `phalcon/devtools` package to your dev requirements:

```json
{
    "require-dev": {
        "phalcon/devtools": "~3.0.3"
    }
}
```

> **NOTE**: The version of Phalcon Devtools depends on which PHP version as well as Phalcon version you're using.
{: .alert .alert-warning }

### Start Nanobox and Generate a New Phalcon App

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

# exit the console
exit
```

### Run the App

Before actually running your new Phalcon app, we recommend using Nanobox to add a DNS alias. This will add an entry to your local `hosts` file pointing to your dev environment and provide a convenient way to access your app from a browser.

```bash
nanobox dns add local phalcon.dev
```

Alternatively you can use the IP address of your container. The IP address is displayed when you first run your container. If you forgot or did not notice it, on a separate terminal, navigate to the same folder that your project lives on your system and type

```bash
nanobox info local
```

The output of this command will show you all the IP addresses of your containers/components as well as passwords to databases (if applicable).

Nanobox provides a `php-server` helper script that starts both Apache (or Nginx depending on your `boxfile.yml` config) and PHP. When passed with the `nanobox run` command, it will start the local dev environment and immediately run your app.

```bash
nanobox run php-server
```

Once running, you can visit your app at `https://phalcon.dev`.

### Check Out the Environment

Your virtual environment includes everything you need to run your Phalcon application.

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