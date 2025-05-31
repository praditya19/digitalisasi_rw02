<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KetuaResource\Pages;
use App\Models\Ketua_Rt;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\MultiSelectFilter;

class KetuaResource extends Resource
{
    protected static ?string $model = Ketua_Rt::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Ketua RT';

    protected static ?string $navigationGroup = 'Kelola Data RT';

    public static function getModelLabel(): string
    {
        return 'Ketua RT';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Ketua RT';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')->label('Nama Ketua RT')->required(),
                Forms\Components\TextInput::make('email')->label('Email')->email()->required(),
                Forms\Components\TextInput::make('nomor_hp')->label('Nomor HP')->required(),
                Forms\Components\Select::make('rt')
                    ->label('RT')
                    ->required()
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
                Forms\Components\TextInput::make('password')->label('Password')->password()->required(),
                Forms\Components\FileUpload::make('sk_ketua_rt')
                    ->label('SK Ketua RT')
                    ->directory('sk-ketua-rt')
                    ->visibility('public')
                    ->acceptedFileTypes(['application/pdf', 'image/*']),
                Forms\Components\TextInput::make('role')
                    ->label('Role')
                    ->default('Ketua RT')
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')->label('Nama Ketua RT'),
                Tables\Columns\TextColumn::make('email')->label('Email'),
                Tables\Columns\TextColumn::make('nomor_hp')->label('Nomor HP'),
                Tables\Columns\TextColumn::make('rt')->label('RT'),
                Tables\Columns\TextColumn::make('sk_ketua_rt')
                    ->label('SK Ketua RT')
                    ->url(fn($record) => $record->sk_ketua_rt ? asset('storage/' . $record->sk_ketua_rt) : null)
                    ->openUrlInNewTab()
                    ->formatStateUsing(fn($state) => $state ? 'Lihat File' : 'Belum di upload')
            ])
            ->emptyStateHeading('Tidak Ada Ketua RT')
            ->emptyStateDescription('Belum ada data Ketua RT yang tersedia.')
            ->filters([
                Filter::make('nama')
                    ->form([
                        Forms\Components\TextInput::make('nama')->label('Nama Ketua RT'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['nama'], fn($q, $nama) => $q->where('nama', 'like', '%' . $nama . '%'));
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
            'index' => Pages\ListKetuas::route('/'),
            'create' => Pages\CreateKetua::route('/create'),
            'edit' => Pages\EditKetua::route('/{record}/edit'),
        ];
    }
}
