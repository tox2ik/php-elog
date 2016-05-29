<?php

if (! function_exists('getPrettyTrace')) {
function getPrettyTrace() {
	$trace ='';
	$btrace = debug_backtrace( 
		DEBUG_BACKTRACE_PROVIDE_OBJECT |
		DEBUG_BACKTRACE_IGNORE_ARGS );

	foreach ($btrace as $element) {
		if ( !isset($element['file'] ))
			$element['file'] = '*nofile*';

		if ( !isset($element['line'] ))
			$element['line'] = -1;

	$trace .= sprintf("%20s/%20s %4d %20s()\n", 
			dirname( basename( $element['file'])),
			         basename( $element['file']) , 
			$element['line'], $element['function']);
	}
	return $trace;
}
}
