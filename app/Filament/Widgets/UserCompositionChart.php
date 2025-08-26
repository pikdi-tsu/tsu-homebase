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
                        'rgb(10, 107, 127)',  // Warna untuk Dosen (merah)
                        'rgb(249, 190, 32)', // Warna untuk Mahasiswa (biru)
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
