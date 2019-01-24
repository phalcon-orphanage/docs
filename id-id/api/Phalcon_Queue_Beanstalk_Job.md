---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Queue\Beanstalk\Job'
---
# Class **Phalcon\Queue\Beanstalk\Job**

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/queue/beanstalk/job.zep)

Merupakan pekerjaan dalam antrian beanstalk

## Metode

public **getId** ()

public **getBody** ()

public **__construct** ([Phalcon\Queue\Beanstalk](Phalcon_Queue_Beanstalk) $queue, *mixed* $id, *mixed* $body)

public **delete** ()

Menghapus pekerjaan dari server sepenuhnya

public **release** ([*mixed* $priority], [*mixed* $delay])

The release command puts a reserved job back into the ready queue (and marks its state as "ready") to be run by any client. It is normally used when the job fails because of a transitory error.

public **bury** ([*mixed* $priority])

The bury command puts a job into the "buried" state. Buried jobs are put into a FIFO linked list and will not be touched by the server again until a client kicks them with the "kick" command.

public **touch** ()

The `touch` command allows a worker to request more time to work on a job. Ini berguna untuk pekerjaan yang berpotensi butuh waktu lama, tapi tetap saja menginginkan manfaat TTR menarik pekerjaan dari pekerja yang tidak responsif. A worker may periodically tell the server that it's still alive and processing a job (e.g. it may do this on `DEADLINE_SOON`). Perintah itu menunda auto pelepasan pekerjaan yang dipesan sampai TTR detik dari saat perintah dikeluarkan.

public **kick** ()

Pindahkan pekerjaan ke antrian siap jika ditunda atau dikuburkan.

public **stats** ()

Memberikan informasi statistik tentang pekerjaan tertentu jika ada.

public **__wakeup** ()

Memeriksa apakah pekerjaan telah dimodifikasi setelah unserializing objek