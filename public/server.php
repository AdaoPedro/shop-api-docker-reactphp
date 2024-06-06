<?php

    use React\Http\HttpServer;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use React\Http\Message\Response;
    use React\Socket\SocketServer;

    require dirname(__DIR__) . DIRECTORY_SEPARATOR .  "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

    $httpServer = new HttpServer(
        function(Request $request) {
            return Response::plaintext("Hello World! \n");
        }
    );

    $httpServer->on("error", function (\Exception $ex) {
        echo "Error: " . $ex->getMessage();

        $previousException = $ex->getPrevious();

        echo $previousException !== null
            ? "Previous error: " . $previousException->getMessage() . PHP_EOL
            : "";
    });


    $socketServer =  new SocketServer("0.0.0.0:80");
    $httpServer->listen($socketServer);

    echo "Server running on "
        . str_replace("tcp", "http", $socketServer->getAddress())
        . PHP_EOL;

