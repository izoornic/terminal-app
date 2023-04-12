<div class="p-6">
    <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6">
    <x-jet-button wire:click="createShowModal">
            <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM256 368C269.3 368 280 357.3 280 344V280H344C357.3 280 368 269.3 368 256C368 242.7 357.3 232 344 232H280V168C280 154.7 269.3 144 256 144C242.7 144 232 154.7 232 168V232H168C154.7 232 144 242.7 144 256C144 269.3 154.7 280 168 280H232V344C232 357.3 242.7 368 256 368z"/></svg>
            {{ __('Dodaj licencu') }}
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
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"></th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Naziv licence</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Opis</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Cena</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">                           
                            @if ($data->count())
                                @foreach ($data as $item)
                                    <tr>
                                        <td class="px-4 py-2">
                                            <x-jet-secondary-button class="btn btn-blue" wire:click="updateShowModal({{ $item->id }}, '{{ $item->licenca_naziv }}')" title="Izmeni podatke">
                                            <svg class="fill-current w-4 h-4 mr-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M373.1 24.97C401.2-3.147 446.8-3.147 474.9 24.97L487 37.09C515.1 65.21 515.1 110.8 487 138.9L289.8 336.2C281.1 344.8 270.4 351.1 258.6 354.5L158.6 383.1C150.2 385.5 141.2 383.1 135 376.1C128.9 370.8 126.5 361.8 128.9 353.4L157.5 253.4C160.9 241.6 167.2 230.9 175.8 222.2L373.1 24.97zM440.1 58.91C431.6 49.54 416.4 49.54 407 58.91L377.9 88L424 134.1L453.1 104.1C462.5 95.6 462.5 80.4 453.1 71.03L440.1 58.91zM203.7 266.6L186.9 325.1L245.4 308.3C249.4 307.2 252.9 305.1 255.8 302.2L390.1 168L344 121.9L209.8 256.2C206.9 259.1 204.8 262.6 203.7 266.6zM200 64C213.3 64 224 74.75 224 88C224 101.3 213.3 112 200 112H88C65.91 112 48 129.9 48 152V424C48 446.1 65.91 464 88 464H360C382.1 464 400 446.1 400 424V312C400 298.7 410.7 288 424 288C437.3 288 448 298.7 448 312V424C448 472.6 408.6 512 360 512H88C39.4 512 0 472.6 0 424V152C0 103.4 39.4 64 88 64H200z"/></svg>
                                            </x-jet-button>
                                        </td> 
                                        <td class="px-6 py-2">{{ $item->licenca_naziv }}</td>
                                        <td class="px-6 py-2">{{ $item->licenca_opis }}</td>
                                        <td class="px-6 py-2">{{ $item->licenca_cena }} EUR</td>                                         
                                        <td class="px-6 py-2 text-right">
                                            <x-jet-danger-button class="mx-2" wire:click="deleteShowModal({{ $item->id }}, '{{ $item->licenca_naziv }}')" title="Obriši lokaciju">
                                                <svg class="fill-current w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69zM31.1 128H416V448C416 483.3 387.3 512 352 512H95.1C60.65 512 31.1 483.3 31.1 448V128zM111.1 208V432C111.1 440.8 119.2 448 127.1 448C136.8 448 143.1 440.8 143.1 432V208C143.1 199.2 136.8 192 127.1 192C119.2 192 111.1 199.2 111.1 208zM207.1 208V432C207.1 440.8 215.2 448 223.1 448C232.8 448 240 440.8 240 432V208C240 199.2 232.8 192 223.1 192C215.2 192 207.1 199.2 207.1 208zM304 208V432C304 440.8 311.2 448 320 448C328.8 448 336 440.8 336 432V208C336 199.2 328.8 192 320 192C311.2 192 304 199.2 304 208z"/></svg>
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
            @if ($isUpdate) {{ __('Izmeni licencu') }}
            @else {{ __('Dodaj licencu') }} @endif
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
            @if ($isUpdate)
                <div class="">Licenca: <span class="font-bold">{{ $l_naziv }}</span></div>
            @else
                <x-jet-label for="licenca_tip_id" value="{{ __('Vrsta licence') }}" />
                <select wire:model="licenca_tip_id" id="" class="block appearance-none w-full bg-gray-100 border border-gray-200 text-gray-700 py-3 px-4 pr-8 round leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                    <option value=""> --- </option>
                    @if($this->prva_licenca)
                        @foreach (App\Models\LicencaDistributerCena::OstaleLicenceZaDistributera($distId) as $key => $value)
                            @if($key == 1)    
                            <option value="{{ $key }}">{{ $value }}</option>
                            @endif
                        @endforeach
                    @else
                        @foreach (App\Models\LicencaDistributerCena::OstaleLicenceZaDistributera($distId) as $key => $value)    
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    @endif
                </select>
                @error('licenca_tip_id') <span class="error">{{ $message }}</span> @enderror
            @endif
            </div>
            <div class="mt-4 flex">
                <div>
                    <x-jet-label for="licenca_cena" value="{{ __('Cena licence') }}" />
                    <x-jet-input wire:model="licenca_cena" id="" class="block mt-1 w-80" type="text" />
                    @error('licenca_cena') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="font-bold px-6 pt-8">EUR</div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                {{ __('Otkaži') }}
            </x-jet-secondary-button>

            @if ($isUpdate)
                <x-jet-button class="ml-2" wire:click="update" wire:loading.attr="disabled">
                    {{ __('Izmeni') }}
                </x-jet-danger-button>
            @else
                <x-jet-button class="ml-2" wire:click="create" wire:loading.attr="disabled">
                    {{ __('Dodaj licencu') }}
                </x-jet-danger-button>
            @endif            
        </x-slot>
    </x-jet-dialog-modal>

    {{-- The Delete Modal --}}
    <x-jet-dialog-modal wire:model="modalConfirmDeleteVisible">
        <x-slot name="title">
            {{ __('Brisanje licence') }}
        </x-slot>

        <x-slot name="content">
            <div class="py-4">Licenca: <span class="font-bold">{{ $l_naziv }}</span></div>
            <div class="font-bold text-red-500">{{ __('Da li ste sigurni da želite da obrišete licencu?') }}</div>
            @if($delete_error)
                <div class="bg-red-50 border border-red-500 text-red-500 px-4 py-3 rounded relative my-4 " role="alert">
                    <p class="">Greška!<br />
                    <span class="font-bold block sm:inline">{{ $delete_error_text }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg class="fill-red-500 h-6 w-6 " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M506.3 417l-213.3-364c-16.33-28-57.54-28-73.98 0l-213.2 364C-10.59 444.9 9.849 480 42.74 480h426.6C502.1 480 522.6 445 506.3 417zM232 168c0-13.25 10.75-24 24-24S280 154.8 280 168v128c0 13.25-10.75 24-23.1 24S232 309.3 232 296V168zM256 416c-17.36 0-31.44-14.08-31.44-31.44c0-17.36 14.07-31.44 31.44-31.44s31.44 14.08 31.44 31.44C287.4 401.9 273.4 416 256 416z"/></svg>
                    </span>
                    </p>
                </div>
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalConfirmDeleteVisible')" wire:loading.attr="disabled">
                {{ __('Otkaži') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
                {{ __('Obriši licencu') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>