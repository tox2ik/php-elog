<?php

if (!function_exists('timeit')) {
	function timeit($msg, $now = null) {
		global $timeit_start;
		global $reqid;
		global $prev;
		if ($timeit_start == null) $timeit_start = microtime(1);
		if ($reqid == null) $reqid = substr(uniqid(), 5);
		if ($now == null) $now = microtime(1);

		$consumed = 0;
		if (null !== $prev) {
			$consumed = ($now - $timeit_start) - $prev;
		}
		error_log(sprintf("[%s] %-50s   %.3f  %.3f  %-90s", $reqid, __FILE__, $now - $timeit_start, $consumed, $msg));
		$prev = $now - $timeit_start;
	}
}

if (! function_exists('timeitAppend')) {
	function timeitAppend($identifier, $begin = false) {
		$now = microtime(1);
		static $timers;
		if ($timers === null) $timers = array();
		if (!isset($timers[$identifier])) {
			$timers[$identifier] = [
				'prev' => $now,
				'total' => 0,
				'onExit' => function () use ($identifier, &$timers) {
					error_log(
						sprintf(
							"on-exit: timeitAppend($identifier) => %.3f",
							$timers[$identifier]['total']));
				}
			];
			register_shutdown_function($timers[$identifier]['onExit']);
		}
		$timers[$identifier]['total'] += $begin ? 0 : ($now - $timers[$identifier]['prev']);
		$timers[$identifier]['prev'] = $begin ? $now : 0;
	}
}
