<h1>Class <strong>Phalcon\\Mvc\\Collection\\Document</strong></h1>

<p><em>implements</em> <a href="/en/3.2/api/Phalcon_Mvc_EntityInterface">Phalcon\Mvc\EntityInterface</a>, <a href="http://php.net/manual/en/class.arrayaccess.php">ArrayAccess</a></p>

<p><a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/collection/document.zep" class="btn btn-default btn-sm" mark="crwd-mark">Source on GitHub</a></p>

<p>This component allows Phalcon\\Mvc\\Collection to return rows without an associated entity.
This objects implements the ArrayAccess interface to allow access the object as object->x or array[x].</p>

<h2>Methods</h2>

<p>public <em>boolean</em> <strong>offsetExists</strong> (<em>int</em> $index)</p>

<p>Checks whether an offset exists in the document</p>

<p>public  <strong>offsetGet</strong> (<em>mixed</em> $index)</p>

<p>Returns the value of a field using the ArrayAccess interfase</p>

<p>public  <strong>offsetSet</strong> (<em>mixed</em> $index, <em>mixed</em> $value)</p>

<p>Change a value using the ArrayAccess interface</p>

<p>public  <strong>offsetUnset</strong> (<em>string</em> $offset)</p>

<p>Rows cannot be changed. It has only been implemented to meet the definition of the ArrayAccess interface</p>

<p>public <em>mixed</em> <strong>readAttribute</strong> (<em>string</em> $attribute)</p>

<p>Reads an attribute value by its name</p>

<pre><code class="php">&lt;?php

 echo $robot-&gt;readAttribute("name");

</code></pre>

<p>public  <strong>writeAttribute</strong> (<em>string</em> $attribute, <em>mixed</em> $value)</p>

<p>Writes an attribute value by its name</p>

<pre><code class="php">&lt;?php

 $robot-&gt;writeAttribute("name", "Rosey");

</code></pre>

<p>public <em>array</em> <strong>toArray</strong> ()</p>

<p>Returns the instance as an array representation</p>
