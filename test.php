<?php

// require 'vendor/autoload.php';
// require 'action.php';
function mask($str, $n)
{
    mb_internal_encoding('UTF-8');
    $len = mb_strlen($str);
    $ret = '';
    for ($i=0; $i < $len; $i++) { 
        if (mt_rand() % $n === 0) {
            $ret .= mb_substr($str, $i, 1);
        } else {
            $ret .= '■';
        }
    }
    return $ret;
}
var_dump(mask('hello, 中国', 2));
exit;
use Testify\Testify;

$tf = new Testify("Danmu Test Suite");

$tf->test("Testing the get_sub() method", function($tf) {
    var_dump(mask('hello, 中国'));
    $tf->assertTrue(true);
});

$tf();
