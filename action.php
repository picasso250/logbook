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
        echo json(1, 'empty');
        return;
    }
    $data = ['text' => $t];
    $id = Service('db')->insert('logbook', $data);
    echo json(compact('id'));
}
