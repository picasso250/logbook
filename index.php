<?php

require __DIR__.'/PHP-tiny/autoload.php';
require __DIR__.'/PHP-tiny/ptf/account.php';
require __DIR__.'/xiaochi-db/src/DB.php';

require __DIR__.'/action.php';

$config = require_config(__DIR__.'/config.php');
Service('config', $config);

define('STATIC_VERSION', $config['static']['version']);

$dbc = $config['db'];
Service('db', new xiaochi\DB($dbc['dsn'], $dbc['username'], $dbc['password']));
Service('render', function () {
    $render = new ptf\Render;
    $render->root = __DIR__.'/view';
    return $render;
});
session_start();

$app = new ptf\App([
    ['/',    'action\\index'],
    ['/add', 'action\\add'],
    ['/my',  'action\\my'],
    ['/login',  'action\\login'],
]);
$app->run();
