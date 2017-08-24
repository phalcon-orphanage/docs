<div class='article-menu'>
  <ul>
    <li>
      <a href="#architecture">The MVC Architecture</a> 
      <ul>
        <li>
          <a href="#models">Models</a>
        </li>
        <li>
          <a href="#views">Views</a>
        </li>
        <li>
          <a href="#controllers">Controllers</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='architecture'></a>

# The MVC Architecture

Phalcon offers the object-oriented classes, necessary to implement the Model, View, Controller architecture (often referred to as [MVC](https://en.wikipedia.org/wiki/Model–view–controller)) in your application. This design pattern is widely used by other web frameworks and desktop applications.

MVC benefits include:

* Isolation of business logic from the user interface and the database layer
* Making it clear where different types of code belong for easier maintenance

If you decide to use MVC, every request to your application resources will be managed by the MVC architecture. Phalcon classes are written in C language, offering a high performance approach of this pattern in a PHP based application.

<a name='models'></a>

## Models

A model represents the information (data) of the application and the rules to manipulate that data. Models are primarily used for managing the rules of interaction with a corresponding database table. In most cases, each table in your database will correspond to one model in your application. The bulk of your application's business logic will be concentrated in the models. [Learn more](/[[language]]/[[version]]/db-models)

<a name='views'></a>

## Views

Views represent the user interface of your application. Views are often HTML files with embedded PHP code that perform tasks related solely to the presentation of the data. Views handle the job of providing data to the web browser or other tool that is used to make requests from your application. [Learn more](/[[language]]/[[version]]/views)

<a name='controllers'></a>

## Controllers

The controllers provide the 'flow' between models and views. Controllers are responsible for processing the incoming requests from the web browser, interrogating the models for data, and passing that data on to the views for presentation. [Learn more](/[[language]]/[[version]]/controllers)