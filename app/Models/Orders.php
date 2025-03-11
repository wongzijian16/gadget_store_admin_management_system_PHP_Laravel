<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;
    
    protected $table = 'orders';
    
    protected $primaryKey = 'orderNo';
    protected $keyType = 'string';
    
    protected $fillable = [
        'orderNo', 
        'cartID', 
        'userID', 
        'totalPrice', 
        'status', 
        'paymentMethod'
        ];
    
    protected $attributes = [
        'status' => 'Pending',
        'paymentMethod' => 'Not Selected'
    ];
    
    protected $connection = 'mysql';
    public $timestamps = true;
    
}
