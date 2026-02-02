<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->label('Nama')
                ->required(),

            TextInput::make('email')
                ->email()
                ->required(),

            TextInput::make('nis')
                ->label('NIS')
                ->visible(fn() => auth()->user()->can('update_user')),

            TextInput::make('kelas')
                ->label('Kelas'),

            Select::make('roles')
                ->label('Role')
                ->relationship('roles', 'name')
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
        ]);
    }
}
