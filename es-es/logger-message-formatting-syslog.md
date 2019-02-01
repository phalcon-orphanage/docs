---
layout: article
language: 'es-es'
version: '4.0'
upgrade: '#logger'
category: 'logger'
---
# Logger Component

* * *

## Formato de mensaje

### Syslog Formatter

Formats the messages returning an array with the type and message as elements:

```bash
[
    "type",
    "message",
]
```