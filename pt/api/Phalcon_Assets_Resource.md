<h1>Class <strong>Phalcon\\Assets\\Resource</strong></h1>

<p><em>implements</em> <a href="/en/3.2/api/Phalcon_Assets_ResourceInterface">Phalcon\Assets\ResourceInterface</a></p>

<p><a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/assets/resource.zep" class="btn btn-default btn-sm" mark="crwd-mark">Source on GitHub</a></p>

<p>Represents an asset resource</p>

<pre><code class="php">&lt;?php

$resource = new \Phalcon\Assets\Resource("js", "javascripts/jquery.js");

</code></pre>

<h2>Methods</h2>

<p>public  <strong>getType</strong> ()</p>

<p>public  <strong>getPath</strong> ()</p>

<p>public  <strong>getLocal</strong> ()</p>

<p>public  <strong>getFilter</strong> ()</p>

<p>public  <strong>getAttributes</strong> ()</p>

<p>public  <strong>getSourcePath</strong> ()</p>

<p>...</p>

<p>public  <strong>getTargetPath</strong> ()</p>

<p>...</p>

<p>public  <strong>getTargetUri</strong> ()</p>

<p>...</p>

<p>public  <strong>__construct</strong> (<em>string</em> $type, <em>string</em> $path, [<em>boolean</em> $local], [<em>boolean</em> $filter], [<em>array</em> $attributes])</p>

<p>Phalcon\\Assets\\Resource constructor</p>

<p>public  <strong>setType</strong> (<em>mixed</em> $type)</p>

<p>Sets the resource's type</p>

<p>public  <strong>setPath</strong> (<em>mixed</em> $path)</p>

<p>Sets the resource's path</p>

<p>public  <strong>setLocal</strong> (<em>mixed</em> $local)</p>

<p>Sets if the resource is local or external</p>

<p>public  <strong>setFilter</strong> (<em>mixed</em> $filter)</p>

<p>Sets if the resource must be filtered or not</p>

<p>public  <strong>setAttributes</strong> (<em>array</em> $attributes)</p>

<p>Sets extra HTML attributes</p>

<p>public  <strong>setTargetUri</strong> (<em>mixed</em> $targetUri)</p>

<p>Sets a target uri for the generated HTML</p>

<p>public  <strong>setSourcePath</strong> (<em>mixed</em> $sourcePath)</p>

<p>Sets the resource's source path</p>

<p>public  <strong>setTargetPath</strong> (<em>mixed</em> $targetPath)</p>

<p>Sets the resource's target path</p>

<p>public  <strong>getContent</strong> ([<em>mixed</em> $basePath])</p>

<p>Returns the content of the resource as an string
Optionally a base path where the resource is located can be set</p>

<p>public  <strong>getRealTargetUri</strong> ()</p>

<p>Returns the real target uri for the generated HTML</p>

<p>public  <strong>getRealSourcePath</strong> ([<em>mixed</em> $basePath])</p>

<p>Returns the complete location where the resource is located</p>

<p>public  <strong>getRealTargetPath</strong> ([<em>mixed</em> $basePath])</p>

<p>Returns the complete location where the resource must be written</p>

<p>public  <strong>getResourceKey</strong> ()</p>

<p>Gets the resource's key.</p>
