@extends('welcome')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Page</title>
    <!-- Include your CSS files directly here -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
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
        
        .btn {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block;
        }

        .btn:hover {
            background-color: #0056b3;
        }

    </style>
</head>
<body>
     <h1>Product Listing</h1>

    <!-- Search and Filter Form -->
    <form method="GET" action="{{ route('products.index') }}">
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

        <form action="{{ route('products.create') }}" method="GET">
            <button type="submit" class="btn btn-primary">Add Product</button>
        </form>
    <!-- Display Products -->
    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Description</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Actions</th> 
            </tr>
        </thead>

        <tbody>
            @if ($products->count())
                @foreach ($products as $product)
                    <tr>
                        <td>
                            <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}">
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ Str::limit($product->description, 100) }}</td>
                        <td>{{ $product->category->name ?? 'N/A' }}</td>
                        <td>${{ $product->price }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>
                        <form action="{{ route('products.show', $product->id) }}" method="GET" style="display:inline;">
                            <button type="submit" class="btn">View Details</button>
                        </form>

                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                        </form>
                        <form action="{{ route('products.edit', $product->id) }}" method="GET" style="display:inline;">
                            <button type="submit" class="btn">Edit</button>
                        </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6">No products found matching your criteria.</td>
                </tr>
            @endif
        </tbody>
    </table>
<!--<div class="container">
    <h1>Product Listing</h1>
    
    <form method="GET" action="{{ route('products.index') }}">
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

    <div class="product-list row mt-4">
        @if($products->count() > 0)
            @foreach($products as $product)
                <div class="product col-md-4 mb-4">
                    <img src="{{ Storage::url($product->image_url) }}" alt="{{ $product->name }}" style="width: 100px; height: auto;">
                    <h2>{{ $product->name }}</h2>
                    <p>{{ $product->description }}</p>
                    <p>Price: ${{ $product->price }}</p>
                    <p>Stock: {{ $product->stock }}</p>
                    <p>Category: {{ $product->category->name ?? 'No Category' }}</p>
                    <a href="{{ route('products.show', $product->id) }}">View Details</a>
                </div>
            @endforeach
        @else
            <p>No products found.</p>
        @endif
    </div>

     Display pagination links 
    <div class="pagination">
        {{ $products->appends(request()->except('page'))->links() }}
    </div>
</div>-->
    </body>
</html>

@endsection