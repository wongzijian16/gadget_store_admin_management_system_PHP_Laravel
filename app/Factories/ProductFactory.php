<?php

namespace App\Factories;

use App\Contracts\ProductInterface;
use App\Models\PhysicalProduct;
use App\Models\DigitalProduct;

class ProductFactory
{
    /**
     * Create a product instance based on type.
     *
     * @param string $type
     * @return ProductInterface
     * @throws \InvalidArgumentException
     */
//    public static function createProduct(string $type): ProductInterface
//    
//    {
//        switch ($type) {
//            case 'physical':
//                return new PhysicalProduct();
//            case 'digital':
//                return new DigitalProduct();
//            default:
//                throw new \InvalidArgumentException("Invalid product type");
//        }
//    }
    
    
        public static function createProduct($type): ProductInterface
    {
        if ($type === 'physical') {
            return new PhysicalProduct();
        } elseif ($type === 'digital') {
            return new DigitalProduct();
        }

        throw new \Exception("Invalid product type");
    }
}
