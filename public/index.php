<?php
// ok, this part might seem weird. Technically, there's no point in assigning
// $app return of the `require`. Even if I didn't it would still be available
// along with `$container` and whatever else I declared in `bootstrap.php`
// I did it for better readability - now it's' obvious, that `$app` will
// be modified/redeclared after `require`
$app = require_once __DIR__ . '/bootstrap.php';

$jsonrpc_controller = new \Egoh\Controllers\JsonRpc($container);
$jsonrpc_controller->attach('/jsonrpc/v1', $app);

// No point in creating a controller for a client
// Can even be left to nginx to handle
// @todo Make client side static
$app->get('/client', function($request, $response, $args) {
    return $this->view->render($response, 'index.twig');
});

$app->run();
