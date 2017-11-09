<?php

function handleErrorWithSlimElog($no, $str, $file=null, $line = null) {
    $eType = array(
        E_ERROR => 'E_ERROR',
        E_WARNING => 'E_WARNING',
        E_PARSE => 'E_PARSE',
        E_NOTICE => 'E_NOTICE',
        E_CORE_ERROR => 'E_CORE_ERROR',
        E_CORE_WARNING => 'E_CORE_WARNING',
        E_COMPILE_ERROR => 'E_COMPILE_ERROR',
        E_COMPILE_WARNING => 'E_COMPILE_WARNING',
        E_USER_ERROR => 'E_USER_ERROR',
        E_USER_WARNING => 'E_USER_WARNING',
        E_USER_NOTICE => 'E_USER_NOTICE',
        E_STRICT => 'E_STRICT',
        E_RECOVERABLE_ERROR => 'E_RECOVERABLE_ERROR',
        E_DEPRECATED => 'E_DEPRECATED',
        E_USER_DEPRECATED => 'E_USER_DEPRECATED',
    );

	if (error_reporting() & $no) {
		error_log(sprintf('%-10s %s:%d; %s', substr($eType[$no], 0,10) , $file, $line, $str));
		//elog("--($no)ERR? $file:$line; $str ");
	}
	//elog(getPrettyTrace());
}


function setSlimElogErrorHandler() {
    set_error_handler('handleErrorWithSlimElog');
}

function set_error_handler_slim_elog() {
    set_error_handler('handleErrorWithSlimElog');
}

