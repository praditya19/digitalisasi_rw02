<?php

namespace App\Filament\Resources\WargaResource\Pages;

use App\Filament\Resources\WargaResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Warga;

class CreateWarga extends CreateRecord
{
    protected static string $resource = WargaResource::class;

    public function getTitle(): string
    {
        return 'Tambah Data Warga';
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        // Generate nomor keluarga otomatis jika belum ada
        if (empty($this->record->nomor_keluarga)) {
            $lastNumber = Warga::where('jenis_warga', 'kepala_keluarga')
                ->where('nomor_keluarga', 'like', 'KK%')
                ->orderBy('nomor_keluarga', 'desc')
                ->first();

            if ($lastNumber) {
                $number = intval(substr($lastNumber->nomor_keluarga, 2)) + 1;
            } else {
                $number = 1;
            }

            $this->record->update([
                'nomor_keluarga' => 'KK' . str_pad($number, 4, '0', STR_PAD_LEFT)
            ]);
        }
    }
}