---
layout: article
language: 'en'
version: '4.0'
category: 'installation'
---
# Installation
<hr/>

## Windows
To use Phalcon on Windows, you will need to install the phalcon.dll. We have compiled several DLLs depending on the target platform. The DLLs can be found in our [download][download] page.

Identify your PHP installation as well as architecture. If you download the wrong DLL, Phalcon will not work. `phpinfo()` contains this information. In the example below, we will need the NTS version of the DLL:

![phpinfo](/assets/images/content/phpinfo-api.png)

The available DLLs are:

| Architecture | Version | Type                  |
| :----------: | :-----: |---------------------- |
| x64          | 7.x     | Thread safe           |
| x64          | 7.x     | Non Thread safe (NTS) |
| x86          | 7.x     | Thread safe           |
| x86          | 7.x     | Non Thread safe (NTS) |

Edit your php.ini file and then append at the end:

```ini
extension=php_phalcon.dll
```

Restart your webserver.

[download]: https://phalconphp.com/en/download/windows
