<?php

namespace App\Filament\Resources\WargaResource\Pages;

use Filament\Actions;
use App\Filament\Resources\WargaResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Models\Warga;

class ListWargas extends ListRecords
{
    protected static string $resource = WargaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableQuery(): Builder
    {
        $query = parent::getTableQuery()
            ->orderBy('rt', 'asc')
            ->orderBy('nama_lengkap', 'asc');
        $user = Auth::user();

        if ($user && $user->role === 'Ketua RT') {
            $ketuaRtWarga = Warga::where('email', $user->email)->first();
            if ($ketuaRtWarga && $ketuaRtWarga->rt) {
                $query->where('rt', $ketuaRtWarga->rt);
            } else {
                // Opsional: Jika user adalah Ketua RT tapi data RT-nya tidak ditemukan di tabel warga,
                // Anda bisa memilih untuk tidak menampilkan data sama sekali.
                // Caranya dengan menambahkan baris di bawah ini:
                // $query->whereRaw('1 = 0'); // Ini akan membuat query tidak mengembalikan hasil apapun
                // Saat ini, jika tidak ditemukan, akan tetap menampilkan semua data (behavior default tanpa filter).
            }
        }

        return $query;
    }
}
