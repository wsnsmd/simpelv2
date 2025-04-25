<x-filament-panels::page>
    <!-- Modal Loading -->
    <x-modal-loading class="fixed inset-0 hidden" id="wire-modal-loading" wire:loading wire:target="loadData" />

    <!-- Form -->
    <form wire:submit.prevent="loadData" class="flex items-end gap-2">
        <div class="w-full">
            {{ $this->form }}
        </div>
        <x-filament::button type="submit" wire:loading.attr="disabled" wire:target="loadData">Proses</x-filament::button>
    </form>

    <!-- Tabel -->
    <x-filament-tables::container>
        <x-filament-tables::table>
            <thead class="divide-y divide-gray-200 dark:divide-white/5">
                <tr class="bg-gray-50 dark:bg-white/5">
                    <x-custom-header-cell rowspan="2" style="width: 50px;">No</x-custom-header-cell>
                    <x-filament-tables::header-cell rowspan="2" class="border border-gray-200 dark:border-white/5 px-4 py-2">Nama</x-filament-tables::header-cell>
                    <x-custom-header-cell colspan="3" style="width: 450px;">Detail JP</x-custom-header-cell>
                    <x-custom-header-cell rowspan="2" style="width: 100px;">Status</x-custom-header-cell>
                    <x-custom-header-cell rowspan="2" style="width: 200px;">Aksi</x-custom-header-cell>
                </tr>
                <tr class="bg-gray-50 dark:bg-white/5">
                    <x-custom-header-cell style="width: 150px;">Bukan JP Minimal</x-custom-header-cell>
                    <x-custom-header-cell style="width: 150px;">JP Minimal</x-custom-header-cell>
                    <x-custom-header-cell style="width: 150px;">Dibayarkan</x-custom-header-cell>
                </tr>
            </thead>
            <tbody>
                @foreach ($fasilitator as $fas)
                    <x-filament-tables::row>
                        <x-filament-tables::cell class="border border-gray-200 dark:border-white/5 px-4 py-2 text-sm text-center" style="width: 50px;">{{ $loop->iteration }}</x-filament-tables::cell>
                        <x-filament-tables::cell class="border border-gray-200 dark:border-white/5 px-4 py-2 text-sm">{{ $fas->nama }}</x-filament-tables::cell>
                        <x-filament-tables::cell class="border border-gray-200 dark:border-white/5 px-4 py-2 text-sm text-center" style="width: 150px;">{{ $fas->kategori_0 }}</x-filament-tables::cell>
                        <x-filament-tables::cell class="border border-gray-200 dark:border-white/5 px-4 py-2 text-sm text-center" style="width: 150px;">{{ $fas->kategori_1 }}</x-filament-tables::cell>
                        <x-filament-tables::cell class="border border-gray-200 dark:border-white/5 px-4 py-2 text-sm text-center" style="width: 150px;">{{ $fas->kategori_2 }}</x-filament-tables::cell>
                        <x-filament-tables::cell class="border border-gray-200 dark:border-white/5 px-4 py-2 text-sm text-center" style="width: 100px;">{{ $fas->laporan_status }}</x-filament-tables::cell>
                        <x-filament-tables::cell class="border border-gray-200 dark:border-white/5 px-4 py-2 text-sm text-center" style="width: 200px;">
                            <div class="flex items-center justify-center gap-x-2">
                                {{-- <x-filament::button x-data @click="Livewire.navigate('{{ route('filament.admin.pages.laporan.jp-minimal-detail', ['fid' => $fas->id, 'bulan' => $this->bulan, 'tahun' => $this->tahun]) }}')" size="xs" color="primary" icon="heroicon-m-eye">
                                    Detail
                                </x-filament::button> --}}
                                <x-filament::button
                                    x-data
                                    @click="window.open('{{ route('filament.admin.pages.laporan.jp-minimal-detail', ['fid' => $fas->id, 'bulan' => $bulan, 'tahun' => $tahun]) }}', '_blank')"
                                    size="xs"
                                    color="primary"
                                    icon="heroicon-m-printer">
                                    Detail
                                </x-filament::button>
                                <!-- Form untuk Tombol Cetak -->
                                <form action="{{ route('cetak.laporan.jp-minimal-wi') }}" method="POST" target="_blank">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $fas->id }}">
                                    <input type="hidden" name="bulan" value="{{ $this->bulan }}">
                                    <input type="hidden" name="tahun" value="{{ $this->tahun }}">
                                    <x-filament::button type="submit" size="xs" color="success" icon="heroicon-m-printer">
                                        Cetak
                                    </x-filament::button>
                                </form>
                            </div>
                        </x-filament-tables::cell>
                    </x-filament-tables::row>
                @endforeach
            </tbody>
        </x-filament-tables::table>
    </x-filament-tables::container>
</x-filament-panels::page>
