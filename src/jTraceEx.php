<?php

/**
 * jTraceEx() - provide a Java style exception trace
 *
 * @param \Exception $e
 * @param array $seen passed to recursive calls to accumulate trace lines already seen.
 *              leave as NULL when calling this function
 * ---return array of strings, one entry per trace line
 *
 * @return string
 */

function jTraceEx($e, $seen=null) {
	$starter = $seen ? 'Caused by: ' : '';
	$result = array();
	if (! $seen) $seen = array();
	$trace  = $e->getTrace();
	$prev   = $e->getPrevious();
	$result[] = sprintf('%s%s: %s', $starter, get_class($e), $e->getMessage());
	$file = $e->getFile();
	$line = $e->getLine();
	while (true) {
		$current = "$file:$line";
		if (in_array($current, $seen)) {
			$end = end($trace);
			$result[] = sprintf(' ... %d more (main:  %s:%s)', count($trace)+1, @$end['file'], @$end['line']);
			break;
		}

		$result[] = sprintf(" at %s%s%s(%s%s%s)",
			count($trace) && array_key_exists('class',    $trace[0])                                            ? str_replace('\\', '.', $trace[0]['class']) : null,
			count($trace) && array_key_exists('class',    $trace[0]) && array_key_exists('function', $trace[0]) ? '::' : '',
			count($trace) && array_key_exists('function', $trace[0])                                            ? str_replace('\\', '.', $trace[0]['function']) : '(main)',
			$line === null ? $file : basename($file),
			$line === null ? '' : ':',
			$line === null ? '' : $line

		);
		$seen[] = "$file:$line";
		if (!count($trace)) break;
		$file = array_key_exists('file', $trace[0])                                                             ? $trace[0]['file'] : 'anonymous source';
		$line = array_key_exists('file', $trace[0]) && array_key_exists('line', $trace[0]) && $trace[0]['line'] ? $trace[0]['line'] : null;
		array_shift($trace);
	}

	$out = join("\n", $result);
	if ($prev)
		$out  .= "\n-pp-\n" . jTraceEx($prev, $seen);
	return $out;
}
