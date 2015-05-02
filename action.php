<?php

namespace action;

use ptf\DB;

function index()
{
    $sql = "SELECT * from logbook where user_id=0 order by id desc limit 100";
    $logs = Service('db')->queryAll($sql);
    $sql = "SELECT * from logbook where is_show=0 group by user_id order by user_id desc, create_time desc";
    $all_user = Service('db')->queryAll($sql);
    $sql = "SELECT * from logbook where is_show=1 group by user_id order by user_id desc, create_time desc";
    $latest = Service('db')->queryAll($sql);
    $logs = array_merge($logs, $latest);
    usort($logs, function($a, $b) {return strcmp($a['create_time'], $b['create_time']);});

    $latest_keys = [];
    foreach ($latest as $row) {
        $latest_keys[$row['id']] = $row;
    }
    $all_user_keys[];
    foreach ($all_user as $row) {
        $id = $row['id'];
        if (!isset($latest_keys[$id])) {
            secret_log($row);
        } else {
            $old = $latest_keys[$id];
            if ($row['create_time'] != $old['create_time']) {
                secret_log($row);
            }
        }
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
function secret_log($data)
{
    $sql = "DELETE from logbook where user_id=? and is_show=1";
    Service('db')->execute($sql, [$data['user_id']]);
    unset($data['id']);
    $data['is_show'] = 1;
    $text = $data['text'];
    $data['text'] = mask($text, 2);
    error_log("$text to $data[text]");
    Service('db')->insert('logbook', $data);
}
