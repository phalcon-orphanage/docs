<h1>Class <strong>Phalcon\\Db\\Index</strong></h1>

<p><em>implements</em> <a href="/en/3.2/api/Phalcon_Db_IndexInterface">Phalcon\Db\IndexInterface</a></p>

<p><a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/db/index.zep" class="btn btn-default btn-sm" mark="crwd-mark">Source on GitHub</a></p>

<p>Allows to define indexes to be used on tables. Indexes are a common way
to enhance database performance. An index allows the database server to find
and retrieve specific rows much faster than it could do without an index</p>

<pre><code class="php">&lt;?php

// Define new unique index
$index_unique = new \Phalcon\Db\Index(
    'column_UNIQUE',
    [
        'column',
        'column'
    ],
    'UNIQUE'
);

// Define new primary index
$index_primary = new \Phalcon\Db\Index(
    'PRIMARY',
    [
        'column'
    ]
);

// Add index to existing table
$connection-&gt;addIndex("robots", null, $index_unique);
$connection-&gt;addIndex("robots", null, $index_primary);

</code></pre>

<h2>Methods</h2>

<p>public  <strong>getName</strong> ()</p>

<p>Index name</p>

<p>public  <strong>getColumns</strong> ()</p>

<p>Index columns</p>

<p>public  <strong>getType</strong> ()</p>

<p>Index type</p>

<p>public  <strong>__construct</strong> (<em>mixed</em> $name, <em>array</em> $columns, [<em>mixed</em> $type])</p>

<p>Phalcon\\Db\\Index constructor</p>

<p>public static  <strong>__set_state</strong> (<em>array</em> $data)</p>

<p>Restore a Phalcon\\Db\\Index object from export</p>
