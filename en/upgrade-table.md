# Phalcon PHP upgrade from 3.4.4 to 4.0.0
## Quick Reference

<table>
<thead>
<tr class="header">
<th>Classes removed/renamed</th>
<th>New classes</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><h2 id="acl">Acl</h2></td>
<td></td>
</tr>
<tr class="even">
<td>Phalcon\Acl</td>
<td>Phalcon\Acl\Adapter\AbstractAdapter</td>
</tr>
<tr class="odd">
<td>Phalcon\Acl\Adapter</td>
<td>Phalcon\Acl\Component</td>
</tr>
<tr class="even">
<td>Phalcon\Acl\Resource</td>
<td>Phalcon\Acl\Enum</td>
</tr>
<tr class="odd">
<td><h2 id="annotations">Annotations</h2></td>
<td></td>
</tr>
<tr class="even">
<td>Phalcon\Annotations\Adapter</td>
<td>Phalcon\Annotations\Adapter\AbstractAdapter</td>
</tr>
<tr class="odd">
<td>Phalcon\Annotations\Adapter\Apc</td>
<td>Phalcon\Annotations\Adapter\Stream</td>
</tr>
<tr class="even">
<td>Phalcon\Annotations\Adapter\Files</td>
<td>Phalcon\Annotations\AnnotationsFactory</td>
</tr>
<tr class="odd">
<td>Phalcon\Annotations\Adapter\Xcache</td>
<td></td>
</tr>
<tr class="even">
<td>Phalcon\Annotations\Factory</td>
<td></td>
</tr>
<tr class="odd">
<td><h2 id="application">Application</h2></td>
<td></td>
</tr>
<tr class="even">
<td>Phalcon\Application</td>
<td>Phalcon\Application\AbstractApplication</td>
</tr>
<tr class="odd">
<td><h2 id="assets">Assets</h2></td>
<td></td>
</tr>
<tr class="even">
<td>Phalcon\Assets\Resource</td>
<td>Phalcon\Assets\Asset</td>
</tr>
<tr class="odd">
<td>Phalcon\Assets\Resource\Css</td>
<td>Phalcon\Assets\Asset\Css</td>
</tr>
<tr class="even">
<td>Phalcon\Assets\Resource\Js</td>
<td>Phalcon\Assets\Asset\Js</td>
</tr>
<tr class="odd">
<td><h2 id="cache">Cache</h2></td>
<td></td>
</tr>
<tr class="even">
<td>Phalcon\Cache\Backend</td>
<td>Phalcon\Cache</td>
</tr>
<tr class="odd">
<td>Phalcon\Cache\Backend\Apc</td>
<td>Phalcon\Cache\AdapterFactory</td>
</tr>
<tr class="even">
<td>Phalcon\Cache\Backend\Apcu</td>
<td>Phalcon\Cache\Adapter\Apcu</td>
</tr>
<tr class="odd">
<td>Phalcon\Cache\Backend\Factory</td>
<td>Phalcon\Cache\Adapter\Libmemcached</td>
</tr>
<tr class="even">
<td>Phalcon\Cache\Backend\File</td>
<td>Phalcon\Cache\Adapter\Memory</td>
</tr>
<tr class="odd">
<td>Phalcon\Cache\Backend\Libmemcached</td>
<td>Phalcon\Cache\Adapter\Redis</td>
</tr>
<tr class="even">
<td>Phalcon\Cache\Backend\Memcache</td>
<td>Phalcon\Cache\Adapter\Stream</td>
</tr>
<tr class="odd">
<td>Phalcon\Cache\Backend\Memory</td>
<td>Phalcon\Cache\CacheFactory</td>
</tr>
<tr class="even">
<td>Phalcon\Cache\Backend\Mongo</td>
<td>Phalcon\Cache\Exception\Exception</td>
</tr>
<tr class="odd">
<td>Phalcon\Cache\Backend\Redis</td>
<td>Phalcon\Cache\Exception\InvalidArgumentException</td>
</tr>
<tr class="even">
<td>Phalcon\Cache\Backend\Xcache</td>
<td></td>
</tr>
<tr class="odd">
<td>Phalcon\Cache\Exception</td>
<td></td>
</tr>
<tr class="even">
<td>Phalcon\Cache\Frontend\Base64</td>
<td></td>
</tr>
<tr class="odd">
<td>Phalcon\Cache\Frontend\Data</td>
<td></td>
</tr>
<tr class="even">
<td>Phalcon\Cache\Frontend\Factory</td>
<td></td>
</tr>
<tr class="odd">
<td>Phalcon\Cache\Frontend\Igbinary</td>
<td></td>
</tr>
<tr class="even">
<td>Phalcon\Cache\Frontend\Json</td>
<td></td>
</tr>
<tr class="odd">
<td>Phalcon\Cache\Frontend\Msgpack</td>
<td></td>
</tr>
<tr class="even">
<td>Phalcon\Cache\Frontend\None</td>
<td></td>
</tr>
<tr class="odd">
<td>Phalcon\Cache\Frontend\Output</td>
<td></td>
</tr>
<tr class="even">
<td>Phalcon\Cache\Multiple</td>
<td></td>
</tr>
<tr class="odd">
<td><h2 id="collection">Collection</h2></td>
<td></td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Collection</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Collection\Exception</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Collection\ReadOnly</td>
</tr>
<tr class="odd">
<td><h2 id="config">Config</h2></td>
<td></td>
</tr>
<tr class="even">
<td>Phalcon\Config\Factory</td>
<td>Phalcon\Config\ConfigFactory</td>
</tr>
<tr class="odd">
<td><h2 id="container">Container</h2></td>
<td></td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Container</td>
</tr>
<tr class="odd">
<td><h2 id="db">Db</h2></td>
<td></td>
</tr>
<tr class="even">
<td>Phalcon\Db</td>
<td>Phalcon\Db\AbstractDb</td>
</tr>
<tr class="odd">
<td>Phalcon\Db\Adapter</td>
<td>Phalcon\Db\Adapter\AbstractAdapter</td>
</tr>
<tr class="even">
<td>Phalcon\Db\Adapter\Pdo</td>
<td>Phalcon\Db\Adapter\PdoFactory</td>
</tr>
<tr class="odd">
<td>Phalcon\Db\Adapter\Pdo\Factory</td>
<td>Phalcon\Db\Adapter\Pdo\AbstractPdo</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Db\Enum</td>
</tr>
<tr class="odd">
<td><h2 id="dispatcher">Dispatcher</h2></td>
<td></td>
</tr>
<tr class="even">
<td>Phalcon\Dispatcher</td>
<td>Phalcon\Dispatcher\AbstractDispatcher</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Dispatcher\Exception</td>
</tr>
<tr class="even">
<td><h2 id="di">Di</h2></td>
<td></td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Di\Exception\ServiceResolutionException</td>
</tr>
<tr class="even">
<td><h2 id="domain">Domain</h2></td>
<td></td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Domain\Payload\Payload</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Domain\Payload\PayloadFactory</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Domain\Payload\Status</td>
</tr>
<tr class="even">
<td><h2 id="factory">Factory</h2></td>
<td></td>
</tr>
<tr class="odd">
<td>Phalcon\Factory</td>
<td>Phalcon\Factory\AbstractFactory</td>
</tr>
<tr class="even">
<td><h2 id="filter">Filter</h2></td>
<td></td>
</tr>
<tr class="odd">
<td>Phalcon\Filter</td>
<td>Phalcon\Filter\Filter</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Filter\FilterFactory</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Filter\Sanitize\AbsInt</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Filter\Sanitize\Alnum</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Filter\Sanitize\Alpha</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Filter\Sanitize\BoolVal</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Filter\Sanitize\Email</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Filter\Sanitize\FloatVal</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Filter\Sanitize\IntVal</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Filter\Sanitize\Lower</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Filter\Sanitize\LowerFirst</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Filter\Sanitize\Regex</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Filter\Sanitize\Remove</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Filter\Sanitize\Replace</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Filter\Sanitize\Special</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Filter\Sanitize\SpecialFull</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Filter\Sanitize\StringVal</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Filter\Sanitize\Striptags</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Filter\Sanitize\Trim</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Filter\Sanitize\Upper</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Filter\Sanitize\UpperFirst</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Filter\Sanitize\UpperWords</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Filter\Sanitize\Url</td>
</tr>
<tr class="even">
<td><h2 id="firewall">Firewall</h2></td>
<td></td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Firewall\Adapter\AbstractAdapter</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Firewall\Adapter\Acl</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Firewall\Adapter\Annotations</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Firewall\Adapter\Micro\Acl</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Firewall\Exception</td>
</tr>
<tr class="even">
<td><h2 id="flash">Flash</h2></td>
<td></td>
</tr>
<tr class="odd">
<td>Phalcon\Flash</td>
<td>Phalcon\Flash\AbstractFlash</td>
</tr>
<tr class="even">
<td><h2 id="forms">Forms</h2></td>
<td></td>
</tr>
<tr class="odd">
<td>Phalcon\Forms\Element</td>
<td>Phalcon\Forms\Element\AbstractElement</td>
</tr>
<tr class="even">
<td><h2 id="helper">Helper</h2></td>
<td></td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Helper\Arr</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Helper\Exception</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Helper\Number</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Helper\Str</td>
</tr>
<tr class="odd">
<td><h2 id="html">Html</h2></td>
<td></td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Html\Attributes</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Html\Breadcrumbs</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Html\Exception</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Html\Helper\AbstractHelper</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Html\Helper\Anchor</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Html\Helper\AnchorRaw</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Html\Helper\Body</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Html\Helper\Button</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Html\Helper\Close</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Html\Helper\Element</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Html\Helper\ElementRaw</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Html\Helper\Form</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Html\Helper\Img</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Html\Helper\Label</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Html\Helper\TextArea</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Html\Tag</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Html\TagFactory</td>
</tr>
<tr class="odd">
<td><h2 id="http">Http</h2></td>
<td></td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Http\Message\AbstractCommon</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Http\Message\AbstractMessage</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Http\Message\AbstractRequest</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Http\Message\Exception\InvalidArgumentException</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Http\Message\Request</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Http\Message\RequestFactory</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Http\Message\Response</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Http\Message\ResponseFactory</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Http\Message\ServerRequest</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Http\Message\ServerRequestFactory</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Http\Message\Stream</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Http\Message\StreamFactory</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Http\Message\Stream\Input</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Http\Message\Stream\Memory</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Http\Message\Stream\Temp</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Http\Message\UploadedFile</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Http\Message\UploadedFileFactory</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Http\Message\Uri</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Http\Message\UriFactory</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Http\Server\AbstractMiddleware</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Http\Server\AbstractRequestHandler</td>
</tr>
<tr class="odd">
<td><h2 id="image">Image</h2></td>
<td></td>
</tr>
<tr class="even">
<td>Phalcon\Image</td>
<td>Phalcon\Image\Adapter\AbstractAdapter</td>
</tr>
<tr class="odd">
<td>Phalcon\Image\Adapter</td>
<td>Phalcon\Image\Enum</td>
</tr>
<tr class="even">
<td>Phalcon\Image\Factory</td>
<td>Phalcon\Image\ImageFactory</td>
</tr>
<tr class="odd">
<td><h2 id="logger">Logger</h2></td>
<td></td>
</tr>
<tr class="even">
<td>Phalcon\Logger</td>
<td>Phalcon\Logger\AdapterFactory</td>
</tr>
<tr class="odd">
<td>Phalcon\Logger\Adapter</td>
<td>Phalcon\Logger\Adapter\AbstractAdapter</td>
</tr>
<tr class="even">
<td>Phalcon\Logger\Adapter\Blackhole</td>
<td>Phalcon\Logger\Adapter\Noop</td>
</tr>
<tr class="odd">
<td>Phalcon\Logger\Adapter\File</td>
<td>Phalcon\Logger\Formatter\AbstractFormatter</td>
</tr>
<tr class="even">
<td>Phalcon\Logger\Adapter\Firephp</td>
<td>Phalcon\Logger\Logger</td>
</tr>
<tr class="odd">
<td>Phalcon\Logger\Factory</td>
<td>Phalcon\Logger\LoggerFactory</td>
</tr>
<tr class="even">
<td>Phalcon\Logger\Formatter</td>
<td></td>
</tr>
<tr class="odd">
<td>Phalcon\Logger\Formatter\Firephp</td>
<td></td>
</tr>
<tr class="even">
<td>Phalcon\Logger\Multiple</td>
<td></td>
</tr>
<tr class="odd">
<td><h2 id="message">Message</h2></td>
<td></td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Messages\Exception</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Messages\Message</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Messages\Messages</td>
</tr>
<tr class="odd">
<td><h2 id="mvc">Mvc</h2></td>
<td></td>
</tr>
<tr class="even">
<td>Phalcon\Mvc\Model\Message</td>
<td>Phalcon\Mvc\Model\MetaData\Stream</td>
</tr>
<tr class="odd">
<td>Phalcon\Mvc\Model\MetaData\Apc</td>
<td>Phalcon\Mvc\View\Engine\AbstractEngine</td>
</tr>
<tr class="even">
<td>Phalcon\Mvc\Model\MetaData\Files</td>
<td></td>
</tr>
<tr class="odd">
<td>Phalcon\Mvc\Model\MetaData\Memcache</td>
<td></td>
</tr>
<tr class="even">
<td>Phalcon\Mvc\Model\MetaData\Session</td>
<td></td>
</tr>
<tr class="odd">
<td>Phalcon\Mvc\Model\MetaData\Xcache</td>
<td></td>
</tr>
<tr class="even">
<td>Phalcon\Mvc\Model\Validator</td>
<td></td>
</tr>
<tr class="odd">
<td>Phalcon\Mvc\Model\Validator\Email</td>
<td></td>
</tr>
<tr class="even">
<td>Phalcon\Mvc\Model\Validator\Exclusionin</td>
<td></td>
</tr>
<tr class="odd">
<td>Phalcon\Mvc\Model\Validator\Inclusionin</td>
<td></td>
</tr>
<tr class="even">
<td>Phalcon\Mvc\Model\Validator\Ip</td>
<td></td>
</tr>
<tr class="odd">
<td>Phalcon\Mvc\Model\Validator\Numericality</td>
<td></td>
</tr>
<tr class="even">
<td>Phalcon\Mvc\Model\Validator\PresenceOf</td>
<td></td>
</tr>
<tr class="odd">
<td>Phalcon\Mvc\Model\Validator\Regex</td>
<td></td>
</tr>
<tr class="even">
<td>Phalcon\Mvc\Model\Validator\StringLength</td>
<td></td>
</tr>
<tr class="odd">
<td>Phalcon\Mvc\Model\Validator\Uniqueness</td>
<td></td>
</tr>
<tr class="even">
<td>Phalcon\Mvc\Model\Validator\Url</td>
<td></td>
</tr>
<tr class="odd">
<td>Phalcon\Mvc\Url</td>
<td></td>
</tr>
<tr class="even">
<td>Phalcon\Mvc\Url\Exception</td>
<td></td>
</tr>
<tr class="odd">
<td>Phalcon\Mvc\User\Component</td>
<td></td>
</tr>
<tr class="even">
<td>Phalcon\Mvc\User\Module</td>
<td></td>
</tr>
<tr class="odd">
<td>Phalcon\Mvc\User\Plugin</td>
<td></td>
</tr>
<tr class="even">
<td>Phalcon\Mvc\View\Engine</td>
<td></td>
</tr>
<tr class="odd">
<td><h2 id="paginator">Paginator</h2></td>
<td></td>
</tr>
<tr class="even">
<td>Phalcon\Paginator\Adapter</td>
<td>Phalcon\Paginator\Adapter\AbstractAdapter</td>
</tr>
<tr class="odd">
<td>Phalcon\Paginator\Factory</td>
<td>Phalcon\Paginator\PaginatorFactory</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Paginator\Repository</td>
</tr>
<tr class="odd">
<td><h2 id="plugin">Plugin</h2></td>
<td></td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Plugin</td>
</tr>
<tr class="odd">
<td><h2 id="queue">Queue</h2></td>
<td></td>
</tr>
<tr class="even">
<td>Phalcon\Queue\Beanstalk</td>
<td></td>
</tr>
<tr class="odd">
<td>Phalcon\Queue\Beanstalk\Exception</td>
<td></td>
</tr>
<tr class="even">
<td>Phalcon\Queue\Beanstalk\Job</td>
<td></td>
</tr>
<tr class="odd">
<td><h2 id="session">Session</h2></td>
<td></td>
</tr>
<tr class="even">
<td>Phalcon\Session\Adapter</td>
<td>Phalcon\Session\Adapter\AbstractAdapter</td>
</tr>
<tr class="odd">
<td>Phalcon\Session\Adapter\Files</td>
<td>Phalcon\Session\Adapter\Noop</td>
</tr>
<tr class="even">
<td>Phalcon\Session\Adapter\Memcache</td>
<td>Phalcon\Session\Adapter\Stream</td>
</tr>
<tr class="odd">
<td>Phalcon\Session\Factory</td>
<td>Phalcon\Session\Manager</td>
</tr>
<tr class="even">
<td><h2 id="storage">Storage</h2></td>
<td></td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Storage\AdapterFactory</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Storage\Adapter\AbstractAdapter</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Storage\Adapter\Apcu</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Storage\Adapter\Libmemcached</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Storage\Adapter\Memory</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Storage\Adapter\Redis</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Storage\Adapter\Stream</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Storage\Exception</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Storage\SerializerFactory</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Storage\Serializer\AbstractSerializer</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Storage\Serializer\Base64</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Storage\Serializer\Igbinary</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Storage\Serializer\Json</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Storage\Serializer\Msgpack</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Storage\Serializer\None</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Storage\Serializer\Php</td>
</tr>
<tr class="odd">
<td><h2 id="translate">Translate</h2></td>
<td></td>
</tr>
<tr class="even">
<td>Phalcon\Translate</td>
<td>Phalcon\Translate\Adapter\AbstractAdapter</td>
</tr>
<tr class="odd">
<td>Phalcon\Translate\Adapter</td>
<td>Phalcon\Translate\InterpolatorFactory</td>
</tr>
<tr class="even">
<td>Phalcon\Translate\Factory</td>
<td>Phalcon\Translate\TranslateFactory</td>
</tr>
<tr class="odd">
<td><h2 id="url">Url</h2></td>
<td></td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Url</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Url\Exception</td>
</tr>
<tr class="even">
<td><h2 id="validation">Validation</h2></td>
<td></td>
</tr>
<tr class="odd">
<td>Phalcon\Validation\CombinedFieldsValidator</td>
<td>Phalcon\Validation\AbstractCombinedFieldsValidator</td>
</tr>
<tr class="even">
<td>Phalcon\Validation\Message</td>
<td>Phalcon\Validation\AbstractValidator</td>
</tr>
<tr class="odd">
<td>Phalcon\Validation\Message\Group</td>
<td>Phalcon\Validation\AbstractValidatorComposite</td>
</tr>
<tr class="even">
<td>Phalcon\Validation\Validator</td>
<td>Phalcon\Validation\ValidatorFactory</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Validation\Validator\File\AbstractFile</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Validation\Validator\File\MimeType</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Validation\Validator\File\Resolution\Equal</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Validation\Validator\File\Resolution\Max</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Validation\Validator\File\Resolution\Min</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Validation\Validator\File\Size\Equal</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Validation\Validator\File\Size\Max</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Validation\Validator\File\Size\Min</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Validation\Validator\Ip</td>
</tr>
<tr class="even">
<td></td>
<td>Phalcon\Validation\Validator\StringLength\Max</td>
</tr>
<tr class="odd">
<td></td>
<td>Phalcon\Validation\Validator\StringLength\Min</td>
</tr>
</tbody>
</table>
