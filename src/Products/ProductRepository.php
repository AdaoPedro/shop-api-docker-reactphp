<?php
    declare(strict_types=1);

    namespace App\Products;

    use App\Repository;

    use React\Mysql\MysqlResult;

    final class ProductRepository extends Repository {

        private string $table = Product::TABLE;

        public function getAll () {
            return $this->connection
                        ->query("SELECT * FROM {$this->table}")
                        ->then(function (MysqlResult $command) {
                            return $command->resultRows;
                        });
        }
        
        public function create (string $name, float $price, int $categoryId, ) {
            return $this->connection
                        ->query(
                            "INSERT INTO {$this->table}(name, price, category_id) VALUES(?, ?, ?)",
                            [$name, $price, $categoryId]
                        )
                        ->then(function (MysqlResult $command) {
                            return $command->insertId;
                        });
        }

    }