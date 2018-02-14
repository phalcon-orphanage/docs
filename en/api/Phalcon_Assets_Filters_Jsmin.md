# Class **Phalcon\\Assets\\Filters\\Jsmin**

*implements* [Phalcon\Assets\FilterInterface](/[[language]]/[[version]]/api/Phalcon_Assets_FilterInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/assets/filters/jsmin.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Deletes the characters which are insignificant to JavaScript. Comments will be removed. Tabs will be
replaced with spaces. Carriage returns will be replaced with linefeeds.
Most spaces and linefeeds will be removed.


## Methods
public  **filter** (*mixed* $content)

Filters the content using JSMIN



