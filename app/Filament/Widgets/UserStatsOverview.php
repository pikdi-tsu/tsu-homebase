<?php

namespace App\Filament\Widgets;

use App\Models\UserDosenTendik;
use App\Models\UserMahasiswa;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = -1;

    protected int | null | array $columns = 2;

    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        return [
            Stat::make('Total Dosen & Tendik', UserDosenTendik::count())
                ->icon('heroicon-o-academic-cap'),
            Stat::make('Total Mahasiswa', UserMahasiswa::count()) // Ganti dengan model Mahasiswa-mu
            ->icon('heroicon-o-users'),
        ];
    }
}
