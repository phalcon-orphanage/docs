Hello World Benchmark
=====================

How the benchmarks were performed?
----------------------------------

We created a "Hello World" benchmark seeking to identify the smallest load overhead of each framework. Many
people don't like this kind of benchmark because real-world applications require more complex features or
structures. However, these tests identify the minimum time spent by each framework to perform a simple task.
Such a task represents the mimimum requirement for every framework to process a single request.

More specifically, the benchmark only measures the time it takes for a framework to start, run an action and
free up resources at the end of the request. Any PHP application based on an MVC architecture will require
this time. Due to the simplicity of the benchmark, we ensure that the time needed for a more complex
request will be higher.

A controller and a view have been created for each framework. The controller "say" and action "hello". The
action only sends data to the view which displays it ("Hello!"). Using the "ab" benchmark tool we sent 2000
requests using 10 concurrent connections to each framework.

What measurements were recorded?
--------------------------------
These were the measurements we record to identify the overall performance of each framework:

* Requests per second
* Time across all concurrent requests
* Number of included PHP files on a single request (measured using function get_included_files_.
* Memory Usage per request (measured using function memory_get_usage_.

Pariticipant Frameworks
-----------------------

* Yii_ (YII_DEBUG=false) (yii-1.1.13)
* FuelPHP_ (1.2.1)
* CodeIgniter_ (2.1.0)

Results
-------

Yii (YII_DEBUG=false) Version yii-1.1.13
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

.. code-block:: php

	# ab -n 1000 -c 5 http://localhost/bench/helloworld/yii/index.php?r=say/hello
	This is ApacheBench, Version 2.3 <$Revision: 655654 $>
	Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
	Licensed to The Apache Software Foundation, http://www.apache.org/

	Benchmarking localhost (be patient)


	Server Software:        Apache/2.2.22
	Server Hostname:        localhost
	Server Port:            80

	Document Path:          /bench/helloworld/yii/index.php?r=say/hello
	Document Length:        61 bytes

	Concurrency Level:      10
	Time taken for tests:   2.081 seconds
	Complete requests:      2000
	Failed requests:        0
	Write errors:           0
	Total transferred:      508000 bytes
	HTML transferred:       122000 bytes
	Requests per second:    961.28 [#/sec] (mean)
	Time per request:       10.403 [ms] (mean)
	Time per request:       1.040 [ms] (mean, across all concurrent requests)
	Transfer rate:          238.44 [Kbytes/sec] received

	Connection Times (ms)
	              min  mean[+/-sd] median   max
	Connect:        0   10   4.3      9      42
	Processing:     0    0   1.0      0      24
	Waiting:        0    0   0.8      0      17
	Total:          3   10   4.3      9      42

	Percentage of the requests served within a certain time (ms)
	  50%      9
	  66%     11
	  75%     13
	  80%     14
	  90%     15
	  95%     17
	  98%     21
	  99%     26
	 100%     42 (longest request)



CodeIgniter 2.1.0
^^^^^^^^^^^^^^^^^

.. code-block:: php

	# ab -n 2000 -c 10 http://localhost/bench/codeigniter/index.php/say/hello
	This is ApacheBench, Version 2.3 <$Revision: 655654 $>
	Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
	Licensed to The Apache Software Foundation, http://www.apache.org/

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



Fuel 1.2.1
^^^^^^^^^^

.. code-block:: php

	# ab -n 2000 -c 10 http://localhost/bench/helloworld/fuel/public/say/hello
	This is ApacheBench, Version 2.3 <$Revision: 655654 $>
	Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
	Licensed to The Apache Software Foundation, http://www.apache.org/

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

Phalcon Version 1.0.1
^^^^^^^^^^^^^^^^^^^^^

.. code-block:: php

	# ab -n 2000 -c 10 http://localhost/bench/helloworld/phalcon/index.php?_url=/say/hello
	This is ApacheBench, Version 2.3 <$Revision: 655654 $>
	Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
	Licensed to The Apache Software Foundation, http://www.apache.org/

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

Graphs
^^^^^^

The first graph shows how many requests per second each framework was able to accept. The second shows the average time across all concurrent requests.

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
				['Nette', 258.07],
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
				['Nette', 3.875],
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
				['Nette', 3.5],
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
				['Nette', 7],
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

Conclusion
----------

The compiled nature of Phalcon offers extraordinary performance that outperforms all other frameworks measured in these benchmarks.

.. _get_included_files: http://www.php.net/manual/en/function.get-included-files.php
.. _memory_get_usage: http://php.net/manual/en/function.memory-get-usage.php
.. _Yii: http://www.yiiframework.com/
.. _Symfony: http://symfony.com/
.. _CodeIgniter: http://codeigniter.com/
.. _Kohana: http://kohanaframework.org/index
.. _FuelPHP: http://fuelphp.com/
.. _CakePHP: http://cakephp.org/
.. _Laravel: http://www.laravel.com/
.. _Zend Framework: http://framework.zend.com
.. _Nette: http://nette.org/

