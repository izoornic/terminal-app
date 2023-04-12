<div class="p-6">
    <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6">
        
    </div>

    {{-- The data table --}}
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <div class="grid grid-cols-1 gap-0 place-items-center">
                        <div class="my-6 flex w-fit">
                            <div>
                                <x-jet-label for="srednji_kurs" value="{{ __('Srednji kurs EUR') }}" />
                                <x-jet-input wire:model="srednji_kurs" id="" class="block mt-1 w-80" type="text" />
                                @error('srednji_kurs') <span class="error">{{ $message }}</span> @enderror
                            </div>
                            <div class="font-bold px-6 pt-8">RSD</div>
                        </div>
                        <div class="mb-6">
                            <button wire:click="nextStep()" class="flex border border-stone-500 bg-stone-300 hover:bg-stone-500 text-stone-700 hover:text-white font-bold uppercase py-1 px-4 rounded mx-2">
                            <svg class="fill-current w-4 h-4 mr-2 mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M64 464H96v48H64c-35.3 0-64-28.7-64-64V64C0 28.7 28.7 0 64 0H229.5c17 0 33.3 6.7 45.3 18.7l90.5 90.5c12 12 18.7 28.3 18.7 45.3V288H336V160H256c-17.7 0-32-14.3-32-32V48H64c-8.8 0-16 7.2-16 16V448c0 8.8 7.2 16 16 16zM176 352h32c30.9 0 56 25.1 56 56s-25.1 56-56 56H192v32c0 8.8-7.2 16-16 16s-16-7.2-16-16V448 368c0-8.8 7.2-16 16-16zm32 80c13.3 0 24-10.7 24-24s-10.7-24-24-24H192v48h16zm96-80h32c26.5 0 48 21.5 48 48v64c0 26.5-21.5 48-48 48H304c-8.8 0-16-7.2-16-16V368c0-8.8 7.2-16 16-16zm32 128c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H320v96h16zm80-112c0-8.8 7.2-16 16-16h48c8.8 0 16 7.2 16 16s-7.2 16-16 16H448v32h32c8.8 0 16 7.2 16 16s-7.2 16-16 16H448v48c0 8.8-7.2 16-16 16s-16-7.2-16-16V432 368z"/></svg>
                                {{ __('Zaduži distributera') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
</div>