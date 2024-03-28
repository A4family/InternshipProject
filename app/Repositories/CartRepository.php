<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Cart;
use App\Repositories\Interfaces\CartRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class CartRepository implements CartRepositoryInterface
{
    /**
     * Display cart items
     * @param string $userId
     * @return mixed
     */
    public function showCartItems(string $userId)
    {
        // TODO: Implement showCartItems() method.

        return Cart::where('buyer_id', $userId)
            ->with('product')
            ->paginate(10);
    }

    /**
     * Store cart items
     * @param array $data
     * @return bool
     */
    public function store(array $data): bool
    {
        // TODO: Implement store() method.
        try {
            DB::beginTransaction();
            $cart = Cart::where('buyer_id', $data['buyer_id'])
                ->where('product_id', $data['product_id'])
                ->first();

            if ($cart){
                $cart->quantity += $data['quantity'];
                $cart->amount = $cart->quantity * $data['price'];
                $cart->save();
            }else{
                Cart::create([
                    'buyer_id' => $data['buyer_id'],
                    'product_id' => $data['product_id'],
                    'quantity' => $data['quantity'],
                    'price' => $data['price'],
                    'amount' => ($data['quantity']*$data['price']),
                ]);
            }
            DB::commit();
            return true;
        }catch (\Exception $e){
            DB::rollBack();
            Log::error('Caught Exception: ' . $e->getMessage());
            Log::error('Exception Details: ' . $e);
            return false;
        }
    }


    /**
     * Update cart quantity
     * @param array $data
     * @return bool
     */
    public function updateQuantity(array $data): bool
    {
        try {
            DB::beginTransaction();
            $cartItem = Cart::findOrFail($data['cart_id']);
            $cartItem->quantity = $data['quantity'];
            $cartItem->amount = $data['quantity']*$data['price'];

            $cartItem->save();
            DB::commit();
            return true;
        }catch (\Exception $e){
            DB::rollBack();
            Log::error('Caught Exception: ' . $e->getMessage());
            Log::error('Exception Details: ' . $e);
            return false;
        }
    }

    /**
     * Remove items from cart
     * @param string $cartId
     * @return bool
     */
    public function removeFromCart(string $cartId): bool
    {
        try {
            DB::beginTransaction();
            if (Cart::find($cartId)->delete()){
                return true;
            }
            DB::commit();
            return false;
        }catch (\Exception $e){
            DB::rollBack();
            Log::error('Caught Exception: ' . $e->getMessage());
            Log::error('Exception Details: ' . $e);
            return false;
        }
    }
}
