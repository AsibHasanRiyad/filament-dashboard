<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Enums\ProductTypeEnum;
use Illuminate\Support\Str;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group as ComponentsGroup;
use Filament\Schemas\Components\Section as ComponentsSection;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Left Column
                ComponentsGroup::make()
                    ->schema([
                        ComponentsSection::make('Basic Information')
                            ->schema([
                                Select::make('brand_id')
                                    ->relationship('brand', 'name')
                                    ->required(),
                                Select::make('categories')
                                    ->relationship('categories', 'name')
                                    ->multiple()
                                    ->preload() // for multi select , loading data without searching
                                    ->required(),
                                TextInput::make('name')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->unique()
                                    ->afterStateUpdated(function (string $operation, $state, Set $set) {
                                        if ($operation === 'create' && filled($state)) {
                                            $set('slug', Str::slug($state));
                                        }
                                    }),
                                TextInput::make('slug')
                                    ->required()
                                    ->unique()
                                    ->readOnly(), // Changed from disabled() to readOnly()

                                MarkdownEditor::make('description')
                                    ->columnSpanFull(),
                            ])
                            ->collapsible(),
                        ComponentsSection::make('Image')
                            ->schema([
                                FileUpload::make('image')
                                    ->image()
                                    ->directory('product-image')
                                    ->preserveFilenames()
                                    ->imageEditor()
                                    ->required(),
                            ])
                            ->collapsible(),
                    ])
                    ->columnSpan(1),

                // Right Column - Stack sections vertically
                ComponentsGroup::make()
                    ->schema([
                        ComponentsSection::make('Status')
                            ->schema([
                                Toggle::make('is_visible')
                                    ->helperText('Enable or Disable for Visibility')
                                    ->default(true)
                                    ->label('Visibility')
                                    ->required(),
                                Toggle::make('is_featured')
                                    ->label('Featured')
                                    ->default(true)
                                    ->required(),
                                Select::make('type')
                                    ->required()
                                    ->default('deliverable')
                                    ->options([
                                        'deliverable' => ProductTypeEnum::DELIVERABLE->value,
                                        'downloadable' => ProductTypeEnum::DOWNLOADABLE->value,
                                    ]),
                                DatePicker::make('published_at')
                                    ->label('Availability')
                                    ->default(now())
                                    ->required(),
                            ])
                            ->collapsible(),

                        ComponentsSection::make('Price & Inventory')
                            ->schema([
                                TextInput::make('sku')
                                    ->label('SKU(Stock Keeping Unit)')
                                    ->unique()
                                    ->required(),
                                TextInput::make('quantity')
                                    ->required()
                                    ->numeric(),
                                TextInput::make('price')
                                    ->required()
                                    ->numeric()
                                    ->prefix('$'),
                            ])
                            ->collapsible(),


                    ])
                    ->columnSpan(1),
            ])
            ->columns(2);
    }
}
