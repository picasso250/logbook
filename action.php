<?php

namespace action;

use xiaochi\DB;

function index()
{
    $n = 100;
    $sql = "SELECT * from logbook where user_id=0 or is_show=1 order by id desc limit $n";
    $logs = Service('db')->queryAll($sql);
    if (count($logs) === $n && mt_rand() % 1000 === 0) {
        Service('db')->execute("DELETE from logbook where id < ? and is_show=1", end(logs)['id']);
    }
    $render = Service('render');
    $render('index.html', compact('logs'));
}
function add()
{
    $t = _post('t');
    if (empty($t)) {
        return;
    }
    $data = [
        'text' => $t,
        'user_id' => user_id(),
        'create_time' => DB::timestamp(),
    ];
    $id = Service('db')->insert('logbook', $data);
    secret_log($data);
    $log = Service('db')->get_logbook_by_id($id);
    $render = Service('render');
    $render('log.html', compact('log'));
}

function my ()
{
    $user_id = user_id();
    $sql = "SELECT * from logbook where user_id=? and is_show=0 order by id desc";
    $logs = Service('db')->queryAll($sql, [$user_id]);
    $render = Service('render');
    $render('index.html', compact('logs'));
}

function login()
{
    $user_id = _get('user_id');
    user_id($user_id);
    redirect('/');
}

// ==== logic ====

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
function is_out_date($two)
{
    return count($two) === 1 || $two[0]['user_id'] !== $two[1]['user_id']
        || $two[0]['create_time'] !== $two[1]['create_time'];
}
function secret_log($data)
{
    unset($data['id']);
    $data['is_show'] = 1;
    $text = $data['text'];
    $data['text'] = mask($text, 2);
    error_log("$text to $data[text]");
    Service('db')->insert('logbook', $data);
}
