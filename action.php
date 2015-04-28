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
