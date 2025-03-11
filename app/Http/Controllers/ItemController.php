<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Psy\Exception;

use App\Models\Orders;
use App\Models\CartItems;
use App\Models\PaymentMethods;
use App\Models\PurchasedItems;

use App\Services\GmailService;

class ItemController extends Controller
{
    public static $currency = "RM";
    
    public static function getUserID() {
        return session()->get('login_status');
    }
    
    public static function getAllItemsInCart($userID)
    {
        $latestCartID = self::lookForLatestID('SELECT cartID FROM cartItems WHERE userID = ?', $userID);
        
        $carts = DB::select(
                'SELECT * '
                . 'FROM cartItems '
                . 'WHERE userID = ? AND cartID = ?', 
                [$userID, $latestCartID->cartID]); // Port to determine items in the user carts
        return $carts;
    }
    
    public static function getAllItemsInOrders($userID)
    {
        $latestOrderNo = self::lookForLatestID('SELECT orderNo FROM orders WHERE userID = ?', $userID);
        
        $orderedItems = DB::select(
                'SELECT C.*, O.orderNo '
                . 'FROM cartItems AS C, orders as O '
                . 'WHERE C.userID = ? AND O.orderNo = ?', 
                [$userID, $latestOrderNo->orderNo]);
        return $orderedItems;
    }
    
    public static function getRecentPurchasedItems($userID)
    {
        $latestOrderNo = self::lookForLatestID('SELECT orderNo FROM orders WHERE userID = ?', $userID);
        
        $purchasedItems = DB::select(
                'SELECT * '
                . 'FROM purchasedItems '
                . 'WHERE userID = ? AND orderNo = ?', 
                [$userID, $latestOrderNo->orderNo]);
        return $purchasedItems;
    }
    
    public static function getAllPurchasedItems($userID)
    {
        $purchasedItems = DB::select(
                'SELECT P.*, O.totalPrice '
                . 'FROM purchasedItems AS P JOIN orders AS O ON P.orderNo = O.orderNo '
                . 'WHERE P.userID = ?', 
                [$userID]);
        return $purchasedItems;
    }
    
    public static function getTotalPriceInOrder($userID) {
        $latestOrderNo = self::lookForLatestID('SELECT orderNo FROM orders WHERE userID = ?', $userID);
        
        $priceSelect = DB::select(
                'SELECT totalPrice '
                . 'FROM orders '
                . 'WHERE userID = ? AND orderNo = ?',
                [$userID, $latestOrderNo->orderNo]);
        
        foreach ($priceSelect as $totalPrice) {
            return $totalPrice->totalPrice;
        }
    }
    
    public static function getAllProducts()
    {
        $products = DB::select('SELECT * FROM products');
        return $products;
    }
    
    public static function getPaymentMethods()
    {
        $paymentMethods = DB::select('SELECT * FROM paymentMethods');
        return $paymentMethods;
    }
    
    public static function getTargetItem($code)
    {
        $items = DB::select('SELECT * FROM products WHERE id = ?', [$code]);
        foreach ($items as $item) {
            return $item;
        }
        
        if ($items == null) {
            if ($code == '') {
                throw new \Exception("It seems nothing yet to be selected, please enter the item code");
            } else {
                throw new \Exception("There is no item with code \"$code\"");
            }
        }
    }
    
    public static function assignLatestID($statement) {
        // Check for latest ID in the database and incrementing the ID if found the same cartID, to assign unique ID to each item in database
        $IDList = DB::select($statement);
        $latestID = 1;
        if ($IDList) {
            foreach ($IDList as $id) {
                $latestID++; // increase number of cartID until the end of IDList
            }
        }
        
        return $latestID;
    }
    
    public static function lookForLatestID($statement, $userID) {
        $IDList = DB::select($statement, [$userID]);
        $currentID = new Dummy();
        
        if ($IDList) {
            foreach ($IDList as $ID) {
                $currentID = $ID;
            }
        }
        
        return $currentID;
    }
    
    public static function searchForID($statement, $userID, $code) {
        $items = DB::select($statement, [$userID, $code]);
        
        if ($items) {
            foreach ($items as $item) {
                return $item->itemQuantity;
            }
        }
        
        return 0;
    }
    
    public static function incrementItemQty($id,Request $request)
    {
        try {
            $userID = $request->Session()->get('login_status');
            $code = $id;
            
            $item = CartItems::where('userID', $userID)
                    ->where('id', $code)
                    ->first();
            $product = self::getTargetItem($code);
            
            if (!$item) {
                $latestCartID = self::assignLatestID('SELECT cartID FROM orders');
                
                $item = new CartItems;
                $item->seq = self::assignLatestID('SELECT seq FROM cartItems');
                $item->id = $product->id;
                $item->cartID = 'C'.$latestCartID;
                $item->userID = $userID;
                $item->itemName = $product->name;
                $item->itemDesc = $product->description;
                $item->itemPrice = $product->price;
                $item->multipliedPrice = $product->price;
                
                $item->save();
            } else {
                $item->itemQuantity++;
                $item->multipliedPrice = $item->itemQuantity * $item->itemPrice;
                
                $item->save();
                
                self::checkItemStock($code, $item->itemQuantity, $product->stock);
                return redirect()->back();
            }
        } catch (\Exception $ex) {
            session()->flash('error', $ex->getMessage());
            return redirect()->back();
        }
        
        return redirect()->back()->with('success', 'Item with code '.$code.' added to cart');
    }
    
    protected static function checkItemStock($code, $qty, $stock) {
        if ($stock - $qty <= 10) {
            return redirect()->back()->with('warning', "The item with code $code almost run out of stock\n"
                        . "(Current item stock : $stock)");
        }
    }
    
    public static function decrementItemQty(Request $request)
    {
        $userID = $request->input('userID');
        $code = $request->input('itemCode');

        $item = CartItems::where('userID', $userID)
                    ->where('id', $code)
                    ->first();
        
        $quantity = $item->itemQuantity;

        if ($quantity > 1) {
            $item->itemQuantity--;
            $item->multipliedPrice = $item->itemQuantity * $item->itemPrice;
            $item->save();
            
            return redirect()->back();
        } else {
            $item->delete();
            
            return redirect()->back()->with('success', 'Item with code '.$code.' removed from cart.');
        }
    }
    
    public static function removeItemFromCart(Request $request)
    {
        $userID = $request->input('userID');
        $code = $request->input('itemCode');

        DB::delete('DELETE from cartItems WHERE userID = ? AND id = ?', [$userID, $code]);
        
        return redirect()->back()->with('success', 'Item with code '.$code.' removed from cart.');
    }
    
    public function heldOrder(Request $request) {
        $userID = $request->input('userID');
        
        $latestOrderNo = self::assignLatestID('SELECT orderNo FROM orders');
        
        $orderNo = 'O' . $latestOrderNo;
        $cartID = self::lookForLatestID('SELECT cartID FROM cartItems WHERE userID = ?', $userID);
        
        $totalPrice = DB::table('cartItems')
              ->where('userID', $userID)
              ->sum('multipliedPrice');
        
        $order = new Orders;
        $order->orderNo = $orderNo;
        $order->cartID = $cartID->cartID;
        $order->userID = $userID;
        $order->totalPrice = $totalPrice;
        
        $order->save();
//      
        return redirect()->route('showOrder')->with('success', 'Your order is ready! Proceed to payment to place your order.');
    }
    
    public static function updateTotalPrice($cartItems) {
        $userID = $cartItems->userID;
        $latestOrderNo = ItemController::lookForLatestID('SELECT orderNo FROM orders WHERE userID = ?', $userID);
        
        $order = Orders::find($latestOrderNo->orderNo);
        if ($order) {
            $totalPrice = DB::table('cartItems')
              ->where('userID', $userID)
              ->sum('multipliedPrice');
            $order->totalPrice = $totalPrice;
            
            $order->save();
        }
    }
    
    private function showOrder() {
        return view('showOrder');
    }
    
    public function selectPaymentMethod(Request $request) {
        $paymentMethod = $request->input('payMethod');
        $request->session()->put('payMethod', $paymentMethod);
        
        $request->session()->forget('buttonSelected');
        
        return redirect()->back()->with('info', 'PAY WITH : ' . $paymentMethod);
    }
    
    public function makePayment(Request $request) {
        $userID = $request->input('userID');
        $orderNo = $request->input('orderNo');
        $paymentMethod = $request->session()->pull('payMethod');
        
        $orders = Orders::where('userID', $userID)
            ->where('orderNo', $orderNo)
            ->first();
        
        switch ($paymentMethod) {
            case 'Cash':
                $orders->status = 'Held';
                break;
            default:
                $orders->status = 'Paid';
                break;
        }
        $orders->save();
        
        $items = self::getAllItemsInCart($userID);
        foreach ($items as $item) {
            $seq = self::assignLatestID('SELECT seq FROM purchasedItems');
            $purchasedItem = new PurchasedItems;
            $purchasedItem->seq = $seq;
            $purchasedItem->orderNo = $orderNo;
            $purchasedItem->userID = $userID;
            $purchasedItem->id = $item->id;
            $purchasedItem->itemName = $item->itemName;
            $purchasedItem->itemDesc = $item->itemDesc;
            $purchasedItem->itemPrice = $item->itemPrice;
            $purchasedItem->itemQuantity = $item->itemQuantity;
            $purchasedItem->multipliedPrice = $item->multipliedPrice;
            
            $purchasedItem->save();
        }
        
        DB::delete('DELETE FROM cartItems where userID = ?', [$userID]);
        
        if ($request->session()->get('buttonSelected')) {
            $isSent = $this->sendOrderStatusEmail($request, $orders);
            if (!$isSent) {
                return redirect(url('/checkoutUI'))->with('error', '!');
            }
        }
        
        if ($paymentMethod == "Cash") {
            return redirect(url('/checkoutUI'))->with('warning', "You have choosen to pay by COD<br/>"
                    . "Please pay according to required amount of cash to get your delivered items.");
        }
        
        return redirect(url('/checkoutUI'))->with('success', "Your order has been placed! Keep an eye of your delivery.");
    }
    
    public static function loadProducts($item)
    {
        try {
            $code = $item->getItemCode();
            $name = $item->getItemName();
            $desc = $item->getItemDesc();
            $price = $item->getItemPrice();
            DB::insert(
                    'INSERT INTO products (itemCode, itemName, itemDesc, itemPrice) VALUES (?, ?, ?, ?)'
                    , [$code, $name, $desc, $price]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
    public static function loadPaymentMethods()
    {
        PaymentMethods::create(['name' => 'TnG', 'type' => 'e-Wallet', 'maxAllowedAmount' => 3000.00]);
        PaymentMethods::create(['name' => 'GrabPay', 'type' => 'e-Wallet', 'maxAllowedAmount' => 3000.00]);
        PaymentMethods::create(['name' => 'VISA', 'type' => 'Credit Card', 'maxAllowedAmount' => 5000.00]);
        PaymentMethods::create(['name' => 'SUS', 'type' => 'Dedit Card', 'maxAllowedAmount' => 5000.00]);
        PaymentMethods::create(['name' => 'FPX', 'type' => 'International Payment', 'maxAllowedAmount' => 5000.00]);
        PaymentMethods::create(['name' => 'Cash On Delivery', 'type' => 'Cash Payment', 'maxAllowedAmount' => -1.0]);
    }
    
    public function toggleButton(Request $request)
    {
        $paymentMethod = $request->session()->get('payMethod');
        
        $isSelected = session('buttonSelected', false);
        session(['buttonSelected' => !$isSelected]);

        return redirect()->back()->with('info', 'PAY WITH : ' . $paymentMethod);
    }
    
    public function sendOrderStatusEmail($request, Orders $orders)
    {
        $gmailSender = new GmailService();
        $status = $orders->status;
        
        $to = 'choykw-wp21@student.tarc.edu.my';#$request->input('clientEmail');
        if ($status == 'Held') {
            $subject = "Order no. $orders->orderNo held to a COD payment";
            $body = "
                <h1>Pending for COD Payment</h1>
                <p>Dear Customer,</p>
                <p>Your order has been held as you have selected to pay with cash 
                for items you have ordered, please pay with amount stated in your order 
                as soon as possible to accept your delivered items.</p>
                    ";
        } else {
            $subject = "Order no. $orders->orderNo has been placed";
            $body = "
                <h1>Order has been placed</h1>
                <p>Dear Customer,</p>
                <p>Your order information has been received, and we will pack your 
                items in a while. Please be patient while waiting for your items to be delivered.</p>
                    ";
        }

        return $gmailSender->sendMessage($to, $subject, $body);
    }
}

class Dummy {
    public $orderNo = '';
    public $cartID = '';
    
    public function __construct() {
        $this->orderNo;
        $this->cartID;
    }
}