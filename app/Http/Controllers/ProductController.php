<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Factories\ProductFactory;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    
public function index(Request $request)
{
    $query = Product::query();

    // Add search functionality
    if ($request->filled('search')) {  // Use 'filled' to check if the input is not empty
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    // Add category filtering
    if ($request->filled('category')) {
        $query->where('category_id', $request->category);
    }

    // Add price range filtering
    if ($request->filled('price_min')) {
        $query->where('price', '>=', $request->price_min);
    }

    if ($request->filled('price_max')) {
        $query->where('price', '<=', $request->price_max);
    }

    // Fetch paginated results
    $products = $query->paginate(10);  // Paginate results, 10 per page

    // Fetch categories for the filter dropdown
    $categories = Category::all();

    // Pass both products and categories to the view
    return view('products.index', compact('products', 'categories'));
}




    public function create()
    {
        // Fetch categories from the database
        $categories = Category::all();
        
         // Pass the categories to the view
        return view('products.create', ['categories' => $categories]);
    }


    
    
public function store(Request $request)
{
    // Validate form data
    $request->validate([
        'name' => 'required',
        'description' => 'required',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:5000',
        'video_url' => 'nullable|url',// Validation for video URL
        'category_id' => 'required|exists:categories,id',
        'type' => 'required|in:physical,digital' // Add a type field to distinguish product types
    ]);

    // Handle file upload
    $imagePath = $request->file('image')->store('uploads', 'public');
    
    // Extract the video ID from the YouTube URL using the helper function
    $videoId = extractVideoId($request->input('video_url'));

    // Use the factory to create the appropriate type of product
    $productFactory = ProductFactory::createProduct($request->type); // Use factory based on the product type
    $productFactory->create([
        'name' => $request->name,
        'description' => $request->description,
        'price' => $request->price,
        'stock' => $request->stock,
        'image_url' => $imagePath,
        'video_url' => $videoId, // Ensure this is passed to the create method
        'category_id' => $request->category_id,
    ]);


    return redirect()->route('products.index')->with('success', 'Product added successfully.');
}


public function show($id)
    {
        // Find the product
        $product = Product::findOrFail($id);
        
        $videoId = $product->youtube_video_id;

        // Fetch YouTube video data from the YouTube API
        $response = Http::get('https://www.googleapis.com/youtube/v3/videos', [
            'part' => 'snippet',
            'id' => $videoId,
            'key' => env('YOUTUBE_API_KEY')
        ]);

        // Parse the response and get the video data
            if ($response->successful()) {
                $videoData = $response->json();
            } else {
                $videoData = [];  // Fallback in case of API error
            }

        // Pass product and video data to the view
        return view('products.show', compact('product', 'videoData'));
    }



public function edit($id)
{
    $products = Product::findOrFail($id);  // Get product by ID
    return view('products.edit', compact('products'));  // Pass the product to the view
}


public function update(Request $request, $id)
{
    // Validate the request
    $request->validate([
        'name' => 'required',
        'description' => 'required',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5000',
        'video_url' => 'nullable|url',
        'category_id' => 'nullable|exists:categories,id',  // Allow category_id to be nullable
    ]);

    // Find the product to update
    $products = Product::findOrFail($id);

    // Update the product fields
    $products->name = $request->input('name');
    $products->description = $request->input('description');
    $products->price = $request->input('price');
    $products->stock = $request->input('stock');
    $products->video_url = $request->video_url;

    // Handle file upload
    if ($request->hasFile('image')) {
        // Save the new image file
        $imagePath = $request->file('image')->store('uploads', 'public');
        $products->image_url = $imagePath;
    }

    // Update category if provided, otherwise keep the old one
    if ($request->has('category_id') && $request->category_id != '') {
        $products->category_id = $request->category_id;
    }

    // Save the product
    $products->save();

    return redirect()->route('products.index')->with('success', 'Product updated successfully.');
}





public function destroy($id)
{
    $products = Product::findOrFail($id);
    $products->delete();

    return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
}


public function productMenu(Request $request)
{
    $query = Product::query();

    // Search functionality
    if ($request->has('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    // Filter by category
    if ($request->has('category') && $request->category != '') {
        $query->where('category_id', $request->category);
    }

    // Filter by price range
    if ($request->has('price_min')) {
        $query->where('price', '>=', $request->price_min);
    }

    if ($request->has('price_max')) {
        $query->where('price', '<=', $request->price_max);
    }

    // Fetch the products and categories
    $products = $query->get();
    $categories = Category::all(); // To show filter options

    return view('products.productMenu', compact('products', 'categories'));
}



}
