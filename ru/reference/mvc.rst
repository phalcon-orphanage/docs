Архитектура MVC
====================

Phalcon поддерживает использование парадигмы объектно-ориентированного программирования и поддержку классов необходимых для разделения на Model, View, Controller ( кратко MVC_). Этот шаблон проектирования активно используется в других web и desktop платформах.

Преимущества MVC: 

* Отделение бизнес-логики от пользовательского интерфейса и работы с базой данных
* Позволяет распологать разные части в разных местах, что благоприятно сказывается на поддержке и обслуживании

If you decide to use MVC, every request to your application resources will be managed by the MVC_ architecture. Phalcon classes are written in C language, offering a high performance approach of this pattern in a PHP based application. 

Модель / Models
------
A model represents the information (data) of the application and the rules to manipulate that data. Models are primarily used for managing the rules of interaction with a corresponding database table. In most cases, each table in your database will correspond to one model in your application. The bulk of your application's business logic will be concentrated in the models. :doc:`Learn more <models>`
Модель отвечает за информацию (данные) приложения и правила управления этими данными. Модели в основном используется для управления соответствующей таблицой базы данных и правил взаимодействия с ней. В большинстве случаев, каждая таблица в базе данных будет соответствовать одной модели в вашем приложении. Основная часть бизнес-логики приложения будет сосредоточена в моделях. : DOC: `Подробнее про модель <models>`

Представление / Views
-----
Представление отвечает за пользовательский интерфейс вашего приложения. Чаще всего это HTML файлы с вставками PHP кода исключительно вывода данных. Этот слой отвечает за вывод данных в веб-браузер или другой инструмент который обращается к вашему приложению.: DOC: `Подробнее про представление <views>`

Контроллер / Controllers
-----------
The controllers provide the "flow" between models and views. Controllers are responsible for processing the incoming requests from the web browser, interrogating the models for data, and passing that data on to the views for presentation. :doc:`Learn more <controllers>`
Контроллеры обеспечивают обмен данными между моделью и представлением. Контроллеры отвечают за обработку входящих запросов от веб-браузера, запрашивают данные у модели и передают эти данные в предсталвение для вывода. `Подробнее про контроллер <controllers>`

.. _MVC: http://en.wikipedia.org/wiki/Model%E2%80%93view%E2%80%93controller
