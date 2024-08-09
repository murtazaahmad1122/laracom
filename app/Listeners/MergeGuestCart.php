<?php

namespace App\Listeners;
use App\Models\Cart;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MergeGuestCart
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Authenticated  $event
     * @return void
     */
    public function handle(Authenticated $event)
    {
        $user = $event->user;
        $sessionId = session()->getId();

        // Get the guest's cart items
        $guestCartItems = Cart::where('session_id', $sessionId)->get();

        foreach ($guestCartItems as $item) {
            // Check if the product is already in the user's cart
            $userCartItem = Cart::where('user_id', $user->id)
                                ->where('product_id', $item->product_id)
                                ->first();

            if ($userCartItem) {
                // Update the quantity if it already exists
                $userCartItem->quantity += $item->quantity;
                $userCartItem->save();
            } else {
                // Assign the guest cart item to the user
                $item->user_id = $user->id;
                $item->session_id = null; // Clear the session ID
                $item->save();
            }
        }
    }
}
