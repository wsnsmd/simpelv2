<?php

namespace App\Filament\Resources\Data\FasilitatorResource\Pages;

use App\Filament\Resources\Data\FasilitatorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFasilitator extends EditRecord
{
    protected static string $resource = FasilitatorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
