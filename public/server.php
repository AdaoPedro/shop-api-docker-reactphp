<?php

    use React\Http\HttpServer;
    use React\Socket\SocketServer;

    use App\Core\Router;

    use FastRoute\{
        RouteCollector,
        RouteParser\Std,
        DataGenerator\GroupCountBased,
    };

    use App\Products\Controllers\{
        GetAllProducts,
        CreateProduct
    };

    require dirname(__DIR__) . DIRECTORY_SEPARATOR .  "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

    $log = function (string $message): void { echo $message . PHP_EOL; };

    $errorHandler = function (\Exception $ex): void {
        $log("Error: {$ex->getMessage()}");

        $previousException = $ex->getPrevious();

        echo $previousException !== null
            ? $log("Previous error: {$previousException->getMessage()}")
            : "";
    };

    $routes = new RouteCollector(new Std(), new GroupCountBased());
    $routes->get("/products", new GetAllProducts(new \App\Products\ProductRepository));
    $routes->post("/products", new CreateProduct(new \App\Products\ProductRepository));

    $httpServer = new HttpServer( new Router($routes) );

    $httpServer->on("error", $errorHandler);


    $socketServer =  new SocketServer("0.0.0.0:80");
    $httpServer->listen($socketServer);

    echo "Server running on "
        . str_replace("tcp", "http", $socketServer->getAddress())
        . PHP_EOL;

