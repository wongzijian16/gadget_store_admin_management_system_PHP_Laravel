<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchasedItems extends Model
{
    use HasFactory;
    
    protected $table = 'purchasedItems';
    
    protected $primaryKey = 'seq';
    public $incrementing = true;
    
    protected $fillable = [
        'seq',
        'orderNo', 
        'userID', 
        'id',
        'itemName',
        'itemDesc',
        'itemPrice',
        'itemQuantity',
        'multipliedPrice'
        ];
    
    protected $connection = 'mysql';
    public $timestamps = true;
}
