<?php

namespace App\Observers;

use App\Models\CartItems;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ItemController;

class CartsObserver
{
    public function creating(CartItems $cartItems): void
    {
        $products = DB::select('SELECT stock FROM products WHERE itemCode = ?', [$cartItems->itemCode]);
        $code = $cartItems->itemCode;
        $quantity = $cartItems->itemQuantity;
        
        foreach($products as $product) {
            $stock = $product->stock;
            if ($stock < $quantity) {
                throw new \Exception(
                        "The item with code $code haven't much than this in the stock\n"
                        . "(Current item stock : $stock)");
            }
        }
    }
    
    public function created(CartItems $cartItems): void
    {
        ItemController::updateTotalPrice($cartItems);
    }
    
    public function updated(CartItems $cartItems): void
    {
        ItemController::updateTotalPrice($cartItems);
    }

    /**
     * Handle the CartItems "deleted" event.
     */
    public function deleted(CartItems $cartItems): void
    {
        //
    }

    /**
     * Handle the CartItems "restored" event.
     */
    public function restored(CartItems $cartItems): void
    {
        //
    }

    /**
     * Handle the CartItems "force deleted" event.
     */
    public function forceDeleted(CartItems $cartItems): void
    {
        //
    }
}
