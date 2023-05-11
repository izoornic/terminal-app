<x-app-layout>
    <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight flex">
                <div class="pr-2"><svg class="fill-gray-500 w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M373.1,134.6L253.4,15.3C243.5,5.5,230.2,0,216.3,0H59C26.5,0,0,26.5,0,59v394c0,32.5,26.5,59,59,59h266 c32.5,0,59-26.5,59-59V160.9C384,151.1,380.1,141.6,373.1,134.6z M354.9,151.8h-61.5c-35.8,0-65-29.2-65-65v-59 c2.7,1.3,5.1,3.1,7.3,5.2L354.9,151.8z M359,453c0,9-3.6,17.5-10,24c-6.5,6.5-15,10-24,10H59c-9,0-17.5-3.6-24-10 c-6.5-6.5-10-15-10-24V59c0-9,3.6-17.5,10-24c6.5-6.5,15-10,24-10h144.4v61.8c0,49.6,40.4,90,90,90H359V453z"/><g><path d="M159.9,391.1h111.3v26.3h-141V197.8h29.7V391.1z"/></g></svg></div>   
                <div><a href="{{ route( 'licence') }}" :active="request()->routeIs('licence')">
                    {{ __('Licenca -> ') }}</a></div>
                <div class="ml-2 pr-2"><svg class="fill-cyan-500 w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><g id="Layer_1_1_" display="none"><path display="inline" d="M320,464c8.8,0,16-7.2,16-16V160h-80c-17.7,0-32-14.3-32-32V48H64c-8.8,0-16,7.2-16,16v384 c0,8.8,7.2,16,16,16H320z M0,64C0,28.7,28.7,0,64,0h165.5c17,0,33.3,6.7,45.3,18.7l90.5,90.5c12,12,18.7,28.3,18.7,45.3V448 c0,35.3-28.7,64-64,64H64c-35.3,0-64-28.7-64-64V64z"/></g><g><path d="M373.1,134.6L253.4,15.3C243.5,5.5,230.2,0,216.3,0H59C26.5,0,0,26.5,0,59v394c0,32.5,26.5,59,59,59h266 c32.5,0,59-26.5,59-59V160.9C384,151,380.1,141.5,373.1,134.6z M228.4,27.8c2.7,1.3,5.1,3,7.3,5.2l119.1,118.7h-61.4 c-35.8,0-65-29.2-65-65V27.8z M359,453c0,9-3.6,17.5-10,24c-6.5,6.5-15,10-24,10H59c-9,0-17.5-3.6-24-10c-6.5-6.5-10-15-10-24V59 c0-9,3.6-17.5,10-24c6.5-6.5,15-10,24-10h144.4v61.8c0,21.2,7.4,40.8,19.8,56.2h-61.1v64h64v-60.5c8.6,9.7,19.2,17.5,31.2,22.8V207 h64v-30.2H359V453z"/><rect x="62.7" y="143" width="64" height="64"/><rect x="62.7" y="256" width="64" height="64"/><rect x="162.1" y="256" width="64" height="64"/><rect x="257.3" y="256" width="64" height="64"/><rect x="62.7" y="369" width="64" height="64"/><rect x="162.1" y="369" width="64" height="64"/><rect x="257.3" y="369" width="64" height="64"/></g></svg></div> 
                <div class="text-cyan-500">Parametri</div>
            </h2>
    </x-slot>

    <div class="pt-6 pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
              @livewire('licenca-parametars')
            </div>
        </div>
    </div>
    @include('admin.footer')
</x-app-layout>