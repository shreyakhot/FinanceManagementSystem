<?php

namespace App\Services\Log;

use Illuminate\Support\Facades\Log;

class LogService
{
    public function info($message)
    {
        Log::info($this->exceptionDetails($message));
    }

    public function error($message)
    {
        Log::error($this->exceptionDetails($message));
    }

    public function warning($message)
    {
        Log::emergency($this->exceptionDetails($message));
    }

    public function debug($message)
    {
        Log::emergency($this->exceptionDetails($message));
    }

    public function fetal($message)
    {
        Log::emergency($this->exceptionDetails($message));
    }

    public function exceptionDetails($message){
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 3);

        // The caller's class, function, and line
        $class = $backtrace[2]['class'] ?? 'N/A';
        $method = $backtrace[2]['function'] ?? 'N/A';
        $lineNo = $backtrace[1]['line'] ?? 'N/A';

        // Get the relative path to the controller from the base path
        //$fileInfo = $backtrace[0]['file'];  //enable and use this if need complete file path

        // Create the log format
        return " Class => {$class} Function => {$method}(lineNo: {$lineNo}) Message => {$message}";
    }
}
