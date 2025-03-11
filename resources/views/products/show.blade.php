<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <title>{{ $product->name }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            font-size: 2em;
            margin-bottom: 10px;
        }
        p {
            line-height: 1.6;
        }
        .video-container {
            margin: 20px 0;
            position: relative;
            padding-bottom: 56.25%; /* 16:9 Aspect Ratio */
            height: 0;
        }
        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        .image {
            margin: 20px 0;
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }
        .button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }
        .button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <h1>{{ $product->name }}</h1>
    <p>{{ $product->description }}</p>
    <p><strong>Price:</strong> ${{ $product->price }}</p>
    <p><strong>Stock:</strong> {{ $product->stock }}</p>

    <!-- YouTube Video Section -->
    @if($product->video_url)
      <?php $videoId = extractVideoId($product->video_url); ?>
        @if($videoId)
            <iframe width="560" height="315" 
                src="https://www.youtube.com/embed/{{ $videoId }}" 
                frameborder="0" 
                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" 
                allowfullscreen>
            </iframe>
        @else
        <p>No video available for this product.</p>
        @endif
    @endif

    <!-- Product Image -->
    @if($product->image_url)
        <img src="{{ Storage::url($product->image_url) }}" alt="{{ $product->name }}" style="width: 300px; height: auto;">
    @endif

    <!-- Optional Edit and Delete Actions -->
    <!-- 
    <a href="{{ route('products.edit', $product->id)}}"  class="button">Edit</a>

    <form method="POST" action="{{ route('products.destroy', $product->id) }}">
        @csrf
        @method('DELETE')
        <button type="submit" class="button">Delete</button>
    </form>
    -->
</body>
</html>
