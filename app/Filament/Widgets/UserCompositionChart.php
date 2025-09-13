<?php

namespace App\Filament\Widgets;

use App\Models\UserDosenTendik;
use App\Models\UserMahasiswa;
use Filament\Widgets\ChartWidget;

class UserCompositionChart extends ChartWidget
{
    protected ?string $heading = 'Komposisi Pengguna';

    protected int | string | array $columnSpan = 'full';

    protected ?string $maxHeight = '300px';

    protected static ?int $sort = 0;

    protected function getData(): array
    {
        // 1. Ambil jumlah data dari masing-masing model
        $dosenTendikCount = UserDosenTendik::count();
        $mahasiswaCount = UserMahasiswa::count();

        return [
            // 2. Definisikan data yang akan ditampilkan
            'datasets' => [
                [
                    'label' => 'Jumlah Pengguna',
                    'data' => [$dosenTendikCount, $mahasiswaCount],
                    'backgroundColor' => [
                        'rgb(26, 130, 143)', // <-- Warna TSU Teal untuk 'Dosen & Tendik'
                        'rgb(245, 185, 71)', // <-- Warna Mustard Gold untuk 'Mahasiswa'
                    ],
                    'hoverBackgroundColor' => [
                        'rgb(22, 111, 122)', // TSU Teal sedikit lebih gelap
                        'rgb(221, 166, 64)', // Mustard Gold sedikit lebih gelap
                    ],
                ],
            ],
            // 3. Definisikan label untuk setiap potongan data
            'labels' => ['Dosen & Tendik', 'Mahasiswa'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
