<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'items', 'payment', 'shipment'])->latest()->paginate(10);
        return response()->json(['status' => true, 'data' => $orders], 200);
    }

    public function store(Request $request)
    {
        // TODO: Logika pembuatan pesanan yang sesungguhnya lebih kompleks.
        // Ini adalah contoh sederhana.
        $validated = $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'jumlah_total' => 'required|numeric',
            'status_pesanan' => 'required|string',
            // ... validasi untuk items, payment, shipment
        ]);

        $order = DB::transaction(function () use ($validated, $request) {
            $order = Order::create($validated);
            // TODO: logic untuk menyimpan order_items
            // TODO: logic untuk menyimpan payment
            // TODO: logic untuk menyimpan shipment
            return $order;
        });

        return response()->json(['status' => true, 'message' => 'Pesanan Berhasil Dibuat', 'data' => $order], 201);
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items', 'payment', 'shipment', 'orderReturn']);
        return response()->json(['status' => true, 'data' => $order], 200);
    }

    public function update(Request $request, Order $order)
    {
        // Biasanya yang diupdate hanya statusnya
        $validated = $request->validate(['status_pesanan' => 'required|string']);
        $order->update($validated);
        return response()->json(['status' => true, 'message' => 'Pesanan Berhasil Diupdate', 'data' => $order], 200);
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(['status' => true, 'message' => 'Pesanan Berhasil Dihapus'], 200);
    }
}
