---
layout: article
language: 'en'
version: '4.0'
---
##### This article reflects v3.4 and has not yet been revised
{:.alert .alert-danger}

<a name='overview'></a>
# Overview
Phalcon Box uses the default **phalcon/xenial64** box from [Vagrant Cloud](https://atlas.hashicorp.com/phalconphp/boxes/xenial64/) for compatibility. If you choose to use a 64-bit ISO you may need to update your BIOS to enable [virtualization](https://en.wikipedia.org/wiki/X86_virtualization) with `AMD-V`, `Intel VT-x` or `VIA VT`.

The first time that you provision a new environment with `vagrant up`, the process will take a lot longer since the box (`phalconphp/xenial64`) will have to be downloaded to your local machine first. Any subsequent environment provisions will be much faster.

<a name='requirements'></a>
## Requirements
* Operating System: Windows, Linux, or macOS
* [Virtualbox](https://www.virtualbox.org/wiki/Downloads) >= 5.1 (if you want to build the VirtualBox box)
* [VMware Fusion](https://www.vmware.com/products/fusion) (or Workstation - if you want to build the VMware box)
* [Vagrant](https://www.vagrantup.com/downloads.html) >= 1.9.8

<a name='packages-included'></a>
## Packages Included
* Ansible
* Beanstalkd
* Blackfire
* Composer
* Git
* goreplace
* Mailhog
* Memcached
* MongoDB
* MySQL
* Nginx
* Ngrok
* Node.js (with Yarn, Bower, Grunt, and Gulp)
* PHIVE
* PHP 7.1
* PHPMD
* PHP_CodeSniffer
* Phalcon
* Phing
* PostgreSQL
* Redis
* Sqlite3
* Ubuntu 16.04
* Zephir

<a name='installation'></a>
## Installation
<a name='installation-vagrant-box'></a>
### Installing the Vagrant Box
Before launching your Phalcon Box environment, you must install VirtualBox, or VMWare as well as Vagrant. All of these software packages provide easy-to-use visual installers for all popular operating systems.

Once VirtualBox/VMWare and Vagrant have been installed, you should add the `phalconphp/xenial64` box to your Vagrant installation using the following command in your terminal. It will take a few minutes to download the box, depending on your Internet connection speed:

```bash
vagrant box add phalconphp/xenial64
```

If this command fails, make sure your Vagrant installation is up to date.

<h5 class='alert alert-warning' markdown='1'>To use the VMware provider, you will need to purchase both VMware Fusion / Workstation and the [VMware Vagrant plug-in](https://www.vagrantup.com/vmware). Though it is not free, VMware can provide faster shared folder performance out of the box.  </h5>

<a name='installation-phalcon-box'></a>
### Installing the Phalcon Box
You can install Phalcon Box by simply cloning the repository. Consider cloning the repository into a `workspace` folder within your `home` directory, as the Phalcon Box box will serve as the host to all of your Phalcon projects:

```bash
cd ~
git clone https://github.com/phalcon/box.git workspace
```

The `master` branch will always contain the latest stable version of Phalcon Box. If you wish to check older versions or newer ones currently under development, please switch to the relevant branch/tag.

You can find the latest stable version on the [Github Release Page](https://github.com/phalcon/box/releases):

```bash
# Clone the desired release...
git checkout v2.4.0
```

Once you have cloned the Phalcon Box repository, run the install command from the Phalcon Box root directory to create the `settings.yml` configuration file. The `settings.yml` file will be placed in the Phalcon Box directory:

```bash
# macOS || Linux
./install
```

```cmd
rem Windows
install.bat
```

Now you are ready to provision your Virtual Machine, run:

```bash
vagrant up
```

<a name='installation-configuration'></a>
## Configuring
<a name='installation-configuration-setting-provider'></a>
### Setting your provider
The provider key in your `settings.yml` file indicates which Vagrant provider should be used: `virtualbox`, `vmware_fusion` or `vmware_workstation`. You may set this to the provider you prefer:

```yaml
provider: virtualbox
```

<a name='installation-configuration-memory-cpu'></a>
### Memory and CPU
By default this setup uses 2GB RAM. You can change this in `settings.yml` and simply run `vagrant reload`:

```yaml
memory: 4096
```

You can also use more than one core if you like, simply change this line in the same file:

```yaml
cpus: 4
```

<a name='installation-configuration-shared-folders'></a>
### Shared folders
The `folders` property of the `settings.yml` file lists all of the folders you wish to share with your Phalcon Box environment. As files within these folders are changed, they will be kept in sync between your local machine and the Phalcon Box environment. You may configure as many shared folders as necessary:

```yaml
folders:
    - map: ~/workspace
      to: /home/vagrant/workspace
```

To enable [NFS](https://www.vagrantup.com/docs/synced-folders/nfs.html), just add a simple flag to your synced folder configuration:

```yaml
folders:
    - map: ~/workspace
      to: /home/vagrant/workspace
      type: "nfs"
```

You may also pass any options supported by Vagrant's [Synced Folders](https://www.vagrantup.com/docs/synced-folders/basic_usage.html) by listing them under the `options` key:

```yaml
folders:
    - map: ~/workspace
      to: /home/vagrant/workspace
      type: "nfs"
      options:
            rsync__args: ["--verbose", "--archive", "--delete", "-zz"]
            rsync__exclude: ["node_modules"]
```

<h5 class='alert alert-danger' markdown='1'>macOS users probably will need to install `vagrant-bindfs` plugin to fix shared folder (NFS) permission issue: </h5>

```bash
vagrant plugin install vagrant-bindfs
```

<a name='installation-configuration-nginx'></a>
### Nginx sites
The `sites` property allows you to easily map a "domain" to a folder on your Phalcon Box environment. A sample site configuration is included in the `settings.yml` file. You may add as many sites to your Phalcon Box environment as necessary. Phalcon Box can serve as a convenient, virtualized environment for every Phalcon project you are working on:

```yaml
sites:
    - map: phalcon.local
      to:  /home/vagrant/workspace/phalcon/public
```

You can use the `type` parameter to specify the type of Nginx configuration for the site. For example:

```yaml
sites:
    - map:  landing.local
      to:   /home/vagrant/workspace/landing/public
      type: spa
```

The default type is `phalcon`. If the desired type is not allowed or not available `phalcon` will be used as fallback.

Available types:

* `phalcon`
* `slayer`
* `phanbook`
* `proxy`
* `spa`
* `silverstripe`
* `symfony2`
* `statamic`
* `laravel`
* `zend`

Feel free to suggest a new type of Nginx configuration [through opening a New Feature Request](https://github.com/phalcon/box/issues/new).

<h5 class='alert alert-warning' markdown='1'>If you change the `sites` property after provisioning the Phalcon Box, you must re-run `vagrant reload --provision` to update the Nginx configuration on the virtual machine. </h5>

<a name='installation-configuration-custom-nginx'></a>
#### Custom Nginx configuration

You can also create your own type. To do this take any template from the `provisioning/templates/nginx` folder as a basis and make the necessary changes. You need to place this file into the same folder. After that, you will be able to use your own custom type:

```yaml
sites:
    - map:  my-site.local
      to:   /home/vagrant/workspace/my-site/public
      # provisioning/templates/nginx/phalcon-advanced.conf.j2
      type: phalcon-advanced
```

Do you need a custom _global_ Nginx configuration? Yes, this is possible. Fox example, let's create the autoindex configuration.

File `/home/user/nginx.d/00-autoindex.conf`:

```nginx
# Processes requests ending with the slash character (‘/’) and produces a directory listing
autoindex on;
```

Add the desired settings to your file and then add it to the `copy` section:

```yaml
copy:
    - from: /home/user/nginx.d/00-autoindex.conf
      to: /etc/nginx/conf.d/
```

<a name='installation-configuration-hosts'></a>
#### Configuring the `hosts` file
You must add the "domains" for your Nginx sites to the hosts file on your machine. The hosts file will redirect requests for your Phalcon sites into your Phalcon Box machine. On Mac and Linux, this file is located at `/etc/hosts`. On Windows, it is located at `C:\Windows\System32\drivers\etc\hosts`. The lines you add to this file will look like the following:

```
192.168.50.4  phalcon.local
```

Make sure the IP address listed is the one set in your `settings.yml` file. Once you have added the domain to your `hosts` file and launched the Vagrant box you will be able to access the site via your web browser:

```
https://phalcon.local
```

<h5 class='alert alert-danger' markdown='1'>To enable adding new sites to the `hosts` file automatically use `vagrant-hostsupdater` plugin: </h5>

```bash
vagrant plugin install vagrant-hostsupdater
```

<a name='installation-aditional-packages'></a>
### Install additional packages

We did our best to provide Phalcon Box with all necessary programs and libraries. However, it should be understood that the typical user does not need all possible packages which can be installed. Phalcon Box must be of reasonable size so that it could be used by even those people who are experiencing difficulties with bandwidth of the Internet channel.

Because of these considerations, we allow users to specify which custom packages they need by every provision. To install the necessary packages add their names in the `apt` section:

```yaml
# Provisioning features
provision:
    # do full system update for each full provisoning
    update: true

    # Install wkhtmltopdf and libffi-dev packages
    apt:
        - wkhtmltopdf
        - libffi-dev
```

<a name='installation-launching-phalcon-box'></a>
### Launching the Phalcon Box
Once you have edited the `settings.yml` to your liking, run the `vagrant up` command from your Phalcon Box directory (for example `$HOME/workspace`). Vagrant will boot the virtual machine and automatically configure your shared folders and Nginx sites.

To destroy the machine, you may use the `vagrant destroy --force` command.

<a name='daily-usage'></a>
## Daily usage
<a name='daily-usage-accessing-box-globally'></a>
### Accessing Phalcon Box globally
Sometimes you may want to `vagrant up` your Phalcon Box machine from anywhere on your filesystem. You can do this on Mac or Linux systems by adding a [Bash function](https://tldp.org/HOWTO/Bash-Prog-Intro-HOWTO-8.html) to your Bash profile. On Windows, you may accomplish this by adding a "batch" file to your `PATH`. These scripts will allow you to run any Vagrant command from anywhere on your system and will automatically point that command to your Phalcon Box installation:

<a name='daily-usage-accessing-box-globally-mac-linux'></a>
#### Mac || Linux

```bash
function box()
{
    ( cd $HOME/workspace && vagrant $* )
}
```

<h5 class='alert alert-warning' markdown='1'>Make sure to tweak the `$HOME/workspace` path in the function to the location of your actual Phalcon Box installation. Once the function is installed, you may run commands like `box up` or `box ssh` from anywhere on your system. </h5>

<a name='daily-usage-accessing-box-globally-windows'></a>
#### Windows
Create a `box.bat` batch file anywhere on your machine with the following contents:

```cmd
@echo off

set cwd=%cd%
set box=C:\workspace

cd /d %box% && vagrant %*
cd /d %cwd%

set cwd=
set box=
```

<h5 class='alert alert-warning' markdown='1'>Make sure to tweak the example `C:\workspace` path in the script to the actual location of your Phalcon Box installation. After creating the file, add the file location to your `PATH`. You may then run commands like `box up` or `box ssh` from anywhere on your system. </h5>

<a name='daily-usage-ssh'></a>
### Connecting via SSH
You can SSH into your virtual machine by issuing the `vagrant ssh` terminal command from your Phalcon Box directory.

But, since you will probably need to SSH into your Phalcon Box machine frequently, consider adding the "function" [described above](#daily-usage-accessing-box-globally) to your host machine to quickly SSH into the Phalcon Box.

<a name='daily-usage-databases'></a>
### Connecting to databases

To connect to your MySQL, Postgres or MongoDB database from your host machine's database client, you should connect to `127.0.0.1` and port `33060` (MySQL), `54320` (Postgres) or `27017` (MongoDB). The username and password for databases is `phalcon` / `secret`.

<h5 class='alert alert-danger' markdown='1'>You should only use these non-standard ports when connecting to the databases from your host machine. You will use the default `3306` and `5432` ports in your Phalcon database configuration file since Phalcon is running within the Virtual Machine. </h5>

To access to the interactive db console from Phalcon Box type:

- **Postgres:** `psql -U phalcon -h localhost` (password `secret`)
- **MySQL:** `mysql` (password not needed for CLI tool)
- **MongoDB:** `mongo` (password not needed for CLI tool)

<a name='daily-usage-additional-sites'></a>
### Adding additional sites
Once your Phalcon Box environment is provisioned and running, you may want to add additional Nginx sites for your applications. You can run as many Phalcon projects as you wish on a single Phalcon Box environment. To add an additional site, simply add the site to your `settings.yml` file:

```yaml
sites:
    - map: phalcon.local
      to:  /home/vagrant/workspace/phalcon/public
    - map: pdffiller.local
      to:  /home/vagrant/workspace/pdffiller/public
    - map: blog.local
      to:  /home/vagrant/workspace/blog/public
```

If Vagrant is not managing your "hosts" file automatically, you may need to add the new site to that file as well:

```
192.168.50.4  phalcon.local
192.168.50.4  pdffiller.local
192.168.50.4  blog.local
```

<h5 class='alert alert-danger' markdown='1'>To enable adding new sites to the `hosts` file automatically use `vagrant-hostsupdater` plugin: </h5>

```bash
vagrant plugin install vagrant-hostsupdater
```

Once the site has been added, run the `vagrant reload --provision` command from your Phalcon Box directory.

<a name='daily-usage-environment-variables'></a>
### Environment variables
<a name='daily-usage-environment-global-variables'></a>
#### Global variables
You can easily register global environment variables. Just add variable and its value to the `variables` section:
```yaml
variables:
    - key: TEST_DB_MYSQL_USER
      value: phalcon

    - key: TEST_DB_MYSQL_PASSWD
      value: secret

    - key: TEST_DB_MYSQL_DSN
      value: "mysql:host=127.0.0.1;dbname=phalcon_test"
```

This way you will be able to use these variables in your applications or scripts. For example when configuring [Codeception](https://codeception.com) in such way:

```yaml
# File codeception.yml
params:
    # Get params from environment
    - env
```

you will able to configure Unit suite as follows:

```yaml
# File tests/unit.suite.yml
class_name: UnitTester
modules:
    enabled:
        - Db
    config
        Db:
            dsn: %TEST_DB_MYSQL_DSN%
            user: %TEST_DB_MYSQL_USER%
            password: %TEST_DB_MYSQL_PASSWD%
            populate: true
            cleanup: false
            dump: tests/_data/schemas/mysql/mysql.dump.sql
```

<a name='daily-usage-environment-site-variables'></a>
#### Site variables
Site variables are how you can easily add `fastcgi_param` values to your site host configuration within Phalcon Box. For example, we may add a `APP_ENV` variable with the value `development`:

```yaml
sites:
    - map: phalconbox.local
      to: /var/www/phalconbox/public
      variables:
          - key: APP_ENV
            value: development
          # Yet another example
          - key: AMQP_DEBUG
            value: true
```

<a name='daily-usage-ports'></a>
### Ports
By default, the following ports are forwarded to your Phalcon Box environment:

| Forwarded port | Phalcon Box | Host system |
|----------------|:-----------:|:-----------:|
| **SSH**        | `22`        | `2222`      |
| **HTTP**       | `80`        | `8000`      |
| **HTTPS**      | `443`       | `44300`     |
| **MySQL**      | `3306`      | `33060`     |
| **Postgres**   | `5432`      | `54320`     |
| **MailHog**    | `8025`      | `8025`      |

<a name='daily-usage-ports-forwarding'></a>
#### Forwarding additional ports
If you wish, you may forward additional ports to the Phalcon Box, as well as specify their protocol:

```yaml
ports:
    - send: 63790
      to: 6379
    - send: 50000
      to: 5000
    - send: 7777
      to: 777
      protocol: udp
```

<a name='daily-usage-sharing-environment'></a>
### Sharing your environment
Sometimes you may wish to share what you're currently working on with coworkers or a client. Vagrant has a built-in way to support this via `vagrant share`; however, this will not work if you have multiple sites configured in your `settings.yml` file.

To solve this problem, Phalcon Box includes its own `share` command. To get started, SSH into your Phalcon Box machine via `vagrant ssh` and run `share <your-site-here>`, for example: `share blog.local`. This will share your site from your `settings.yml` configuration file. Of course, you may substitute any of your other configured sites for `blog.local`:

```bash
share blog.local
```

After running the command, you will see an [Ngrok](https://ngrok.com) screen appear which contains the activity log and the publicly accessible URLs for the shared site. If you would like to specify a custom region, subdomain, or other Ngrok runtime option, you may add them to your `share` command:

```bash
share blog.local -region=eu -subdomain=phalcongelist
```

<h5 class='alert alert-danger' markdown='1'>Vagrant is inherently insecure and you are exposing your virtual machine to the Internet when running the `share` command. </h5>

<a name='daily-usage-network-interfaces'></a>
### Network interfaces
The `networks` property of the `settings.yml` configures network interfaces for your Phalcon Box environment. You may configure as many interfaces as necessary:

```yaml
networks:
    - type: "private_network"
      ip: "192.168.50.99"
```

To enable a [bridged](https://www.vagrantup.com/docs/networking/public_network.html) interface, configure a `bridge` setting and change the network type to `public_network`:

```yaml
networks:
    - type: "private_network"
      ip: "192.168.50.99"
      bridge: "en1: Wi-Fi (AirPort)"
```

To enable [DHCP](https://www.vagrantup.com/docs/networking/public_network.html), just remove the `ip` option from this configuration:

```yaml
networks:
    - type: "private_network"
      bridge: "en1: Wi-Fi (AirPort)"
```

<a name='daily-usage-updating-box'></a>
### Updating Phalcon Box
You can update Phalcon Box in two simple steps.

1. First, you will need to update the Vagrant box using the `vagrant box update` command:
```bash
vagrant box update
```
2. Next, you need to update the Phalcon Box source code. If you cloned the repository you can simply
```bash
git pull origin master
```
at the location you originally cloned the repository.

The new version of Phalcon Box will contain updated or amended configuration files:
* `settings.yml`
* `.bash_aliases`
* `after_provision.sh`

When you run the command `./install` (or `install.bat`) the Phalcon Box creates these files in the root directory. However, if the files already exist, they will not be overwritten.

We recommend that you always take backups of those files, and remove them from the project so that the new updated ones can be copied over. You can then compare your own files with the phalcon box ones to apply your personalized changes and take advantage of the new features offered by the update.

<a name='daily-usage-provider-settings'></a>
### Provider specific settings
<a name='daily-usage-provider-settings-virtualbox'></a>
#### VirtualBox
By default, Phalcon Box configures the `natdnshostresolver` setting to `on`. This allows Phalcon Box to use your host operating system's DNS settings. If you would like to override this behavior, add the following lines to your `settings.yml` file:

```yaml
natdnshostresolver: off
```

<a name='daily-usage-mail-catcher'></a>
### Mail catcher
By default, Phalcon Box redirects all PHP emails to [MailHog](https://github.com/mailhog/MailHog) (instead of sending them to the outside world). You can access the MailHog UI at `https://localhost:8025/` (or whatever domain you have configured in `settings.yml`).

<a name='troubleshooting'></a>
## Troubleshooting

**Problem:**

> An error occurred in the underlying SSH library that Vagrant uses.
  The error message is shown below. In many cases, errors from this
  library are caused by ssh-agent issues. Try disabling your SSH
  agent or removing some keys and try again.
  If the problem persists, please report a bug to the net-ssh project.
  timeout during server version negotiating

**Solution:**

```bash
vagrant plugin install vagrant-vbguest
```

**Problem:**

> Vagrant was unable to mount VirtualBox shared folders. This is usually
  because the filesystem "vboxsf" is not available. This filesystem is
  made available via the VirtualBox Guest Additions and kernel module.
  Please verify that these guest additions are properly installed in the
  guest. This is not a bug in Vagrant and is usually caused by a faulty
  Vagrant box. For context, the command attempted was:
>
> mount -t vboxsf -o uid=900,gid=900 vagrant /vagrant

**Solution:**

```bash
vagrant plugin install vagrant-vbguest
```

**Problem:**

> There was an error while executing `VBoxManage`, a CLI used by Vagrant
  for controlling VirtualBox. The command and stderr is shown below.
>
> Command: `["startvm", "9d2b95e1-0fdd-40f4-ad65-4b56eb4315f8", "--type", "headless"]`
>
> Stderr: VBoxManage.exe: error: VT-x is not available (VERR_VMX_NO_VMX)
  VBoxManage.exe: error: Details: code E_FAIL (0x80004005), component ConsoleWrap, interface IConsole

**Solution:**

You need to update your BIOS to enable [virtualization](https://en.wikipedia.org/wiki/X86_virtualization) with `Intel VT-x`.
