<?php

namespace App\Filament\Office\Resources;

use App\Filament\Office\Resources\TenantResource\Pages\CreateTenant;
use App\Filament\Office\Resources\TenantResource\Pages\EditTenant;
use App\Filament\Office\Resources\TenantResource\Pages\ListTenants;
use App\Filament\Office\Resources\TenantResource\RelationManagers\DomainsRelationManager;
use App\Models\Tenant;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class TenantResource extends Resource
{
    protected static ?string $model = Tenant::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Tenant Info')
                    ->schema([
                        TextInput::make('id')
                            ->label('ID: Tenant Name')
                            ->hint('foo.bar.com')
                            ->required()
                            ->unique(ignoreRecord: true),
                        DateTimePicker::make('created_at')
                            ->visibleOn('edit')
                            ->disabled(),
                    ]),

                Section::make('Delete Tenant')
                    ->visibleOn('edit')
                    ->iconColor('danger')
                    ->icon('heroicon-o-trash')
                    ->schema([
                        Actions::make([
                            Action::make('deleteTenant')
                                ->color('danger')
                                ->label('Delete')
                                ->requiresConfirmation()
                                ->form([
                                    TextInput::make('password')
                                        ->password()
                                        ->revealable()
                                        ->required(),
                                ])
                                ->action(function (array $data, Tenant $record, Action $action) {
                                    if (! Hash::check($data['password'], auth()->user()->password)) {
                                        Notification::make()
                                            ->danger()
                                            ->title('Password does not match')
                                            ->send();

                                        return;
                                    }

                                }),
                        ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->since()
                    ->dateTimeTooltip(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                //                Tables\Actions\BulkActionGroup::make([
                //                    Tables\Actions\DeleteBulkAction::make()
                //                        ->after(fn () => Tenant::updateTenanCountCache()),
                //                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            DomainsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTenants::route('/'),
            'create' => CreateTenant::route('/create'),
            'edit' => EditTenant::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return (int) Cache::get('total-tenant-count');
    }
}
