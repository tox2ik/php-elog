<?php

if (!function_exists('elog')) {
    // consider using: https://raw.githubusercontent.com/google-code-export/prado3/master/framework/Util/TVarDumper.php
    // window.elog = function() { return console.log.apply(console, arguments); };
    function elog($e, $f = null, $g = null) {
        $args = func_get_args();
        if (count($args) === 1) {
            error_log(print_r($args, true));
        } elseif (count($args) > 1) {
            error_log(print_r($args, true));
        } else {
            error_log(__FUNCTION__);
        }
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
    function elogm($data=null) {
        $db = debug_backtrace();
        array_shift($db);
        $last = (object) @$db[0];
        $caller = @$last->class . '@' . @$last->function;
        if ($data !== null)  return elog(array($caller => $data));
        elog($caller);
    }
}

if (!function_exists('elogj')) {
    function elogj($e) {
        $out = null;
        if (version_compare(phpversion(), '5.4', '>=')) {
            $out = json_encode($e, JSON_PRETTY_PRINT);
        } else {
            $out = str_replace('{', "{\n", json_encode($e));
        }
        error_log($out);
    }
}

