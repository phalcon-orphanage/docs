<h1>Interface <strong>Phalcon\\Cache\\BackendInterface</strong></h1>

<p><a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/cache/backendinterface.zep" class="btn btn-default btn-sm" mark="crwd-mark">Source on GitHub</a></p>

<h2>Methods</h2>

<p>abstract public  <strong>start</strong> (<em>mixed</em> $keyName, [<em>mixed</em> $lifetime])</p>

<p>...</p>

<p>abstract public  <strong>stop</strong> ([<em>mixed</em> $stopBuffer])</p>

<p>...</p>

<p>abstract public  <strong>getFrontend</strong> ()</p>

<p>...</p>

<p>abstract public  <strong>getOptions</strong> ()</p>

<p>...</p>

<p>abstract public  <strong>isFresh</strong> ()</p>

<p>...</p>

<p>abstract public  <strong>isStarted</strong> ()</p>

<p>...</p>

<p>abstract public  <strong>setLastKey</strong> (<em>mixed</em> $lastKey)</p>

<p>...</p>

<p>abstract public  <strong>getLastKey</strong> ()</p>

<p>...</p>

<p>abstract public  <strong>get</strong> (<em>mixed</em> $keyName, [<em>mixed</em> $lifetime])</p>

<p>...</p>

<p>abstract public  <strong>save</strong> ([<em>mixed</em> $keyName], [<em>mixed</em> $content], [<em>mixed</em> $lifetime], [<em>mixed</em> $stopBuffer])</p>

<p>...</p>

<p>abstract public  <strong>delete</strong> (<em>mixed</em> $keyName)</p>

<p>...</p>

<p>abstract public  <strong>queryKeys</strong> ([<em>mixed</em> $prefix])</p>

<p>...</p>

<p>abstract public  <strong>exists</strong> ([<em>mixed</em> $keyName], [<em>mixed</em> $lifetime])</p>

<p>...</p>
