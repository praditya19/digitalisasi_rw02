<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class TransactionConstructPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationGroup = 'Kelola UMKM Warga';
    protected static ?string $navigationLabel = 'Transaksi UMKM';
    protected static ?int $navigationSort = 3;

    protected static string $view = 'filament.pages.transaction-construct-page';

    public function getTitle(): string
    {
        return 'Transaksi UMKM';
    }

}
