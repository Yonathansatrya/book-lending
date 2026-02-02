<?php

namespace App\Filament\Widgets;

use App\Models\Book;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class TopBorrowedBooksWidget extends TableWidget
{
    use HasWidgetShield;
    // protected static ?string $heading = 'Buku Paling Sering Dipinjam';
    protected static ?int $sort = 4;

    /**
     * Hanya admin yang boleh melihat
     */
    // public static function canView(): bool
    // {
    //     return auth()->user()?->can('view_admin_dashboard') ?? false;
    // }

    public function table(Table $table): Table
    {
        return $table
            ->query(function (): Builder {
                return Book::query()
                    ->select('books.id', 'books.judul')
                    ->selectRaw('COALESCE(SUM(loan_details.qty), 0) as total_dipinjam')
                    ->leftJoin('loan_details', 'books.id', '=', 'loan_details.book_id')
                    ->leftJoin('loans', 'loans.id', '=', 'loan_details.loan_id')
                    ->groupBy('books.id', 'books.judul')
                    ->orderByDesc('total_dipinjam')
                    ->limit(5);
            })
            ->columns([
                TextColumn::make('judul')
                    ->label('Judul Buku')
                    ->limit(30),

                TextColumn::make('total_dipinjam')
                    ->label('Total Dipinjam')
                    ->badge()
                    ->color('primary'),
            ]);
    }
}
