<?php

namespace App\Filament\Resources\TransaksiUmkmResource\Pages;

use App\Filament\Resources\TransaksiUmkmResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTransaksiUmkms extends ListRecords
{
    protected static string $resource = TransaksiUmkmResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
