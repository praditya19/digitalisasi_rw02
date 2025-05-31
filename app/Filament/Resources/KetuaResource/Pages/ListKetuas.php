<?php

namespace App\Filament\Resources\KetuaResource\Pages;

use App\Filament\Resources\KetuaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKetuas extends ListRecords
{
    protected static string $resource = KetuaResource::class;

    public function getTitle(): string
    {
        return 'Ketua RT';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Ketua RT'),
        ];
    }
}
