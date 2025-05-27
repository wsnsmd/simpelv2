@php
    use Filament\Support\Enums\MaxWidth;
@endphp

<x-filament-panels::layout.base :livewire="$livewire">
    @props([
        'after' => null,
        'heading' => null,
        'subheading' => null,
    ])

    <div class="loginwrapper">
        <div class="lg-inner-column">
        <div class="left-column relative z-[1]">
            <div class="absolute left-0 h-full w-full z-[-1]">
                <img src="https://dashcode-html.codeshaper.tech/assets/images/auth/ils1.svg" alt="" class=" h-full w-full object-contain">
            </div>
        </div>
        <div class="right-column relative">
            <div class="inner-content h-full flex flex-col bg-gray-50 dark:bg-slate-800">
                <div class="auth-box h-full flex flex-col justify-center">
                    <!-- BEGIN: Login Form -->
                        {{ $slot }}
                    <!-- END: Login Form -->
                    </div>
                    <div class="auth-footer text-center">

                    Hak Cipta © 2019, BPSDM Prov. Kaltim.

                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</x-filament-panels::layout.base>
