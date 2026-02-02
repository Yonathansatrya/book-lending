<?php

namespace App\Filament\Widgets;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

class AdminStatsWidget extends StatsOverviewWidget
{
    use HasWidgetShield;

    protected static ?int $sort = 1;

    /**
     * Hanya admin yang boleh melihat widget
     */
    // public static function canView(): bool
    // {
    //     return auth()->user()->can('view_admin_dashboard');
    // }

    protected function getStats(): array
    {
        return [
            Stat::make('Total Buku', Book::count())
                ->icon('heroicon-o-book-open'),

            Stat::make(
                'Total Siswa',
                User::role('siswa')->count()
            )->icon('heroicon-o-users'),

            Stat::make(
                'Peminjaman Aktif',
                Loan::where('status', 'dipinjam')->count()
            )->icon('heroicon-o-arrow-path'),

            Stat::make(
                'Stok Habis',
                Book::where('stok', 0)->count()
            )
                ->icon('heroicon-o-exclamation-triangle')
                ->color('danger'),
        ];
    }
}
