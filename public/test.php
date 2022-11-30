<?php
declare(strict_types=1);

$req_dump = file_get_contents('php://input');
//print to log file
$date = new DateTime();
$log_line = '[' . $date->format('Y-m-d H:i:s') . ']: ' . $req_dump . PHP_EOL;
$fp = file_put_contents('request.log', $log_line, FILE_APPEND);

echo($req_dump);
echo "OK";