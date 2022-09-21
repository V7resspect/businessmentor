<?php

spl_autoload_register(function($class) {

    $path = pathinfo(str_replace('\\', '/', $class) . '.php');
    $file = dirname(__FILE__) . '/' . strtolower($path['dirname']) . '/' . $path['basename'];

    !is_file($file) || require $file;
});