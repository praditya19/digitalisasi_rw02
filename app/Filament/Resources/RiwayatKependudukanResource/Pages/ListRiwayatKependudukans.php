<?php

namespace App\Filament\Resources\RiwayatKependudukanResource\Pages;

use App\Filament\Resources\RiwayatKependudukanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRiwayatKependudukans extends ListRecords
{
    protected static string $resource = RiwayatKependudukanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
