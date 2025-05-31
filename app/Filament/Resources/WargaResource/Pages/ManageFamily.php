<?php

namespace App\Filament\Resources\WargaResource\Pages;

use Filament\Forms;
use Filament\Tables;
use App\Models\Warga;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\WargaResource;
use Filament\Resources\Pages\ManageRecords;

class ManageFamily extends ManageRecords
{
    protected static string $resource = WargaResource::class;

    public $nomor_keluarga;

    public function mount(): void
    {
        $this->nomor_keluarga = request()->route('nomor_keluarga');
        parent::mount();
    }

    public function getTitle(): string
    {
        return 'Kelola Anggota Keluarga - ' . $this->nomor_keluarga;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Warga::query()->where('nomor_keluarga', $this->nomor_keluarga)
            )
            ->columns([
                Tables\Columns\TextColumn::make('nama_lengkap')
                    ->label('Nama Lengkap')
                    ->searchable(),

                Tables\Columns\TextColumn::make('jenis_warga')
                    ->label('Jenis Warga')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Kepala Keluarga' => 'success',
                        'Anggota Keluarga' => 'info',
                    }),

                Tables\Columns\TextColumn::make('status_keluarga')
                    ->label('Status dalam Keluarga'),

                Tables\Columns\TextColumn::make('jenis_kelamin')
                    ->label('Jenis Kelamin'),

                Tables\Columns\TextColumn::make('tanggal_lahir')
                    ->label('Tanggal Lahir')
                    ->date(),

                Tables\Columns\TextColumn::make('pekerjaan')
                    ->label('Pekerjaan')
                    ->formatStateUsing(fn($state) => match ($state) {
                        'Swasta' => 'Pegawai Swasta',
                        'Negeri' => 'Pegawai Negeri',
                        'Ibu Rumah Tangga' => 'Ibu Rumah Tangga',
                        'Pelajar' => 'Pelajar/Mahasiswa',
                        'Tidak Bekerja' => 'Tidak Bekerja',
                        default => ucfirst($state),
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->form([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('nama_lengkap')
                                    ->required()
                                    ->label('Nama Lengkap'),

                                Forms\Components\Select::make('status_keluarga')
                                    ->label('Status dalam Keluarga')
                                    ->options([
                                        'Suami' => 'Suami',
                                        'Istri' => 'Istri',
                                        'Anak' => 'Anak',
                                        'Kakak' => 'Kakak',
                                        'Adik' => 'Adik',
                                        'Ibu' => 'Ibu',
                                        'Ayah' => 'Ayah',
                                        'Lainnya' => 'Lainnya',
                                    ])
                                    ->required(),

                                Forms\Components\TextInput::make('nomor_hp')->nullable(),

                                Forms\Components\Select::make('jenis_kelamin')
                                    ->options([
                                        'Laki-laki' => 'Laki-laki',
                                        'Perempuan' => 'Perempuan',
                                    ])
                                    ->nullable(),

                                Forms\Components\DatePicker::make('tanggal_lahir')->nullable(),

                                Forms\Components\Select::make('pekerjaan')
                                    ->label('Pekerjaan')
                                    ->options([
                                        'Swasta' => 'Pegawai Swasta',
                                        'Negeri' => 'Pegawai Negeri',
                                        'Ibu Rumah Tangga' => 'Ibu Rumah Tangga',
                                        'Pelajar' => 'Pelajar/Mahasiswa',
                                        'Tidak Bekerja' => 'Tidak Bekerja'
                                    ])
                                    ->nullable(),

                                Forms\Components\Select::make('pendidikan')
                                    ->label('Pendidikan')
                                    ->options([
                                        'Tidak Sekolah' => 'Tidak Sekolah',
                                        'SD' => 'SD',
                                        'SMP' => 'SMP',
                                        'SMA' => 'SMA',
                                        'D1' => 'D1',
                                        'D2' => 'D2',
                                        'D3' => 'D3',
                                        'S1' => 'S1',
                                        'S2' => 'S2',
                                        'S3' => 'S3',
                                    ])
                                    ->nullable(),

                                Forms\Components\Select::make('domisili')
                                    ->options([
                                        'RW 02' => 'RW 02',
                                        'Diluar' => 'Diluar',
                                    ])
                                    ->nullable(),
                            ]),
                    ]),

                Tables\Actions\DeleteAction::make()
                    ->visible(fn($record) => $record->jenis_warga === 'Anggota Keluarga'),
            ]);
    }
}