<?php
// ok, this part might seem weird. Technically, there's no point in assigning
// $app return of the `require`. Even if I didn't it would still be available
// along with `$container` and whatever else I declared in `bootstrap.php`
// I did it for better readability - it is clear now that `$app` will
// be modified/redeclared after `require`
$app = require_once __DIR__ . '/bootstrap.php';

$jsonrpc_controller_v1 = new \Egoh\Controllers\JsonRpc($container);
$jsonrpc_controller_v1->configureVersion1();
$jsonrpc_controller_v1->attach('/jsonrpc/v1', $app);

$jsonrpc_controller_v2 = new \Egoh\Controllers\JsonRpc($container);
$jsonrpc_controller_v2->configureVersion2();
$jsonrpc_controller_v2->attach('/jsonrpc/v2', $app);

// This is in case server index is set to index.php and "/" resolves to us
$app->get('/', function($request, $response, $args) {
    return $response->withRedirect('/index.html');
});

$app->run();
