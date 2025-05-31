<?php

namespace App\Filament\Resources\WargaResource\Pages;

use App\Filament\Resources\WargaResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewWarga extends ViewRecord
{
    protected static string $resource = WargaResource::class;

    public function getTitle(): string
    {
        return 'Detail Keluarga: ' . $this->record->nama_lengkap;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label('Edit Data'),
        ];
    }

    protected function resolveRecord($key): \Illuminate\Database\Eloquent\Model
    {
        return static::getResource()::resolveRecordRouteBinding($key)->load('anggotaKeluarga');
    }
}