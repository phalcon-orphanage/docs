---
layout: default
language: 'pt-br'
version: '4.0'
title: 'Índice da API'
---

## Índice da API
{% for element in site.data.api %}
### {{ element['title'] }}
    {% for document in element['docs'] %}
* [{{ document | replace: '_', '\' }}](/{{ pageVersion }}/{{ pageLanguage }}/api/{{ element['title'] | replace: '\', '_' | downcase }}#{{ document | replace: '/', '-' | downcase }})
    {% endfor %}
{% endfor %}
