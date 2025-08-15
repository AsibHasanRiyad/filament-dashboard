<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class ProductsChart extends ChartWidget
{
    protected ?string $heading = 'Orders Statistics';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Orders',
                    'data' => [
                        rand(10, 50), // Jan
                        rand(15, 60), // Feb
                        rand(20, 70), // Mar
                        rand(25, 80), // Apr
                        rand(30, 90), // May
                        rand(35, 100), // Jun
                        rand(20, 80), // Jul
                        rand(10, 60), // Aug
                        rand(15, 70), // Sep
                        rand(25, 90), // Oct
                        rand(20, 75), // Nov
                        rand(15, 60), // Dec
                    ],
                    'borderColor' => '#4F46E5', // Indigo
                    'backgroundColor' => 'rgba(79, 70, 229, 0.2)',
                ],
            ],
            'labels' => [
                'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec',
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
