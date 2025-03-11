<?php

namespace App\Observers;

use App\Models\Orders;
use App\Models\Product;
use App\Http\Controllers\ItemController;

class OrdersObserver
{
    public function created(Orders $orders): void
    {
        $userID = $orders->userID;
        $orderedItems = ItemController::getAllItemsInOrders($userID);
        
        foreach ($orderedItems as $orderedItem) {
            $product = Product::find($orderedItem->itemCode);
            $product->stock -= $orderedItem->itemQuantity;
            
            $product->save();
        }
    }

    /**
     * Handle the Orders "updated" event.
     */
    public function updated(Orders $orders): void
    {
        //
    }

    /**
     * Handle the Orders "deleted" event.
     */
    public function deleted(Orders $orders): void
    {
        //
    }

    /**
     * Handle the Orders "restored" event.
     */
    public function restored(Orders $orders): void
    {
        //
    }

    /**
     * Handle the Orders "force deleted" event.
     */
    public function forceDeleted(Orders $orders): void
    {
        //
    }
}
