<?php

namespace App\Http\Controllers;

use App\Models\Fasilitator;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Settings\JpMinimalSettings;

class LaporanController extends Controller
{
    public function jpMinimalWi(Request $request)
    {
        $id = $request->id;
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $fasilitator = Fasilitator::findOrFail($id);
        $kategori_0 = DB::select('CALL GetJPWIMinimalByDateAndCategory(?, ?, ?, ?)', [$id, $bulan, $tahun, 0]);
        $kategori_1 = DB::select('CALL GetJPWIMinimalByDateAndCategory(?, ?, ?, ?)', [$id, $bulan, $tahun, 1]);
        $kategori_2 = DB::select('CALL GetJPWIMinimalByDateAndCategory(?, ?, ?, ?)', [$id, $bulan, $tahun, 2]);
        $this->perbulan = app(JpMinimalSettings::class)->perbulan;

        $data = [
            'bulan' => $bulan,
            'tahun' => $tahun,
            'fasilitator' => $fasilitator,
            'kategori' => [
                0 => $kategori_0,
                1 => $kategori_1,
                2 => $kategori_2
            ],
            'perbulan' => app(JpMinimalSettings::class)->perbulan,
            'tandatangan' => [
                'nip' => app(JpMinimalSettings::class)->nip,
                'nama' => app(JpMinimalSettings::class)->nama,
                'jabatan' => app(JpMinimalSettings::class)->jabatan,
            ]
        ];

        $pdf = Pdf::loadView('laporan.jp-minimal', $data)
                    ->setPaper('A4', 'portrait')
                    ->setOptions(['defaultFont' => 'DejaVu Sans']);
        return $pdf->download('laporan-jp-minimal-'.$fasilitator->nip.'-'.$tahun.$bulan.'.pdf');
    }
}
