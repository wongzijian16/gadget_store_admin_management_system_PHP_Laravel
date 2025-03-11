<!<!doctype html>
<html lang="en">
    <head>
        <title>Payment Summary</title>
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
        <h1>Your Order Summary</h1>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        
        <form>
            @csrf
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('warning'))
                <div class="alert alert-warning">
                    {{ session('warning') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <?php
            use App\Http\Controllers\ItemController;
            
            $currency = ItemController::$currency;
            $userID = ItemController::getUserID();
            
            $purchasedItems = ItemController::getRecentPurchasedItems($userID);
            $totalPrice = ItemController::getTotalPriceInOrder($userID);
            
            echo "<table>";
            echo "<tr><td>Item Code</td><td>Item Name</td><td>Item Desc</td><td>Item Price</td><td>Order Quantity</td><td>Total Price / Item</td></tr>";
            $i = 0;
            foreach ($purchasedItems as $item) {
                if ($i == 0) {
                    echo "<tr><td colspan='6'>Order No. $item->orderNo</tr>";
                }
                $i++;
                echo "<tr><td>$item->id</td><td>$item->itemName</td><td>$item->itemDesc</td><td>$item->itemPrice</td><td>$item->itemQuantity</td><td>$currency $item->multipliedPrice</td></tr>";
            }
            echo "<tr><td colspan='5'>TOTAL PRICE : </td><td>$currency $totalPrice</td></tr>";
            echo "</table>";
            ?>
            
            <br><br><a href="{{ url('/product') }}"><input type="button" value="Shop Around"/></a>
            <br><a href="{{ url('/purchaseHistory') }}"><input type="button" value="Your shopping history"/></a>
        </form>
    </body>
</html>