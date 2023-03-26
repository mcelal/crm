<?php

namespace App\Domains\Panel\Livewire;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class TenantTable extends DataTableComponent
{
    protected $model = Tenant::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function builder(): Builder
    {
        return Tenant::query()
            ->withCount('domains');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->searchable()
                ->sortable()
                ->excludeFromColumnSelect(),
            Column::make('Domains', 'id')
                ->format(
                    fn($value, $row) => $row->domains_count
                ),
            Column::make("Created at", "created_at")
                ->format(
                    fn($value) => $value->format('d.m.Y')
                )
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
        ];
    }
}
