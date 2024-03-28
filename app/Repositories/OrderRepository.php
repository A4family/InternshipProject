<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Order;
use App\Models\Product;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OrderRepository implements OrderRepositoryInterface
{
    /**
     * Store new order
     * @param array $data
     * @return bool
     */
    public function storeOrder(array $data): bool
    {
        try {
            DB::beginTransaction();

            $order = Order::create([
                'buyer_id' => $data['buyer_id'],
                'total_amount' => $data['total_amount'],
                'status' => $data['status'],
            ]);

            $pivotData[] = [
                'product_id' => $data['product_id'],
                'quantity' => $data['quantity'],
                'price' => $data['price'],
            ];
            $order->products()->attach($pivotData);

            $this->sendEmailReceipt(auth()->user(), $data);
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
     * Send email receipt to customer
     * @param $userDetails
     * @param array $orderInfo
     * @return void
     */
    public function sendEmailReceipt($userDetails, array $orderInfo)
    {
        $nameOfUser = $userDetails->name;
        $productName = Product::find($orderInfo['product_id'])->product_title;
        Mail::send('userend.commonComponents.purchase-receipt-email', compact('nameOfUser', 'productName', 'orderInfo'), function($message) use ($userDetails) {
            $message->to($userDetails->email);
            $message->subject('Purchase Receipt');
        });
    }
}
