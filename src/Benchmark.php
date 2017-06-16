<?php

namespace Vesic\Benchmark;

class Benchmark {
    protected $_start;
    protected $_end;
    protected $_memoryUsage;
    
    public function startTime() {
        $this->_start = microtime(true);
    }
    
    public function endTime() {
        $this->_end = microtime(true);
        $this->_memoryUsage = memory_get_usage();
    }
    
    public function run($args) {
        $args = func_get_args();
        $this->startTime();
        call_user_func_array($args[0], array_slice($args, 1));
        $this->endTime();
        echo $this->output(round(($this->_end - $this->_start), 3), $this->convertToHumanReadable($this->_memoryUsage));
    }
    
    public function convertToHumanReadable($memory) {
        return round($memory / pow(1024, ($i=floor(log($memory, 1024)))), 2). ' ' . ['b','kb','mb','gb','tb','pb'][$i];
    }
    
    public function output($time, $memory) {
        return sprintf("Your code performance:\nTime - %s. Memory - %s\n", $time, $memory);
    }
}