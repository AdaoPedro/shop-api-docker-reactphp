<?php declare(strict_types=1);

    namespace App\Products\Exceptions;

    final class InvalidCategoryIdException extends \Exception {

        public function __construct(string $reason, int $code = 0) {
            parent::__construct($reason, $code);
        }

    }