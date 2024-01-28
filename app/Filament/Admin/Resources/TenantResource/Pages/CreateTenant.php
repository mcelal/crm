<?php

namespace App\Filament\Admin\Resources\TenantResource\Pages;

use App\Filament\Admin\Resources\TenantResource;
use App\Models\Tenant;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateTenant extends CreateRecord
{
    protected static string $resource = TenantResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $domain = $data['domain'];
        unset($data['domain']);

        /** @var Tenant $tenant */
        $tenant = static::getModel()::create($data);

        $tenant->domains()->create([
            'domain' => $domain,
        ]);

        return $tenant;
    }
}
