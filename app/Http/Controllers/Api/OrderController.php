<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatusHistory;
use App\Models\Service;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tenant_id' => 'required|integer|exists:tenants,id',
            'customer_id' => 'required|integer|exists:users,id',
            'service_id' => 'required|integer|exists:services,id',
            'weight' => 'required|numeric|gt:0',
            'pickup_type' => 'nullable|string|max:50',
            'address' => 'nullable|string',
        ]);

        $tenant = Tenant::where('id', $validated['tenant_id'])
            ->where('status', 'Aktif')
            ->first();

        if (!$tenant) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tenant tidak ditemukan atau tidak aktif'
            ], 404);
        }

        $customer = User::where('id', $validated['customer_id'])
            ->where('role', 'customer')
            ->first();

        if (!$customer) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data pelanggan tidak valid'
            ], 422);
        }

        $service = Service::where('id', $validated['service_id'])
            ->where('tenant_id', $tenant->id)
            ->where('status', 'Aktif')
            ->first();

        if (!$service) {
            return response()->json([
                'status' => 'error',
                'message' => 'Layanan tidak ditemukan atau bukan milik tenant tersebut'
            ], 422);
        }

        $total = round(
            (float) $service->price * (float) $validated['weight'],
            2
        );

        $status = 'Menunggu Pembayaran';

        $order = DB::transaction(function () use (
            $validated,
            $tenant,
            $customer,
            $service,
            $total,
            $status
        ) {
            $order = Order::create([
                'tenant_id' => $tenant->id,
                'customer_id' => $customer->id,
                'service_id' => $service->id,
                'order_code' => 'ORD-' . now()->format('ymdHis') . Str::upper(Str::random(6)),
                'weight' => $validated['weight'],
                'total' => $total,
                'payment_status' => 'Menunggu Pembayaran',
                'status' => $status,
                'pickup_type' => $validated['pickup_type'] ?? null,
                'address' => $validated['address'] ?? null,
            ]);

            OrderStatusHistory::create([
                'order_id' => $order->id,
                'status' => $status,
                'note' => 'Pesanan dibuat',
                'changed_by' => $customer->id,
            ]);

            return $order;
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Pesanan berhasil dibuat',
            'data' => $order
        ], 201);
    }

    public function show(Tenant $tenant, Order $order)
    {
        if ($tenant->status !== 'Aktif') {
            return response()->json([
                'status' => 'error',
                'message' => 'Tenant tidak aktif'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $order
        ], 200);
    }

    public function showLegacy($id)
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Gunakan endpoint pesanan berdasarkan tenant'
        ], 404);
    }
}