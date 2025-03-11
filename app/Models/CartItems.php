<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItems extends Model
{
    use HasFactory;
    
    protected $table = 'cartItems';
    
    protected $primaryKey = 'seq';
    public $incrementing = true;
    
    protected $fillable = [
        'seq', 
        'id', 
        'cartID', 
        'userID', 
        'itemName', 
        'itemDesc', 
        'itemPrice', 
        'itemQuantity', 
        'multipliedPrice'
    ];
    
    protected $attributes = [
        'itemQuantity' => 1,
    ];
    
    protected $connection = 'mysql';
    public $timestamps = true;
}
