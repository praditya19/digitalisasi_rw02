<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WargaResource\Pages;
use App\Models\Warga;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\MultiSelectFilter;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;

class WargaResource extends Resource
{
    protected static ?string $model = Warga::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Warga';

    public static function getModelLabel(): string
    {
        return 'Warga';
    }

    protected static ?string $navigationGroup = 'Kelola Data Warga';

    public static function getPluralModelLabel(): string
    {
        return 'Warga';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Kepala Keluarga')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('nama_lengkap')
                                    ->label('Nama Kepala Keluarga')
                                    ->required(),

                                Forms\Components\Select::make('status_keluarga')
                                    ->label('Status dalam Keluarga')
                                    ->options([
                                        'suami' => 'Suami',
                                        'istri' => 'Istri',
                                        'anak' => 'Anak',
                                        'kakak' => 'Kakak',
                                        'adik' => 'Adik',
                                        'ibu' => 'Ibu',
                                        'ayah' => 'Ayah',
                                        'lainnya' => 'Lainnya',
                                    ])
                                    ->required(),

                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->unique(Warga::class, 'email', ignoreRecord: true)
                                    ->nullable(),

                                Forms\Components\TextInput::make('nomor_hp')
                                    ->label('Nomor HP')
                                    ->nullable()
                                    ->numeric()
                                    ->maxLength(20)
                                    ->rule('regex:/^[0-9]+$/'),

                                Forms\Components\Select::make('rt')
                                    ->label('RT')
                                    ->required()
                                    ->options([
                                        '1' => 'RT 1',
                                        '2' => 'RT 2',
                                        '3' => 'RT 3',
                                        '4' => 'RT 4',
                                        '5' => 'RT 5',
                                        '6' => 'RT 6',
                                        '7' => 'RT 7',
                                        '8' => 'RT 8',
                                        '9' => 'RT 9',
                                        '10' => 'RT 10',
                                        '11' => 'RT 11',
                                        '12' => 'RT 12',
                                        '13' => 'RT 13',
                                    ]),

                                Forms\Components\Select::make('jenis_kelamin')
                                    ->options([
                                        'Laki-laki' => 'Laki-laki',
                                        'Perempuan' => 'Perempuan',
                                    ])
                                    ->nullable(),

                                Forms\Components\Select::make('status_rumah')
                                    ->options([
                                        'Milik Sendiri' => 'Milik Sendiri',
                                        'Kontrak' => 'Kontrak',
                                        'Kos' => 'Kos',
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

                                Forms\Components\Select::make('pekerjaan')
                                    ->options([
                                        'Swasta' => 'Pegawai Swasta',
                                        'Negeri' => 'Pegawai Negeri',
                                        'Ibu Rumah Tangga' => 'Ibu Rumah Tangga',
                                        'Pelajar' => 'Pelajar/Mahasiswa',
                                        'Tidak Bekerja' => 'Tidak Bekerja',
                                    ])
                                    ->nullable(),

                                Forms\Components\Select::make('domisili')
                                    ->label('Domisili')
                                    ->options([
                                        'RW 02' => 'RW 02',
                                        'Diluar' => 'Diluar',
                                    ])
                                    ->nullable(),

                                Forms\Components\DatePicker::make('tanggal_lahir')->nullable(),
                            ]),

                        Forms\Components\Hidden::make('jenis_warga')->default('kepala_keluarga'),
                    ]),

                Forms\Components\Section::make('Anggota Keluarga')
                    ->schema([
                        Forms\Components\Repeater::make('anggotaKeluarga')
                            ->label('')
                            ->relationship()
                            ->schema([
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('nama_lengkap')
                                            ->required()
                                            ->label('Nama Lengkap'),

                                        Forms\Components\Select::make('status_keluarga')
                                            ->label('Status dalam Keluarga')
                                            ->options([
                                                'suami' => 'Suami',
                                                'istri' => 'Istri',
                                                'anak' => 'Anak',
                                                'kakak' => 'Kakak',
                                                'adik' => 'Adik',
                                                'ibu' => 'Ibu',
                                                'ayah' => 'Ayah',
                                                'lainnya' => 'Lainnya',
                                            ])
                                            ->required(),

                                        Forms\Components\TextInput::make('nomor_hp')
                                            ->label('Nomor HP')
                                            ->nullable()
                                            ->numeric()
                                            ->maxLength(20)
                                            ->rule('regex:/^[0-9]+$/'),

                                        Forms\Components\Select::make('jenis_kelamin')
                                            ->options([
                                                'Laki-laki' => 'Laki-laki',
                                                'Perempuan' => 'Perempuan',
                                            ])
                                            ->nullable(),

                                        Forms\Components\DatePicker::make('tanggal_lahir')->nullable(),

                                        Forms\Components\Select::make('pekerjaan')
                                            ->options([
                                                'Swasta' => 'Pegawai Swasta',
                                                'Negeri' => 'Pegawai Negeri',
                                                'Ibu Rumah Tangga' => 'Ibu Rumah Tangga',
                                                'Pelajar' => 'Pelajar/Mahasiswa',
                                                'Tidak Bekerja' => 'Tidak Bekerja',
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
                                            ->nullable()
                                            ->columnSpan(1),

                                        Forms\Components\Hidden::make('jenis_warga')->default('anggota_keluarga'),
                                    ])
                            ])
                            ->addActionLabel('Tambah Anggota Keluarga')
                            ->minItems(0)
                            ->maxItems(10)
                            ->collapsible()
                            ->cloneable()
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ])
            ->columns(1);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Data Kepala Keluarga')
                    ->schema([
                        TextEntry::make('nomor_keluarga')
                            ->label('Nomor Keluarga'),
                        TextEntry::make('nama_lengkap')
                            ->label('Nama Lengkap'),
                        TextEntry::make('email')
                            ->label('Email'),
                        TextEntry::make('nomor_hp')
                            ->label('Nomor HP'),
                        TextEntry::make('rt')
                            ->label('RT')
                            ->formatStateUsing(fn($state) => "RT {$state}"),
                        TextEntry::make('jenis_kelamin')
                            ->label('Jenis Kelamin'),
                        TextEntry::make('status_rumah')
                            ->label('Status Rumah'),
                        TextEntry::make('pendidikan')
                            ->label('Pendidikan'),
                        TextEntry::make('pekerjaan')
                            ->label('Pekerjaan'),
                        TextEntry::make('domisili')
                            ->label('Domisili'),
                        TextEntry::make('tanggal_lahir')
                            ->label('Tanggal Lahir')
                            ->date('d F Y'),
                    ])
                    ->columns(2),

                Section::make('Anggota Keluarga')
                    ->schema([
                        RepeatableEntry::make('anggotaKeluarga')
                            ->label('')
                            ->schema([
                                TextEntry::make('nama_lengkap')
                                    ->label('Nama Lengkap'),
                                TextEntry::make('status_keluarga')
                                    ->label('Status dalam Keluarga')
                                    ->formatStateUsing(function ($state) {
                                        $statusMap = [
                                            'suami' => 'Suami',
                                            'istri' => 'Istri',
                                            'anak' => 'Anak',
                                            'kakak' => 'Kakak',
                                            'adik' => 'Adik',
                                            'ibu' => 'Ibu',
                                            'ayah' => 'Ayah',
                                            'lainnya' => 'Lainnya',
                                        ];
                                        return $statusMap[$state] ?? $state;
                                    }),
                                TextEntry::make('nomor_hp')
                                    ->label('Nomor HP'),
                                TextEntry::make('jenis_kelamin')
                                    ->label('Jenis Kelamin'),
                                TextEntry::make('tanggal_lahir')
                                    ->label('Tanggal Lahir')
                                    ->date('d F Y'),
                                TextEntry::make('pekerjaan')
                                    ->label('Pekerjaan'),
                                TextEntry::make('pendidikan')
                                    ->label('Pendidikan'),
                                TextEntry::make('domisili')
                                    ->label('Domisili'),
                            ])
                            ->columns(2)
                            ->columnSpanFull(),
                    ])
                    ->visible(fn($record) => $record->anggotaKeluarga->count() > 0)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn($query) => $query->where('jenis_warga', 'kepala_keluarga'))
            ->columns([
                Tables\Columns\TextColumn::make('nomor_keluarga')->label('Nomor Keluarga'),
                Tables\Columns\TextColumn::make('nama_lengkap')->label('Nama Lengkap'),
                Tables\Columns\TextColumn::make('rt')->label('RT'),
                Tables\Columns\TextColumn::make('domisili')->label('Domisili'),
                Tables\Columns\TextColumn::make('email')->label('Email'),
                Tables\Columns\TextColumn::make('anggotaKeluarga')
                    ->label('Jumlah Anggota')
                    ->formatStateUsing(function ($record) {
                        $jumlah = $record->anggotaKeluarga->count();
                        return $jumlah . ' orang';
                    }),
            ])
            ->emptyStateHeading('Tidak Ada Warga')
            ->emptyStateDescription('Belum ada data Warga yang tersedia.')
            ->filters([
                Filter::make('nama_lengkap')
                    ->form([
                        TextInput::make('nama_lengkap')->label('Nama Lengkap'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['nama_lengkap'], fn($q, $value) => $q->where('nama_lengkap', 'like', "%{$value}%"));
                    }),

                MultiSelectFilter::make('rt')
                    ->label('RT')
                    ->options([
                        1 => 'RT 1',
                        2 => 'RT 2',
                        3 => 'RT 3',
                        4 => 'RT 4',
                        5 => 'RT 5',
                        6 => 'RT 6',
                        7 => 'RT 7',
                        8 => 'RT 8',
                        9 => 'RT 9',
                        10 => 'RT 10',
                        11 => 'RT 11',
                        12 => 'RT 12',
                        13 => 'RT 13',
                    ]),

                SelectFilter::make('status_rumah')
                    ->label('Status Rumah')
                    ->options([
                        'Milik Sendiri' => 'Milik Sendiri',
                        'Kontrak' => 'Kontrak',
                        'Kos' => 'Kos',
                    ])
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Lihat')
                    ->icon('heroicon-m-eye'),
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
            'index' => Pages\ListWargas::route('/'),
            'create' => Pages\CreateWarga::route('/create'),
            'edit' => Pages\EditWarga::route('/{record}/edit'),
            'view' => Pages\ViewWarga::route('/{record}'),
        ];
    }
}