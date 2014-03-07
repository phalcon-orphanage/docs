%{hello-world_1800af32d03bd008a9402366cb562b10}%
=====================
%{hello-world_be607a94ba810fb49f1d348cd29b87bb}%

%{hello-world_e097d55e97d0ff4d888a1c2a9eed5357}%

%{hello-world_49ec9562ad77b0b76cf7d70688d2933b}%

%{hello-world_700a6ad346d43e1699d5c0b3aadc88d3}%
--------------------------------
%{hello-world_ec893cb35c0849db46bf2925bc983027}%

%{hello-world_206f9a7d463cbb1929f6fc75d7a4d8b0}%

%{hello-world_cfd6d0dbc2b5533200c7d0c3369a32d8}%
-----------------------
%{hello-world_2b86a81605ae77b4d2fdf472eaf9861f}%

%{hello-world_b41eb33ab6ec77b77338ec73c1482297}%
-------
%{hello-world_eebbb5a7a6f98f95cb182222e9e99afd}%

%{hello-world_1f68a2266ffba5950c721cc793e612c9}%
^^^^^^^^^^^^^^^^^^^^^^
%{hello-world_efd645d60467e031c41de25fabfac6a0}%

%{hello-world_c1227286363b63972f06ff817d206c93}%
^^^^^^^^^^^^^^^^^
%{hello-world_d6de87e1cf7b240103bce8dd423412af}%

%{hello-world_f2e90ea49af5972b53ac103544e70493}%
^^^^^^^^^^^^
%{hello-world_7a554496c19714b9e6dd6da212973438}%

%{hello-world_8f62194b8e4f52233f1177a108718f7b}%
^^^^^^^^^^
%{hello-world_9a9acdc09a40318cfbdec66c705d8cf1}%

%{hello-world_792a2e281fc8a89af0a6f20f04efc9d6}%
^^^^^^^^^^^^^^^^^^^^^^
%{hello-world_3bfde5d82472f308c951ccf7c5bfcee1}%

%{hello-world_d55c02a93225bb3b6c5ffcf017d93e85}%
^^^^^^^^^^^^^
%{hello-world_bb9780a4752e1229aa1e32d2d0ce2ea1}%

%{hello-world_48c229f162cc5fe15ece777a27c869d9}%
^^^^^^^^^^^^^^^^^^^^^
%{hello-world_50beb857765b105f681b81958f15957c}%

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

