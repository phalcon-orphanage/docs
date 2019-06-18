---
layout: default
language: 'en'
version: '4.0'
title: 'API Index'
---

## API Index
{% assign rootNamespace = '' %}
{% for apiPage in site.pages %}
    {% if page.language == apiPage.language and page.version == apiPage.version %} {% assign stub = apiPage.name | slice: 0, 8 %} {% if "Phalcon_" == stub %} {% assign parts = apiPage.name | split: '*' %} {% assign partNs = parts[1] | replace: '.md', '' | replace: '.html', '' %} {% assign linkUrl = apiPage.name | replace: '.md', '' | replace: '.html', '' %} {% assign linkName = linkUrl | replace: '*', '\' | replace: '.md', '' | replace: '.html', '' %}{% if rootNamespace != partNs %}
### {{ partNs }}
            {% assign rootNamespace = partNs %}
            {% endif %}
* [{{ linkName }}](/{{ apiPage.version }}/{{ apiPage.language }}/api/{{ linkUrl }})
        {% endif %}
    {% endif %}
{% endfor %}
