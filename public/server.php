<?php

    use React\Http\HttpServer;
    use React\Socket\SocketServer;

    use React\Http\Message\Response;
    use Psr\Http\Message\ServerRequestInterface;

    use App\Core\Router;
    use FastRoute\DataGenerator\GroupCountBased;
    use FastRoute\RouteCollector;
    use FastRoute\RouteParser\Std;

    require dirname(__DIR__) . DIRECTORY_SEPARATOR .  "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

    $routes = new RouteCollector(new Std(), new GroupCountBased());
    
    $routes->get("/", function(ServerRequestInterface $request) {
        return Response::plaintext("GET /");
    });

    $routes->get("/products", function (ServerRequestInterface $request) {
        return Response::plaintext("GET /products");
    });
   
    $routes->post("/products", function (ServerRequestInterface $request) {
        return Response::plaintext("POST /products");
    });

    $httpServer = new HttpServer(
        new Router($routes)
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

