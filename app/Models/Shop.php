<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
		'address_line',
		'zipcode',
		'city',
		'country',
        'email',
    ];

    public function products(){
        return $this->belongsToMany('App\Models\Product', 'stocks', 'shop_id', 'product_id')->withPivot('price', 'stock', 'sales');
    }
}
