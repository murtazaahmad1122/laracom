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
    public function addToCart(Request $request, $productId)
{
    $product = Product::find($productId);

    if (!$product) {
        return redirect()->back()->with('error', 'Product not found.');
    }

    $session_id = session()->getId();

    if (Auth::check()) {
        $cart = Cart::where('user_id', Auth::id())->where('product_id', $productId)->first();
    } else {
        $cart = Cart::where('session_id', $session_id)->where('product_id', $productId)->first();
    }

    if ($cart) {
        $cart->increment('quantity'); // This increments the quantity directly
    } else {
        Cart::create([
            'user_id' => Auth::id() ? Auth::id() : null,
            'session_id' => Auth::check() ? null : $session_id,
            'product_id' => $productId,
            'quantity' => 1,
        ]);
    }

    return redirect()->back()->with('success', 'Product added to cart.');
}
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
