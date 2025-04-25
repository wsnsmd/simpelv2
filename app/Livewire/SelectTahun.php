<?php

namespace App\Livewire;

use App\Models\Tahun;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class SelectTahun extends Component implements HasForms
{
    use InteractsWithForms;
    public $tahun;

    public $tahunOptions = [];


    public function mount()
    {
        $this->tahunOptions = Tahun::where('aktif', true)->pluck('tahun', 'tahun')->toArray();
        $this->tahun = Session::get('tahun-aktif', !empty($this->tahunOptions) ? max($this->tahunOptions) : null);

        $this->form->fill([
            'tahun' => $this->tahun,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('tahun')
                ->label('Tahun')
                ->inlineLabel()
                ->options($this->tahunOptions)
                ->live()
                ->afterStateUpdated(fn($state) => $this->updateTahun($state))
                ->extraAttributes([
                    'class' => 'w-[1000px]'
                ])
                ->selectablePlaceholder(false)
                ->native(false)
        ]);
    }

    public function updateTahun($value)
    {
        Session::put('tahun-aktif', $value);
        return redirect(request()->header('Referer'));
    }

    public function render()
    {
        return view('livewire.select-tahun');
    }
}
