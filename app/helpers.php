<?php

function dump($value)
{
 	$bt = debug_backtrace();
	echo '<pre>'.$bt[0]['file'].' '.$bt[0]['line'].'<br>'.print_r($value, true).'</pre>';
}

function dd($value)
{
 	$bt = debug_backtrace();
	echo '<pre>'.$bt[0]['file'].' '.$bt[0]['line'].'<br>'.print_r($value, true).'</pre>';
	die();
}

function array_update_keys($ar, callable $callback)
{
	$updated = [];
	foreach ($ar as $key => $value) {
		$newKey = $callback($key);
		$updated[$newKey] = $value;
	}
	return $updated;
}

function parse_config_sh($file) {
    $config = [];
    $handle = fopen($file, "r");
    if ($handle) {
        while (($line = fgets($handle)) !== false) {
            // skip bash declaration and comments
            if ($line[0] == '#') continue;
            $cfg_item = explode('=', $line);
            $config[$cfg_item[0]] = trim($cfg_item[1]);
        }
        fclose($handle);
    }
    return $config;    
}
