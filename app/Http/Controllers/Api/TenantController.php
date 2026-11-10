<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    // Menampilkan semua tenant yang aktif
    public function index()
    {
        $tenants = Tenant::where('status', 'Aktif')->get();

        return response()->json([
            'status' => 'success',
            'data' => $tenants
        ], 200);
    }

    // Menampilkan detail tenant yang aktif
    public function show($id)
    {
        $tenant = Tenant::where('status', 'Aktif')->find($id);

        if (!$tenant) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tenant tidak ditemukan atau tidak aktif'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $tenant
        ], 200);
    }

    // Menambahkan tenant baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'owner' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        $tenant = Tenant::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Tenant berhasil ditambahkan',
            'data' => $tenant
        ], 201);
    }
}