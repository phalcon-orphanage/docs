* * *

layout: default language: 'en' version: '3.4' title: 'API Index'

* * *

## Índice del API

{% for apiPage in site.pages %} {% assign stub = apiPage.name | slice: 0, 8 %} {% if "Phalcon_" == stub %} {% assign linkUrl = apiPage.name | replace: '', '' %} {% assign linkName = linkUrl | replace: '_', '\' %}

* [{{ linkName }}](/{{ apiPage.version }}/{{ apiPage.language }}/api/{{ linkUrl }}) {% endif %} {% endfor %}