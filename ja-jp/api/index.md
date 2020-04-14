---
layout: default
language: 'ja-jp'
version: '4.0'
title: 'API インデックス'
---

## API インデックス
{% for element in site.data.api %}
### {{ element['title'] }}
    {% for document in element['docs'] %}
* [{{ document | replace: '_', '\' }}](/{{ page.version }}/{{ page.language }}/api/{{ element['title'] | replace: '\', '_' | downcase }}#{{ document | replace: '/', '-' | downcase }})
    {% endfor %}
{% endfor %}
