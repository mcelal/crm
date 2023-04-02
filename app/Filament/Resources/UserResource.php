<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Pages\Page;
use Filament\Resources\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Users';

    protected static ?string $navigationGroup = 'Auth';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->required()
                        ->unique(column: 'email', ignoreRecord: true)
                        ->maxLength(255),

                    Forms\Components\DateTimePicker::make('email_verified_at')
                        ->when(static fn(Page $livewire): string => $livewire instanceof Pages\EditUser)
                        ->disabled(),

                    Forms\Components\TextInput::make('password')
                        ->password()
                        ->maxLength(255)
                        ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                        ->dehydrated(fn ($state): bool => filled($state))
                        ->required(fn (Page $livewire): string => $livewire instanceof CreateRecord)
                        ->label(static fn(Page $livewire):
                        string => ($livewire instanceof Pages\EditUser)
                            ? __('Change Password')
                            : __('Password')
                        ),

                    Forms\Components\Grid::make(1)
                        ->schema([
                            Forms\Components\Select::make('roles')
                                ->multiple()
                                ->preload()
                                ->relationship('roles', 'name'),
                        ]),

                    Forms\Components\Grid::make(1)
                        ->schema([
                            Forms\Components\Select::make('permissions')
                                ->multiple()
                                ->preload()
                                ->relationship('permissions', 'name')
                        ]),

                ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('roles.name'),

                Tables\Columns\IconColumn::make('email_verified_at')
                    ->label('E-Mail Verified')
                    ->tooltip(fn (User $record) => $record->email_verified_at ?: null)
                    ->alignCenter()
                    ->colors([
                        'danger',
                        'success' => fn ($state): bool => $state instanceof Carbon,
                    ])
                    ->options([
                        'heroicon-o-x-circle',
                        'heroicon-o-check-circle' => fn ($state): bool => $state instanceof Carbon,
                    ]),

                Tables\Columns\TextColumn::make('updated_at')
                    ->since()
                    ->sortable()
                    ->tooltip(fn (User $record): string => $record->created_at),

                Tables\Columns\TextColumn::make('created_at')
                    ->since()
                    ->sortable()
                    ->tooltip(fn (User $record): string => $record->created_at),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),

                    Tables\Actions\DeleteAction::make()
                        ->visible(fn (User $record) => $record->id !== auth()->id()),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit'   => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    protected static function getNavigationSort(): ?int
    {
        return 1;
    }
}
