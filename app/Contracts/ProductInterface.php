<?php

namespace App\Contracts;

interface ProductInterface
{
    /**
     * Create a new product.
     *
     * @param array $attributes
     * @return mixed
     */
//    public function create(array $attributes);
    public function create(array $data);
}
