<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Enums\OrderStatusEnum;
use App\Models\Product;
use App\Models\Customer;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;

use Filament\Schemas\Components\Utilities\Set;

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
                                        ->options(Product::query()->pluck('name', 'id'))
                                        ->reactive()
                                        ->afterStateUpdated(
                                            fn($state, Set $set) =>
                                            $set('unit_price', Product::find($state)?->price ?? 0)
                                        ),
                                    TextInput::make('quantity')
                                        ->numeric()
                                        ->default(1)
                                        ->required()
                                        ->live()
                                        ->dehydrated(),
                                    TextInput::make('unit_price')
                                        ->label('Unit Price')
                                        ->disabled()
                                        ->dehydrated()
                                        ->numeric()
                                        ->required(),
                                ])
                                ->columns(3),

                            // ✅ Shipping price here is on the `orders` table
                            TextInput::make('shipping_price')
                                ->label('Shipping Price')
                                ->numeric()
                                ->required()
                                ->dehydrated(),

                            Placeholder::make('total_price')
                                ->label('Total Price')
                                ->content(function ($get) {
                                    $itemsTotal = collect($get('items') ?? [])
                                        ->sum(fn($item) => ($item['quantity'] ?? 0) * ($item['unit_price'] ?? 0));

                                    return $itemsTotal + ($get('shipping_price') ?? 0);
                                }),
                        ]),

                ])->columnSpanFull()
            ]);
    }
}
