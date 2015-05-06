<?php

// require 'vendor/autoload.php';
// require 'action.php';
use Testify\Testify;

$tf = new Testify("Danmu Test Suite");

$tf->test("Testing the get_sub() method", function($tf) {
    var_dump(mask('hello, 中国'));
    $tf->assertTrue(true);
});

$tf();
