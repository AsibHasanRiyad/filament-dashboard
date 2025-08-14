<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Enums\OrderStatusEnum;
use App\Models\Product;
use App\Models\Customer;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    Step::make('Order Details')
                        ->schema([
                            Select::make('customer_id')
                                ->relationship('customer', 'name')
                                ->searchable()
                                ->preload()
                                ->required(),
                            TextInput::make('number')
                                ->default('OR-' . random_int(100000, 99999999))
                                ->disabled()
                                ->dehydrated()
                                ->required(),
                            Select::make('status')
                                ->options([
                                    'pending' => OrderStatusEnum::PENDING->value,
                                    'processing' => OrderStatusEnum::PROCESSING->value,
                                    'completed' => OrderStatusEnum::COMPLETED->value,
                                    'declined' => OrderStatusEnum::DECLINED->value,
                                ])
                                ->required()
                                ->default('pending')
                                ->columnSpanFull(),
                            MarkdownEditor::make('notes')
                                ->columnSpanFull(),
                        ])->columns(2),
                    Step::make('Order Items')
                        ->schema([
                            Repeater::make('items')
                                ->relationship()
                                ->schema([
                                    Select::make('product_id')
                                        ->label('Product')
                                        ->options(Product::query()->pluck('name', 'id')),
                                    TextInput::make('quantity')
                                        ->numeric()
                                        ->default(1)
                                        ->required(),
                                    TextInput::make('unit_price')
                                        ->label('Unit Price')
                                        ->disabled()
                                        ->dehydrated()
                                        ->numeric()
                                        ->required(),
                                ])->columns(3)
                        ])
                ])->columnSpanFull()
            ]);
    }
}
