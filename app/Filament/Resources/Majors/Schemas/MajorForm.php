<?php

namespace App\Filament\Resources\Majors\Schemas;

use Illuminate\Support\Str;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;

class MajorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Jurusan')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $state, callable $set) {
                                $code = collect(explode(' ', $state))
                                    ->filter()
                                    ->map(fn($word) => Str::upper(Str::substr($word, 0, 1)))
                                    ->implode('');

                                $set('code', $code);
                            }),

                        TextInput::make('code')
                            ->label('Kode Jurusan')
                            ->required()
                            ->readOnly()
                            ->maxLength(10),
                    ]),
            ]);
    }
}
