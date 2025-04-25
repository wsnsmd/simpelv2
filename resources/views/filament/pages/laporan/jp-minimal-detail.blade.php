<x-filament::page>
    <x-filament-panels::form
            id="form"
            :wire:key="$this->getId() . '.forms.' . $this->getFormStatePath()"
            wire:submit="save"
        >
            <button>Lesles</button>
    </x-filament-panels::form>
    <div class="p-6 bg-white shadow-md rounded-lg dark:bg-gray-800">
        <h2 class="text-2xl font-bold dark:text-gray-100">Rekapitulasi JP Widyaiswara</h2>

        {{-- Informasi Fasilitator --}}
        <div class="mt-4 p-4 border rounded-lg bg-gray-50 dark:bg-gray-700">
            <p><strong>NIP:</strong> {{ $nip }}</p>
            <p><strong>Nama:</strong> {{ $nama }}</p>
            <p><strong>Bulan:</strong> {{ $bulan }}</p>
            <p><strong>Tahun:</strong> {{ $tahun }}</p>
        </div>

        {{-- Tabel Bukan JP Minimal --}}
        <div class="mt-6">
            <h3 class="text-lg font-semibold">Tidak Termasuk Perhitungan</h3>
            <x-filament-tables::container>
                <x-filament-tables::table>
                    <thead class="divide-y divide-gray-200 dark:divide-white/5">
                        <tr class="bg-gray-50 dark:bg-white/5">
                            <x-filament-tables::header-cell class="border border-gray-200 dark:border-white/5 px-4 py-2" style="width: 50px;">No</x-filament-tables::header-cell>
                            <x-filament-tables::header-cell class="border border-gray-200 dark:border-white/5 px-4 py-2" style="width: 120px;">Tanggal</x-filament-tables::header-cell>
                            <x-filament-tables::header-cell class="border border-gray-200 dark:border-white/5 px-4 py-2" style="width: 500px;">Jadwal</x-filament-tables::header-cell>
                            <x-filament-tables::header-cell class="border border-gray-200 dark:border-white/5 px-4 py-2">Mata Pelatihan</x-filament-tables::header-cell>
                            <x-filament-tables::header-cell class="border border-gray-200 dark:border-white/5 px-4 py-2" style="width: 60px;">JP</x-filament-tables::header-cell>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($bukan_jp_minimal) > 0)
                            @foreach ($bukan_jp_minimal as $item)
                                <x-filament-tables::row>
                                    <x-filament-tables::cell class="border border-gray-200 dark:border-white/5 px-4 py-2 text-center">{{ $loop->iteration }}</x-filament-tables::cell>
                                    <x-filament-tables::cell class="border border-gray-200 dark:border-white/5 px-4 py-1">{{ $item->tanggal }}</x-filament-tables::cell>
                                    <x-filament-tables::cell class="border border-gray-200 dark:border-white/5 px-4 py-1">{{ $item->jid_nama }}</x-filament-tables::cell>
                                    <x-filament-tables::cell class="border border-gray-200 dark:border-white/5 px-4 py-1">{{ $item->nama_mapel }}</x-filament-tables::cell>
                                    <x-filament-tables::cell class="border border-gray-200 dark:border-white/5 px-4 py-1 text-right">{{ $item->jp }}</x-filament-tables::cell>
                                </x-filament-tables::row>
                            @endforeach
                        @else
                            <x-filament-tables::row>
                                <x-filament-tables::cell colspan="5" class="border border-gray-200 dark:border-white/5 px-4 py-2 text-center text-gray-500 dark:text-gray-100">
                                    Tidak ada.
                                </x-filament-tables::cell>
                            </x-filament-tables::row>
                        @endif
                    </tbody>
                    @if (count($bukan_jp_minimal) > 0)
                        <tfoot>
                            <tr>
                                <x-filament-tables::cell colspan="4" class="border border-gray-200 dark:border-white/5 px-4 py-1 font-bold text-center">Total</x-filament-tables::cell>
                                <x-filament-tables::cell class="border border-gray-200 dark:border-white/5 px-4 py-1 font-bold">{{ array_sum(array_column($bukan_jp_minimal, 'jp')) }}</x-filament-tables::cell>
                            </tr>
                        </tfoot>
                    @endif
                </x-filament-tables::table>
            </x-filament-tables::container>
        </div>

        {{-- Tabel JP Minimal --}}
        <div class="mt-6">
            <h3 class="text-lg font-semibold">Perhitungan JP Minimal</h3>
            <x-filament-tables::container>
                <x-filament-tables::table>
                    <thead class="divide-y divide-gray-200 dark:divide-white/5">
                        <tr class="bg-gray-50 dark:bg-white/5">
                            <x-filament-tables::header-cell class="border border-gray-200 dark:border-white/5 px-4 py-2" style="width: 50px;">No</x-filament-tables::header-cell>
                            <x-filament-tables::header-cell class="border border-gray-200 dark:border-white/5 px-4 py-2" style="width: 120px;">Tanggal</x-filament-tables::header-cell>
                            <x-filament-tables::header-cell class="border border-gray-200 dark:border-white/5 px-4 py-2" style="width: 500px;">Jadwal</x-filament-tables::header-cell>
                            <x-filament-tables::header-cell class="border border-gray-200 dark:border-white/5 px-4 py-2">Mata Pelatihan</x-filament-tables::header-cell>
                            <x-filament-tables::header-cell class="border border-gray-200 dark:border-white/5 px-4 py-2" style="width: 60px;">JP</x-filament-tables::header-cell>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($jp_minimal) > 0)
                            @foreach ($jp_minimal as $item)
                                <x-filament-tables::row>
                                    <x-filament-tables::cell class="border border-gray-200 dark:border-white/5 px-4 py-2 text-center">{{ $loop->iteration }}</x-filament-tables::cell>
                                    <x-filament-tables::cell class="border border-gray-200 dark:border-white/5 px-4 py-1">{{ $item->tanggal }}</x-filament-tables::cell>
                                    <x-filament-tables::cell class="border border-gray-200 dark:border-white/5 px-4 py-1">{{ $item->jid_nama }}</x-filament-tables::cell>
                                    <x-filament-tables::cell class="border border-gray-200 dark:border-white/5 px-4 py-1">{{ $item->nama_mapel }}</x-filament-tables::cell>
                                    <x-filament-tables::cell class="border border-gray-200 dark:border-white/5 px-4 py-1 text-right">{{ $item->jp }}</x-filament-tables::cell>
                                </x-filament-tables::row>
                            @endforeach
                        @else
                            <x-filament-tables::row>
                                <x-filament-tables::cell colspan="5" class="border border-gray-200 dark:border-white/5 px-4 py-2 text-center text-gray-500 dark:text-gray-100">
                                    Tidak ada.
                                </x-filament-tables::cell>
                            </x-filament-tables::row>
                        @endif
                    </tbody>
                    @if (count($jp_minimal) > 0)
                        <tfoot>
                            <tr>
                                <x-filament-tables::cell colspan="4" class="border border-gray-200 dark:border-white/5 px-4 py-1 font-bold text-center">Total</x-filament-tables::cell>
                                <x-filament-tables::cell class="border border-gray-200 dark:border-white/5 px-4 py-1 font-bold text-right">{{ array_sum(array_column($jp_minimal, 'jp')) }}</x-filament-tables::cell>
                            </tr>
                            <tr>
                                <x-filament-tables::cell colspan="4" class="border border-gray-200 dark:border-white/5 px-4 py-1 font-bold text-center">Total JP - Jam Minimal ( {{ array_sum(array_column($jp_minimal, 'jp')) . 'JP - ' . $perbulan . 'JP' }}) </x-filament-tables::cell>
                                <x-filament-tables::cell class="border border-gray-200 dark:border-white/5 px-4 py-1 font-bold text-right">{{array_sum(array_column($jp_minimal, 'jp')) - $perbulan}}</x-filament-tables::cell>
                            </tr>
                        </tfoot>
                    @endif
                </x-filament-tables::table>
            </x-filament-tables::container>
        </div>

        {{-- Tabel Dibayarkan --}}
        <div class="mt-6">
            <h3 class="text-lg font-semibold">Perhitungan Penuh</h3>
            <x-filament-tables::container>
                <x-filament-tables::table>
                    <thead class="divide-y divide-gray-200 dark:divide-white/5">
                        <tr class="bg-gray-50 dark:bg-white/5">
                            <x-filament-tables::header-cell class="border border-gray-200 dark:border-white/5 px-4 py-2" style="width: 50px;">No</x-filament-tables::header-cell>
                            <x-filament-tables::header-cell class="border border-gray-200 dark:border-white/5 px-4 py-2" style="width: 120px;">Tanggal</x-filament-tables::header-cell>
                            <x-filament-tables::header-cell class="border border-gray-200 dark:border-white/5 px-4 py-2" style="width: 500px;">Jadwal</x-filament-tables::header-cell>
                            <x-filament-tables::header-cell class="border border-gray-200 dark:border-white/5 px-4 py-2">Mata Pelatihan</x-filament-tables::header-cell>
                            <x-filament-tables::header-cell class="border border-gray-200 dark:border-white/5 px-4 py-2" style="width: 60px;">JP</x-filament-tables::header-cell>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($dibayarkan) > 0)
                            @foreach ($dibayarkan as $item)
                                <x-filament-tables::row>
                                    <x-filament-tables::cell class="border border-gray-200 dark:border-white/5 px-4 py-2 text-center">{{ $loop->iteration }}</x-filament-tables::cell>
                                    <x-filament-tables::cell class="border border-gray-200 dark:border-white/5 px-4 py-1">{{ $item->tanggal }}</x-filament-tables::cell>
                                    <x-filament-tables::cell class="border border-gray-200 dark:border-white/5 px-4 py-1">{{ $item->jid_nama }}</x-filament-tables::cell>
                                    <x-filament-tables::cell class="border border-gray-200 dark:border-white/5 px-4 py-1">{{ $item->nama_mapel }}</x-filament-tables::cell>
                                    <x-filament-tables::cell class="border border-gray-200 dark:border-white/5 px-4 py-1 text-right">{{ $item->jp }}</x-filament-tables::cell>
                                </x-filament-tables::row>
                            @endforeach
                        @else
                            <x-filament-tables::row>
                                <x-filament-tables::cell colspan="5" class="border border-gray-200 dark:border-white/5 px-4 py-2 text-center text-gray-500 dark:text-gray-100">
                                    Tidak ada.
                                </x-filament-tables::cell>
                            </x-filament-tables::row>
                        @endif
                    </tbody>
                    @if (count($dibayarkan) > 0)
                        <tfoot>
                            <tr>
                                <x-filament-tables::cell colspan="4" class="border border-gray-200 dark:border-white/5 px-4 py-1 font-bold text-center">Total</x-filament-tables::cell>
                                <x-filament-tables::cell class="border border-gray-200 dark:border-white/5 px-4 py-1 font-bold text-right">{{ array_sum(array_column($dibayarkan, 'jp')) }}</x-filament-tables::cell>
                            </tr>
                        </tfoot>
                    @endif
                </x-filament-tables::table>
            </x-filament-tables::container>
        </div>
        <div class="mt-5">
            <form action="{{ route('cetak.laporan.jp-minimal-wi') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $fid }}">
                <input type="hidden" name="bulan" value="{{ $bulan }}">
                <input type="hidden" name="tahun" value="{{ $tahun }}">
                <x-filament::button type="submit" size="md" color="success" icon="heroicon-m-printer">
                    Cetak
                </x-filament::button>
            </form>
        </div>
    </div>
</x-filament::page>
