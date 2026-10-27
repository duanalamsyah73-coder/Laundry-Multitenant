<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Tenant;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Membuat pesanan baru
    public function store(Request $request)
    {
        // Mengecek apakah tenant/laundry terdaftar
        $tenant = Tenant::where('nama', $request->nama_laundry)->first();

        // Jika tenant tidak ditemukan
        if (!$tenant) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tenant tidak ditemukan'
            ], 404);
        }

        // Jika tenant ditemukan, pesanan dibuat
        $order = Order::create([
            'nama_pelanggan' => $request->nama_pelanggan,
            'nama_laundry' => $request->nama_laundry,
            'jenis_laundry' => $request->jenis_laundry,
            'berat' => $request->berat,
            'total_harga' => $request->total_harga,
            'status' => $request->status ?? 'diproses',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Pesanan berhasil dibuat',
            'data' => $order
        ], 201);
    }

    // Melihat detail pesanan berdasarkan ID
    public function show($id)
    {
        $order = Order::find($id);

        // Jika pesanan tidak ditemukan
        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pesanan tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $order
        ], 200);
    }
}