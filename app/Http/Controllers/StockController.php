<?php

namespace App\Http\Controllers;

use App\Http\Resources\StockCollection;
use Illuminate\Http\Request;

class StockController extends Controller
{
    //
    function Stock(){
        return new StockCollection();
    }
}
