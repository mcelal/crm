<?php

namespace App\Filament\Office\Resources\TenantResource\Pages;

use App\Filament\Office\Resources\TenantResource;
use App\Models\Tenant;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTenant extends EditRecord
{
    protected static string $resource = TenantResource::class;

    protected function getHeaderActions(): array
    {
        return [
                        Actions\DeleteAction::make()
                            ->after(fn () => Tenant::updateTenanCountCache()),
        ];
    }
}
