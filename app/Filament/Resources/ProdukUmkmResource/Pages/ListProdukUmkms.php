<?php

namespace App\Filament\Resources\ProdukUmkmResource\Pages;

use App\Filament\Resources\ProdukUmkmResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProdukUmkms extends ListRecords
{
    protected static string $resource = ProdukUmkmResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
