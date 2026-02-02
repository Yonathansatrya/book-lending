<?php

namespace App\Filament\Resources\Users\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\Users\UserResource;
use App\Filament\Resources\Users\Schemas\UserForm;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah User')
                ->modalHeading('Tambah User')
                ->modalSubmitActionLabel('Simpan')
                ->schema(fn() => UserForm::configure(app(\Filament\Schemas\Schema::class))->getComponents())
                ->visible(fn() => auth()->user()->can('Create:User')),
        ];
    }
}
