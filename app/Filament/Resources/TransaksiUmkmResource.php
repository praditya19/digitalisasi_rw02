<?php

namespace App\Filament\Resources;

use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\TransaksiUmkm;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\TransaksiUmkmResource\Pages;

class TransaksiUmkmResource extends Resource
{
    protected static ?string $model = TransaksiUmkm::class;

    protected static ?string $navigationIcon = 'heroicon-o-receipt-percent';

    protected static ?string $navigationGroup = 'Kelola UMKM Warga';

    protected static ?string $navigationLabel = 'Transaksi Umkm';

    protected static ?int $navigationSort = 3;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('produk_umkm_id')
                ->label('Produk UMKM')
                ->relationship('produk', 'nama_produk')
                ->required(),

            TextInput::make('jumlah')
                ->label('Jumlah')
                ->numeric()
                ->min(1)
                ->required(),

            TextInput::make('total_harga')
                ->label('Total Harga')
                ->numeric()
                ->required(),

            Select::make('status')
                ->label('Status')
                ->options([
                    'pending' => 'Pending',
                    'selesai' => 'Selesai',
                    'batal' => 'Batal',
                ])
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('produk.nama_produk')->label('Produk UMKM'),
                TextColumn::make('jumlah')->label('Jumlah'),
                TextColumn::make('total_harga')->label('Total Harga')->money('idr', true),
                TextColumn::make('status')->label('Status')->sortable(),
                TextColumn::make('created_at')->label('Tanggal')->dateTime('d M Y H:i'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')->options([
                    'pending' => 'Pending',
                    'selesai' => 'Selesai',
                    'batal' => 'Batal',
                ]),
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
            'index' => Pages\ListTransaksiUmkms::route('/'),
            'create' => Pages\CreateTransaksiUmkm::route('/create'),
            'edit' => Pages\EditTransaksiUmkm::route('/{record}/edit'),
        ];
    }
}
