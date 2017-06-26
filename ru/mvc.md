<div class='article-menu'>
  <ul>
    <li>
      <a href="#architecture">Архитектура MVC</a> <ul>
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

Phalcon поддерживает использование парадигмы объектно-ориентированного программирования и поддержку классов, необходимых для разделения на Модель, Представление, Контроллер (Model, View, Controller, кратко [MVC](https://en.wikipedia.org/wiki/Model–view–controller)). Этот шаблон проектирования активно используется в других веб-фреймворках и обычных приложениях.

Преимущества MVC:

- Отделение бизнес-логики от пользовательского интерфейса и работы с базой данных
- Позволяет располагать разные части в разных местах, что благоприятно сказывается на поддержке и обслуживании

Если вы выберете MVC, все запросы будут выполнятся согласно MVC архитектуре. Phalcon поддерживает MVC своими классами, написанными на C, что позволяет добиться высокой производительности PHP приложения.

<a name='models'></a>

## Models

A model represents the information (data) of the application and the rules to manipulate that data. Models are primarily used for managing the rules of interaction with a corresponding database table. In most cases, each table in your database will correspond to one model in your application. The bulk of your application's business logic will be concentrated in the models. [Подробнее про модели](/[[language]]/[[version]]/models).

<a name='views'></a>

## Views

Представление отвечает за пользовательский интерфейс вашего приложения. Чаще всего это HTML файлы с вставками PHP кода исключительно для вывода данных. Этот слой отвечает за вывод данных в веб-браузер или другой инструмент, который обращается к вашему приложению. [Подробнее про представления](/[[language]]/[[version]]/views).

<a name='controllers'></a>

## Controllers

Контроллеры предоставляют "клей" между моделью и представлением. Контроллеры ответственны за обработку входящих запросов от веб-браузера, запрашивание данных у модели и передачу этих данных в представление для вывода. [Подробнее про контроллеры](/[[language]]/[[version]]/controllers).