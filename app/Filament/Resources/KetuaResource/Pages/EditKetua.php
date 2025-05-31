<?php

namespace App\Filament\Resources\KetuaResource\Pages;

use App\Filament\Resources\KetuaResource;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Js;
use Filament\Notifications\Notification;

class EditKetua extends EditRecord
{
    protected static string $resource = KetuaResource::class;
    protected function getHeaderActions(): array
    {
        return [
            $this->getDeleteFormAction(),
        ];
    }
    protected function getSaveFormAction(): Action
    {
        return Action::make('save')
            ->label('Simpan')
            ->submit('save')
            ->keyBindings(['mod+s']);
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
    protected function getDeleteFormAction(): DeleteAction
    {
        return DeleteAction::make()
            ->label('Hapus')
            ->modalHeading('Hapus Data Ketua RT')
            ->modalDescription('Apakah kamu yakin ingin menghapus data Ketua RT atas nama ' . $this->record->nama . '?')
            ->modalButton('Hapus');
    }
    protected function beforeDelete(): void
    {
        $emailKetua = $this->record->email;
        $user = User::where('email', $emailKetua)->first();

        if ($user) {
            $user->delete();
        }
    }
    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->title('Data berhasil diperbarui')
            ->success();
    }
    protected function getDeletedNotification(): ?Notification
    {
        return Notification::make()
            ->title('Data berhasil dihapus')
            ->success();
    }
}
