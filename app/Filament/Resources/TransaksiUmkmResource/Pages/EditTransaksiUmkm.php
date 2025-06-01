<?php

namespace App\Filament\Resources\TransaksiUmkmResource\Pages;

use App\Filament\Resources\TransaksiUmkmResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTransaksiUmkm extends EditRecord
{
    protected static string $resource = TransaksiUmkmResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
