<?php

if(!function_exists('funcHelloWorld')){
    function funcHelloWorld($param){
        $sayhello = "Hello, $param";
        return $sayhello;
    }
}