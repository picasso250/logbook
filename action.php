<?php

namespace action;

function index()
{
    $render = Service('render');
    $render('index.html');
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
