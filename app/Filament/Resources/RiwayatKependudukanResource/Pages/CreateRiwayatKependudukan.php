<?php

namespace App\Filament\Resources\RiwayatKependudukanResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\RiwayatKependudukanResource;

class CreateRiwayatKependudukan extends CreateRecord
{
    protected static string $resource = RiwayatKependudukanResource::class;

    protected static bool $canCreateAnother = false;

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Riwayat Kependudukan Berhasil Ditambahkan')
            ->body('Perubahan data kependudukan telah dicatat dan disimpan dengan sukses.')
            ->duration(3000);
    }
}
