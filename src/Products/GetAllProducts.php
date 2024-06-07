<?php

    declare(strict_types=1);

    namespace App\Products;

    use React\Http\Message\Response;
    use Psr\Http\Message\ServerRequestInterface;

    final class GetAllProducts {

        public function __invoke(ServerRequestInterface $request) {
            return Response::plaintext("GET /products");
        }

    }