---
layout: default
language: 'ja-jp'
version: '4.0'
title: 'API 索引'
---

## API 索引
{% for element in site.data.api %}
### {{ element['title'] }}
    {% for document in element['docs'] %}
* [{{ document | replace: '_', '\' }}](/{{ pageVersion }}/{{ pageLanguage }}/api/{{ element['title'] | replace: '\', '_' | downcase }}#{{ document | replace: '/', '-' | downcase }})
    {% endfor %}
{% endfor %}
