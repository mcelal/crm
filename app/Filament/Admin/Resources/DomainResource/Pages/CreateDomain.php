<?php

namespace App\Filament\Admin\Resources\DomainResource\Pages;

use App\Filament\Admin\Resources\DomainResource;
use App\Models\Tenant;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateDomain extends CreateRecord
{
    protected static string $resource = DomainResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        return Tenant::query()
            ->find($data['tenant_id'])
            ->domains()
            ->create([
                'domain' => $data['domain'],
            ]);
    }
}
