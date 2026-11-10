<?php

namespace App\Models\Concerns;

use App\Support\TenantContext;
use Illuminate\Database\Eloquent\Builder;

trait BelongsToTenant
{
    protected static function bootBelongsToTenant(): void
    {
        static::addGlobalScope('tenant', function (Builder $builder) {
            $context = app(TenantContext::class);

            if (!$context->hasTenant()) {
                $builder->whereRaw('1 = 0');
                return;
            }

            $builder->where(
                $builder->getModel()->qualifyColumn('tenant_id'),
                $context->tenantId()
            );
        });

        static::creating(function ($model) {
            $context = app(TenantContext::class);

            if ($context->hasTenant()) {
                $model->tenant_id = $context->tenantId();
            }
        });
    }
}