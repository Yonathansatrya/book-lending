<?php

namespace App\Filament\Resources\Books\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class BooksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover')
                    ->label('Cover')
                    ->circular(),

                TextColumn::make('kode_buku')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('judul')
                    ->searchable()
                    ->limit(30),

                TextColumn::make('stok')
                    ->badge()
                    ->color(fn(int $state) => $state > 0 ? 'success' : 'danger'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                // BulkActionGroup::make([
                    DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
