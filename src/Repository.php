<?php
    declare(strict_types=1);

    namespace App;

    use App\Core\Database\Connection;
    use React\Mysql\MysqlClient;

    abstract class Repository {

        protected MysqlClient $connection;

        public function __construct () {
            $this->connection = (new \App\Core\Database\Connection())->getInstance()->getAsyncMysqlClient();
        }

    } 