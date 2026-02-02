<?php

namespace App\Filament\Resources\Loans;

use App\Filament\Resources\Loans\Pages\CreateLoan;
use App\Filament\Resources\Loans\Pages\EditLoan;
use App\Filament\Resources\Loans\Pages\ListLoans;
use App\Filament\Resources\Loans\Schemas\LoanForm;
use App\Filament\Resources\Loans\Tables\LoansTable;
use App\Models\Loan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LoanResource extends Resource
{
    protected static ?string $model = Loan::class;

    protected static string|BackedEnum|null $navigationIcon =
    Heroicon::OutlinedArrowPath;

    protected static ?string $navigationLabel = 'Peminjaman Buku';

    public static function form(Schema $schema): Schema
    {
        return LoanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LoansTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        // admin lihat semua, siswa hanya miliknya
        if (auth()->user()->can('view_any_loan')) {
            return parent::getEloquentQuery();
        }

        return parent::getEloquentQuery()
            ->where('user_id', auth()->id());
    }

    // public static function canViewAny(): bool
    // {
    //     return auth()->user()->can('view_any_loan');
    // }

    public static function getPages(): array
    {
        return [
            'index'  => ListLoans::route('/'),
            // 'create' => CreateLoan::route('/create'),
            // 'edit'   => EditLoan::route('/{record}/edit'),
        ];
    }
}
