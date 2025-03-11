<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
        use HasFactory;

    // Specify the table associated with the model (optional if the table name is the plural form of the model name)
    protected $table = 'products';

    // Define which attributes are mass assignable
    protected $fillable = ['name', 'description', 'price', 'stock', 'image_url', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Optionally, you can define hidden attributes (attributes not to be included in array or JSON conversions)
    protected $hidden = [
        // Example: 'some_sensitive_field',
    ];

    // Optionally, you can define casts for attributes
    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];

    // Optionally, you can define dates or other attributes
    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
