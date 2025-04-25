<?php

namespace App\Filament\Pages\Setting;

use App\Settings\JpMinimalSettings;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Illuminate\Contracts\Support\Htmlable;

class ManageJpMinimal extends SettingsPage
{
    use HasPageShield;
    protected static ?string $navigationIcon = 'fluentui-clipboard-settings-20';
    protected static string $settings = JpMinimalSettings::class;
    protected static ?int $navigationSort = 99;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('JP Minimal')
                    ->label('JP Minimal')
                    ->icon('fluentui-web-asset-24-o')
                    ->schema([
                        Forms\Components\Grid::make()->schema([
                            Forms\Components\TextInput::make('perbulan')
                                ->label('Perbulan')
                                ->required()
                                ->numeric(),
                    ]),
                ]),
                Forms\Components\Section::make('Penandatangan')
                    ->schema([
                        Forms\Components\Grid::make()->schema([
                            Forms\Components\TextInput::make('nip')
                                ->label('NIP')
                                ->required()
                                ->minLength(18)
                                ->maxLength(18),
                            Forms\Components\TextInput::make('nama')
                                ->label('Nama')
                                ->required(),
                            Forms\Components\TextInput::make('jabatan')
                                ->label('Jabatan')
                                ->required(),
                    ])->columns(3),
                ])
            ]);
    }

    public static function getNavigationGroup(): ?string
    {
        return __("menu.nav_group.settings");
    }

    public static function getNavigationLabel(): string
    {
        return "JP Minimal";
    }

    public function getHeading(): string|Htmlable
    {
        return 'JP Minimal Settings';
    }
}
