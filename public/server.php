<?php

    use React\Http\HttpServer;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use React\Http\Message\Response;
    use React\Socket\SocketServer;
    use \Exception;

    require dirname(__DIR__) . "/vendor/autoload.php";

    $httpServer = new HttpServer(
        function(Request $request) {
            return Response::plaintext("Ola mundo!!!\n");
        }
    );

    $httpServer->on("error", function (Exception $ex) {
        echo "Error: " . $ex->getMessage();

        $previousException = $ex->getPrevious();

        echo $previousException !== null
            ? "Previous error: " . $previousException->getMessage() . PHP_EOL
            : "";
    });


    $socketServer =  new SocketServer("0.0.0.0:80");
    $httpServer->listen($socketServer);

    echo "Server running on "
        . str_replace("tcp", "http", $socketServer->getLocalAddress())
        . PHP_EOL;

