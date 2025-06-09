<?php

namespace App\Filament\Resources\WargaResource\Pages;

use Filament\Actions;
use App\Filament\Resources\WargaResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListWargas extends ListRecords
{
    protected static string $resource = WargaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()
            ->orderBy('rt', 'asc')
            ->orderBy('nama_lengkap', 'asc');
    }

}
