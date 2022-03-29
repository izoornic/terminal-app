<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
              @livewire('users')
            </div>
        </div>
    </div>
    <div class="pt-2 bg-white">
            <div class="flex justify-between">
                <div></div>
                <div class="text-xs lg:text-sm leading-none text-gray-700">{{ config('global.siteFooter') }}</div>
                <div class="pr-4 text-xs lg:text-sm leading-none text-gray-700">{{ config('global.version') }}</div>
            </div>
    </div>
</x-app-layout>