<?php

namespace App\Filament\Resources\TenantResource\Pages;

use App\Filament\Resources\TenantResource;
use App\Models\Tenant;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ListTenants extends ListRecords
{
    protected static string $resource = TenantResource::class;

    protected function getTableQuery(): Builder
    {
        return Tenant::query()
            ->addSelect('*')
            ->addSelect(DB::raw('(SELECT PG_SIZE_PRETTY(PG_DATABASE_SIZE(tenants.data ->> \'tenancy_db_name\'))) as "db_size"'))
            ->withCount('domains');
    }

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getDefaultTableSortColumn(): ?string
    {
        return 'created_at';
    }

    protected function getDefaultTableSortDirection(): string
    {
        return 'desc';
    }
}
