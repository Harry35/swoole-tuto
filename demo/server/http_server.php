<?php

$http = new swoole_http_server("0.0.0.0", 8811);

$http->set([
    'enable_static_hanlder' => true,
    'document_root' => "/path/swoole-tuto/demo/static",
]);
$http->on('request', function ($request, $response) {
    //print_r($request->get);
    $response->cookie('toto', "helloworld", time() + 1800);
    $response->end(json_encode($request->get));
});
$http->start();