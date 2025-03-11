<!<!doctype html>
<html lang="en">
    <head>
        <title>Cart</title>
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
        <h2>Cart</h2>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        
        
        <?php
            use App\Http\Controllers\ItemController;
            use App\Models\Orders;
            

            
            $currency = ItemController::$currency;
            $userID = ItemController::getUserID();
            

            
            $cartItems = ItemController::getAllItemsInCart($userID);
            $orders = Orders::where('userID', $userID)->where('status', 'Pending')->first();
            
            if (!$cartItems) {
                echo "Seems nothing inside of your cart, shop around to add something here. :)";
            }
        ?>
        
        <br><br><a href="{{ url('/product-menu') }}"><input type="button" value="Shop around"/></a>
        &nbsp;&nbsp;&nbsp;
        <a href="{{ url('/purchaseHistory') }}"><input type="button" value="Your shopping history"/></a><br><br>
        
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        @if ($cartItems)
            <table>
                <tr>
                    <td>Item Code</td>
                    <td>Item Name</td>
                    <td>Item Description</td>
                    <td>Price per item</td>
                    <td colspan="3">Quantity</td>
                    <td>Total Price</td>
                </tr>
            @foreach($cartItems as $item)
                <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->itemName}}</td>
                    <td>{{$item->itemDesc}}</td>
                    <td>{{$currency}} {{$item->itemPrice}}</td>
                    <td>
                        <br>
                        <form action="{{route("decreaseQty")}}" method="post">
                            @csrf
                            <button type="submit">-</button>
                            <input type='hidden' name='userID' value='{{$userID}}'>
                            <input type='hidden' name='itemCode' value='{{$item->id}}'>
                        </form>
                    </td>
                    <td>{{$item->itemQuantity}}</td>
                    <td>
                        <br>
                        <form action="{{ route('increaseQty', $item->id) }}" method="post">
                            @csrf
                            <button type="submit">+</button>
                            <input type='hidden' name='userID' value='{{$userID}}'>
                            <input type='hidden' name='itemCode' value='{{$item->id}}'>
                        </form>
                    </td>
                    <td>{{$currency}} {{$item->multipliedPrice}}</td>
                    <td>
                        <br>
                        <form action="{{route("removeItemFromCart")}}" method="post">
                            @csrf
                            <button type="submit">Remove from cart</button>
                            <input type='hidden' name='userID' value='{{$userID}}'>
                            <input type='hidden' name='itemCode' value='{{$item->id}}'>
                        </form>
                    </td>
                </tr>
            @endforeach
            </table>
        
            @if(!$orders)
                <form action="{{ route('heldOrder') }}", method="post">
                    @csrf
                    <br> 
                    <button type='submit' name='heldOrder' value='Place Order'>Place Order</button>
                    <input type='hidden' name='userID' value='{{$userID}}'>
                </form>
            @else
                <br><a href="{{ url('/orderUI') }}"><input type="button" value="View your orders"/></a>
            @endif
            
            @if(session('warning'))
                <div class="alert alert-warning">
                    {{ session('warning') }}
                </div>
            @endif
        @endif
        
    </body>
</html>