<?php

namespace App\Filament\Resources\Loans\Schemas;

use App\Models\Book;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;

class LoanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('user_id')
                    ->default(fn() => auth()->id()),

                DatePicker::make('tanggal_pinjam')
                    ->label('Tanggal Pinjam')
                    ->default(now())
                    ->required(),

                Repeater::make('details')
                    ->relationship()
                    ->label('Buku Dipinjam')
                    ->schema([
                        Select::make('book_id')
                            ->label('Buku')
                            ->options(Book::where('stok', '>', 0)
                                ->pluck('judul', 'id'))
                            ->searchable()
                            ->required(),

                        TextInput::make('qty')
                            ->label('Jumlah')
                            ->numeric()
                            ->minValue(1)
                            ->required(),
                    ])
                    ->minItems(1)
                    ->columnSpanFull(),
            ]);
    }
}
