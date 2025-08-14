<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('brand.name')
                    ->numeric(),
                TextEntry::make('name'),
                TextEntry::make('description')->columnSpanFull(),
                TextEntry::make('slug'),
                TextEntry::make('sku')
                    ->label('SKU'),
                ImageEntry::make('image'),
                TextEntry::make('quantity')
                    ->numeric(),
                TextEntry::make('price')
                    ->money(),
                IconEntry::make('is_visible')
                    ->boolean(),
                IconEntry::make('is_featured')
                    ->boolean(),
                TextEntry::make('type'),
                TextEntry::make('published_at')
                    ->date(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ])->columns(2);
    }
}
