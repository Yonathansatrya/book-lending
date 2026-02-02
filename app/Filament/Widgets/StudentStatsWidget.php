<?php

namespace App\Filament\Widgets;

use App\Models\Loan;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StudentStatsWidget extends StatsOverviewWidget
{
    use HasWidgetShield;
    protected static ?int $sort = 2;

    /**
     * Hanya siswa
     */
    // public static function canView(): bool
    // {
    //     return auth()->user()?->can('view_student_dashboard') ?? false;
    // }

    protected function getStats(): array
    {
        $userId = auth()->id();

        return [
            Stat::make(
                'Sedang Dipinjam',
                Loan::where('user_id', $userId)
                    ->where('status', 'dipinjam')
                    ->count()
            )
                ->icon('heroicon-o-book-open')
                ->color('warning'),

            Stat::make(
                'Total Riwayat',
                Loan::where('user_id', $userId)->count()
            )
                ->icon('heroicon-o-clock'),

            Stat::make(
                'Terakhir Pinjam',
                optional(
                    Loan::where('user_id', $userId)
                        ->latest()
                        ->first()
                )?->tanggal_pinjam?->format('d M Y') ?? '-'
            )
                ->icon('heroicon-o-calendar'),
        ];
    }
}
