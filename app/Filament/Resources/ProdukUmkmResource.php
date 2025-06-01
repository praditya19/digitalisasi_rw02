<?php

namespace App\Filament\Resources;

use Filament\Tables;
use Filament\Forms\Form;
use App\Models\ProdukUmkm;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;

use App\Filament\Resources\ProdukUmkmResource\Pages;
class ProdukUmkmResource extends Resource
{
    protected static ?string $model = ProdukUmkm::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationGroup = 'Kelola UMKM Warga';

    protected static ?string $navigationLabel = 'Produk Umkm';

    protected static ?int $navigationSort = 2;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('nama_produk')
                ->label('Nama Produk')
                ->required()
                ->maxLength(255),

            Textarea::make('deskripsi')
                ->label('Deskripsi')
                ->nullable(),

            TextInput::make('stok')
                ->label('Stok')
                ->required()
                ->numeric()
                ->minValue(0),

            TextInput::make('harga')
                ->label('Harga')
                ->required()
                ->numeric()
                ->minValue(0),

            Select::make('umkm_id')
                ->label('UMKM')
                ->relationship('umkm', 'nama_umkm')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('nama_produk')->label('Nama Produk')->sortable()->searchable(),
            TextColumn::make('deskripsi')->label('Deskripsi')->limit(50),
            TextColumn::make('stok')->label('Stok')->sortable(),
            TextColumn::make('harga')->label('Harga')->sortable()->money('idr', true),
            TextColumn::make('umkm.nama_umkm')->label('UMKM')->sortable()->searchable(),
            TextColumn::make('created_at')->label('Tanggal Dibuat')->dateTime('d M Y'),
        ])
            ->filters([
                Filter::make('umkm')->label('UMKM')->query(fn(Builder $query) => $query->whereHas('umkm', fn($q) => $q)),
                Filter::make('stok_tersedia')->label('Stok Tersedia')->query(fn(Builder $query) => $query->where('stok', '>', 0)),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProdukUmkms::route('/'),
            'create' => Pages\CreateProdukUmkm::route('/create'),
            'edit' => Pages\EditProdukUmkm::route('/{record}/edit'),
        ];
    }
}
