<div {{ $attributes->merge([
    'class' => 'absolute inset-0 flex items-center justify-center'
]) }}>
    <div>
        <x-filament::loading-indicator @class([ "w-10 h-10 block mx-auto" ]) />
        @if($slot->isNotEmpty())
            {{ $slot }}
        @else
            <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Mohon Tunggu...</span>
        @endif
    </div>
</div>
