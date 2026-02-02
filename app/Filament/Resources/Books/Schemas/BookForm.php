<?php

namespace App\Filament\Resources\Books\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;

class BookForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('kode_buku')
                    ->label('Kode Buku')
                    ->required()
                    ->unique(ignoreRecord: true),

                TextInput::make('judul')
                    ->label('Judul Buku')
                    ->required(),

                TextInput::make('penulis')
                    ->required(),

                TextInput::make('penerbit')
                    ->required(),

                TextInput::make('tahun')
                    ->numeric()
                    ->required(),

                TextInput::make('stok')
                    ->numeric()
                    ->minValue(0)
                    ->required(),

                FileUpload::make('cover')
                    ->label('Cover Buku')
                    ->image()
                    ->directory('book-covers')
                    ->columnSpanFull(),
            ])->columns(2);
    }
}
