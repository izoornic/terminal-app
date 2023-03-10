<div class="p-6">
    <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6">
        <x-jet-button wire:click="createShowModal">
            <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM256 368C269.3 368 280 357.3 280 344V280H344C357.3 280 368 269.3 368 256C368 242.7 357.3 232 344 232H280V168C280 154.7 269.3 144 256 144C242.7 144 232 154.7 232 168V232H168C154.7 232 144 242.7 144 256C144 269.3 154.7 280 168 280H232V344C232 357.3 242.7 368 256 368z"/></svg>
            {{ __('Novi Distributer') }}
        </x-jet-button>
    </div>

    {{-- The data table --}}
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200" style="width: 100% !important">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    <button wire:click="$set('orderBy', 'id')"><svg class="@if ($orderBy == 'id') {{ 'fill-orange-600' }}  @else {{ 'fill-current' }} @endif w-4 h-4 mr-0 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M320 224H416c17.67 0 32-14.33 32-32s-14.33-32-32-32h-95.1c-17.67 0-32 14.33-32 32S302.3 224 320 224zM320 352H480c17.67 0 32-14.33 32-32s-14.33-32-32-32h-159.1c-17.67 0-32 14.33-32 32S302.3 352 320 352zM320 96h32c17.67 0 31.1-14.33 31.1-32s-14.33-32-31.1-32h-32c-17.67 0-32 14.33-32 32S302.3 96 320 96zM544 416h-223.1c-17.67 0-32 14.33-32 32s14.33 32 32 32H544c17.67 0 32-14.33 32-32S561.7 416 544 416zM192.4 330.7L160 366.1V64.03C160 46.33 145.7 32 128 32S96 46.33 96 64.03v302L63.6 330.7c-6.312-6.883-14.94-10.38-23.61-10.38c-7.719 0-15.47 2.781-21.61 8.414c-13.03 11.95-13.9 32.22-1.969 45.27l87.1 96.09c12.12 13.26 35.06 13.26 47.19 0l87.1-96.09c11.94-13.05 11.06-33.31-1.969-45.27C224.6 316.8 204.4 317.7 192.4 330.7z"/></svg></button>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    <button wire:click="$set('orderBy', 'distributer_naziv')">NAZIV<svg class="@if ($orderBy == 'distributer_naziv') {{ 'fill-orange-600' }}  @else {{ 'fill-current' }} @endif float-right w-4 h-4 mr-0 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M320 224H416c17.67 0 32-14.33 32-32s-14.33-32-32-32h-95.1c-17.67 0-32 14.33-32 32S302.3 224 320 224zM320 352H480c17.67 0 32-14.33 32-32s-14.33-32-32-32h-159.1c-17.67 0-32 14.33-32 32S302.3 352 320 352zM320 96h32c17.67 0 31.1-14.33 31.1-32s-14.33-32-31.1-32h-32c-17.67 0-32 14.33-32 32S302.3 96 320 96zM544 416h-223.1c-17.67 0-32 14.33-32 32s14.33 32 32 32H544c17.67 0 32-14.33 32-32S561.7 416 544 416zM192.4 330.7L160 366.1V64.03C160 46.33 145.7 32 128 32S96 46.33 96 64.03v302L63.6 330.7c-6.312-6.883-14.94-10.38-23.61-10.38c-7.719 0-15.47 2.781-21.61 8.414c-13.03 11.95-13.9 32.22-1.969 45.27l87.1 96.09c12.12 13.26 35.06 13.26 47.19 0l87.1-96.09c11.94-13.05 11.06-33.31-1.969-45.27C224.6 316.8 204.4 317.7 192.4 330.7z"/></svg></button>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Adresa</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Broj ugovora</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Datum ugovora</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Datum isteka</th>
                                <th colspan="2" class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Licence</th>
                                <th colspan="2" class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Br. terminala</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"></th>
                                
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">  
                        {{-- SEARCH ROW --}}
                            <tr class="bg-orange-50">
                                <td><svg class="mx-auto fill-orange-600 w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M3.853 54.87C10.47 40.9 24.54 32 40 32H472C487.5 32 501.5 40.9 508.1 54.87C514.8 68.84 512.7 85.37 502.1 97.33L320 320.9V448C320 460.1 313.2 471.2 302.3 476.6C291.5 482 278.5 480.9 268.8 473.6L204.8 425.6C196.7 419.6 192 410.1 192 400V320.9L9.042 97.33C-.745 85.37-2.765 68.84 3.854 54.87L3.853 54.87z"/></svg></td>
                                <td>
                                    <x-jet-input wire:model="searchName" id="" class="block bg-orange-50 w-full" type="text" placeholder="Pretraži ime" />
                                </td>
                                <td>
                                    <x-jet-input wire:model="searchMesto" id="" class="block bg-orange-50 w-full" type="text" placeholder="Pretraži mesto" />
                                </td>
                                <td colspan="2">
                                    <x-jet-input wire:model="searchPib" id="" class="block bg-orange-50 w-full" type="text" placeholder="Pretraži PIB" />
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                            @if ($data->count())
                                @foreach ($data as $item)
                                    <tr>
                                        <td class="px-4 py-2">
                                            <x-jet-secondary-button class="btn btn-blue" wire:click="updateShowModal({{ $item->id }})" title="Izmeni podatke">
                                            <svg class="fill-current w-4 h-4 mr-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M373.1 24.97C401.2-3.147 446.8-3.147 474.9 24.97L487 37.09C515.1 65.21 515.1 110.8 487 138.9L289.8 336.2C281.1 344.8 270.4 351.1 258.6 354.5L158.6 383.1C150.2 385.5 141.2 383.1 135 376.1C128.9 370.8 126.5 361.8 128.9 353.4L157.5 253.4C160.9 241.6 167.2 230.9 175.8 222.2L373.1 24.97zM440.1 58.91C431.6 49.54 416.4 49.54 407 58.91L377.9 88L424 134.1L453.1 104.1C462.5 95.6 462.5 80.4 453.1 71.03L440.1 58.91zM203.7 266.6L186.9 325.1L245.4 308.3C249.4 307.2 252.9 305.1 255.8 302.2L390.1 168L344 121.9L209.8 256.2C206.9 259.1 204.8 262.6 203.7 266.6zM200 64C213.3 64 224 74.75 224 88C224 101.3 213.3 112 200 112H88C65.91 112 48 129.9 48 152V424C48 446.1 65.91 464 88 464H360C382.1 464 400 446.1 400 424V312C400 298.7 410.7 288 424 288C437.3 288 448 298.7 448 312V424C448 472.6 408.6 512 360 512H88C39.4 512 0 472.6 0 424V152C0 103.4 39.4 64 88 64H200z"/></svg>
                                            </x-jet-button>
                                        </td> 
                                        <td class="px-4 py-2">{{ $item->distributer_naziv }}</td>
                                        <td class="px-4 py-2">{{ $item->distributer_adresa }} <br /> {{ $item->distributer_zip }} {{ $item->distributer_mesto }}</td>                                         
                                        <td class="px-4 py-2">{{ $item->broj_ugovora }}</td>
                                        <td class="px-4 py-2">{{ App\Http\Helpers::datumFormatDan($item->datum_ugovora) }}</td>
                                        <td class="px-4 py-2">{{ App\Http\Helpers::datumFormatDan($item->datum_kraj_ugovora) }}</td>
                                        <td class="px-4 py-2">{{ $item->broj_licenci }}</td>
                                        <td>
                                            <x-jet-nav-link href="{{ route( 'distributer-licenca', ['id' => $item->id] ) }}" :active="request()->routeIs('distributer-licenca', ['id' => $item->id])" title="Dodaj / obriši licence">
                                            <svg class="fill-current w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M373.1,134.6L253.4,15.3C243.5,5.5,230.2,0,216.3,0H59C26.5,0,0,26.5,0,59v394c0,32.5,26.5,59,59,59h266 c32.5,0,59-26.5,59-59V160.9C384,151.1,380.1,141.6,373.1,134.6z M354.9,151.8h-61.5c-35.8,0-65-29.2-65-65v-59 c2.7,1.3,5.1,3.1,7.3,5.2L354.9,151.8z M359,453c0,9-3.6,17.5-10,24c-6.5,6.5-15,10-24,10H59c-9,0-17.5-3.6-24-10 c-6.5-6.5-10-15-10-24V59c0-9,3.6-17.5,10-24c6.5-6.5,15-10,24-10h144.4v61.8c0,49.6,40.4,90,90,90H359V453z"/><g><path d="M159.9,391.1h111.3v26.3h-141V197.8h29.7V391.1z"/></g></svg>
                                            </x-jet-nav-link>
                                        </td> 
                                        <td class="px-4 py-2">1024</td>
                                        <td class="px-2 py-2">
                                            <x-jet-nav-link href="{{ route( 'distributer-treminal', ['id' => $item->id] ) }}" :active="request()->routeIs('distributer-treminal', ['id' => $item->id])" title="Dodaj / ukloni terminale">
                                                <svg class="fill-current w-4 h-4" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 512 512"><g><path d="M422.4,254.5c-4.1-27.1-27.3-47.1-55.5-47.1H180v-27.7h69.2c15.3,0,27.7-12.4,27.7-27.7V96.7c0-15.3-12.4-27.7-27.7-27.7 H54.6c-14.5,0-27.7,12.4-27.7,27.7v55.4c0,15.3,13.2,27.7,27.7,27.7h69.2v27.7H75.3c-27.4,0-50.6,20-54.7,47.1L0.9,384 c-0.6,4.1-0.9,8.2-0.9,12.4v60.2C0,487.2,24.8,512,55.4,512h332.3c30.5,0,55.4-24.8,55.4-55.4v-60.2c0-4.2-0.3-8.3-1-12.4 L422.4,254.5z M346.1,255.9c11.5,0,20.8,9.3,20.8,20.8c0,11.5-9.3,20.8-20.8,20.8s-20.8-9.3-20.8-20.8 C325.3,265.1,334.6,255.9,346.1,255.9z M304.6,325.1c11.5,0,20.8,9.3,20.8,20.8c0,11.5-9.3,20.8-20.8,20.8s-20.8-9.3-20.8-20.8 C283.8,334.4,293.1,325.1,304.6,325.1z M263,255.9c11.5,0,20.8,9.3,20.8,20.8c0,11.5-9.3,20.8-20.8,20.8s-20.8-9.3-20.8-20.8 C242.3,265.1,251.5,255.9,263,255.9z M221.5,325.1c11.5,0,20.8,9.3,20.8,20.8c0,11.5-9.3,20.8-20.8,20.8s-20.8-9.3-20.8-20.8 C200.7,334.4,210,325.1,221.5,325.1z M200.7,276.7c0,11.5-9.3,20.8-20.8,20.8s-20.8-9.3-20.8-20.8c0-11.5,9.3-20.8,20.8-20.8 S200.7,265.1,200.7,276.7z M83.1,138.2c-7.6,0-13.8-6.2-13.8-13.8c0-7.6,6.2-13.8,13.8-13.8h138.4c7.6,0,13.8,6.2,13.8,13.8 c0,7.6-6.2,13.8-13.8,13.8H83.1z M138.4,325.1c11.5,0,20.8,9.3,20.8,20.8c0,11.5-9.3,20.8-20.8,20.8s-20.8-9.3-20.8-20.8 C117.7,334.4,126.9,325.1,138.4,325.1z M96.9,255.9c11.5,0,20.8,9.3,20.8,20.8c0,11.5-9.3,20.8-20.8,20.8 c-11.5,0-20.8-9.3-20.8-20.8C76.1,265.1,85.4,255.9,96.9,255.9z M373.8,456.6H69.2c-7.6,0-13.8-6.2-13.8-13.8 c0-7.6,6.2-13.8,13.8-13.8h304.6c7.6,0,13.8,6.2,13.8,13.8C387.6,450.4,381.4,456.6,373.8,456.6z"/><polygon points="437.3,75.2 437.3,0 386.8,0 386.8,75.2 311.6,75.2 311.6,125.7 386.8,125.7 386.8,200.9 437.3,200.9 437.3,125.7 512.5,125.7 512.5,75.2 "/></g></svg>
                                            </x-jet-nav-link>
                                        </td>                                     
                                        <td>
                                            <x-jet-secondary-button class="mx-2" wire:click="deleteShowModal({{ $item->id }})" title="Info">
                                                <svg class="fill-red-500 w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 128c17.67 0 32 14.33 32 32c0 17.67-14.33 32-32 32S224 177.7 224 160C224 142.3 238.3 128 256 128zM296 384h-80C202.8 384 192 373.3 192 360s10.75-24 24-24h16v-64H224c-13.25 0-24-10.75-24-24S210.8 224 224 224h32c13.25 0 24 10.75 24 24v88h16c13.25 0 24 10.75 24 24S309.3 384 296 384z"/></svg>
                                            </x-jet-button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else 
                                <tr>
                                    <td class="px-6 py-4 text-sm whitespace-no-wrap" colspan="4">No Results Found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-5">
    {{ $data->links() }}
    </div>

    {{-- Modal Form --}}
    <x-jet-dialog-modal wire:model="modalFormVisible">
        <x-slot name="title">
            @if ($isUpdate) {{ __('Izmeni podatke - ') }}{{ $d_naziv }}
            @else {{ __('Novi distributer') }} @endif
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <x-jet-label for="d_naziv" value="{{ __('Naziv') }}" />
                <x-jet-input wire:model="d_naziv" id="" class="block mt-1 w-full" type="text" />
                @error('d_naziv') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="d_adresa" value="{{ __('Adresa') }}" />
                <x-jet-input wire:model="d_adresa" id="" class="block mt-1 w-full" type="text" />
                @error('d_adresa') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="d_zip" value="{{ __('Poštanski broj') }}" />
                <x-jet-input wire:model="d_zip" id="" class="block mt-1 w-full" type="text" />
                @error('d_zip') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="d_mesto" value="{{ __('Mesto') }}" />
                <x-jet-input wire:model="d_mesto" id="" class="block mt-1 w-full" type="text" />
                @error('d_mesto') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="d_email" value="{{ __('E-mail adresa') }}" />
                <x-jet-input wire:model="d_email" id="" class="block mt-1 w-full" type="text" />
                @error('d_email') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="d_pib" value="{{ __('PIB') }}" />
                <x-jet-input wire:model="d_pib" id="" class="block mt-1 w-full" type="text" />
                @error('d_pib') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="d_mb" value="{{ __('Matični broj') }}" />
                <x-jet-input wire:model="d_mb" id="" class="block mt-1 w-full" type="text" />
                @error('d_mb') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="broj_ugovora" value="{{ __('Broj ugovora') }}" />
                <x-jet-input wire:model="broj_ugovora" id="" class="block mt-1 w-full" type="text" />
                @error('broj_ugovora') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="datum_ugovora" value="Datum ugovora" />
                <x-jet-input id="datum_ugovora" type="date" class="mt-1 block" value="{{ $datum_ugovora }}" wire:model.defer="datum_ugovora" />
                @error('datum_ugovora') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="datum_kraj_ugovora" value="Datum kraja ugovora" />
                <x-jet-input id="datum_kraj_ugovora" type="date" class="mt-1 block" value="{{ $datum_kraj_ugovora }}" wire:model.defer="datum_kraj_ugovora" />
                @error('datum_kraj_ugovora') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="dani_prekoracenja_licence" value="{{ __('Broj dana za prekoračenje licence') }}" />
                <x-jet-input wire:model="dani_prekoracenja_licence" type="date" id="" class="block mt-1 w-full" type="text" />
                @error('dani_prekoracenja_licence') <span class="error">{{ $message }}</span> @enderror
            </div>
            

        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                {{ __('Otkaži') }}
            </x-jet-secondary-button>

            @if ($isUpdate)
                <x-jet-button class="ml-2" wire:click="update" wire:loading.attr="disabled">
                    {{ __('Izmeni podatke') }}
                </x-jet-danger-button>
            @else
                <x-jet-button class="ml-2" wire:click="create" wire:loading.attr="disabled">
                    {{ __('Dodaj novog distributera') }}
                </x-jet-danger-button>
            @endif            
        </x-slot>
    </x-jet-dialog-modal>

    {{-- The Delete Modal --}}
    <x-jet-dialog-modal wire:model="modalConfirmDeleteVisible">
        <x-slot name="title">
            {{ __('Delete Modal Title') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete this item?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalConfirmDeleteVisible')" wire:loading.attr="disabled">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
                {{ __('Delete Item') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>