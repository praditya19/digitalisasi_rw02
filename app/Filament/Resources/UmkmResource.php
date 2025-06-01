<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UmkmResource\Pages;
use App\Models\Umkm;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UmkmResource extends Resource
{
    protected static ?string $model = Umkm::class;

    protected static ?string $navigationIcon = 'heroicon-s-building-storefront';

    protected static ?string $navigationLabel = 'Umkm';

    protected static ?string $navigationGroup = 'Kelola UMKM Warga';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('kode')
                ->required()
                ->unique(ignoreRecord: true),
            Forms\Components\TextInput::make('nama_umkm')
                ->required(),
            Forms\Components\TextInput::make('jenis_usaha')
                ->required(),
            Forms\Components\TextInput::make('nomor_nib')
                ->label('Nomor NIB')
                ->nullable(),
            Forms\Components\TextInput::make('pemilik')
                ->nullable(),
            Forms\Components\Textarea::make('alamat')
                ->nullable(),
            Forms\Components\TextInput::make('nomor_hp')
                ->nullable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('kode')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('nama_umkm')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('jenis_usaha'),
            Tables\Columns\TextColumn::make('pemilik')->label('Pemilik'),
            Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y'),
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
            'index' => Pages\ListUmkms::route('/'),
            'create' => Pages\CreateUmkm::route('/create'),
            'edit' => Pages\EditUmkm::route('/{record}/edit'),
        ];
    }
}
