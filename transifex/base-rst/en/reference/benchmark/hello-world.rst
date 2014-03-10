%{hello-world_1800af32d03bd008a9402366cb562b10}%

=====================
%{hello-world_be607a94ba810fb49f1d348cd29b87bb}%


%{hello-world_e097d55e97d0ff4d888a1c2a9eed5357}%

%{hello-world_49ec9562ad77b0b76cf7d70688d2933b}%

%{hello-world_700a6ad346d43e1699d5c0b3aadc88d3}%

--------------------------------
%{hello-world_ec893cb35c0849db46bf2925bc983027}%


* {%hello-world_8fd726917600a25986a8c691b5c226ec%}
* {%hello-world_c5f736212ef146e6ceeaad1ffc0d6525%}
* {%hello-world_942a3e8024bdd193bb139ed966607e21%}
* {%hello-world_461a2a1bb7d9edb05d40bed788ca856a%}

%{hello-world_cfd6d0dbc2b5533200c7d0c3369a32d8}%

-----------------------
* {%hello-world_7dfd4d940dc24ca12424ee7f7b8a3b48%}
* {%hello-world_a4d272ca7b3f09dccea884bec14efc42%}
* {%hello-world_2af304570efa6f3d07777817b4fbaec5%}
* {%hello-world_182f3c39700ac68c95103a3f4e84df3d%}
* {%hello-world_509642417a03137647fbbf918c0b6ef4%}
* {%hello-world_d1d751af51649ec9489b619ffabaa8ee%}
* {%hello-world_31a53a4d1d9d5e1406266247e17981e3%}


%{hello-world_b41eb33ab6ec77b77338ec73c1482297}%

-------
%{hello-world_eebbb5a7a6f98f95cb182222e9e99afd}%


%{hello-world_1f68a2266ffba5950c721cc793e612c9}%

^^^^^^^^^^^^^^^^^^^^^^
.. code-block:: php

    # ab -n 2000 -c 10 http://{%hello-world_48e76b0b84660431c3da92ec7e5dc67f%}
    This is ApacheBench, Version 2.3 <$Revision: 655654 $>
    Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://{%hello-world_8867914463339f2de85ba83ed5558268%}
    Licensed to The Apache Software Foundation, http://{%hello-world_6ea2f8b0a2d60668dd736d98dedbd3b9%}

    Benchmarking localhost (be patient)


    Server Software:        Apache/2.2.22
    Server Hostname:        localhost
    Server Port:            80

    Document Path:          /bench/Symfony/web/app.php/say/hello/
    Document Length:        16 bytes

    Concurrency Level:      5
    Time taken for tests:   1.848 seconds
    Complete requests:      1000
    Failed requests:        0
    Write errors:           0
    Total transferred:      249000 bytes
    HTML transferred:       16000 bytes
    Requests per second:    541.01 [#/sec] (mean)
    Time per request:       9.242 [ms] (mean)
    Time per request:       1.848 [ms] (mean, across all concurrent requests)
    Transfer rate:          131.55 [Kbytes/sec] received

    Connection Times (ms)
                  min  mean[+/-sd] median   max
    Connect:        0    9   4.8      8      61
    Processing:     0    0   0.6      0      15
    Waiting:        0    0   0.6      0      15
    Total:          4    9   4.8      8      61

    Percentage of the requests served within a certain time (ms)
      50%      8
      66%      9
      75%     11
      80%     12
      90%     15
      95%     18
      98%     22
      99%     30
     100%     61 (longest request)


%{hello-world_c1227286363b63972f06ff817d206c93}%

^^^^^^^^^^^^^^^^^
.. code-block:: php

    # ab -n 2000 -c 10 http://{%hello-world_569bccad7acf9a43ca3b7453ad07c9d3%}
    This is ApacheBench, Version 2.3 <$Revision: 655654 $>
    Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://{%hello-world_8867914463339f2de85ba83ed5558268%}
    Licensed to The Apache Software Foundation, http://{%hello-world_6ea2f8b0a2d60668dd736d98dedbd3b9%}

    Benchmarking localhost (be patient)


    Server Software:        Apache/2.2.22
    Server Hostname:        localhost
    Server Port:            80

    Document Path:          /bench/helloworld/codeigniter/index.php/say/hello
    Document Length:        16 bytes

    Concurrency Level:      10
    Time taken for tests:   1.888 seconds
    Complete requests:      2000
    Failed requests:        0
    Write errors:           0
    Total transferred:      418000 bytes
    HTML transferred:       32000 bytes
    Requests per second:    1059.05 [#/sec] (mean)
    Time per request:       9.442 [ms] (mean)
    Time per request:       0.944 [ms] (mean, across all concurrent requests)
    Transfer rate:          216.15 [Kbytes/sec] received

    Connection Times (ms)
                  min  mean[+/-sd] median   max
    Connect:        0    9   4.1      9      33
    Processing:     0    0   0.8      0      19
    Waiting:        0    0   0.7      0      16
    Total:          3    9   4.2      9      33

    Percentage of the requests served within a certain time (ms)
      50%      9
      66%     10
      75%     11
      80%     12
      90%     14
      95%     16
      98%     21
      99%     24
     100%     33 (longest request)


%{hello-world_f2e90ea49af5972b53ac103544e70493}%

^^^^^^^^^^^^
.. code-block:: php

    # ab -n 2000 -c 10 http://{%hello-world_87245e37e5d13d3584052c0721154a82%}
    This is ApacheBench, Version 2.3 <$Revision: 655654 $>
    Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://{%hello-world_8867914463339f2de85ba83ed5558268%}
    Licensed to The Apache Software Foundation, http://{%hello-world_6ea2f8b0a2d60668dd736d98dedbd3b9%}

    Benchmarking localhost (be patient)


    Server Software:        Apache/2.2.22
    Server Hostname:        localhost
    Server Port:            80

    Document Path:          /bench/helloworld/kohana/index.php/say/hello
    Document Length:        15 bytes

    Concurrency Level:      10
    Time taken for tests:   2.324 seconds
    Complete requests:      2000
    Failed requests:        0
    Write errors:           0
    Total transferred:      446446 bytes
    HTML transferred:       30030 bytes
    Requests per second:    860.59 [#/sec] (mean)
    Time per request:       11.620 [ms] (mean)
    Time per request:       1.162 [ms] (mean, across all concurrent requests)
    Transfer rate:          187.60 [Kbytes/sec] received

    Connection Times (ms)
                  min  mean[+/-sd] median   max
    Connect:        0   11   5.1     10      64
    Processing:     0    0   1.9      0      39
    Waiting:        0    0   1.4      0      35
    Total:          3   11   5.3     11      64

    Percentage of the requests served within a certain time (ms)
      50%     11
      66%     13
      75%     15
      80%     15
      90%     17
      95%     18
      98%     24
      99%     31
     100%     64 (longest request)


%{hello-world_8f62194b8e4f52233f1177a108718f7b}%

^^^^^^^^^^
.. code-block:: php

    # ab -n 2000 -c 10 http://{%hello-world_c5f6f35c74d217893615cdea37de662a%}
    This is ApacheBench, Version 2.3 <$Revision: 655654 $>
    Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://{%hello-world_8867914463339f2de85ba83ed5558268%}
    Licensed to The Apache Software Foundation, http://{%hello-world_6ea2f8b0a2d60668dd736d98dedbd3b9%}

    Benchmarking localhost (be patient)


    Server Software:        Apache/2.2.22
    Server Hostname:        localhost
    Server Port:            80

    Document Path:          /bench/helloworld/fuel/public/say/hello
    Document Length:        16 bytes

    Concurrency Level:      10
    Time taken for tests:   2.742 seconds
    Complete requests:      2000
    Failed requests:        0
    Write errors:           0
    Total transferred:      418000 bytes
    HTML transferred:       32000 bytes
    Requests per second:    729.42 [#/sec] (mean)
    Time per request:       13.709 [ms] (mean)
    Time per request:       1.371 [ms] (mean, across all concurrent requests)
    Transfer rate:          148.88 [Kbytes/sec] received

    Connection Times (ms)
                  min  mean[+/-sd] median   max
    Connect:        0   13   6.0     12      79
    Processing:     0    0   1.3      0      22
    Waiting:        0    0   0.8      0      21
    Total:          4   14   6.1     13      80

    Percentage of the requests served within a certain time (ms)
      50%     13
      66%     15
      75%     17
      80%     17
      90%     19
      95%     24
      98%     30
      99%     38
     100%     80 (longest request)


%{hello-world_792a2e281fc8a89af0a6f20f04efc9d6}%

^^^^^^^^^^^^^^^^^^^^^^
.. code-block:: php

    # ab -n 2000 -c 10 http://{%hello-world_7659b81b72e8d355f7e16f921ac01e83%}
    This is ApacheBench, Version 2.3 <$Revision: 655654 $>
    Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://{%hello-world_8867914463339f2de85ba83ed5558268%}
    Licensed to The Apache Software Foundation, http://{%hello-world_6ea2f8b0a2d60668dd736d98dedbd3b9%}

    Benchmarking localhost (be patient)


    Server Software:        Apache/2.2.22
    Server Hostname:        localhost
    Server Port:            80

    Document Path:          /bench/helloworld/zendfw/public/index.php
    Document Length:        16 bytes

    Concurrency Level:      10
    Time taken for tests:   5.641 seconds
    Complete requests:      2000
    Failed requests:        0
    Write errors:           0
    Total transferred:      418000 bytes
    HTML transferred:       32000 bytes
    Requests per second:    354.55 [#/sec] (mean)
    Time per request:       28.205 [ms] (mean)
    Time per request:       2.820 [ms] (mean, across all concurrent requests)
    Transfer rate:          72.36 [Kbytes/sec] received

    Connection Times (ms)
                  min  mean[+/-sd] median   max
    Connect:        0   27   9.6     25      89
    Processing:     0    1   3.0      0      70
    Waiting:        0    0   2.9      0      70
    Total:          9   28   9.6     26      90

    Percentage of the requests served within a certain time (ms)
      50%     26
      66%     28
      75%     32
      80%     34
      90%     41
      95%     46
      98%     55
      99%     62
     100%     90 (longest request)


%{hello-world_d55c02a93225bb3b6c5ffcf017d93e85}%

^^^^^^^^^^^^^
.. code-block:: php

    # ab -n 2000 -c 10 http://{%hello-world_b31d24289741d5bb7d7a3efdea5debb4%}

    This is ApacheBench, Version 2.3 <$Revision: 655654 $>
    Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://{%hello-world_8867914463339f2de85ba83ed5558268%}
    Licensed to The Apache Software Foundation, http://{%hello-world_6ea2f8b0a2d60668dd736d98dedbd3b9%}

    Benchmarking localhost (be patient)


    Server Software:        Apache/2.2.22
    Server Hostname:        localhost
    Server Port:            80

    Document Path:          /bench/helloworld/laravel/public/say/hello
    Document Length:        15 bytes

    Concurrency Level:      10
    Time taken for tests:   4.090 seconds
    Complete requests:      2000
    Failed requests:        0
    Write errors:           0
    Total transferred:      1665162 bytes
    HTML transferred:       30045 bytes
    Requests per second:    489.03 [#/sec] (mean)
    Time per request:       20.449 [ms] (mean)
    Time per request:       2.045 [ms] (mean, across all concurrent requests)
    Transfer rate:          397.61 [Kbytes/sec] received

    Connection Times (ms)
                  min  mean[+/-sd] median   max
    Connect:        0   20   7.6     19      92
    Processing:     0    0   2.5      0      53
    Waiting:        0    0   2.5      0      53
    Total:          6   20   7.6     19      93

    Percentage of the requests served within a certain time (ms)
      50%     19
      66%     21
      75%     23
      80%     24
      90%     29
      95%     34
      98%     42
      99%     48
     100%     93 (longest request)


%{hello-world_48c229f162cc5fe15ece777a27c869d9}%

^^^^^^^^^^^^^^^^^^^^^
.. code-block:: php

    # ab -n 2000 -c 10 http://{%hello-world_396e421716a36dc752e4ab5147ac6b49%}
    This is ApacheBench, Version 2.3 <$Revision: 655654 $>
    Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://{%hello-world_8867914463339f2de85ba83ed5558268%}
    Licensed to The Apache Software Foundation, http://{%hello-world_6ea2f8b0a2d60668dd736d98dedbd3b9%}

    Benchmarking localhost (be patient)


    Server Software:        Apache/2.2.22
    Server Hostname:        localhost
    Server Port:            80

    Document Path:          /bench/helloworld/phalcon/index.php?_url=/say/hello
    Document Length:        16 bytes

    Concurrency Level:      10
    Time taken for tests:   0.789 seconds
    Complete requests:      2000
    Failed requests:        0
    Write errors:           0
    Total transferred:      418000 bytes
    HTML transferred:       32000 bytes
    Requests per second:    2535.82 [#/sec] (mean)
    Time per request:       3.943 [ms] (mean)
    Time per request:       0.394 [ms] (mean, across all concurrent requests)
    Transfer rate:          517.56 [Kbytes/sec] received

    Connection Times (ms)
                  min  mean[+/-sd] median   max
    Connect:        0    4   1.7      3      23
    Processing:     0    0   0.2      0       6
    Waiting:        0    0   0.2      0       6
    Total:          2    4   1.7      3      23

    Percentage of the requests served within a certain time (ms)
      50%      3
      66%      4
      75%      4
      80%      4
      90%      5
      95%      6
      98%      8
      99%     14
     100%     23 (longest request)


%{hello-world_a94983dc1e4458d958a1a8e817cc47bf}%

^^^^^^
%{hello-world_a01002ed3c81362911d4b3598f976d34}%


.. raw:: html

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
        google.load("visualization", "1", {packages:["corechart"]});
        google.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Framework');
            data.addColumn('number', 'Requests per second');
            data.addRows([
                ['Zend', 354.55],
                ['Laravel', 489.03],
                ['Symfony', 541.01],
                ['Fuel', 568.41],
                ['Yii', 851.83],
                ['Kohana', 860.59],
                ['CodeIgniter', 1059.05],
                ['Phalcon', 2535.82]
            ]);

            var options = {
                title: 'Framework / Requests per second (#/sec) [more is better]',
                colors: ['#3366CC'],
                animation: {
                    duration: 0.5
                },
                fontSize: 12,
                chartArea: {
                    width: '600px'
                }
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('rps_div'));
            chart.draw(data, options);

            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Framework');
            data.addColumn('number', 'Time per Request');
            data.addRows([
                ['Zend', 2.820],
                ['Laravel', 2.045],
                ['Symfony', 1.848],
                ['Fuel', 1.371],
                ['Yii', 1.174],
                ['Kohana', 1.162],
                ['CodeIgniter', 0.944],
                ['Phalcon', 0.394]
            ]);

            var options = {
                title: 'Framework / Time per Request (mean, across all concurrent requests) [less is better]',
                colors: ['#3366CC'],
                fontSize: 11
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('tpr_div'));
            chart.draw(data, options);

            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Framework');
            data.addColumn('number', 'Memory Usage (MB)');
            data.addRows([
                ['Zend', 1.75],
                ['Symfony', 1.5],
                ['Yii', 1.5],
                ['Laravel', 1.25],
                ['Kohana', 1.25],
                ['CodeIgniter', 1.1],
                ['Fuel', 1.0],
                ['Phalcon', 0.75]
            ]);

            var options = {
                title: 'Framework / Memory Usage (mean, megabytes per request) [less is better]',
                colors: ['#3366CC'],
                fontSize: 11
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('mpr_div'));
            chart.draw(data, options);

            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Framework');
            data.addColumn('number', 'Number of included PHP files');
            data.addRows([
                ['Zend', 66],
                ['Laravel', 46],
                ['Kohana', 46],
                ['Fuel', 30],
                ['Yii', 27],
                ['CodeIgniter', 23],
                ['Symfony', 18],
                ['Phalcon', 4]
            ]);

            var options = {
                title: 'Framework / Number of included PHP files (mean, number on a single request) [less is better]',
                colors: ['#3366CC'],
                fontSize: 11
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('nfi_div'));
            chart.draw(data, options);

        }
    </script>
    <div align="center">
        <div id="rps_div" style="width: 600px; height: 400px; position: relative; "><iframe name="Drawing_Frame_31166" id="Drawing_Frame_31166" width="600" height="400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><div></div></div>
        <div id="tpr_div" style="width: 600px; height: 400px; position: relative; "><iframe name="Drawing_Frame_89467" id="Drawing_Frame_89467" width="600" height="400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><div></div></div>
        <div id="nfi_div" style="width: 600px; height: 400px; position: relative; "><iframe name="Drawing_Frame_49746" id="Drawing_Frame_49746" width="600" height="400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><div></div></div>
        <div id="mpr_div" style="width: 600px; height: 400px; position: relative; "><iframe name="Drawing_Frame_77939" id="Drawing_Frame_77939" width="600" height="400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><div></div></div>
    </div>


%{hello-world_ee50f1d496b9cd00d5955f10f6dc7517}%

----------
%{hello-world_68ef87283b6316f5d9008d3f147a2511}%


%{hello-world_33fa5f2e3ee45b74877500f5588a41e2}%

