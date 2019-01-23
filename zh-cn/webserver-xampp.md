---
layout: article
language: 'zh-cn'
version: '4.0'
---
##### This article reflects v3.4 and has not yet been revised

{:.alert .alert-danger}

<a name='overview'></a>

# 在XAMPP中安装Phalcon扩展

[XAMPP](https://www.apachefriends.org/download.html) is an easy to install Apache distribution containing MySQL, PHP and Perl. Once you download XAMPP, all you have to do is extract it and start using it. Below are detailed instructions on how to install Phalcon on XAMPP for Windows. Using the latest XAMPP version is highly recommended.

<a name='phalcon'></a>

## 下载正确版本的Phalcon扩展。

XAMPP is always releasing 32 bit versions of Apache and PHP. You will need to download the x86 version of Phalcon for Windows from the download section.

当下载Phalcon扩展完成后，会得到一个如下所示的zip包。

![](/assets/images/content/webserver-xampp-1.png)

解压zip包，会有一个Phalcon DLL文件。

![](/assets/images/content/webserver-xampp-2.png)

Copy the file `php_phalcon.dll` to the PHP extensions directory. If you have installed XAMPP in the `C:\xampp` folder, the extension needs to be in `C:\xampp\php\ext`

![](/assets/images/content/webserver-xampp-3.png)

Edit the `php.ini` file, it is located at `C:\xampp\php\php.ini`. 你可以使用Notepad或者其他类似文件编辑器进行修改。 We recommend [Notepad++](https://notepad-plus-plus.org/) to avoid issues with line endings. 在文件末尾追加：

```ini
extension=php_phalcon.dll
```

保存所修改的。

![](/assets/images/content/webserver-xampp-4.png)

Restart the Apache Web Server from the XAMPP Control Center. This will load the new PHP configuration.

![](/assets/images/content/webserver-xampp-5.png)

Open your browser to navigate to `https://localhost`. The XAMPP welcome page will appear. Click on the link `phpinfo()`.

![](/assets/images/content/webserver-xampp-6.png)

[phpinfo](https://php.net/manual/en/function.phpinfo.php) will output a significant amount of information on screen about the current state of PHP. Scroll down to check if the phalcon extension has been loaded correctly.

![](/assets/images/content/webserver-xampp-7.png)

If you can see the phalcon version in the `phpinfo()` output, congratulations!, You are now phlying with Phalcon.

<a name='screencast'></a>

## 安装过程截图

The following screencast is a step by step guide to install Phalcon on Windows:

<div align="center">
  <iframe src="https://player.vimeo.com/video/40265988" 
          width="500" 
          height="266" 
          frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen>
  </iframe>
</div>

<a name='related'></a>

## 相关指引

* [General Installation](/4.0/en/installation)
* [在WAMP集成环境中安装Phalcon](/4.0/en/webserver-wamp)