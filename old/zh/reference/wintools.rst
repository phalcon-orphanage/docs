Windows 系统下使用 Phalcon 开发工具（Phalcon Developer Tools on Windows）
=========================================================================

下面这些步骤将指导您在 windows 上完成安装 Phalcon 开发者工具。

预备知识（Prerequisites）
-------------------------
运行 Phalcon 工具必须先安装 PHP Phalcon 扩展包。如果您还没有安装，请参考安装指南 :doc:`Installation <install>`

下载（Download）
----------------
你可以从 Download_ 部分下载一个包含开发工具的跨平台软件包，你也可以从 Github_ 克隆。

在Windows平台下，你需要把 Phalcon 工具作为 PHP 可执行文件配置到系统路径。如果你下载了 Phalcon 工具的zip压缩文件，提取它到本地的任何路径，例如：*c:\\phalcon-tools*。你需要按照下面步骤继续操作。选择"phalcon.bat" 文件，鼠标右键"编辑"：

.. figure:: ../_static/img/path-0.png
   :align: center

把路径设为你安装 Phalcon 工具的路径（设置 PTOOLSPATH=C:\phalcon-tools\）：

.. figure:: ../_static/img/path-01.png
   :align: center

保存修改。

添加 PHP 以及工具所在路径到系统环境变量 PATH （Adding PHP and Tools to your system PATH）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
因为脚本是用PHP编写的，你需要在自己的机器上安装PHP。由于你安装了PHP，可执行文件可以位于不同的地方。搜索php.exe文件，复制它的路径。例如，如果你使用最新的 WAMP, PHP 的路径为： *C:\\wamp\bin\\php\\php5.3.10\\php.exe* 。

找到桌面的"计算机"图标，右键选择"属性"：

.. figure:: ../_static/img/path-1.png
   :align: center

选择"高级系统设置"，然后点击"环境变量"的按钮。

.. figure:: ../_static/img/path-2.png
   :align: center

找到"path"

.. figure:: ../_static/img/path-3.png
   :align: center

这一步要非常小心！你需要在很长的路径字符串找到 php.exe，在它后面添加 Phalcon 工具的路径。使用";"来分隔不同的路径。

.. figure:: ../_static/img/path-4.png
   :align: center

点击"确定"，然后关闭对话框。按"Windows Key" + "R"，键

.. figure:: ../_static/img/path-5.png
   :align: center

输入"cmd"，按回车键打开 windows 命令行程序：

.. figure:: ../_static/img/path-6.png
   :align: center

输入"php -v" 和 "phalcon"，然后你将看到类似下面的效果：

.. figure:: ../_static/img/path-7.png
   :align: center

祝贺你现在完成了Phalcon 工具的安装。

相关指南（Related Guides）
^^^^^^^^^^^^^^^^^^^^^^^^^^
* :doc:`Using Developer Tools <tools>`
* :doc:`Installation on OS X <mactools>`
* :doc:`Installation on Linux <linuxtools>`

.. _Download: http://phalconphp.com/download
.. _Github: https://github.com/phalcon/phalcon-devtools
