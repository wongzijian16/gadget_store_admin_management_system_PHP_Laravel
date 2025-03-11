<!<!doctype html>
<html lang="en">
    <head>
        <title>Purchase History</title>
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
        <h1>Item Purchase History</h1>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

        <?php

        use App\Http\Controllers\ItemController;

$currency = ItemController::$currency;
        $userID = ItemController::getUserID();

        $purchasedItems = ItemController::getAllPurchasedItems($userID);


        echo "<table>";
        echo "<tr><td>Item Code</td><td>Item Name</td><td>Item Desc</td><td>Item Price</td><td>Order Quantity</td><td>Total Price / Item</td></tr>";
        $orderNo = "";
        foreach ($purchasedItems as $item) {
            if ($orderNo != $item->orderNo) {
                echo "<tr><td colspan='6'>Order No. $item->orderNo <br>Total Price :  $currency $item->totalPrice</tr>";
            }
            echo "<tr>"
            . "<td>$item->id</td>"
            . "<td>$item->itemName</td>"
            . "<td>$item->itemDesc</td>"
            . "<td>$item->itemPrice</td>"
            . "<td>$item->itemQuantity</td>"
            . "<td>$currency $item->multipliedPrice</td>"
            . "</tr>";

            $orderNo = $item->orderNo;
            if ($orderNo != $item->orderNo) {
                echo "<tr><td colspan='6'>$item->orderNo</tr>";
            }
        }
        echo "</table>";
        ?>

        <br><br><a href="{{ url('/product-menu') }}"><input type="button" value="Shop Around"/></a>
        <form action="{{ route('transform') }}" method="post">
            @csrf
            <button type='submit' name='xmlGen' value='Generate Data'>Generate Data</button>
        </form>
    </body>
</html>