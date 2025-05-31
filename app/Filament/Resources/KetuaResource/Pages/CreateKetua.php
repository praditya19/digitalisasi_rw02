<?php

namespace App\Filament\Resources\KetuaResource\Pages;

use App\Filament\Resources\KetuaResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Js;

class CreateKetua extends CreateRecord
{
    protected static string $resource = KetuaResource::class;

    protected function afterCreate(): void
    {
        $data = $this->record;

        User::create([
            'name' => $data->nama,
            'email' => $data->email,
            'password' => Hash::make($data->password),
            'role' => 'Ketua RT',
        ]);
    }

    protected static bool $canCreateAnother = false;

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Ketua RT Berhasil Dibuat')
            ->body('Akun pengguna untuk Ketua RT telah berhasil ditambahkan ke sistem.')
            ->duration(3000);
    }

    protected function getCancelFormAction(): Action
    {
        return Action::make('cancel')
            ->label('Batal')
            ->alpineClickHandler('document.referrer ? window.history.back() : (window.location.href = ' . Js::from($this->previousUrl ?? static::getResource()::getUrl()) . ')')
            ->color('gray');
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
