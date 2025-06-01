<?php

namespace App\Filament\Resources\ProdukUmkmResource\Pages;

use App\Filament\Resources\ProdukUmkmResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProdukUmkm extends EditRecord
{
    protected static string $resource = ProdukUmkmResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
