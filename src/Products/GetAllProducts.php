<?php

    declare(strict_types=1);

    namespace App\Products;

    use React\Http\Message\Response;
    use Psr\Http\Message\ServerRequestInterface;

    final class GetAllProducts {

        public function __invoke(ServerRequestInterface $request) {
            try {
                $connection = (new \App\Core\Database\Connection)->getInstance()->getAsyncMysqlClient();

                $connection->query("SHOW TABLES")
                           ->then(function (\React\Mysql\MysqlResult $result) {
                                print_r($result->resultRows);
                           });
                
            } catch (\Exception $ex) {
                echo "/n/n *** " . $ex->getMessage() . "\n\n";
            }

            return Response::plaintext("GET /products");
        }

    }