<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
	<META HTTP-EQUIV="CONTENT-TYPE" CONTENT="text/html; charset=utf-8">
	<TITLE></TITLE>
	<META NAME="GENERATOR" CONTENT="LibreOffice 4.0.2.2 (Linux)">
	<META NAME="CREATED" CONTENT="0;0">
	<META NAME="CHANGEDBY" CONTENT="Rodrigo Emygdio">
	<META NAME="CHANGED" CONTENT="20130807;6501200">
	<META NAME="CHANGEDBY" CONTENT="Rodrigo Emygdio">
</HEAD>
<BODY LANG="pt-BR" DIR="LTR">
<P STYLE="margin-bottom: 0cm">Instalação no XAMPP</P>
<P STYLE="margin-bottom: 0cm">=====================</P>
<P STYLE="margin-bottom: 0cm">XAMPP_ é uma distribuição Apache
fácil de instalar contendo MySQL, PHP e Perl. Uma vez feito o
download do XAMPP, tudo que você precisa fazer é extrair-lo e
começar a usa-lo. Abaixo existem instruções detalhadas de como
instalar o Phalcon no XAMPP para o Windows. É fortemente
recomendável utilizar a última versão do XAMPP.</P>
<P STYLE="margin-bottom: 0cm"><BR>
</P>
<P STYLE="margin-bottom: 0cm">Download da versão certa do Phalcon</P>
<P STYLE="margin-bottom: 0cm">-------------------------------------</P>
<P STYLE="margin-bottom: 0cm">XAMPP sempre é lançado para versões
32 bit do Apache e do PHP. Você precisará fazer o download da
versão x86 do Phalcon para o Windows, na seção de download.</P>
<P STYLE="margin-bottom: 0cm"><BR>
</P>
<P STYLE="margin-bottom: 0cm">Após o download da biblioteca do
Phalcon, você terá um arquivo zip como o da figura abaixo:</P>
<P STYLE="margin-bottom: 0cm"><BR>
</P>
<P STYLE="margin-bottom: 0cm">.. figure:: ../_static/img/xampp-1.png</P>
<P STYLE="margin-bottom: 0cm">:align: center</P>
<P STYLE="margin-bottom: 0cm"><BR>
</P>
<P STYLE="margin-bottom: 0cm">Extraia a biblioteca DLL do phalcon do
arquivo zip: 
</P>
<P STYLE="margin-bottom: 0cm"><BR>
</P>
<P STYLE="margin-bottom: 0cm">.. figure:: ../_static/img/xampp-2.png</P>
<P STYLE="margin-bottom: 0cm">:align: center</P>
<P STYLE="margin-bottom: 0cm"><BR>
</P>
<P STYLE="margin-bottom: 0cm">Copie o arquivo php_phalcon.dll para o
diretório de extensões do PHP. Se você tiver o XAMPP instalado no
c:\\xampp, a extensão precisa estar no c:\\xampp\\php\\ext. 
</P>
<P STYLE="margin-bottom: 0cm"><BR>
</P>
<P STYLE="margin-bottom: 0cm">.. figure:: ../_static/img/xampp-3.png</P>
<P STYLE="margin-bottom: 0cm">:align: center</P>
<P STYLE="margin-bottom: 0cm"><BR>
</P>
<P STYLE="margin-bottom: 0cm">Edite o arquivo php.ini localizado no
diretório <FONT FACE="Lohit Hindi"><SPAN LANG="hi-IN"><FONT FACE="Lohit Hindi"><SPAN LANG="hi-IN">﻿</SPAN></FONT></SPAN></FONT>C:<A HREF="smb://xampp//php//php.ini">\\xampp\\php\\php.ini</A>.
Esse arquivo pode ser editado com o Notepad ou outro programa
similar. Nós recomendamos o Notepad++ para evitar problemas com
caracteres de controle de final de linha. Acrescente no final do
arquivo a seguinte instrução: extension=php_phalcon.dll e salve-o.</P>
<P STYLE="margin-bottom: 0cm"><BR>
</P>
<P STYLE="margin-bottom: 0cm">.. figure:: ../_static/img/xampp-4.png</P>
<P STYLE="margin-bottom: 0cm">:align: center</P>
<P STYLE="margin-bottom: 0cm"><BR>
</P>
<P STYLE="margin-bottom: 0cm">Reinicie o servidor web Apache
diretamente do Centro de Controle do XAMPP. Desta forma irá carregar
as novas configurações do PHP (a nova extensão instalada).</P>
<P STYLE="margin-bottom: 0cm"><BR>
</P>
<P STYLE="margin-bottom: 0cm">.. figure:: ../_static/img/xampp-5.png</P>
<P STYLE="margin-bottom: 0cm">:align: center</P>
<P STYLE="margin-bottom: 0cm"><BR>
</P>
<P STYLE="margin-bottom: 0cm">Abra o browser e navegue até o
endereço <A HREF="http://localhost/">http://localhost</A>. A pagina
de boas vindas do XAMPP será mostrada. Clique no link phpinfo().</P>
<P STYLE="margin-bottom: 0cm"><BR>
</P>
<P STYLE="margin-bottom: 0cm">.. figure:: ../_static/img/xampp-6.png</P>
<P STYLE="margin-bottom: 0cm">:align: center</P>
<P STYLE="margin-bottom: 0cm"><BR>
</P>
<P STYLE="margin-bottom: 0cm">phpinfo() ira mostrar na tela um numero
significante de informações a respeito do estado atual do PHP. Role
a tela para baixo, verificando se a extensão do phalcon foi
carregada corretamente. 
</P>
<P STYLE="margin-bottom: 0cm"><BR>
</P>
<P STYLE="margin-bottom: 0cm">.. figure:: ../_static/img/xampp-7.png</P>
<P STYLE="margin-bottom: 0cm">:align: center</P>
<P STYLE="margin-bottom: 0cm"><BR>
</P>
<P STYLE="margin-bottom: 0cm">Se você conseguir ver o phalcon na
saída do phpinfo(), parabéns! Agora você esta voando com o
Phalcon.</P>
<P STYLE="margin-bottom: 0cm"><BR>
</P>
<P STYLE="margin-bottom: 0cm">Screencast</P>
<P STYLE="margin-bottom: 0cm">----------</P>
<P STYLE="margin-bottom: 0cm">O seguinte screencast é um guia
passo-a-passo para instalação do Phalcon no Windows:</P>
<P STYLE="margin-bottom: 0cm"><BR>
</P>
<P STYLE="margin-bottom: 0cm">.. raw:: html</P>
<P STYLE="margin-bottom: 0cm"><BR>
</P>
<P STYLE="margin-bottom: 0cm">&lt;div align=&quot;center&quot;&gt;&lt;iframe
src=&quot;http://player.vimeo.com/video/40265988&quot; width=&quot;500&quot;
height=&quot;266&quot; frameborder=&quot;0&quot;
webkitAllowFullScreen mozallowfullscreen
allowFullScreen&gt;&lt;/iframe&gt;&lt;/div&gt;</P>
<P STYLE="margin-bottom: 0cm"><BR>
</P>
<P STYLE="margin-bottom: 0cm">Related Guides</P>
<P STYLE="margin-bottom: 0cm">--------------</P>
<P STYLE="margin-bottom: 0cm">* :doc:`General Installation
&lt;/reference/install&gt;`</P>
<P STYLE="margin-bottom: 0cm">* :doc:`Detailed Installation on WAMP
for Windows &lt;/reference/wamp&gt;`</P>
<P STYLE="margin-bottom: 0cm"><BR>
</P>
<P STYLE="margin-bottom: 0cm">.. _XAMPP:
http://www.apachefriends.org/en/xampp-windows.html</P>
</BODY>
</HTML>