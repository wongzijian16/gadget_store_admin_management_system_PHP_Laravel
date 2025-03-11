<!doctype html>
<html lang="en">
    <head>
        <title>Payment</title>
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
            .selected {
                background-color: #004085;
                color: white;
            }
        </style>
    </head>
    <body>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

        <form action="{{ route('selectPaymentMethod') }}" method="post">
            @csrf
            <?php

            use App\Http\Controllers\ItemController;

$currency = ItemController::$currency;
            $userID = ItemController::getUserID();

            $order = ItemController::lookForLatestID("SELECT * FROM orders WHERE userID = ?", $userID);
            $payMethods = ItemController::getPaymentMethods();

            if (!$payMethods) {
                return view('orderUI');
            } else {
                echo "<h3>Total Payable Amount : <strong>$currency $order->totalPrice</strong></h3>";
                echo "<br><p>Select a way to pay : <p>";
                echo "<table><tr>";
                $i = 1;
                foreach ($payMethods as $payMethod) {
                    echo "<td><input type='submit' name='payMethod' value='$payMethod->name'></td>";
                    if ($i % 3 === 0) {
                        echo "</tr><tr>";
                    }
                    $i++;
                }
                echo "</tr></table>";
            }
            ?>
        </form>
        @csrf
        @if(session('info'))
        <div class="alert alert-info">
            {{ session('info') }}
        </div>
        <form action="{{ route('makePayment') }}" method="post">
            @csrf
            <?php
            echo "<br><button type='submit' name='makePayment' value='Make Payment'><strong>PAY</strong></button>"
            . "<input type='hidden' name='userID' value='$userID'>"
            . "<input type='hidden' name='orderNo' value='$order->orderNo'>"
            ?>
        </form>
        <br><a href="{{ url('/auth/gmail') }}"><input type="button" value="Authenticate Gmail"/></a>
        <form action="{{ route('toggleButton') }}" method="post">
            @csrf
            <br><button type="submit" class="{{ session('buttonSelected') ? 'selected' : '' }}">Also send an email to me</button>
        </form>
        @endif
    </body>
</html>