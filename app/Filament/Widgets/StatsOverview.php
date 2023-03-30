<?php

namespace App\Filament\Widgets;

use App\Models\Tenant;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Total Tenant', Tenant::query()->count())
                ->url(route('filament.resources.tenants.index')),

            Card::make('Total User', User::query()->count())
                ->url(route('filament.resources.users.index')),
        ];
    }
}
