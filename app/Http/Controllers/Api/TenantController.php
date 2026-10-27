<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function index()
    {
        $tenant = Tenant::all();

        return response()->json([
            'status' => 'success',
            'data' => $tenant
        ]);
    }

    public function show($id)
    {
        $tenant = Tenant::find($id);

        if (!$tenant) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tenant tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $tenant
        ]);
    }

    public function store(Request $request)
    {
        $tenant = Tenant::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
            'jenis_laundry' => $request->jenis_laundry,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Tenant berhasil ditambahkan',
            'data' => $tenant
        ], 201);
    }
}