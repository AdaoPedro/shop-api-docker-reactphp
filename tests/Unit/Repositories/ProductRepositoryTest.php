<?php declare(strict_types=1);

    namespace Tests\Unit\Repositories;

    use PHPUnit\Framework\TestCase;
    use function React\Async\await;

    use App\Products\ProductRepository;
    use App\Products\Exceptions\InvalidCategoryIdException;

    final class ProductRepositoryTest extends TestCase {

        public function testGetAllProducts_shouldReturnAnArray(): void {
            $productRepo = new ProductRepository;
            $result = await( $productRepo->getAll() );

            $this->assertIsArray( $result );
        }

        public function testCreateProduct_WithNamePriceAndCategoryId_shouldReturnTheInsertId(): void {
            $productRepo = new ProductRepository;
            $result = await( $productRepo->create("SSD HD 1TB Transcend", 40, 2) );

            $this->assertIsInt( $result );
        }

        public function testCreateProduct_withInvalidCategoryId_shouldThrowException(): void {
            $this->expectException(InvalidCategoryIdException::class);

            $productRepo = new ProductRepository;
            $result = await( $productRepo->create("SSD HD 1TB Transcend", 40, 20) );
        }

    }