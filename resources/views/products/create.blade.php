
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product</title>
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
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
    <h1>Add New Product</h1>

    <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" required>
        <br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>
        <br>

        <label for="price">Price:</label>
        <input type="number" id="price" name="price" step="0.01" required>
        <br>

        <label for="stock">Stock:</label>
        <input type="number" id="stock" name="stock" required>
        <br>

        <label for="image">Image:</label>
        <input type="file" id="image" name="image" required>
        <br>
        
        <label for="video_url">Video URL:</label>
        <input type="url" id="video_url" name="video_url" placeholder="Enter YouTube URL">
        <br>

        <label for="category">Category:</label>
        <select id="category" name="category_id" required>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>

        <br>
        
        <label for="type">Product Type:</label>
        <select id="type" name="type" required>
            <option value="physical">Physical</option>
            <option value="digital">Digital</option>
        </select>
        <br>

        <button type="submit">Add Product</button>
    </form>
    </div>
    </body>
</html>
