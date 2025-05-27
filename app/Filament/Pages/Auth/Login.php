<?php

namespace App\Filament\Pages\Auth;

use Illuminate\Validation\ValidationException;
use Filament\Facades\Filament;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Pages\Auth\Login as BasePage;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Illuminate\Contracts\Support\Htmlable;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use MarcoGermani87\FilamentCaptcha\Forms\Components\CaptchaField;

class Login extends BasePage
{
    // use InteractsWithForms;
    use WithRateLimiting;
    protected static string $view = 'filament.pages.auth.login';
    protected static string $layout = 'filament.layouts.auth';
    public $useTahun = true;
    public $useCaptcha = false;

    public function mount(): void
    {
        parent::mount();

        if($this->useTahun) {
            $this->form->fill([
                'tahun' => date('Y'),
            ]);
        }

        $this->form->fill([
            'username' => 'superadmin',
            'password' => 'superadmin',
            'tahun' => date('Y'),
        ]);
    }

    public function authenticate(): ?LoginResponse
    {
        try {
            $this->rateLimit(10);
        } catch (TooManyRequestsException $exception) {
            Notification::make()
                ->title(__('filament-panels::pages/auth/login.notifications.throttled.title', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]))
                ->body(array_key_exists('body', __('filament-panels::pages/auth/login.notifications.throttled') ?: []) ? __('filament-panels::pages/auth/login.notifications.throttled.body', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]) : null)
                ->danger()
                ->send();

            return null;
        }

        $data = $this->form->getState();

        if (!Filament::auth()->attempt([
            'username' => $data['username'],
            'password' => $data['password'],
        ])) {
            throw ValidationException::withMessages([
                'data.username' => __('filament-panels::pages/auth/login.messages.failed'),
            ]);
        }

        session()->regenerate();

        if ($this->useTahun) {
            session()->put('tahun-aktif', $data['tahun']);
        }

        return app(LoginResponse::class);
    }

    public function form(Form $form): Form
    {
        // dd(\App\Models\Tahun::where('aktif', true)->pluck('tahun', 'tahun'));
        return $form
            ->schema([
                TextInput::make('username')
                    ->label('Username')
                    ->required()
                    ->autocomplete(),
                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required(),
                Select::make('tahun')
                    // ->options(collect(range($yearStart, date('Y')))->mapWithKeys(fn ($year) => [$year => $year]))
                    ->options(\App\Models\Tahun::where('aktif', true)->pluck('tahun', 'tahun')->toArray())
                    ->native(false)
                    ->required()
                    ->selectablePlaceholder(false)
                    ->hidden(! $this->useTahun),
                CaptchaField::make('captcha')
                    ->hidden(! $this->useCaptcha),
            ]);
    }

    public function getHeading(): string | Htmlable
    {
        return 'SIMPel Kaltim';
    }

    public function getMaxWidth(): MaxWidth
    {
        return MaxWidth::Full;
    }

    public function getExtraBodyAttributes(): array
    {
        return ['class' => 'login-page'];
    }

    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.login' => __('filament-panels::pages/auth/login.messages.failed'),
        ]);
}
}
