<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

beforeEach(function () {
    Schema::create('tenants', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('status');
        $table->timestamps();
    });

    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('tenant_id');
        $table->unsignedBigInteger('customer_id')->nullable();
        $table->unsignedBigInteger('service_id')->nullable();
        $table->string('order_code');
        $table->decimal('weight', 8, 2);
        $table->decimal('total', 12, 2);
        $table->string('payment_status')->nullable();
        $table->string('status');
        $table->string('pickup_type')->nullable();
        $table->text('address')->nullable();
        $table->timestamps();
    });

    DB::table('tenants')->insert([
        ['id' => 1, 'name' => 'Laundry A', 'status' => 'Aktif'],
        ['id' => 2, 'name' => 'Laundry B', 'status' => 'Aktif'],
    ]);

    DB::table('orders')->insert([
        'id' => 1,
        'tenant_id' => 1,
        'order_code' => 'ORD-TEST-001',
        'weight' => 2,
        'total' => 24000,
        'status' => 'Menunggu Pembayaran',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
});

test('tenant A dapat mengakses pesanan miliknya', function () {
    $response = $this->getJson('/api/tenants/1/orders/1');

    $response->assertOk()
        ->assertJsonPath('data.id', 1)
        ->assertJsonPath('data.tenant_id', 1);
});

test('tenant B tidak dapat mengakses pesanan tenant A', function () {
    $response = $this->getJson('/api/tenants/2/orders/1');

    $response->assertNotFound();
});