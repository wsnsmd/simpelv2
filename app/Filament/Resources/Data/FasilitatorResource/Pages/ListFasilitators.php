<?php

namespace App\Filament\Resources\Data\FasilitatorResource\Pages;

use App\Filament\Resources\Data\FasilitatorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListFasilitators extends ListRecords
{
    protected static string $resource = FasilitatorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah'),
        ];
    }

    public function getTabs(): array
{
    return [
        'all' => Tab::make()->label('Semua'),
        'internal' => Tab::make()
            ->label('Internal')
            ->modifyQueryUsing(fn (Builder $query) => $query->where('internal', 1)),
        'external' => Tab::make()
            ->label('External')
            ->modifyQueryUsing(fn (Builder $query) => $query->where('internal', 0)),
    ];
}
}
