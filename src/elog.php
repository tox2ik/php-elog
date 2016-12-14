<?php

if (!function_exists('elog')) {
    // window.elog = function() { return console.log.apply(console, arguments); };
    function elog($e) { 
        error_log(print_r($e, true));
    }
}

if (!function_exists('eloga')) {
	function eloga() {
		$db = debug_backtrace();
		array_shift($db);
		$last = (object) $db[0];
		if (!isset($last->args))  {
			$arguments = '';
		} else {
			$arguments = json_encode($last->args, JSON_PRETTY_PRINT);
		}
		
		error_log(@$last->class . '@' . $last->function . $arguments);
	}
}

if (!function_exists('elogr')) {
	function elogr() {
		
		$db = debug_backtrace();
		array_shift($db);
		$last = (object) $db[0];
		if (isset($last->args)) {
			foreach ($last->args as $i => $a) {

				if (class_exists('\Slim\Http\Request') and ($a instanceof \Slim\Http\Request)) {
					elog(array(@$last->class . '@' . @$last->function => $a->getParams()));
					break;
				}
				
				if (class_exists('\Illuminate\Http\Request') and ($a instanceof \Illuminate\Http\Request)) {
					elog( array(@$last->class . '@' . @$last->function => $a->all()));
					break;
				}
			}
		}
	}
}


if (!function_exists('elogm')) {
	function elogm($data) {
		$db = debug_backtrace();
		array_shift($db);
		$last = (object) @$db[0];
		$caller = @$last->class . '@' . @$last->function;
		elog(array($caller => $data));
	}
}
