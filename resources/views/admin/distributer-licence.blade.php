<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <span class="float-left mr-2 pr-2"><svg class="fill-current w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M373.1,134.6L253.4,15.3C243.5,5.5,230.2,0,216.3,0H59C26.5,0,0,26.5,0,59v394c0,32.5,26.5,59,59,59h266 c32.5,0,59-26.5,59-59V160.9C384,151.1,380.1,141.6,373.1,134.6z M354.9,151.8h-61.5c-35.8,0-65-29.2-65-65v-59 c2.7,1.3,5.1,3.1,7.3,5.2L354.9,151.8z M359,453c0,9-3.6,17.5-10,24c-6.5,6.5-15,10-24,10H59c-9,0-17.5-3.6-24-10 c-6.5-6.5-10-15-10-24V59c0-9,3.6-17.5,10-24c6.5-6.5,15-10,24-10h144.4v61.8c0,49.6,40.4,90,90,90H359V453z"/><g><path d="M159.9,391.1h111.3v26.3h-141V197.8h29.7V391.1z"/></g></svg></span>   
                {{ __('Licence - ') }} 
                @php
                    $dist_name = App\Models\LicencaDistributerTip::DistributerName(request()->query('id'));
                @endphp
                {{ $dist_name }}
            </h2>
            </div>
        </div>
    </x-slot>

    <div class="pt-6 pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
              @livewire('distributer-licenca')
            </div>
        </div>
    </div>
    @include('admin.footer')
</x-app-layout>