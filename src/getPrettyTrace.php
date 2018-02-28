<?php

if (! function_exists('getPrettyTrace')) {
function getPrettyTrace() {
	$trace = "\n";
	$btrace = debug_backtrace(
		DEBUG_BACKTRACE_PROVIDE_OBJECT |
		DEBUG_BACKTRACE_IGNORE_ARGS );

	foreach ($btrace as $element) {
		if ( !isset($element['file'] ))
			$element['file'] = '*nofile*';

		if ( !isset($element['line'] ))
			$element['line'] = -1;
	$trace .= sprintf("%25s / %-25s %4d=> %20s()\n",
        basename(dirname($element['file'])),
        basename( $element['file']),
        $element['line'],
        $element['function']
    );
	}
	return $trace;
}
}
