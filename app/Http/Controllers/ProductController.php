<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
class ProductController extends Controller {
    /**
    * Display a listing of the resource.
    */

    public function index()
    {
        // Fetch distinct categories from products table
        $categories = Product::select('category')->distinct()->get();

        // Fetch products grouped by category
        $products = Product::all()->groupBy('category');

        return view('index', compact('categories', 'products'));
    }

    /**
    * Show the form for creating a new resource.
    */

    public function create() {
        //
    }

    /**
    * Store a newly created resource in storage.
    */

    public function store( Request $request ) {
        //
    }

    /**
    * Display the specified resource.
    */

    public function show( $id ) {
        $product = Product::find( $id );
        return view( 'products.show', compact( 'product' ) );
    }

    /**
    * Show the form for editing the specified resource.
    */

    public function edit( Product $product ) {
        //
    }

    /**
    * Update the specified resource in storage.
    */

    public function update( Request $request, Product $product ) {
        //
    }

    /**
    * Remove the specified resource from storage.
    */

    public function destroy( Product $product ) {
        //
    }
}
