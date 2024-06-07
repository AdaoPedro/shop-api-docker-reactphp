<?php

    declare(strict_types=1);

    namespace App\Products;

    use React\Http\Message\Response;
    use Psr\Http\Message\ServerRequestInterface;
    use function React\Async\await;

    final class GetAllProducts {

        public function __construct (private ProductRepository $repo) {}

        public function __invoke(ServerRequestInterface $request) {
            try {
                
                $products = await( $this->repo->getAll() );

                return new response(
                    Response::STATUS_OK,
                    [
                        'Content-Type' => 'application/json'
                    ],
                    json_encode(
                        $products,
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