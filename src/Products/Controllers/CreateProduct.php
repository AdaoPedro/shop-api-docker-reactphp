<?php

    declare(strict_types=1);

    namespace App\Products\Controllers;

    use React\Http\Message\Response;
    use Psr\Http\Message\ServerRequestInterface;
    use Psr\Http\Message\ResponseInterface;
    use function React\Async\await;

    use App\Products\ProductRepository;

    final class CreateProduct {

        public function __construct (private ProductRepository $repo) {}

        public function __invoke(ServerRequestInterface $request): ResponseInterface  {
            try {

                $data = $request->getParsedBody();

                $name = (string)  $data["name"];
                $price = (float)  $data["price"];
                $categoryId = (int)  $data["category_id"];
                
                $productId = await( $this->repo->create($name, $price, $categoryId) );

                return new response(
                    Response::STATUS_OK,
                    [
                        'Content-Type' => 'application/json'
                    ],
                    json_encode(
                        ["id" => $productId],
                        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRESERVE_ZERO_FRACTION
                    )
                );
                
            } catch (\Exception $ex) {
                echo "Cannot get product records from database: " . $ex->getMessage() . PHP_EOL;
                
                return new Response(
                    500, ["Content-Type: application/json"], json_encode(["error" => $ex->getMessage()])
                );
            }
        }

    }