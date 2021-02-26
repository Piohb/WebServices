<?php

namespace App\Http\Controllers;

use App\Http\Resources\ShopCollection;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    //
    function Shop(){
        return new ShopCollection();
    }
}
