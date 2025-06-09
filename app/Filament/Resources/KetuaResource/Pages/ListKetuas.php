<?php

namespace App\Filament\Resources\KetuaResource\Pages;

use Filament\Actions;
use App\Filament\Resources\KetuaResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListKetuas extends ListRecords
{
    protected static string $resource = KetuaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()->orderBy('rt', 'asc');
    }
}
