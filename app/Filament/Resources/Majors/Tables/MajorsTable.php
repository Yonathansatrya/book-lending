<?php

namespace App\Filament\Resources\Majors\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\Majors\Schemas\MajorForm;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;

class MajorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('code')
                    ->label('Code Jurusan')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                DeleteAction::make()->visible(fn() => auth()->user()->can('Delete:Major')),
                
                EditAction::make()->label('Edit Jurusan')
                    ->modalHeading('Edit Jurusan')
                    ->modalSubmitActionLabel('Simpan')
                    ->schema(fn() => MajorForm::configure(app(\Filament\Schemas\Schema::class))->getComponents())
                    ->visible(fn() => auth()->user()->can('Update:Major')),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
