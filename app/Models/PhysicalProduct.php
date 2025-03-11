<?php

namespace App\Models;

use App\Contracts\ProductInterface;
use Illuminate\Database\Eloquent\Model;

class PhysicalProduct extends Model implements ProductInterface
{
//    protected $fillable = ['name', 'description', 'price', 'stock', 'image_url'];
//
//    /**
//     * Implement the create method from ProductInterface.
//     */
//    public function create(array $attributes)
//    {
//        return self::create($attributes);  // Create a new physical product
//    }
    
        public function create(array $data)
    {
        return Product::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'stock' => $data['stock'],
            'image_url' => $data['image_url'],
            'category_id' => $data['category_id'],
            'type' => 'physical',
        ]);
    }
}
