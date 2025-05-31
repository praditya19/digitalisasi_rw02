<?php

namespace App\Filament\Resources\WargaResource\Pages;

use App\Filament\Resources\WargaResource;
use App\Models\Warga;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Js;
use Illuminate\Support\Facades\Hash;

class CreateWarga extends CreateRecord
{
    protected static string $resource = WargaResource::class;

    protected static bool $canCreateAnother = false;

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Data Keluarga Berhasil Ditambahkan')
            ->body('Kepala keluarga dan anggota keluarga berhasil disimpan ke dalam sistem.')
            ->duration(3000);
    }

    protected function getCancelFormAction(): Action
    {
        return Action::make('cancel')
            ->label('Batal')
            ->alpineClickHandler(
                'document.referrer ? window.history.back() : (window.location.href = ' . Js::from($this->previousUrl ?? static::getResource()::getUrl()) . ')'
            )
            ->color('gray');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['nomor_keluarga'] = $this->generateNomorKeluarga();
        $data['jenis_warga'] = 'kepala_keluarga';

        return $data;
    }

    protected function afterCreate(): void
    {
        $kepalaKeluarga = $this->record;
        $state = $this->form->getState();

        $anggota = $state['anggota_keluarga'] ?? [];
        foreach ($anggota as $data) {
            Warga::create([
                'nama_lengkap' => $data['nama_lengkap'] ?? null,
                'status_keluarga' => $data['status_keluarga'] ?? null,
                'email' => $data['email'] ?? null,
                'nomor_hp' => $data['nomor_hp'] ?? null,
                'tanggal_lahir' => $data['tanggal_lahir'] ?? null,
                'pekerjaan' => $data['pekerjaan'] ?? null,
                'pendidikan' => $data['pendidikan'] ?? null,
                'jenis_kelamin' => $data['jenis_kelamin'] ?? null,
                'status_rumah' => $data['status_rumah'] ?? null,
                'domisili' => $data['domisili'] ?? null,
                'jenis_warga' => 'anggota_keluarga',
                'kepala_keluarga_id' => $kepalaKeluarga->id,
                'rt' => $kepalaKeluarga->rt,
            ]);
        }

        if ($kepalaKeluarga->jenis_warga === 'kepala_keluarga') {
            User::create([
                'name' => $kepalaKeluarga->nama_lengkap,
                'email' => $kepalaKeluarga->email,
                'password' => Hash::make('123'),
                'role' => 'Kepala Keluarga',
            ]);
        }
    }

    private function generateNomorKeluarga(): string
    {
        $last = Warga::where('jenis_warga', 'kepala_keluarga')
            ->orderByDesc('id')
            ->first();

        if (!$last) {
            return 'KK0001';
        }

        $lastNumber = (int) substr($last->nomor_keluarga, 2);

        return 'KK' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
