---
layout: default
title: 'Створення зворотного трасування'
keywords: 'backtrace, debugging, segmentation faults, зворотне трасування, відлагодження, виловлювання помилок'
---

# Створення зворотного трасування
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

Phalcon скомпільований у C-розширення, завантажене на ваш веб-сервер. Через це помилки призводять до порушення сегментації, що призводить до аварійного завершення деяких процесів вашого веб-сервера.

Щоб полагодити ці порушення сегментації, необхідне відстеження активності процесів. Створення трасування активності процесів потребує спеціальної збірки php та потрібно зробити деякі кроки для створення сліду, який дозволяє команді Phalcon налагоджувати цю поведінку.

Будь ласка, ознайомтеся з цим посібником, щоб зрозуміти, як створити зворотне трасування.

[https://bugs.php.net/bugs-generating-backtrace.php](https://bugs.php.net/bugs-generating-backtrace.php)

[https://bugs.php.net/bugs-generating-backtrace-win32.php](https://bugs.php.net/bugs-generating-backtrace-win32.php)
