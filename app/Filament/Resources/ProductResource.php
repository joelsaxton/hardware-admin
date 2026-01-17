<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use BackedEnum;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\RelationManagers\RelationGroup;
use Filament\Resources\RelationManagers\RelationManagerConfiguration;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Collection;
use UnitEnum;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static string|null|BackedEnum $navigationIcon = 'heroicon-o-cube';

    protected static string|null|UnitEnum $navigationGroup = 'Hardware Management';

    protected static ?int $navigationSort = 1;

    /**
     * @param Schema $schema
     * @return Schema
     */
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Product Information')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('sku')
                            ->label('SKU')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Textarea::make('description')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Classification')
                    ->schema([
                        Select::make('category_id')
                            ->label('Category')
                            ->relationship('category', 'category')
                            ->required()
                            ->searchable()
                            ->preload(),

                        Select::make('brand_id')
                            ->label('Brand')
                            ->relationship('brand', 'brand')
                            ->required()
                            ->searchable()
                            ->preload(),
                    ])
                    ->columns(2),

                Section::make('Pricing, Inventory & Specs')
                    ->schema([
                        TextInput::make('price')
                            ->required()
                            ->inputMode('decimal')
                            ->prefix('$')
                            ->step(0.01)
                            ->formatStateUsing(fn ($state) => $state ? number_format((float) $state, 2, '.', '') : null),

                        TextInput::make('stock')
                            ->required()
                            ->numeric()
                            ->minValue(0),

                        TextInput::make('weight')
                            ->required()
                            ->numeric()
                            ->suffix('lbs')
                            ->step(0.01),
                    ])
                    ->columns(3),
            ]);
    }

    /**
     * @param Table $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                TextColumn::make('description')
                    ->searchable()
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('category.category')
                    ->label('Category')
                    ->sortable()
                    ->badge()
                    ->color('info'),

                TextColumn::make('brand.brand')
                    ->label('Brand')
                    ->sortable()
                    ->badge()
                    ->color('success'),

                TextColumn::make('price')
                    ->formatStateUsing(fn (string $state): string => '$'.number_format((float) $state, 2))
                    ->sortable(),

                TextColumn::make('stock')
                    ->numeric()
                    ->sortable()
                    ->color(fn (Product $record): string => $record->stock < 10 ? 'danger' : 'success'),

                TextColumn::make('weight')
                    ->numeric(decimalPlaces: 2)
                    ->suffix(' lbs')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultPaginationPageOption(30)
            ->paginated([10, 25, 30, 50, 100])
            ->filters([
                SelectFilter::make('category')
                    ->relationship('category', 'category')
                    ->multiple()
                    ->preload(),

                SelectFilter::make('brand')
                    ->relationship('brand', 'brand')
                    ->multiple()
                    ->preload(),

                Filter::make('low_stock')
                    ->query(fn ($query) => $query->where('stock', '<', 10))
                    ->label('Low Stock (< 10)'),

                Filter::make('out_of_stock')
                    ->query(fn ($query) => $query->where('stock', '=', 0))
                    ->label('Out of Stock'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    BulkAction::make('updateStock')
                        ->label('Update Stock')
                        ->icon('heroicon-o-archive-box')
                        ->schema([
                            TextInput::make('stock')
                                ->label('New Stock Level')
                                ->required()
                                ->numeric()
                                ->minValue(0),
                        ])
                        ->action(function (Collection $records, array $data): void {
                            $records->each(fn ($record) => $record->update(['stock' => $data['stock']]));
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->defaultSort('sku', 'asc');
    }

    /**
     * @return array|\class-string[]|RelationGroup[]|RelationManagerConfiguration[]
     */
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    /**
     * @return array|PageRegistration[]
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    /**
     * @return string[]
     */
    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'sku', 'description'];
    }
}
