<!<!doctype html>
<html lang="en">
    <head>
        <title>Orders</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
        
        <style>
            table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
            }
            th, td {
                padding: 10px;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <h2>Your Orders Here</h2>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        
        <form action="{{ url('/paymentUI') }}" method="get">
            <a href="{{ url('/product') }}"><input type="button" value="Add other items"/></a>
            &nbsp;&nbsp;&nbsp;
            <a href="{{ url('/') }}"><input type="button" value="View your cart"/></a><br><br>
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            <?php
            use App\Http\Controllers\ItemController;

            $currency = ItemController::$currency;
            $userID = ItemController::getUserID();
            
            $orderItems = ItemController::getAllItemsInOrders($userID);
            $payMethods = ItemController::getPaymentMethods();

            if (!$orderItems) {
                echo "You have no orders yet, look fowrard to your cart to place orders";
            } else {
                $cartDiv = "";
                $totalPrice = 0.00;
                
                
                echo "<table>";
                echo "<tr>"
                . "<td>Item Code</td>"
                    . "<td>Item Name</td>"
                    . "<td>Item Desc</td>"
                    . "<td>Item Price</td>"
                    . "<td>Order Quantity</td>"
                    . "<td>Total Price</td>"
                . "</tr>";
                
                for ($i = 0; $i < count($orderItems); $i++) {
                    $item = $orderItems[$i];
                            
                    if ($item->cartID != $cartDiv) {
                        echo "<tr><td colspan='6'>Order No. : $item->orderNo<br/>Item in Cart : ID $item->cartID</td></tr>";
                        $cartDiv = $item->cartID;
                    }
                    
                    echo "<tr>"
                    . "<td>$item->id</td>"
                        . "<td>$item->itemName</td>"
                        . "<td>$item->itemDesc</td>"
                        . "<td>$item->itemPrice</td>"
                        . "<td>$item->itemQuantity</td>"
                        . "<td>$currency $item->multipliedPrice</td>"
                    . "</tr>";
                    $totalPrice += $item->multipliedPrice;
                }
            }
            echo "<tr><td colspan='5'>TOTAL PRICE : $currency $totalPrice</td></tr>";
            echo "</table>";
            echo "<br><button type='submit'>Proceed to Payment</button>";

            if (!$payMethods) {
                ItemController::loadPaymentMethods();
            }
            ?>
        </form>
    </body>
</html>