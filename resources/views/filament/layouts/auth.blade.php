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
            <div class="max-w-[520px] pt-20 pl-20">
                <a href="index.html">
                    <img src="https://dashcode-html.codeshaper.tech/assets/images/logo/logo.svg" alt="" class="mb-10 dark_logo inline-block dark:hidden">
                    <img src="https://dashcode-html.codeshaper.tech/assets/images/logo/logo-white.svg" alt="" class="mb-10 white_logo hidden dark:inline-block">
                </a>
                <h4>
                    Unlock your Project
                    <span class="text-slate-800 dark:text-slate-400 font-bold">performance</span>
                </h4>
            </div>
            <div class="absolute left-0 2xl:bottom-[-160px] bottom-[-130px] h-full w-full z-[-1]">
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

            Copyright 2021, Dashcode All Rights Reserved.

                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</x-filament-panels::layout.base>
