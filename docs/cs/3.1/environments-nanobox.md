<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Overview</a> <ul>
        <li>
          <a href="#create-project">Vytvoření nového projektu</a>
        </li>
        <li>
          <a href="#boxfile-yml">Add a <code>boxfile.yml</code></a>
        </li>
        <li>
          <a href="#add-devtools">Add Phalcon Devtools to your <code>composer.json</code></a>
        </li>
        <li>
          <a href="#new-phalcon-app">Start Nanobox and Generate a New Phalcon App</a>
        </li>
        <li>
          <a href="#run-app">Run the App Locally</a>
        </li>
        <li>
          <a href="#environment">Check Out the Environment</a>
        </li>
        <li>
          <a href="#conclusion">Phalcon and Nanobox</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Overview

[Nanobox](https://nanobox.io) is a portable, micro platform for developing and deploying apps. When working locally, Nanobox uses Docker to spin up and configure a virtual development environment configured to your specific needs. When you're ready to deploy to live servers, Nanobox will take that same environment and spin it up on your cloud provider of choice, where you can then manage and scale your app through the Nanobox dashboard.

In this post, we'll walk through getting a brand new Phalcon app up and running locally, with nothing installed other than Nanobox. First [create a free Nanobox account](https://dashboard.nanobox.io/users/register), then [download and run the Nanobox installer](https://dashboard.nanobox.io/download).

<a name='create-project'></a>

## Create a New Project

Create a project folder and `cd` into it:

```bash
mkdir nanobox-phalcon && cd nanobox-phalcon
```

<a name='boxfile-yml'></a>

## Add a `boxfile.yml`

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

- Use the PHP [engine](https://docs.nanobox.io/engines/), a set of scripts that build your app's runtime.
- Use PHP 7.1.
- Set the Apache document root to `public`.
- Include the Phalcon extension. *Nanobox takes a bare-bones approach to extensions, so you'll likely need to include other extensions. More information can be found [here](https://guides.nanobox.io/php/phalcon/php-extensions/).*
- Add a bash alias for Phalcon Devtools so you can just use the `phalcon` command.

<a name='add-devtools'></a>

## Add Phalcon Devtools to your `composer.json`

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

## Start Nanobox and Generate a New Phalcon App

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

<a name='run-app'></a>

## Run the App Locally

Before actually running your new Phalcon app, we recommend using Nanobox to add a DNS alias. This will add an entry to your local `hosts` file pointing to your dev environment and provide a convenient way to access your app from a browser.

```bash
nanobox dns add local phalcon.dev
```

Nanobox provides a `php-server` helper script that starts both Apache (or Nginx depending on your `boxfile.yml` config) and PHP. When passed with the `nanobox run` command, it will start the local dev environment and immediately run your app.

```bash
nanobox run php-server
```

Once running, you can visit your app at [phalcon.dev](http://phalcon.dev).

<a name='environment'></a>

## Check Out the Environment

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

## Phalcon and Nanobox

Nanobox gives you everything you need develop and run your Phalcon app in an isolated virtual environment. With the `boxfile.yml` in your project, collaborators can get up and running in minutes simply by running `nanobox run`.

Nanobox has a [Phalcon Quickstart](https://github.com/nanobox-quickstarts/nanobox-phalcon) that includes everything covered in this post. They also have as guides for [using Phalcon with Nanobox](https://guides.nanobox.io/php/phalcon/). In future posts, we'd like to cover other aspects of using Phalcon with Nanobox, including adding and connecting to a database, deploying Phalcon into production, etc. If you're interested [let us know on Twitter](http://twitter.com/nanobox_io).