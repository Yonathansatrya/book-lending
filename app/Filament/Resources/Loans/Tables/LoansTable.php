<?php

namespace App\Filament\Resources\Loans\Tables;

use App\Filament\Resources\Loans\Schemas\LoanForm;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;

class LoansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Peminjam'),

                TextColumn::make('tanggal_pinjam')
                    ->date(),

                TextColumn::make('status')
                    ->badge()
                    ->color(
                        fn(string $state) =>
                        $state === 'dipinjam' ? 'warning' : 'success'
                    ),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                DeleteAction::make()->visible(fn() => auth()->user()->can('Delete:Loan')),
                EditAction::make()
                    ->label('Edit Peminjaman')
                    ->modalHeading('Edit Peminjaman')
                    ->modalSubmitActionLabel('Simpan')
                    ->schema(fn() => LoanForm::configure(app(\Filament\Schemas\Schema::class))->getComponents())
                    ->visible(fn() => auth()->user()->can('Update:Loan')),

                Action::make('kembalikan')
                    ->label('Kembalikan')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    // ->visible(
                    //     fn($record) =>
                    //     $record->status === 'dipinjam'
                    //         && auth()->user()->can('update', $record->id)
                    // )
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'dikembalikan',
                            'tanggal_kembali' => now(),
                        ]);
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->visible(fn() => auth()->user()->can('Delete:Loan')),
                ]),
            ]);
    }
}
