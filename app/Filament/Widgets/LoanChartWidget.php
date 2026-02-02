<?php

namespace App\Filament\Widgets;

use App\Models\Loan;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\ChartWidget;

class LoanChartWidget extends ChartWidget
{
    use HasWidgetShield;
    // protected static ?string $heading = 'Statistik Peminjaman';
    protected static ?int $sort = 3;

    // public static function canView(): bool
    // {
    //     return auth()->user()?->can('view_admin_dashboard') ?? false;
    // }

    protected function getData(): array
    {
        $data = Loan::selectRaw('MONTH(tanggal_pinjam) as bulan, COUNT(*) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');

        return [
            'datasets' => [
                [
                    'label' => 'Peminjaman',
                    'data' => $data->values(),
                ],
            ],
            'labels' => $data->keys()
                ->map(fn($m) => date('F', mktime(0, 0, 0, $m, 1)))
                ->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
