<?php
    declare(strict_types=1);

    namespace App\Core;

    use LogicException;
    
    use FastRoute\Dispatcher;
    use FastRoute\RouteCollector;
    use FastRoute\Dispatcher\GroupCountBased;

    use Psr\Http\Message\ServerRequestInterface;
    use Psr\Http\Message\ResponseInterface;
    use React\Http\Message\Response;

    final class Router {
        private Dispatcher $dispatcher;

        public function __construct (RouteCollector $routes) {
            $this->dispatcher = new GroupCountBased($routes->getData());
        }

        public function __invoke (ServerRequestInterface $request): ResponseInterface {
            $routeInfo = $this->dispatcher->dispatch(
                $request->getMethod(), $request->getUri()->getPath()
            );
    
            switch ($routeInfo[0]) {
                case Dispatcher::NOT_FOUND:
                    return new Response(404, ['Content-Type' => 'text/plain'], 'Not found');
                case Dispatcher::METHOD_NOT_ALLOWED:
                    return new Response(405, ['Content-Type' => 'text/plain'], 'Method not allowed');
                case Dispatcher::FOUND:
                    $handler = $routeInfo[1];
                    return $handler($request, ...array_values($routeInfo[2]));
            }

            throw new LogicException('Something went wrong with routing');
        }
    }