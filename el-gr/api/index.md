---
layout: default
language: 'el-gr'
version: '4.0'
title: 'Δείκτης API'
---

## Δείκτης API
{% for element in site.data.api %}
### {{ element['title'] }}
    {% for document in element['docs'] %}
* [{{ document | replace: '_', '\' }}](/{{ pageVersion }}/{{ pageLanguage }}/api/{{ element['title'] | replace: '\', '_' | downcase }}#{{ document | replace: '/', '-' | downcase }})
    {% endfor %}
{% endfor %}
