---
layout: default
language: 'fr-fr'
version: '4.0'
title: 'Environments - Devilbox'
keywords: 'environment, devilbox, docker'
---

# Environments

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Vue d'ensemble

The [Devilbox](https://devilbox.org) The Devilbox is a modern and highly customizable dockerized PHP stack supporting full LAMP and MEAN and running on all major platforms. The main goal is to easily switch and combine any version required for local development. It supports an unlimited number of projects for which vhosts, SSL certificates and DNS records are created automatically. Reverse proxies per project are supported to ensure listening server such as NodeJS can also be reached. Email catch-all and popular development tools will be at your service as well. Configuration is not necessary, as everything is already pre-setup.

Furthermore, the Devilbox provides an identical and reproducible development environment for different host operating systems.

This example will use `phalcon` to install Phalcon from within the Devilbox PHP container. After completing the steps listed below, you will have a working Phalcon setup ready to be served via http and https.

## Configuration

The following configuration will be used:

| Project name | `my-phalcon` | | VirtualHost directory | `/shared/httpd/my-phalcon` | | Database | n.a. | | `TLD_SUFFIX` | loc | | Project URL | `http://my-phalcon.loc`, `https://my-phalcon.loc` |

> * Inside the Devilbox PHP container, projects are always in `/shared/httpd/`.
> * On your host operating system, projects are by default in `./data/www/` inside the Devilbox git directory. This path can be changed via `HOST_PATH_HTTPD_DATADIR`.
{: .alert .alert-info }

## Activation

Your environment will be ready in six simple steps:

- Enter the PHP container
- Create a new VirtualHost directory
- Install Phalcon
- Symlink webroot directory
- Setup DNS record
- Visit `http://my-phalcon.loc` in your browser
- (Nginx) Create custom vhost config file

### Enter the PHP Container

All the work will be performed inside the PHP container since it offers all the necessary tools. Navigate to the Devilbox git directory and execute `./shell.sh` (or `shell.bat` on Windows) to enter the running PHP container.

```bash
host> ./shell.sh
```

### Create New Vhost Directory

The vhost directory defines the name under which your project will be available. (`<vhost dir>.TLD_SUFFIX` will be the final URL ).

```bash
devilbox@php-7.3 in /shared/httpd $ mkdir my-phalcon
```

### Install Phalcon

Navigate into your newly created vhost directory and install Phalcon with `phalcon` cli.

```bash
devilbox@php-7.3 in /shared/httpd $ cd my-phalcon
devilbox@php-7.3 in /shared/httpd/my-phalcon $ phalcon project phalconphp
```

The directory structure looks like this after the installation:

```bash
devilbox@php-7.3 in /shared/httpd/my-phalcon $ tree -L 1
.
└── phalconphp

1 directory, 0 files
```

### Symlink Webroot

Symlinking the actual webroot directory to `htdocs` is important. The web server expects every project's document root to be in `<vhost dir>/htdocs/`. This is the path where it will serve the files. This is also the path where the entry point of your application (usually `index.php`) needs to reside.

Some frameworks however, store files and content in nested directories of unknown levels. It is therefore impossible to set this as a pre-set for the environment. You will therefore have to manually set a symlink back to the expected path that your framework requires.

```bash
devilbox@php-7.3 in /shared/httpd/my-phalcon $ ln -s phalconphp/public/ htdocs
```

The directory structure looks like this after the installation:

```bash
devilbox@php-7.3 in /shared/httpd/my-phalcon $ tree -L 1
.
├── phalconphp
└── htdocs -> phalconphp/public

2 directories, 0 files
```

As you can see in the above listing, the `htdocs` folder that is required by the web server is now pointing to the entry point of your framework.

> **NOTE**: When using **Docker Toolbox**, you need to **explicitly allow** the usage of **symlinks**.
{: .alert .alert-warning }

### DNS Record

If you **have** Auto DNS configured already, you can skip this section, because DNS entries will be available automatically by the bundled DNS server.

If you **do not have** Auto DNS configured, you will need to add the following line to your host operating system `/etc/hosts` file (or `C:\Windows\System32\drivers\etc` on Windows):

```bash
127.0.0.1 my-phalcon.loc
```

### Open your Browser

Open your browser and navigate to `http://my-phalcon.loc` or `https://my-phalcon.loc`

### Create Custom Vhost Config File (Nginx Only)

By default routes will not work if using Nginx. To fix this, you will need to create a custom vhost configuration.

In your project folder, you will need to create a folder called `.devilbox` unless you changed `HTTPD_TEMPLATE_DIR` in your `.env`

Copy the default nginx config from `./cfg/vhost-gen/nginx.yml-example-vhost` to `./data/www/my-project/.devilbox/nginx.yml`

Carefully edit the nginx.yml file and change:

`try_files $uri $uri/ /index.php$is_args$args;`

to

`try_files $uri $uri/ /index.php?_url=$uri&$args;`

and

`location ~ \.php?$ {`

to

`location ~ [^/]\.php(/|$) {`

Save the file as `nginx.yml` and ensure not to use any tabs in the file or devilbox will not use the custom configuration. You can use `yamllint nginx.yml` whilst inside the Devilbox shell to check the file before restarting devilbox.

## References

- [Devilbox.com](https://devilbox.org)
- [Devilbox Documentation](https://devilbox.readthedocs.io/en/latest/examples/setup-phalcon.html)
- [HOST_PATH_HTTPD_DATADIR](https://devilbox.readthedocs.io/en/latest/configuration-files/env-file.html#env-httpd-datadir)
- [Enter the PHP container](https://devilbox.readthedocs.io/en/latest/getting-started/enter-the-php-container.html#enter-the-php-container) 
- [Work inside the PHP container](https://devilbox.readthedocs.io/en/latest/intermediate/work-inside-the-php-container.html#work-inside-the-php-container)
- [Available tools](https://devilbox.readthedocs.io/en/latest/readings/available-tools.html#available-tools) 
- [TLD_SUFFIX](https://devilbox.readthedocs.io/en/latest/configuration-files/env-file.html#env-tld-suffix)
- [Docker Toolbox and Symlinks](https://devilbox.readthedocs.io/en/latest/howto/docker-toolbox/docker-toolbox-and-the-devilbox.html#howto-docker-toolbox-and-the-devilbox-windows-symlinks)
- [Add project hosts entry on MacOS](https://devilbox.readthedocs.io/en/latest/howto/dns/add-project-dns-entry-on-mac.html#howto-add-project-hosts-entry-on-mac)
- [Add project hosts entry on Windows](https://devilbox.readthedocs.io/en/latest/howto/dns/add-project-dns-entry-on-win.html#howto-add-project-hosts-entry-on-win)
- [Setup Auto DNS](https://devilbox.readthedocs.io/en/latest/intermediate/setup-auto-dns.html#setup-auto-dns)