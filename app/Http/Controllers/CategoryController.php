<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryCollection;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    function Category(){
        return new CategoryCollection();
    }
}
