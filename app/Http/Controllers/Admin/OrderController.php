<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // show all orders to admin
    public function index()
    {
         $orders = Order::latest()->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
     // ✅ Show single order details
    public function show(string $id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

     // ✅ Update order status or mark as paid
    public function update(Request $request, string $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'status' => 'nullable|string',
            'payment_status' => 'nullable|string',
            'courier_status' => 'nullable|string',
        ]);

        $order->update([
            'status' => $request->status ?? $order->status,
            'payment_status' => $request->payment_status ?? $order->payment_status,
            'courier_status' => $request->courier_status ?? $order->courier_status,
            'admin_note' => $request->admin_note,
        ]);

        return back()->with('success', 'Order updated successfully!');
    

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
