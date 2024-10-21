<?php

namespace App\Filament\Office\Resources\TenantResource\Pages;

use App\Filament\Office\Resources\TenantResource;
use App\Models\Tenant;
use Filament\Resources\Pages\CreateRecord;

class CreateTenant extends CreateRecord
{
    protected static string $resource = TenantResource::class;

    protected function afterCreate(): void
    {
        Tenant::updateTenanCountCache();
    }
}
