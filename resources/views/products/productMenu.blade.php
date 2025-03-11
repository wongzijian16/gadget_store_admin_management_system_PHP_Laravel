<!-- resources/views/products/productMenu.blade.php -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Product Menu</title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }

            table, th, td {
                border: 1px solid #ddd;
            }

            th, td {
                padding: 8px;
                text-align: left;
            }

            th {
                background-color: #f2f2f2;
            }

            img {
                max-width: 100px;
                height: auto;
            }

            .view-details {
                text-decoration: none;
                color: #007bff;
                font-weight: bold;
            }

            .view-details:hover {
                text-decoration: underline;
            }

            .product-grid {
                display: flex;
                flex-wrap: wrap;
                gap: 20px;
                justify-content: center;
            }

            .product-card {
                border: 1px solid #ddd;
                padding: 15px;
                width: 250px;
                text-align: center;
                box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            }

            .product-card h3 {
                font-size: 1.5em;
                margin-bottom: 10px;
            }

            .product-card p {
                margin: 5px 0;
            }

            .product-card img {
                max-width: 100%;
                height: auto;
                margin-bottom: 10px;
            }

            .product-actions {
                display: flex;
                justify-content: space-between;
            }

            /*        .btn {
                        padding: 10px 20px;
                        background-color: #007bff;
                        color: white;
                        border: none;
                        border-radius: 4px;
                        text-decoration: none;
                        display: inline-block;
                    }*/

            .btn {
                background-color: #3490dc;
                color: white;
                padding: 10px;
                border: none;
                cursor: pointer;
                text-decoration: none;
            }

            .btn:hover {
                background-color: #0056b3;
            }


            .dropbtn {
                background-color: #3498DB;
                color: white;
                padding: 16px;
                font-size: 16px;
                border: none;
                cursor: pointer;
            }

            .dropbtn:hover, .dropbtn:focus {
                background-color: #2980B9;
            }

            .dropdown {
                position: relative;
                display: inline-block;
            }

            .dropdown-content {
                display: none;
                position: absolute;
                background-color: #f1f1f1;
                min-width: 160px;
                overflow: auto;
                box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
                z-index: 1;
            }

            .dropdown-content a {
                color: black;
                padding: 12px 16px;
                text-decoration: none;
                display: block;
            }

            .dropdown a:hover {background-color: #ddd;}

            .show {display: block;}

        </style>
    </head>
    <body>
        <h1>Product Menu</h1>
        <div class="dropdown">
            <button onclick="myFunction()" class="dropbtn">{{Session::get('login_status')->email}}</button>
            <div id="myDropdown" class="dropdown-content">
                <a href="profile1">User Profile</a>
                <a href="editprofile1">Edit Profile</a>
                <a href="changepassword1">Change Password</a>
                <a href="logout">Logout</a>
            </div>
        </div>
        <a href="{{ url('/cart/goToCart') }}"><input type="button" value="View Your Cart"/></a><br><br>

        <!-- Search and Filter Form -->
        <form method="GET" action="{{ route('products.menu') }}">
            <input type="text" name="search" placeholder="Search products" value="{{ request('search') }}">

            <select name="category">
                <option value="">Select Category</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>

            <input type="number" name="price_min" placeholder="Min Price" value="{{ request('price_min') }}">
            <input type="number" name="price_max" placeholder="Max Price" value="{{ request('price_max') }}">

            <button type="submit">Filter</button>
        </form>

        <!-- Display Products -->
        <div class="product-grid">
            @if ($products->count())
            @foreach ($products as $product)
            <div class="product-card">
                <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}" class="product-image">
                <h3>{{ $product->name }}</h3>
                <p>{{ Str::limit($product->description, 100) }}</p>
                <p>Category: {{ $product->category->name ?? 'N/A' }}</p>
                <p>Price: ${{ $product->price }}</p>
                <p>Stock: {{ $product->stock }}</p>

                <div class="product-actions">
                    <form action="{{ route('products.show', $product->id) }}" method="GET" style="display:inline;">
                        <button type="submit" class="btn">View Details</button>
                    </form>
                    <form action="{{ route('increaseQty', $product->id) }}" method="POST" style="display:inline;">
                        @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                        @endif
                        @csrf
                        <button type="submit"  class="btn">Add to Cart</button>
                        <input type='hidden' name='userID' value='$userID'>
                    </form>
                    <!--<a href="{{ route('products.edit', $product->id) }}" class="btn">Edit</a>-->
                </div>
            </div>
            @endforeach
            @else
            <p>No products found matching your criteria.</p>
            @endif
        </div>


    </body>
</html>

<script>
    /* When the user clicks on the button, 
     toggle between hiding and showing the dropdown content */
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

// Close the dropdown if the user clicks outside of it
    window.onclick = function (event) {
        if (!event.target.matches('.dropbtn')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
</script>