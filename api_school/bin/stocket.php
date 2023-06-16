<?php
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use React\EventLoop\Factory;
use React\Socket\LimitingServer;
use React\Socket\Server;
use React\Socket\SecureServer;
use PSCMEDIA\Chat;
require dirname(__DIR__).'/vendor/autoload.php';
require dirname(__DIR__).'/bin/controllers.php';

$loop = Factory::create();

$server = new Server('0.0.0.0:5388', $loop);

$secureServer = new SecureServer($server, $loop, [
    'local_cert'  => dirname(__DIR__).'/ssl/certificate.crt',
    'local_pk' => dirname(__DIR__).'/ssl/private.key',
    'verify_peer' => false,
]);

// $server = IoServer::factory(
//     new HttpServer(
//         new WsServer(
//             new Chat()
//         )
//     ),
//     5388
// );
// $server->run();
// $limitingServer = new LimitingServer($secureServer, 1000); 

$httpServer = new HttpServer(
    new WsServer(
        new Chat()
    )
);

$ioServer = new IoServer($httpServer, $secureServer, $loop);

$ioServer->run();