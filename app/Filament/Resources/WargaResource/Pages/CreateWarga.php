<?php

namespace App\Filament\Resources\WargaResource\Pages;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Filament\Resources\WargaResource;
use Filament\Resources\Pages\CreateRecord;

class CreateWarga extends CreateRecord
{
    protected static string $resource = WargaResource::class;

    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        $data = $this->record;

        User::create([
            'name' => $data->nama_lengkap,
            'email' => $data->email,
            'password' => Hash::make('123'),
            'role' => 'Kepala Keluarga',
        ]);
    }
}