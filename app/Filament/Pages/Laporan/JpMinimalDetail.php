<?php

namespace App\Filament\Pages\Laporan;

use App\Models\Fasilitator;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;
use App\Settings\JpMinimalSettings;
use Illuminate\Support\Facades\Http;

class JpMinimalDetail extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.laporan.jp-minimal-detail';
    protected static ?string $title = 'JP Minimal Detail';
    protected static bool $shouldRegisterNavigation = false;

    public $fid, $nip, $nama, $bulan, $tahun, $perbulan;
    public $activeTab = 'bukan_jp_minimal';
    public $bukan_jp_minimal = [];
    public $jp_minimal = [];
    public $dibayarkan = [];

    public static function getSlug(): string
    {
        return 'laporan/jp-minimal-detail'; // Ganti dengan URL slug yang diinginkan
    }

    public function mount()
    {
        $this->perbulan = app(JpMinimalSettings::class)->perbulan;
        $this->fid = request()->query('fid');
        $this->bulan = request()->query('bulan');
        $this->tahun = request()->query('tahun');
        $fasilitator = Fasilitator::where('id', $this->fid)->first();
        $this->nip = $fasilitator->nip;
        $this->nama = $fasilitator->nama;

        // Contoh data, bisa diganti dengan query dari database
        $this->bukan_jp_minimal = $this->getData(0);

        $this->jp_minimal = $this->getData(1);

        $this->dibayarkan = $this->getData(2);
    }

    public function getData(int $kategori)
    {
        return DB::select('CALL GetJPWIMinimalByDateAndCategory(?, ?, ?, ?)', [$this->fid, $this->bulan, $this->tahun, $kategori]);
    }
}
