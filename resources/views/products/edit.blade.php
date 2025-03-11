<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <!-- Include your CSS files directly here -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input[type="text"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        .current-image {
            max-width: 150px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Product</h1>
    <form method="POST" action="{{ route('products.update', $products->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" value="{{ old('name', $products->name) }}" required>
        <br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required>{{ old('description', $products->description) }}</textarea>
        <br>

        <label for="price">Price:</label>
        <input type="number" id="price" name="price" value="{{ old('price', $products->price) }}" step="0.01" required>
        <br>

        <label for="stock">Stock:</label>
        <input type="number" id="stock" name="stock" value="{{ old('stock', $products->stock) }}" required>
        <br>

        <label for="image">Image:</label>
        <input type="file" id="image" name="image">
        @if($products->image_url)
            <img src="{{ asset('storage/' . $products->image_url) }}" alt="Current Image" style="max-width: 150px;">
        @endif
        <br>
        
        <label for="video_url">YouTube Video URL:</label>
        <input type="text" id="video_url" name="video_url" value="{{ old('video_url', $products->video_url ?? '') }}">
        <br>

        <label for="category">Category:</label>
        <select id="category" name="category_id">
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ $products->category_id == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        <br>

        <button type="submit">Update Product</button>
    </form>
    </div>
</body>
</html>
