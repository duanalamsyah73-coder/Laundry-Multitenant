<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use App\Support\TenantContext;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ResolveTenantContext
{
    public function __construct(
        protected TenantContext $tenantContext
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        $this->tenantContext->clear();

        $tenantId = null;

        if ($request->routeIs('laundry.detail')) {
            $tenantId = $request->route('id');
        } elseif (
            $request->is('api/orders') &&
            $request->isMethod('post')
        ) {
            $tenantId = $request->input('tenant_id');
        } elseif (
            $request->is('api/tenants/*/orders/*')
        ) {
            $tenantId = $request->route('tenant');
        }

        if ($tenantId instanceof Tenant) {
            $tenantId = $tenantId->id;
        }

        if ($tenantId !== null && filter_var($tenantId, FILTER_VALIDATE_INT)) {
            $tenant = Tenant::where('status', 'Aktif')
                ->find($tenantId);

            if ($tenant) {
                $this->tenantContext->setTenant($tenant);
            }
        }

        return $next($request);
    }
}