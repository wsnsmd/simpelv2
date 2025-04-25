<?php

namespace App\Filament\Pages\Laporan;

use Filament\Pages\Page;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Components\Grid;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Filament\Actions\Action;
use Filament\Navigation\NavigationItem;
use Barryvdh\DomPDF\Facade\Pdf;

class JpMinimalPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.laporan.jp-minimal-page';
    protected static ?string $navigationGroup = 'Laporan';
    protected static ?string $navigationLabel = 'JP Minimal';
    protected ?string $maxContentWidth = 'full';

    public $bulan;
    public $tahun;

    public function mount()
    {
        $this->tahun = Session::get('tahun-aktif', !empty($this->tahunOptions) ? max($this->tahunOptions) : null);
        $this->bulan = now()->month;
    }

    public function getTitle(): string
    {
        return 'Laporan JP Minimal ';
    }

    public static function getSlug(): string
    {
        return 'laporan/jp-minimal'; // Ganti dengan URL slug yang diinginkan
    }

    public static function getNavigationItems(): array
    {
        return [
            NavigationItem::make(static::getNavigationLabel())
                ->group(static::getNavigationGroup())
                ->parentItem(static::getNavigationParentItem())
                ->icon(static::getNavigationIcon())
                ->activeIcon(static::getActiveNavigationIcon())
                ->isActiveWhen(function (): bool {
                    return request()->routeIs(static::getNavigationItemActiveRoutePattern()) ||
                           request()->routeIs('filament.admin.pages.laporan.jp-minimal-detail');
                })
                ->sort(static::getNavigationSort())
                ->badge(static::getNavigationBadge(), color: static::getNavigationBadgeColor())
                ->badgeTooltip(static::getNavigationBadgeTooltip())
                ->url(static::getNavigationUrl()),
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(1) // Mengatur lebar grid
                    ->schema([
                        Select::make('bulan')
                            ->options([
                                1 => 'Januari',
                                2 => 'Februari',
                                3 => 'Maret',
                                4 => 'April',
                                5 => 'Mei',
                                6 => 'Juni',
                                7 => 'Juli',
                                8 => 'Agustus',
                                9 => 'September',
                                10 => 'Oktober',
                                11 => 'November',
                                12 => 'Desember',
                            ])
                            ->label('Pilih Bulan')
                            ->required()
                            ->native(false)
                            ->default($this->bulan)
                            ->selectablePlaceholder(false),
                    ]),
            ]);
    }

    protected function getViewData(): array
    {
        return [
            'fasilitator' => $this->getFasilitator(),
        ];
    }

    public function getFasilitator()
    {
        return DB::select('CALL GetFasilitatorWithTotalJP(?, ?)', [$this->bulan, $this->tahun]);
    }

    public function loadData()
    {
        $this->validate([
            'bulan' => 'required|numeric|between:1,12',
        ]);
    }

    public function cetakAction(): Action
    {
        return Action::make('test')
        ->openUrlInNewTab(true)
        ->action(function (array $args) {
            route('cetak.laporan.jp-minimal-wi', ['id' => $args['id']]);
        });
    }

    public function cetak(String $id)
    {
        $data = [
            'bulan' => 'Maret 2025',
            'items' => [
                ['nama' => 'John Doe', 'jumlah' => 10],
                ['nama' => 'Jane Doe', 'jumlah' => 15],
            ],
        ];

        $pdf = Pdf::loadView('laporan.jp-minimal', $data)
                    ->setPaper('A4', 'portrait')
                    ->setOptions(['defaultFont' => 'DejaVu Sans']);
        return $pdf->download('laporan-jp-minimal.pdf');
    }

}
