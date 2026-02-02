<?php

namespace App\Filament\Resources\Books\Pages;

use App\Filament\Resources\Books\BookResource;
use App\Filament\Resources\Books\Schemas\BookForm;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBooks extends ListRecords
{
    protected static string $resource = BookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Buku')
                ->modalHeading('Tambah Buku')
                ->modalSubmitActionLabel('Simpan')
                ->schema(fn() => BookForm::configure(app(\Filament\Schemas\Schema::class))->getComponents())
                ->visible(fn() => auth()->user()->can('Create:Book')),
        ];
    }
}
