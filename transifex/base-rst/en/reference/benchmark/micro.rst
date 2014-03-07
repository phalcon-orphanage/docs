%{micro_eab4d07d8a9575f527b3730ef3370c35}%
===============
%{micro_7b6ecb13a2c6daf1001477919719f5cb}%

%{micro_5ba672f78c975f4589f71d697256adcc}%

%{micro_700a6ad346d43e1699d5c0b3aadc88d3}%
--------------------------------
%{micro_ec893cb35c0849db46bf2925bc983027}%

%{micro_206f9a7d463cbb1929f6fc75d7a4d8b0}%

%{micro_cfd6d0dbc2b5533200c7d0c3369a32d8}%
----------------------
%{micro_6a94f6e78a0a0dbc0ea234fed60c0f75}%

%{micro_b41eb33ab6ec77b77338ec73c1482297}%
-------
%{micro_28aed413d87cef284812ecd6f37592d2}%

%{micro_4ae903c204ca77a929c7e45e6fa9de81}%
^^^^^
%{micro_ab6f3fa9ecd5a5850eaf85b25efe33ab}%

%{micro_3b5d5768410054932ff9d0f1dffe8028}%
^^^^^^^^^^^^^
%{micro_bc1d1f1403e88ffce4551a78c8796af9}%

%{micro_a94983dc1e4458d958a1a8e817cc47bf}%
^^^^^^
%{micro_a01002ed3c81362911d4b3598f976d34}%

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
                ['Silex',    448.75],
                ['Slim',    1134.21],
                ['Phalcon', 2516.74]
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
                ['Silex',   2.228],
                ['Slim',    0.882],
                ['Phalcon', 0.397]
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
                ['Silex',   1.25],
                ['Slim',    1.25],
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
                ['Silex',    54],
                ['Slim',     17],
                ['Phalcon',   2]
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


%{micro_ee50f1d496b9cd00d5955f10f6dc7517}%
----------
%{micro_68ef87283b6316f5d9008d3f147a2511}%

