<?php

namespace App\Filament\Widgets;

use App\Enums\OrderStatusEnum;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Customer', Customer::count())
                ->description('Increase In Customer')
                ->descriptionIcon(Heroicon::ArrowTrendingUp)
                ->descriptionColor('success')
                ->chart([1, 4, 33, 3, 34, 8, 2, 5]),


            Stat::make('Total Product ', Product::count())
                ->description('Increase In Product')
                ->descriptionIcon(Heroicon::ArrowTrendingUp)
                ->descriptionColor('success')
                ->chart([18, 14, 23, 3, 44, 18, 21, 55]),
            Stat::make('Pending Order', Order::where('status', OrderStatusEnum::PENDING->value)->count())
                ->description('Increase In Product')
                ->descriptionIcon(Heroicon::ArrowTrendingUp)
                ->descriptionColor('success')
                ->chart([18, 14, 23, 3, 44, 18, 21, 55]),

        ];
    }
}
