<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use App\Models\Product;
use Illuminate\Support\Str;

class CartController extends Controller
{
    protected function getCartId()
    {
        $cartId = Cookie::get('cart_id');
        if (!$cartId) {
            $cartId = Str::uuid()->toString(); // Generate a unique ID
            Cookie::queue('cart_id', $cartId, 43200); // Save cookie for 30 days
        }
        return $cartId;
    }

    public function add(Request $request, $id)
    {
        $cartId = $this->getCartId();
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found.'], 404);
        }

        // Check if the product is already in the cart for this unique identifier
        $cartItem = DB::table('carts')
            ->where('unique_identifier', $cartId)
            ->where('product_id', $id)
            ->first();

        if ($cartItem) {
            // If exists, update the quantity
            DB::table('carts')
                ->where('unique_identifier', $cartId)
                ->where('product_id', $id)
                ->update(['quantity' => $cartItem->quantity + 1]);
        } else {
            // Otherwise, add the product to the cart
            DB::table('carts')->insert([
                'unique_identifier' => $cartId,
                'product_id' => $id,
                'quantity' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json(['success' => 'Product added to cart']);
    }

    public function show()
    {
        $cartId = $this->getCartId();

        $cartItems = DB::table('carts')
            ->where('unique_identifier', $cartId)
            ->get();

        // Fetch the products associated with the cart items
        $products = Product::whereIn('id', $cartItems->pluck('product_id'))->get();

        return view('show', compact('products', 'cartItems'));
    }

    public function update(Request $request, $id)
    {
        $cartId = $this->getCartId();
        $quantity = $request->quantity;

        // Update quantity in the cart
        DB::table('carts')
            ->where('unique_identifier', $cartId)
            ->where('product_id', $id)
            ->update(['quantity' => $quantity]);

        return response()->json(['success' => 'Cart updated']);
    }

    public function remove($id)
    {
        $cartId = $this->getCartId();

        // Remove the product from the cart
        DB::table('carts')
            ->where('unique_identifier', $cartId)
            ->where('product_id', $id)
            ->delete();

        return response()->json(['success' => 'Product removed from cart']);
    }


    public function getCartItems()
{
    $cartId = $this->getCartId();

    // Get cart items for the unique identifier
    $cartItems = DB::table('carts')
        ->where('unique_identifier', $cartId)
        ->get();

    // Get product details for the items in the cart
    $products = Product::whereIn('id', $cartItems->pluck('product_id'))->get();

    // Prepare the cart data
    $totalPrice = 0;
    $formattedItems = [];

    foreach ($cartItems as $cartItem) {
        $product = $products->firstWhere('id', $cartItem->product_id);

        if ($product) {
            $formattedItems[] = [
                'id' => $product->id,
                'title' => $product->title,
                'image_path' => asset($product->image_path),
                'quantity' => $cartItem->quantity,
                'price' => $product->new_price,
                'total' => $product->new_price * $cartItem->quantity,
            ];

            $totalPrice += $product->new_price * $cartItem->quantity;
        }
    }

    return response()->json([
        'items' => $formattedItems,
        'totalPrice' => $totalPrice,
        'totalCount' => $cartItems->sum('quantity')
    ]);
}
}
