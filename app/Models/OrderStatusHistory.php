<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderStatusHistory extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'order_id',
        'status',
        'note',
        'changed_by',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope('tenant', function (Builder $builder) {
            $builder->whereHas('order', function (Builder $query) {
                $context = app(\App\Support\TenantContext::class);

                if (!$context->hasTenant()) {
                    $query->whereRaw('1 = 0');
                    return;
                }

                $query->where('tenant_id', $context->tenantId());
            });
        });
    }

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function changedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}