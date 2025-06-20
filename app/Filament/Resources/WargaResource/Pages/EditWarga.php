<?php

namespace App\Filament\Resources\WargaResource\Pages;

use App\Filament\Resources\WargaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWarga extends EditRecord
{
    protected static string $resource = WargaResource::class;

    public function getTitle(): string
    {
        return 'Edit Data Keluarga: ' . $this->record->nama_lengkap;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make()
                ->label('Lihat Detail'),
            Actions\DeleteAction::make(),
        ];
    }

    protected function resolveRecord($key): \Illuminate\Database\Eloquent\Model
    {
        return static::getResource()::resolveRecordRouteBinding($key)->load('anggotaKeluarga');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}