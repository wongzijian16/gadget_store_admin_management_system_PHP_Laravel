<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethods extends Model
{
    use HasFactory;
    
    protected $table = 'paymentMethods';
    
    protected $primaryKey = 'name';
    protected $keyType = 'string';
    
    protected $fillable = [
        'name',
        'type',
        'maxAllowedAmount'
    ];
    
    protected $connection = 'mysql';
}
