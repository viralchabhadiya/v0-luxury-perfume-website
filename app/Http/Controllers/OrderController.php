<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
    public function confirmation($orderId)
    {
        $order = Order::with('items.product')->findOrFail($orderId);

        return view('order.confirmation', [
            'order' => $order,
        ]);
    }
}
