<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'product_number', 
        'product_name',   
        'material',  
        'description',     
        'unit',            
        'price',           
        'status',         
        'updated_at',
        'created_at',
    ];
    
}
