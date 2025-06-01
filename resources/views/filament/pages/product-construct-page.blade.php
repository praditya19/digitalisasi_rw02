<x-filament::page>
    <div class="text-center py-12 md:py-20 px-4">
        <!-- Animasi konstruksi -->
        <div class="animate-bounce text-6xl mb-8">🚧</div>

        <!-- Judul dengan gradient -->
        <h1
            class="text-4xl md:text-5xl font-extrabold mb-4 bg-gradient-to-r from-orange-500 to-yellow-400 bg-clip-text text-transparent">
            Sedang Dalam Pengerjaan
        </h1>

        <!-- Deskripsi -->
        <div class="max-w-2xl mx-auto">
            <p class="text-lg text-gray-600 mb-6">
                Kami sedang membangun sesuatu yang <span class="font-semibold text-yellow-600">bermanfaat</span> dan
                <span class="font-semibold text-orange-500">khusus</span> untuk Anda!
            </p>

            <div class="relative mb-8">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center">
                    <span class="px-4 bg-white text-gray-400 text-sm">Fitur Produk UMKM</span>
                </div>
            </div>

            <p class="text-gray-500 mb-8 animate-pulse">
                "Harap bersabar ya... fitur spesial akan segera hadir!" 🙏
            </p>
        </div>

        <!-- Kotak estimasi dengan efek hover -->
        <div class="inline-block transform transition-all hover:scale-105">
            <div
                class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-xl px-8 py-6 shadow-sm">
                <div class="text-4xl mb-3 animate-pulse">⏳</div>
                <h3 class="text-blue-800 font-bold mb-1 text-lg">Estimasi Selesai</h3>
                <div
                    class="flex items-center justify-center space-x-2 bg-blue-50 px-3 py-2 rounded-lg border border-blue-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                    </svg>
                    <span class="text-blue-700 font-medium">Akan Hadir dalam Beberapa Hari</span>
                </div>
            </div>
        </div>
    </div>
</x-filament::page>
