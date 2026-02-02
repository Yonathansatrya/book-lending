<?php

namespace App\Filament\Resources\Majors\Pages;

use App\Filament\Resources\Majors\MajorResource;
use App\Filament\Resources\Majors\Schemas\MajorForm;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMajors extends ListRecords
{
    protected static string $resource = MajorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Jurusan')
                ->modalHeading('Tambah Jurusan')
                ->modalSubmitActionLabel('Simpan')
                ->schema(fn() => MajorForm::configure(app(\Filament\Schemas\Schema::class))->getComponents())
                ->visible(fn() => auth()->user()->can('Create:Major')),
        ];
    }
}
