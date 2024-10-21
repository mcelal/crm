<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Concerns\MaintenanceMode;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase;
    use HasDomains;
    use MaintenanceMode;

    public static function updateTenanCountCache(): void
    {
        Cache::forever(
            'total-tenant-count',
            self::all()->count()
        );
    }
}
