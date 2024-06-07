<?php

    use React\Http\HttpServer;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use React\Http\Message\Response;
    use React\Socket\SocketServer;

    use FastRoute\ConfigureRoutes;
    use FastRoute\Dispatcher;
    use function FastRoute\simpleDispatcher;

    require dirname(__DIR__) . DIRECTORY_SEPARATOR .  "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

    $dispatcher = simpleDispatcher( function ($routes) {
        $routes->get("/", function(Request $request) {
            return Response::plaintext("GET /");
        });

        $routes->get("/products", function (Request $request) {
            return Response::plaintext("GET /products");
        });
       
        $routes->post("/products", function (Request $request) {
            return Response::plaintext("POST /products");
        });
    } );


    $httpServer = new HttpServer(
        function(Request $request) use ($dispatcher) {
            $httpMethod = $request->getMethod();
            $uri = $request->getUri()->getPath();

            $routeInfo = $dispatcher->dispatch($httpMethod, $uri);
            switch($routeInfo[0]) {
                case Dispatcher::NOT_FOUND:
                    // ... 404 Not found
                    return Response::plaintext("404 Not found");
                    break;
                case Dispatcher::METHOD_NOT_ALLOWED:
                    $allowedMethods = $routeInfo[1];
                    return Response::plaintext("405 Method Not Allowed");
                    // ... 405 Method Not Allowed
                    break;
                case Dispatcher::FOUND:
                    $handler = $routeInfo[1];
                    $vars = $routeInfo[2];
                    // ... call $handler with $vars
                    return $handler($request, ...$vars);
                    break;
                    
                
            }
            throw new \LogicException("Error on routing");
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

