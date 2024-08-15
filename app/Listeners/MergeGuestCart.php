<?php

namespace App\Listeners;
use App\Models\Cart;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
// use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Log;

class MergeGuestCart implements ShouldQueue
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
        $oldSessionId = session()->get('guest_session_id'); // Retrieve stored guest session ID

        if (!$oldSessionId) {
            return;
        }

        // Get the guest's cart items
        $guestCartItems = Cart::where('session_id', $oldSessionId)->get();

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

        // Clear the guest session ID from the user session
        session()->forget('guest_session_id');
    }

}
