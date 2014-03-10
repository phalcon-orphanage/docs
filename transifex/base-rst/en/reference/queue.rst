%{queue_6332f1db13668447736410ecc6fbfa07}%

========
%{queue_4effefab7e75769f5442bf260b5babd8}%


%{queue_505fd6da56ac07ad21003663bf14dc05}%

%{queue_b344a7c6d42394ffa5dcbd6360c9fe46}%

%{queue_d861a4bdd04064beee0ad4280b891a07}%

---------------------------
%{queue_4f0f692e09e17e4965af1c96ee80c35e}%


.. code-block:: php

    <?php

    //{%queue_2a3800c31fb6ed307886a661769c5729%}
    $queue = new Phalcon\Queue\Beanstalk(array(
        'host' => '192.168.0.21'
    ));

    //{%queue_b2d990e5adc30102881181c0c68bda78%}
    $queue->put(array('processVideo' => 4871));

%{queue_7dfd67b804f06fd719dc552d4dc87303}%

+----------+----------------------------------------------------------+-----------+
| Option   | Description                                              | Default   |
+==========+==========================================================+===========+
| host     | IP where the beanstalk server is located                 | 127.0.0.1 |
+----------+----------------------------------------------------------+-----------+
| port     | Connection port                                          | 11300     |
+----------+----------------------------------------------------------+-----------+

%{queue_97c986c9576036cdfaf9caa988b20129}%

%{queue_50037fc1e92a52022435c16bd4fa4115}%

.. code-block:: php

    <?php

    //{%queue_e1f0588bcc119cfc8b55c2b58722f953%}
    $queue->put(
        array('processVideo' => 4871),
        array('priority' => 250, 'delay' => 10, 'ttr' => 3600)
    );

%{queue_adefa153f60c1a9713e386ee3ef52b3a}%

+----------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Option   | Description                                                                                                                                                                                 |
+==========+=============================================================================================================================================================================================+
| priority | It's an integer < 2**32. Jobs with smaller priority values will be scheduled before jobs with larger priorities. The most urgent priority is 0; the least urgent priority is 4,294,967,295. |
+----------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| delay    | It's an integer number of seconds to wait before putting the job in the ready queue. The job will be in the "delayed" state during this time.                                               |
+----------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| ttr      | Time to run -- is an integer number of seconds to allow a worker to run this job. This time is counted from the moment a worker reserves this job.                                          |
+----------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

%{queue_792805419afcd14aa9b9ade1c8b637ae}%

.. code-block:: php

    <?php

    $jobId = $queue->put(array('processVideo' => 4871));

%{queue_d005fd4b7ced2a8f6064edcbd43f7614}%

-------------------
%{queue_6194507a7a197e897f39cdf27349775a}%


.. code-block:: php

    <?php

    while (($job = $queue->peekReady()) !== false) {

        $message = $job->getBody();

        var_dump($message);

        $job->delete();
    }

%{queue_fa84d1fa18924ca5203ffeccd04eaafd}%

.. code-block:: php

    <?php

    while ($queue->peekReady() !== false) {

        $job = $queue->reserve();

        $message = $job->getBody();

        var_dump($message);

        $job->delete();
    }

%{queue_8259d74e2240c8655ba5a57864dc70ea}%

