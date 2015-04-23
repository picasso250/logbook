<?php

require __DIR__.'/PHP-tiny/autoload.php';
require __DIR__.'/xiaochi-db/src/DB.php';

require __DIR__.'/action.php';

$config = require_config(__DIR__.'/config.php');
Service('config', $config);
$dbc = $config['db'];
Service('db', new xiaochi\DB($dbc['dsn'], $dbc['username'], $dbc['password']));
Service('render', function () {
    $render = new ptf\Render;
    $render->root = __DIR__.'/view';
    return $render;
});

$app = new ptf\App([
    ['/', 'action\\index'],
    ['/add', 'action\\add'],
]);
$app->run();
