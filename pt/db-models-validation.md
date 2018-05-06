<div class='article-menu' mark="crwd-mark">

<ul>
<li><a href="#overview">Validating Models</a>

<ul>
<li><a href="#data-integrity">Validating Data Integrity</a></li>
<li><a href="#messages">Validation Messages</a></li>
<li><a href="#failed-events">Validation Failed Events</a></li>
</ul></li>
</ul>

</div>

<p><a name='overview' mark="crwd-mark"></a></p>

<h1>Validating Models</h1>

<p><a name='data-integrity' mark="crwd-mark"></a></p>

<h2>Validating Data Integrity</h2>

<p><code>Phalcon\Mvc\Model</code> provides several events to validate data and implement business rules. The special <code>validation</code> event allows us to call built-in validators over the record. Phalcon exposes a few built-in validators that can be used at this stage of validation.</p>

<p>The following example shows how to use it:</p>

<pre><code class="php">&lt;?php

namespace Store\Toys;

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness;
use Phalcon\Validation\Validator\InclusionIn;

class Robots extends Model
{
    public function validation()
    {
        $validator = new Validation();

        $validator-&gt;add(
            'type',
            new InclusionIn(
                [
                    'domain' =&gt; [
                        'Mechanical',
                        'Virtual',
                    ]
                ]
            )
        );

        $validator-&gt;add(
            'name',
            new Uniqueness(
                [
                    'message' =&gt; 'The robot name must be unique',
                ]
            )
        );

        return $this-&gt;validate($validator);
    }
}
</code></pre>

<p>The above example performs a validation using the built-in validator 'InclusionIn'. It checks the value of the field <code>type</code> in a domain list. If the value is not included in the method then the validator will fail and return false.</p>

<h5 class='alert alert-warning' mark="crwd-mark">For more information on validators, see the <a href="/[[language]]/[[version]]/validation">Validation documentation</a></h5>

<p>The idea of creating validators is make them reusable between several models. A validator can also be as simple as:</p>

<pre><code class="php">&lt;?php

namespace Store\Toys;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Message;

class Robots extends Model
{
    public function validation()
    {
        if ($this-&gt;type === 'Old') {
            $message = new Message(
                'Sorry, old robots are not allowed anymore',
                'type',
                'MyType'
            );

            $this-&gt;appendMessage($message);

            return false;
        }

        return true;
    }
}
</code></pre>

<p><a name='messages' mark="crwd-mark"></a></p>

<h2>Validation Messages</h2>

<p><code>Phalcon\Mvc\Model</code> has a messaging subsystem that provides a flexible way to output or store the validation messages generated during the insert/update processes.</p>

<p>Each message is an instance of <code>Phalcon\Mvc\Model\Message</code> and the set of messages generated can be retrieved with the <code>getMessages()</code> method. Each message provides extended information like the field name that generated the message or the message type:</p>

<pre><code class="php">&lt;?php

if ($robot-&gt;save() === false) {
    $messages = $robot-&gt;getMessages();

    foreach ($messages as $message) {
        echo 'Message: ', $message-&gt;getMessage();
        echo 'Field: ', $message-&gt;getField();
        echo 'Type: ', $message-&gt;getType();
    }
}
</code></pre>

<p><code>Phalcon\Mvc\Model</code> can generate the following types of validation messages:</p>

<table>
<thead>
<tr>
  <th>Type</th>
  <th>Description</th>
</tr>
</thead>
<tbody>
<tr>
  <td><code>PresenceOf</code></td>
  <td>Generated when a field with a non-null attribute on the database is trying to insert/update a null value</td>
</tr>
<tr>
  <td><code>ConstraintViolation</code></td>
  <td>Generated when a field part of a virtual foreign key is trying to insert/update a value that doesn't exist in the referenced model</td>
</tr>
<tr>
  <td><code>InvalidValue</code></td>
  <td>Generated when a validator failed because of an invalid value</td>
</tr>
<tr>
  <td><code>InvalidCreateAttempt</code></td>
  <td>Produced when a record is attempted to be created but it already exists</td>
</tr>
<tr>
  <td><code>InvalidUpdateAttempt</code></td>
  <td>Produced when a record is attempted to be updated but it doesn't exist</td>
</tr>
</tbody>
</table>

<p>The <code>getMessages()</code> method can be overridden in a model to replace/translate the default messages generated automatically by the ORM:</p>

<pre><code class="php">&lt;?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function getMessages()
    {
        $messages = [];

        foreach (parent::getMessages() as $message) {
            switch ($message-&gt;getType()) {
                case 'InvalidCreateAttempt':
                    $messages[] = 'The record cannot be created because it already exists';
                    break;

                case 'InvalidUpdateAttempt':
                    $messages[] = "The record cannot be updated because it doesn't exist";
                    break;

                case 'PresenceOf':
                    $messages[] = 'The field ' . $message-&gt;getField() . ' is mandatory';
                    break;
            }
        }

        return $messages;
    }
}
</code></pre>

<p><a name='failed-events' mark="crwd-mark"></a></p>

<h2>Validation Failed Events</h2>

<p>Another type of events are available when the data validation process finds any inconsistency:</p>

<table>
<thead>
<tr>
  <th>Operation</th>
  <th>Name</th>
  <th>Explanation</th>
</tr>
</thead>
<tbody>
<tr>
  <td>Insert or Update</td>
  <td><code>notSaved</code></td>
  <td>Triggered when the <code>INSERT</code> or <code>UPDATE</code> operation fails for any reason</td>
</tr>
<tr>
  <td>Insert, Delete or Update</td>
  <td><code>onValidationFails</code></td>
  <td>Triggered when any data manipulation operation fails</td>
</tr>
</tbody>
</table>
