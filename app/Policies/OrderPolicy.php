<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['super_admin', 'tenant', 'customer'], true);
    }

    public function view(User $user, Order $order): bool
    {
        if ($user->role === 'super_admin') {
            return true;
        }

        if ($user->role === 'tenant') {
            return $user->tenant_id !== null
                && (int) $user->tenant_id === (int) $order->tenant_id;
        }

        if ($user->role === 'customer') {
            return (int) $user->id === (int) $order->customer_id;
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->role === 'customer';
    }

    public function update(User $user, Order $order): bool
    {
        if ($user->role === 'super_admin') {
            return true;
        }

        return $user->role === 'tenant'
            && $user->tenant_id !== null
            && (int) $user->tenant_id === (int) $order->tenant_id;
    }

    public function delete(User $user, Order $order): bool
    {
        return false;
    }

    public function restore(User $user, Order $order): bool
    {
        return false;
    }

    public function forceDelete(User $user, Order $order): bool
    {
        return false;
    }
}