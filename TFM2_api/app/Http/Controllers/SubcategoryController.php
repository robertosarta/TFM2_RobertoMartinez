<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subcategory;

class SubcategoryController extends Controller
{
    public function index()
    {
        $subcategories = Subcategory::all();
        return view('subcategories.index', compact('subcategories'));
    }
}
