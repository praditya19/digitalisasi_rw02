<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UmkmResource\Pages;
use App\Models\Umkm;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\TextInput;

class UmkmResource extends Resource
{
    protected static ?string $model = Umkm::class;

    protected static ?string $navigationIcon = 'heroicon-s-building-storefront';

    protected static ?string $navigationGroup = 'Kelola UMKM Warga';

    protected static ?string $navigationLabel = 'Umkm';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('kode')
                ->required()
                ->unique(ignoreRecord: true)
                ->numeric()
                ->maxLength(20),

            Forms\Components\TextInput::make('nama_umkm')
                ->required(),

            Forms\Components\Select::make('jenis_usaha')
                ->options([
                    'Kuliner' => 'Kuliner',
                    'Fashion' => 'Fashion',
                    'Jasa' => 'Jasa',
                    'Kerajinan' => 'Kerajinan',
                    'Lainnya' => 'Lainnya',
                ])
                ->required()
                ->reactive()
                ->afterStateUpdated(fn($state, callable $set) => $set('jenis_usaha_lainnya', null)),

            Forms\Components\TextInput::make('jenis_usaha_lainnya')
                ->label('Jenis Usaha Lainnya')
                ->visible(fn(Get $get) => $get('jenis_usaha') === 'Lainnya')
                ->required(fn(Get $get) => $get('jenis_usaha') === 'Lainnya'),

            Forms\Components\TextInput::make('nomor_nib')
                ->label('Nomor NIB')
                ->nullable()
                ->numeric()
                ->maxLength(20),

            Forms\Components\TextInput::make('pemilik')
                ->nullable(),

            Forms\Components\Textarea::make('alamat')
                ->nullable(),

            Forms\Components\TextInput::make('nomor_hp')
                ->nullable()
                ->numeric()
                ->maxLength(20),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode')->label(label: 'kode'),
                Tables\Columns\TextColumn::make('nama_umkm')->label(label: 'Nama Umkm'),
                Tables\Columns\TextColumn::make('jenis_usaha'),
                Tables\Columns\TextColumn::make('pemilik')->label(label: 'Pemilik'),
                Tables\Columns\TextColumn::make('created_at')->dateTime(format: 'd M Y'),
            ])
            ->filters([
                Filter::make('nama_umkm')
                    ->form([
                        TextInput::make('nama_umkm')->label('Nama UMKM'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['nama_umkm'], fn($q, $value) => $q->where('nama_umkm', 'like', "%{$value}%"));
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->emptyStateHeading('Tidak Ada Data UMKM')
            ->emptyStateDescription('Belum ada data UMKM yang tersedia.');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUmkms::route('/'),
            'create' => Pages\CreateUmkm::route('/create'),
            'edit' => Pages\EditUmkm::route('/{record}/edit'),
        ];
    }
}
