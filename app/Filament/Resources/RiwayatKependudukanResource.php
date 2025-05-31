<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use App\Models\Warga;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\RiwayatKependudukan;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\MultiSelectFilter;
use App\Filament\Resources\RiwayatKependudukanResource\Pages;
use Filament\Forms\Components\TextInput;

class RiwayatKependudukanResource extends Resource
{
    protected static ?string $model = RiwayatKependudukan::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static ?string $navigationLabel = 'Riwayat Kependudukan';

    protected static ?string $navigationGroup = 'Kelola Data Warga';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('warga_id')
                    ->relationship('warga', 'nama_lengkap')
                    ->searchable()
                    ->required(),

                Forms\Components\DatePicker::make('tanggal_perubahan')
                    ->required(),

                Forms\Components\TextInput::make('jenis_perubahan')
                    ->required()
                    ->placeholder('Contoh: Pindah Alamat, Menikah'),

                Forms\Components\Textarea::make('keterangan'),

                Forms\Components\TextInput::make('diubah_oleh')
                    ->default(auth()->user()->name)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('warga.nama_lengkap')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('warga.rt')->label('RT')->sortable(),
                Tables\Columns\TextColumn::make('tanggal_perubahan')->date(),
                Tables\Columns\TextColumn::make('jenis_perubahan'),
                Tables\Columns\TextColumn::make('keterangan')->limit(30),
                Tables\Columns\TextColumn::make('diubah_oleh')->searchable(),
            ])
            ->emptyStateHeading('Tidak Ada Riwayat Kependudukan')
            ->emptyStateDescription('Belum ada data Warga yang tersedia.')
            ->filters([
                Filter::make('nama_lengkap')
                    ->form([
                        TextInput::make('nama_lengkap')->label('Nama Lengkap'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query->when($data['nama_lengkap'], function ($q, $value) {
                            $q->whereHas(
                                'warga',
                                fn($qr) =>
                                $qr->where('nama_lengkap', 'like', "%{$value}%")
                            );
                        });
                    }),

                MultiSelectFilter::make('warga.rt')
                    ->label('RT')
                    ->options(
                        Warga::query()
                            ->select('rt')
                            ->distinct()
                            ->pluck('rt', 'rt')
                            ->toArray()
                    ),

                SelectFilter::make('warga.status_rumah')
                    ->label('Status Rumah')
                    ->options([
                        'Milik Sendiri' => 'Milik Sendiri',
                        'Kontrak' => 'Kontrak',
                        'Kos' => 'Kos',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()->before(function ($record) {
                    User::where('email', $record->email)->delete();
                }),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRiwayatKependudukans::route('/'),
            'create' => Pages\CreateRiwayatKependudukan::route('/create'),
            'edit' => Pages\EditRiwayatKependudukan::route('/{record}/edit'),
        ];
    }
}
