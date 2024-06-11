<?php declare(strict_types=1);

    namespace App\Products\Controllers;

    use React\Http\Message\Response;
    use Psr\Http\Message\ServerRequestInterface;
    use Psr\Http\Message\ResponseInterface;
    use function React\Async\await;

    use App\Products\ProductRepository;

    final class GetAllProducts {

        public function __construct (private ProductRepository $repo) {}

        public function __invoke(ServerRequestInterface $request): ResponseInterface {
            try {
                
                $products = await( $this->repo->getAll() );

                /** @var string[] $headers */
                $headers = ["Content-Type" => "application/json"];

                return new response(
                    Response::STATUS_OK,
                    $headers,
                    (string) json_encode(
                        $products,
                        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRESERVE_ZERO_FRACTION
                    )
                );
                
            } catch (\Exception $ex) {
                echo "Cannot get product records from database: " . $ex->getMessage() . PHP_EOL;
                
                /** @var string[] $headers */
                $headers = ["Content-Type" => "application/json"];
                return new Response(
                    500, $headers, (string) json_encode(["error" => $ex->getMessage()])
                );
            }
            
        }

    }