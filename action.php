<?php

namespace action;

use ptf\DB;

function index()
{
    $sql = "SELECT * from logbook where user_id=0 order by id desc limit 100";
    $logs = Service('db')->queryAll($sql);
    $two = Service('db')->queryAll("SELECT * from logbook group by user_id, is_show order by user_id desc, is_show asc, create_time desc limit 2");
    print_r($two);
    if (is_out_date($two)) {
        var_dump('is_out_date');
        $data = $two[0];
        $id = $data['id'];
        Service('db')->execute("DELETE from logbook where id=?", [$id]);
        unset($data['id']);
        $data['is_show'] = 1;
        $text = $data['text'];
        $data['text'] = mask($text, 2);
        Service('db')->insert('logbook', $data);
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
    $log = Service('db')->get_logbook_by_id($id);
    $render = Service('render');
    $render('log.html', compact('log'));
}

function my ()
{
    $user_id = user_id();
    $logs = Service('db')->queryAll("SELECT * from logbook where user_id=? order by id desc", [$user_id]);
    $render = Service('render');
    $render('index.html', compact('logs'));
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
