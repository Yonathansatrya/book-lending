<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\Major;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Grid::make(2)->schema([
                TextInput::make('name')
                    ->label('Nama')
                    ->required(),

                TextInput::make('email')
                    ->email()
                    ->required(),

                TextInput::make('nis')
                    ->label('NIS')
                    ->visible(fn() => auth()->user()->can('update_user')),

                Select::make('kelas')
                    // ->required()
                    ->options([
                        'X' => 'X',
                        'XI' => 'XI',
                        'XII' => 'XII',
                    ])
                    ->label('Kelas'),

                Select::make('major_id')
                    ->label('Jurusan')
                    ->relationship('major', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable(),

                Select::make('roles')
                    ->label('Role')
                    ->relationship('roles', 'name', function ($query) {
                        if (auth()->user()?->hasRole('Admin')) {
                            $query->where('name', '!=', 'super_admin');
                        }
                    })
                    ->preload()
                    ->searchable()
                    ->required(),

                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->dehydrateStateUsing(
                        fn($state) => filled($state) ? Hash::make($state) : null
                    )
                    ->dehydrated(fn($state) => filled($state))
                    ->helperText('Kosongkan jika tidak ingin mengubah password'),
            ])
        ]);
    }
}
