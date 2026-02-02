<?php

namespace App\Filament\Resources\Books\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use App\Filament\Resources\Books\Schemas\BookForm;

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
                DeleteAction::make()->visible(fn() => auth()->user()->can('Delete:Book')),
                
                EditAction::make()
                    ->label('Edit Buku')
                    ->modalHeading('Edit Buku')
                    ->modalSubmitActionLabel('Simpan')
                    ->schema(fn() => BookForm::configure(app(\Filament\Schemas\Schema::class))->getComponents())
                    ->visible(fn() => auth()->user()->can('Update:Book')),
            ])
            ->toolbarActions([
                // BulkActionGroup::make([
                DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
