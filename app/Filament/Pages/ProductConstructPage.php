<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class ProductConstructPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationGroup = 'Kelola UMKM Warga';
    protected static ?string $navigationLabel = 'Produk UMKM';
    protected static ?int $navigationSort = 2;

    protected static string $view = 'filament.pages.product-construct-page';

    public function getTitle(): string
    {
        return 'Produk UMKM';
    }

}
