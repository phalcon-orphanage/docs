<?php

error_reporting(E_ALL);

$fp = fopen("x.txt", "r");

fputs($fp, "hello");

fclose($fp);
