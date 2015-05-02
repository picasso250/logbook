<?php

namespace action;

function index()
{
    $logs = Service('db')->queryAll("SELECT * from logbook order by id desc");
    $render = Service('render');
    $render('index.html', compact('logs'));
}
function add()
{
    $t = _post('t');
    if (empty($t)) {
        return;
    }
    $data = ['text' => $t];
    $id = Service('db')->insert('logbook', $data);
    $log = Service('db')->get_logbook_by_id($id);
    $render = Service('render');
    $render('log.html', compact('log'));
}
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
