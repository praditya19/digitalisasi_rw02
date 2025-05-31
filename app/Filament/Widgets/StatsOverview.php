<?php

namespace App\Filament\Widgets;

use App\Models\Warga;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalWarga = Warga::count();
        $totalKK = Warga::distinct('nomor_keluarga')->count('nomor_keluarga');
        $lakiLaki = Warga::whereIn('jenis_kelamin', ['L', 'Laki-laki', 'laki-laki'])->count();
        $perempuan = Warga::whereIn('jenis_kelamin', ['P', 'Perempuan', 'perempuan'])->count();

        $bayi = Warga::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) < 1')->count();
        $anak = Warga::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 1 AND 17')->count();
        $dewasa = Warga::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 18 AND 60')->count();
        $manula = Warga::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) > 60')->count();

        return [
            Stat::make('Total Warga', $totalWarga)
                ->description('Jumlah seluruh warga')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Total KK', $totalKK)
                ->description('Jumlah kepala keluarga')
                ->descriptionIcon('heroicon-m-home-modern')
                ->color('success'),

            Stat::make('Jenis Kelamin', "$lakiLaki L / $perempuan P")
                ->description('Perbandingan gender')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),

            Stat::make('Kategori Usia', "Bayi: $bayi, Anak: $anak")
                ->description("Dewasa: $dewasa, Manula: $manula")
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('warning'),
        ];
    }

    protected function getGenderRatio(int $laki, int $perempuan): string
    {
        $total = $laki + $perempuan;
        $percentLaki = $total > 0 ? round(($laki / $total) * 100) : 0;
        $percentPerempuan = $total > 0 ? round(($perempuan / $total) * 100) : 0;

        return "$laki ($percentLaki%) L / $perempuan ($percentPerempuan%) P";
    }

    protected function getAgeDistribution(int $bayi, int $anak, int $dewasa, int $manula): string
    {
        $total = $bayi + $anak + $dewasa + $manula;

        $getPercent = fn($value) => $total > 0 ? round(($value / $total) * 100) : 0;

        return sprintf(
            "Bayi: %d%% • Anak: %d%% • Dewasa: %d%% • Lansia: %d%%",
            $getPercent($bayi),
            $getPercent($anak),
            $getPercent($dewasa),
            $getPercent($manula)
        );
    }

    protected function getMonthlyGrowthData(): array
    {
        return [5, 10, 12, 8, 15, 20, 25, 30, 28, 35, 40, 45];
    }
}

class WargaChart extends ChartWidget
{
    protected static ?string $heading = 'Pertumbuhan Penduduk Tahun Ini';
    protected static ?int $sort = 2;
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $data = Trend::model(Warga::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Warga',
                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
                    'backgroundColor' => 'rgba(59, 130, 246, 0.2)',
                    'borderColor' => '#3b82f6',
                    'borderWidth' => 2,
                    'tension' => 0.3,
                    'fill' => true,
                ],
            ],
            'labels' => $data->map(fn(TrendValue $value) => now()->create($value->date)->format('M')),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => false,
                    'grid' => [
                        'color' => 'rgba(200, 200, 200, 0.1)',
                    ],
                ],
                'x' => [
                    'grid' => [
                        'display' => false,
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'position' => 'top',
                    'labels' => [
                        'font' => [
                            'size' => 14,
                        ],
                    ],
                ],
            ],
        ];
    }
}

class JenisKelaminChart extends ChartWidget
{
    protected static ?string $heading = 'Komposisi Jenis Kelamin';
    protected static ?int $sort = 3;
    protected static ?string $maxHeight = '225px';

    protected function getData(): array
    {
        $laki = Warga::whereIn('jenis_kelamin', ['L', 'Laki-laki', 'laki-laki'])->count();
        $perempuan = Warga::whereIn('jenis_kelamin', ['P', 'Perempuan', 'perempuan'])->count();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah',
                    'data' => [$laki, $perempuan],
                    'backgroundColor' => ['#3b82f6', '#ec4899'],
                    'borderColor' => '#fff',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => ['Laki-laki', 'Perempuan'],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'right',
                    'labels' => [
                        'font' => [
                            'size' => 14,
                        ],
                    ],
                ],
                'tooltip' => [
                    'callbacks' => [
                        'label' => function ($context) {
                            $label = $context->label;
                            $value = $context->raw;
                            $total = array_sum($context->chart->data->datasets[0]->data);
                            $percentage = round(($value / $total) * 100);
                            return "$label: $value ($percentage%)";
                        }
                    ]
                ]
            ],
            'cutout' => '60%',
        ];
    }
}

class UsiaChart extends ChartWidget
{
    protected static ?string $heading = 'Distribusi Kelompok Usia';
    protected static ?int $sort = 4;
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $bayi = Warga::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) < 1')->count();
        $anak = Warga::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 1 AND 17')->count();
        $dewasa = Warga::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 18 AND 60')->count();
        $manula = Warga::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) > 60')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Warga',
                    'data' => [$bayi, $anak, $dewasa, $manula],
                    'backgroundColor' => [
                        'rgba(34, 211, 238, 0.7)',
                        'rgba(165, 180, 252, 0.7)',
                        'rgba(52, 211, 153, 0.7)',
                        'rgba(251, 191, 36, 0.7)'
                    ],
                    'borderColor' => [
                        '#22d3ee',
                        '#a5b4fc',
                        '#34d399',
                        '#fbbf24'
                    ],
                    'borderWidth' => 1,
                ],
            ],
            'labels' => ['Bayi (<1 thn)', 'Anak (1-17 thn)', 'Dewasa (18-60 thn)', 'Lansia (>60 thn)'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'grid' => [
                        'color' => 'rgba(200, 200, 200, 0.1)',
                    ],
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                ],
                'x' => [
                    'grid' => [
                        'display' => false,
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
        ];
    }
}