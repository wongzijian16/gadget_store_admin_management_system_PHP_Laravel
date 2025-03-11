<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderServiceController extends Controller
{
    private $products = [
        "book" => 20,
        "pen" => 10,
        "pencil" => 5
    ];

    // GET: /api/product/{name}
    public function getPrice($name)
    {
        $newName = strtolower($name);

        if (array_key_exists($newName, $this->products)) {
            return response()->json(['name' => $newName, 'price' => $this->products[$newName]]);
        } else {
            return response()->json(['error' => 'Product not found'], 404);
        }
    }
}
