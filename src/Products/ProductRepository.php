<?php
    declare(strict_types=1);

    namespace App\Products;

    use React\Promise\PromiseInterface;
    use React\Mysql\MysqlResult;

    use App\Repository;
    use App\Products\Exceptions\InvalidCategoryIdException;

    final class ProductRepository extends Repository {

        private string $table = Product::TABLE;

        public function getAll (): PromiseInterface {
            return $this->connection
                        ->query("SELECT * FROM {$this->table}")
                        ->then(function (MysqlResult $command) {
                            return $command->resultRows;
                        });
        }
        
        public function create (string $name, float $price, int $categoryId, ): PromiseInterface {
            return $this->connection
                        ->query(
                            "INSERT INTO {$this->table}(name, price, category_id) VALUES(?, ?, ?)",
                            [$name, $price, $categoryId]
                        )
                        ->then(function (MysqlResult $command) {
                            return $command->insertId;
                        })
                        ->catch(function(\Exception $ex) {
                            throw new InvalidCategoryIdException( $ex->getMessage() );
                        });
        }

    }