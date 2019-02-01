---
layout: article
language: 'it-it'
version: '4.0'
upgrade: '#logger'
category: 'logger'
---
# Logger Component

* * *

## Message Formatting

### Syslog Formatter

Formats the messages returning an array with the type and message as elements:

```bash
[
    "type",
    "message",
]
```