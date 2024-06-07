<?php
    declare (strict_types=1);

    namespace App\Core\Database;

    use React\Mysql\MysqlClient;

    final class Connection {

        private static $instance;
        private MysqlClient $asyncMysqlClient;

        public function __construct () {
            $connectionString = sprintf(
                "%s:%s@%s:%s/%s",
                $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"], $_ENV["DB_HOST"], $_ENV["DB_PORT"], $_ENV["DB_NAME"]
            );

            try {
                $this->asyncMysqlClient = new MySqlClient($connectionString);
            } catch (\Exception $ex) {
                echo "Cannot connect to database: " . $ex->getMessage();
            }
        }

        public static function getInstance(): self {
            if (self::$instance === null) {
                self::$instance = new self();
            }

            return self::$instance;
        }

        public function getAsyncMysqlClient(): MysqlClient { return $this->asyncMysqlClient; }

    }