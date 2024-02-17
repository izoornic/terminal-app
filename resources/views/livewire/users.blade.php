<div class="p-6">
    <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6">
        <x-jet-button wire:click="createShowModal" >
            <!--! CREATE NEW USER -->
        <svg class="fill-current w-4 h-4 mr-0 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M224 256c70.7 0 128-57.31 128-128S294.7 0 224 0C153.3 0 96 57.31 96 128S153.3 256 224 256zM274.7 304H173.3C77.61 304 0 381.6 0 477.3C0 496.5 15.52 512 34.66 512h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304zM616 200h-48v-48C568 138.8 557.3 128 544 128s-24 10.75-24 24v48h-48C458.8 200 448 210.8 448 224s10.75 24 24 24h48v48C520 309.3 530.8 320 544 320s24-10.75 24-24v-48h48C629.3 248 640 237.3 640 224S629.3 200 616 200z"/></svg>
        <span class="ml-4">Novi korisnik</span>    
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
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase"><button wire:click="$set('orderBy', 'uid')"><svg class="@if ($orderBy == 'uid') {{ 'fill-orange-600' }}  @else {{ 'fill-current' }} @endif w-4 h-4 mr-0 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M320 224H416c17.67 0 32-14.33 32-32s-14.33-32-32-32h-95.1c-17.67 0-32 14.33-32 32S302.3 224 320 224zM320 352H480c17.67 0 32-14.33 32-32s-14.33-32-32-32h-159.1c-17.67 0-32 14.33-32 32S302.3 352 320 352zM320 96h32c17.67 0 31.1-14.33 31.1-32s-14.33-32-31.1-32h-32c-17.67 0-32 14.33-32 32S302.3 96 320 96zM544 416h-223.1c-17.67 0-32 14.33-32 32s14.33 32 32 32H544c17.67 0 32-14.33 32-32S561.7 416 544 416zM192.4 330.7L160 366.1V64.03C160 46.33 145.7 32 128 32S96 46.33 96 64.03v302L63.6 330.7c-6.312-6.883-14.94-10.38-23.61-10.38c-7.719 0-15.47 2.781-21.61 8.414c-13.03 11.95-13.9 32.22-1.969 45.27l87.1 96.09c12.12 13.26 35.06 13.26 47.19 0l87.1-96.09c11.94-13.05 11.06-33.31-1.969-45.27C224.6 316.8 204.4 317.7 192.4 330.7z"/></svg></button></th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"><button wire:click="$set('orderBy', 'name')">IME <svg class="@if ($orderBy == 'name') {{ 'fill-orange-600' }}  @else {{ 'fill-current' }} @endif float-right w-4 h-4 mr-0 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M320 224H416c17.67 0 32-14.33 32-32s-14.33-32-32-32h-95.1c-17.67 0-32 14.33-32 32S302.3 224 320 224zM320 352H480c17.67 0 32-14.33 32-32s-14.33-32-32-32h-159.1c-17.67 0-32 14.33-32 32S302.3 352 320 352zM320 96h32c17.67 0 31.1-14.33 31.1-32s-14.33-32-31.1-32h-32c-17.67 0-32 14.33-32 32S302.3 96 320 96zM544 416h-223.1c-17.67 0-32 14.33-32 32s14.33 32 32 32H544c17.67 0 32-14.33 32-32S561.7 416 544 416zM192.4 330.7L160 366.1V64.03C160 46.33 145.7 32 128 32S96 46.33 96 64.03v302L63.6 330.7c-6.312-6.883-14.94-10.38-23.61-10.38c-7.719 0-15.47 2.781-21.61 8.414c-13.03 11.95-13.9 32.22-1.969 45.27l87.1 96.09c12.12 13.26 35.06 13.26 47.19 0l87.1-96.09c11.94-13.05 11.06-33.31-1.969-45.27C224.6 316.8 204.4 317.7 192.4 330.7z"/></svg></button></th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"><button wire:click="$set('orderBy', 'lokacija')">LOKACIJA <svg class="@if ($orderBy == 'lokacija') {{ 'fill-orange-600' }}  @else {{ 'fill-current' }} @endif float-right w-4 h-4 mr-0 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M320 224H416c17.67 0 32-14.33 32-32s-14.33-32-32-32h-95.1c-17.67 0-32 14.33-32 32S302.3 224 320 224zM320 352H480c17.67 0 32-14.33 32-32s-14.33-32-32-32h-159.1c-17.67 0-32 14.33-32 32S302.3 352 320 352zM320 96h32c17.67 0 31.1-14.33 31.1-32s-14.33-32-31.1-32h-32c-17.67 0-32 14.33-32 32S302.3 96 320 96zM544 416h-223.1c-17.67 0-32 14.33-32 32s14.33 32 32 32H544c17.67 0 32-14.33 32-32S561.7 416 544 416zM192.4 330.7L160 366.1V64.03C160 46.33 145.7 32 128 32S96 46.33 96 64.03v302L63.6 330.7c-6.312-6.883-14.94-10.38-23.61-10.38c-7.719 0-15.47 2.781-21.61 8.414c-13.03 11.95-13.9 32.22-1.969 45.27l87.1 96.09c12.12 13.26 35.06 13.26 47.19 0l87.1-96.09c11.94-13.05 11.06-33.31-1.969-45.27C224.6 316.8 204.4 317.7 192.4 330.7z"/></svg></button></th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Radni odnos</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"><button wire:click="$set('orderBy', 'pozicija')">POZICIJA <svg class="@if ($orderBy == 'pozicija') {{ 'fill-orange-600' }}  @else {{ 'fill-current' }} @endif float-right w-4 h-4 mr-0 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M320 224H416c17.67 0 32-14.33 32-32s-14.33-32-32-32h-95.1c-17.67 0-32 14.33-32 32S302.3 224 320 224zM320 352H480c17.67 0 32-14.33 32-32s-14.33-32-32-32h-159.1c-17.67 0-32 14.33-32 32S302.3 352 320 352zM320 96h32c17.67 0 31.1-14.33 31.1-32s-14.33-32-31.1-32h-32c-17.67 0-32 14.33-32 32S302.3 96 320 96zM544 416h-223.1c-17.67 0-32 14.33-32 32s14.33 32 32 32H544c17.67 0 32-14.33 32-32S561.7 416 544 416zM192.4 330.7L160 366.1V64.03C160 46.33 145.7 32 128 32S96 46.33 96 64.03v302L63.6 330.7c-6.312-6.883-14.94-10.38-23.61-10.38c-7.719 0-15.47 2.781-21.61 8.414c-13.03 11.95-13.9 32.22-1.969 45.27l87.1 96.09c12.12 13.26 35.06 13.26 47.19 0l87.1-96.09c11.94-13.05 11.06-33.31-1.969-45.27C224.6 316.8 204.4 317.7 192.4 330.7z"/></svg></button></th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"><button wire:click="$set('orderBy', 'status')">RADNI STATUS <svg class="@if ($orderBy == 'status') {{ 'fill-orange-600' }}  @else {{ 'fill-current' }} @endif float-right w-4 h-4 mr-0 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M320 224H416c17.67 0 32-14.33 32-32s-14.33-32-32-32h-95.1c-17.67 0-32 14.33-32 32S302.3 224 320 224zM320 352H480c17.67 0 32-14.33 32-32s-14.33-32-32-32h-159.1c-17.67 0-32 14.33-32 32S302.3 352 320 352zM320 96h32c17.67 0 31.1-14.33 31.1-32s-14.33-32-31.1-32h-32c-17.67 0-32 14.33-32 32S302.3 96 320 96zM544 416h-223.1c-17.67 0-32 14.33-32 32s14.33 32 32 32H544c17.67 0 32-14.33 32-32S561.7 416 544 416zM192.4 330.7L160 366.1V64.03C160 46.33 145.7 32 128 32S96 46.33 96 64.03v302L63.6 330.7c-6.312-6.883-14.94-10.38-23.61-10.38c-7.719 0-15.47 2.781-21.61 8.414c-13.03 11.95-13.9 32.22-1.969 45.27l87.1 96.09c12.12 13.26 35.06 13.26 47.19 0l87.1-96.09c11.94-13.05 11.06-33.31-1.969-45.27C224.6 316.8 204.4 317.7 192.4 330.7z"/></svg></button></th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">  
                            {{-- SEARCH ROW --}}
                            <tr class="bg-orange-50">
                                <td><svg class="mx-auto fill-orange-600 w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M3.853 54.87C10.47 40.9 24.54 32 40 32H472C487.5 32 501.5 40.9 508.1 54.87C514.8 68.84 512.7 85.37 502.1 97.33L320 320.9V448C320 460.1 313.2 471.2 302.3 476.6C291.5 482 278.5 480.9 268.8 473.6L204.8 425.6C196.7 419.6 192 410.1 192 400V320.9L9.042 97.33C-.745 85.37-2.765 68.84 3.854 54.87L3.853 54.87z"/></svg></td>
                                <td>
                                    <x-jet-input wire:model="searchName" id="" class="block bg-orange-50 w-full" type="text" placeholder="Pretrazi ime" />
                                </td>
                                <td>
                                    <select wire:model="searchLokacija" id="" class="block appearance-none bg-orange-50 w-full border border-0 text-gray-700 py-3 px-4 pr-8 round leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                            <option value="">---</option>
                                        @foreach (App\Models\Lokacija::userLokacijeList() as $key => $value)    
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td></td>
                                <td>
                                    <select wire:model="searchPozicija" id="" class="block appearance-none bg-orange-50 w-full border border-0 text-gray-700 py-3 px-4 pr-8 round leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                            <option value="">---</option>
                                        @foreach (App\Models\PozicijaTip::userRoleListAll() as $key => $value)    
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select wire:model="searchRStatus" id="" class="block appearance-none bg-orange-50 w-full border border-0 text-gray-700 py-3 px-4 pr-8 round leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                        <option value="">---</option>
                                        @foreach (App\Models\RadniStatusTip::userRadniStatusList() as $key => $value)    
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td></td>
                            </tr>
                        
                            @if ($data->count())
                                @foreach ($data as $item)
                                    <tr>
                                        <td class="px-6 py-2">
                                            @if($item->naziv != 'Obrisan')
                                            <x-jet-secondary-button class="btn btn-blue" wire:click="updateShowModal({{ $item->id }})">
                                            <svg class="fill-current w-4 h-4 mr-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M373.1 24.97C401.2-3.147 446.8-3.147 474.9 24.97L487 37.09C515.1 65.21 515.1 110.8 487 138.9L289.8 336.2C281.1 344.8 270.4 351.1 258.6 354.5L158.6 383.1C150.2 385.5 141.2 383.1 135 376.1C128.9 370.8 126.5 361.8 128.9 353.4L157.5 253.4C160.9 241.6 167.2 230.9 175.8 222.2L373.1 24.97zM440.1 58.91C431.6 49.54 416.4 49.54 407 58.91L377.9 88L424 134.1L453.1 104.1C462.5 95.6 462.5 80.4 453.1 71.03L440.1 58.91zM203.7 266.6L186.9 325.1L245.4 308.3C249.4 307.2 252.9 305.1 255.8 302.2L390.1 168L344 121.9L209.8 256.2C206.9 259.1 204.8 262.6 203.7 266.6zM200 64C213.3 64 224 74.75 224 88C224 101.3 213.3 112 200 112H88C65.91 112 48 129.9 48 152V424C48 446.1 65.91 464 88 464H360C382.1 464 400 446.1 400 424V312C400 298.7 410.7 288 424 288C437.3 288 448 298.7 448 312V424C448 472.6 408.6 512 360 512H88C39.4 512 0 472.6 0 424V152C0 103.4 39.4 64 88 64H200z"/></svg>
                                            </x-jet-button>
                                            @endif
                                        </td> 
                                        <td class="px-6 py-2">{{ $item->name }}</td>
                                        <td class="px-6 py-2">{{ $item->l_naziv }} - {{ $item->mesto }}</td> 
                                        <td class="px-6 py-2">{{ $item->ro_naziv }}</td>
                                        <td class="px-6 py-2">
                                            @if($item->naziv == 'Obrisan')
                                                <span class="text-red-600 font-bold"> {{ $item->naziv }}</span>
                                            @elseif($item->naziv == 'Distributer')
                                                <span class="text-sky-600"> {{ $item->naziv }}</span>
                                            @else
                                                {{ $item->naziv }}
                                            @endif
                                        </td>  
                                        
                                        <td class="px-6 py-2">
                                            @if($item->naziv == 'Obrisan' || $item->naziv == 'Distributer')
                                                ---
                                            @else
                                                <x-jet-secondary-button wire:click="updateShowRadniStatusModal({{ $item->id }})">
                                                    {{ $item->rs_naziv }}
                                                </x-jet-button></td> 
                                            @endif
                                        <td class="px-6 py-2 flex justify-end">
                                            @if($item->naziv != 'Obrisan')
                                                <x-jet-danger-button class="ml-2" wire:click="deleteShowModal({{ $item->id }})">
                                                <svg class="fill-current w-4 h-4 mr-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69zM31.1 128H416V448C416 483.3 387.3 512 352 512H95.1C60.65 512 31.1 483.3 31.1 448V128zM111.1 208V432C111.1 440.8 119.2 448 127.1 448C136.8 448 143.1 440.8 143.1 432V208C143.1 199.2 136.8 192 127.1 192C119.2 192 111.1 199.2 111.1 208zM207.1 208V432C207.1 440.8 215.2 448 223.1 448C232.8 448 240 440.8 240 432V208C240 199.2 232.8 192 223.1 192C215.2 192 207.1 199.2 207.1 208zM304 208V432C304 440.8 311.2 448 320 448C328.8 448 336 440.8 336 432V208C336 199.2 328.8 192 320 192C311.2 192 304 199.2 304 208z"/></svg>
                                                </x-jet-button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else 
                                <tr>
                                    <td class="px-6 py-4 text-sm whitespace-no-wrap" colspan="7">No Results Found</td>
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
           @if ($modelId) {{ __('Izmeni podatke') }}
           @else {{ __('Novi korisnik') }} @endif
        </x-slot>
        <x-slot name="content">
            <div class="mt-4">
                <x-jet-label for="name" value="{{ __('Ime') }}" />
                <x-jet-input wire:model="name" id="" class="block mt-1 w-full" type="text" />
                @error('name') <span class="error">{{ $message }}</span> @enderror
            </div>  
            @if (!$modelId) 
                <div class="mt-4">
                    <x-jet-label for="email" value="{{ __('E-mail') }}" />
                    <x-jet-input wire:model="email" id="" class="block mt-1 w-full" type="text" />
                    @error('email') <span class="error">{{ $message }}</span> @enderror
                </div>  

                <div class="mt-4">
                    <x-jet-label for="password" value="{{ __('Password') }}" />
                    <x-jet-input wire:model="password" id="" class="block mt-1 w-full" type="text" />
                    @error('password') <span class="error">{{ $message }}</span> @enderror
                </div>  

            @else
                <br />
                <x-jet-label value="{{ $email }}" />
            @endif

            <div class="mt-4">
                <x-jet-label for="telegramId" value="{{ __('Telegram ID') }}" />
                <x-jet-input wire:model="telegramId" id="" class="block mt-1 w-full" type="text" />
                @error('telegramId') <span class="error">{{ $message }}</span> @enderror
            </div> 
            <div class="mt-4">
                <x-jet-label for="tel" value="{{ __('Broj telefona') }}" />
               <div class="mt-4 flex rounded-md shadow-sm">
               
                  <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-m">
                     +381
                  </span>
                  <input wire:model="tel" class="form-input flex-1 block w-full rounded-none rounded-r-md transition duration-150 ease-in-out sm:text-sm sm:leading-5" >
                  @error('tel') <span class="error">{{ $message }}</span>@enderror
               </div>
            </div> 
                 
            <div class="mt-4">
                @if($modelId && $pozicijaId == 8)
                    <label>Pozicija</label>
                    <div class="bg-gray-100 mb-2 border-b-4 border-black-200 p-1.5">
                        <p class="font-bold">Distributer</p>
                    </div>
                @else
                    <x-jet-label for="pozicijaId" value="{{ __('Pozicija') }}" />
                    <select wire:model="pozicijaId" id="pozicija" class="block appearance-none w-full bg-gray-100 border border-gray-200 text-gray-700 py-3 px-4 pr-8 round leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                            <option value="">-- Odaberi poziciju -- </option>
                        @foreach (App\Models\PozicijaTip::userRoleList() as $key => $value)    
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    @error('pozicijaId') <span class="error">{{ $message }}</span> @enderror
                @endif
            </div>
            <br />
            
            <div class="mt-4">

            @if($pozicijaId == 8)
            @php
                $radniOdnosId = 3;
            @endphp
            <label> Lokacija: </label>
            @if(!$lokacijaId)
                {{-- Novi korisnik je Ditributer  --}}

                <table class="min-w-full divide-y divide-gray-200 mt-4" style="width: 100% !important">
                    <thead>
                        <tr>
                            <th class="px-3 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"></th>
                            <th class="px-3 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Naziv</th> 
                            <th class="px-3 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Mesto</th> 
                            <th class="px-3 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Region</th> 
                            <th class="px-3 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"></th>  
                        </tr>
                        <tr class="bg-orange-50">
                            <td><svg class="mx-auto fill-orange-600 w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M3.853 54.87C10.47 40.9 24.54 32 40 32H472C487.5 32 501.5 40.9 508.1 54.87C514.8 68.84 512.7 85.37 502.1 97.33L320 320.9V448C320 460.1 313.2 471.2 302.3 476.6C291.5 482 278.5 480.9 268.8 473.6L204.8 425.6C196.7 419.6 192 410.1 192 400V320.9L9.042 97.33C-.745 85.37-2.765 68.84 3.854 54.87L3.853 54.87z"/></svg></td>
                            <td><x-jet-input wire:model="searchPLokacijaNaziv" id="" class="block bg-orange-50 w-full" type="text" placeholder="Naziv" /></td>
                            <td><x-jet-input wire:model="searchPlokacijaMesto" id="" class="block bg-orange-50 w-full" type="text" placeholder="Mesto" /></td>
                            <td>
                                    <select wire:model="searchPlokacijaRegion" id="" class="block appearance-none bg-orange-50 w-full border border-0 text-gray-700 py-3 px-4 pr-8 round leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                            <option value="">---</option>
                                        @foreach (App\Models\Region::regioni() as $key => $value)    
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                </select>
                            </td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200"> 
                    @foreach ($this->lokacijeTipa() as $value)
                    <tr class="hover:bg-gray-100" wire:click="$set('lokacijaId', {{ $value->id }})" >    
                            <td></td>
                            <td>{{ $value->l_naziv }}</td>
                            <td>{{ $value->mesto}}</td>
                            <td>{{ $value->r_naziv}}</td>
                            <td></td>
                    </tr>
                    @endforeach
                    </tbody>
                <table>
                <div class="mt-5">
                    {{ $this->lokacijeTipa()->links() }}
                </div>
                @else
                    {{-- IZABRAO LOKACIJU MENJAM PRIKAZ --}}
                    <div class="bg-gray-100 mb-2 border-b-4 border-black-200 p-1.5">
                        <p class="font-bold">{{ $this->izabranaLokacija()->l_naziv}}, {{ $this->izabranaLokacija()->mesto }}</p>
                        <p class="text-sm">Region: {{ $this->izabranaLokacija()->r_naziv }}</p>
                        <p>&nbsp;</p>
                        <p>Distributer:</p>
                        <p class="font-bold">{{ $this->izabranaLokacija()->distributer_naziv}}</p>
                        <p class="text-sm">Mesto: {{ $this->izabranaLokacija()->distributer_mesto }}</p>
                    </div>
                    @if(!$this->izabranaLokacija()->distId)
                    <div class="bg-red-50 border border-red-500 text-red-500 px-4 py-3 rounded relative my-4 " role="alert">
                        <p class="">UPOZORENJE!<br />
                            <span class="font-bold block sm:inline">Korisnik neće biti sačuvan!</span>
                            <span><br />Lokacija koju ste izabrali nije povezana sa Distributerom! <br />Pre dodavanja korisnika potrebno je da Menadžer licenci poveže lokaciju sa Distributerom!  </span>
                        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                            <svg class="fill-red-500 h-6 w-6 " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M506.3 417l-213.3-364c-16.33-28-57.54-28-73.98 0l-213.2 364C-10.59 444.9 9.849 480 42.74 480h426.6C502.1 480 522.6 445 506.3 417zM232 168c0-13.25 10.75-24 24-24S280 154.8 280 168v128c0 13.25-10.75 24-23.1 24S232 309.3 232 296V168zM256 416c-17.36 0-31.44-14.08-31.44-31.44c0-17.36 14.07-31.44 31.44-31.44s31.44 14.08 31.44 31.44C287.4 401.9 273.4 416 256 416z"/></svg>
                        </span>
                        </p>
                    </div>
                    @endif
                    <p>&nbsp;</p>

                @endif
            @else
                <x-jet-label for="lokacijaId" value="{{ __('Lokacija') }}" />
                <select wire:model="lokacijaId" id="lokacija" class="block appearance-none w-full bg-gray-100 border border-gray-200 text-gray-700 py-3 px-4 pr-8 round leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                        <option value="">-- Odaberi lokaciju -- </option>
                    @foreach (App\Models\Lokacija::userLokacijeList() as $key => $value)    
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
                @error('lokacijaId') <span class="error">{{ $message }}</span> @enderror
            @endif
            </div>
            <br />
            @if($pozicijaId != 8)
            <div class="mt-4">
                <x-jet-label for="radniOdnosId" value="{{ __('Radni odnos') }}" />
                <select wire:model="radniOdnosId" id="radniodnos" class="block appearance-none w-full bg-gray-100 border border-gray-200 text-gray-700 py-3 px-4 pr-8 round leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                        <option value="">-- Odaberi radni odnos -- {{ $radniOdnosId }}</option>
                    @foreach (App\Models\RadniOdnosTip::userRadniOdnosList() as $key => $value)    
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
                @error('radniOdnosId') <span class="error">{{ $message }}</span> @enderror
            </div> 
            @endif   
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                {{ __('Otkaži') }}
            </x-jet-secondary-button>

            @if ($modelId)
                <x-jet-button class="ml-2" wire:click="update" wire:loading.attr="disabled">
                    {{ __('Update') }}
                </x-jet-danger-button>
            @else
                <x-jet-button class="ml-2" wire:click="create" wire:loading.attr="disabled">
                    {{ __('Sačuvaj') }}
                </x-jet-danger-button>
            @endif            
        </x-slot>
    </x-jet-dialog-modal>

    {{-- Modal Form Radni Srtatus --}}
    <x-jet-dialog-modal wire:model="modalRadniStatusVisible">
        <x-slot name="title">
            <svg class="float-left fill-current w-4 h-4 mr-0 mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M224 256c70.7 0 128-57.31 128-128s-57.3-128-128-128C153.3 0 96 57.31 96 128S153.3 256 224 256zM274.7 304H173.3C77.61 304 0 381.6 0 477.3c0 19.14 15.52 34.67 34.66 34.67h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304z"/></svg> 
            <span class="ml-4">{{ $name }}</span>
            <br />
        </x-slot>
        <x-slot name="content">          
            <div class="mt-4">
                <x-jet-label for="radniStatusId" value="{{ __('Radni status') }}" />
                <select wire:model="radniStatusId" id="" class="block appearance-none w-full bg-gray-100 border border-gray-200 text-gray-700 py-3 px-4 pr-8 round leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                    @foreach (App\Models\RadniStatusTip::userRadniStatusList() as $key => $value)    
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
                @error('radniStatusId') <span class="error">{{ $message }}</span> @enderror
            </div>      
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalRadniStatusVisible')" wire:loading.attr="disabled">
                {{ __('Otkaži') }}
            </x-jet-secondary-button>
            <x-jet-button class="ml-2" wire:click="updateRadniStatus" wire:loading.attr="disabled">
                {{ __('Sačuvaj') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>

    {{-- The Delete Modal --}}
    <x-jet-dialog-modal wire:model="modalConfirmDeleteVisible">
        <x-slot name="title">
        <svg class="float-left fill-red-700 w-4 h-4 mr-2 mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) --><path d="M569.517 440.013C587.975 472.007 564.806 512 527.94 512H48.054c-36.937 0-59.999-40.055-41.577-71.987L246.423 23.985c18.467-32.009 64.72-31.951 83.154 0l239.94 416.028zM288 354c-25.405 0-46 20.595-46 46s20.595 46 46 46 46-20.595 46-46-20.595-46-46-46zm-43.673-165.346l7.418 136c.347 6.364 5.609 11.346 11.982 11.346h48.546c6.373 0 11.635-4.982 11.982-11.346l7.418-136c.375-6.874-5.098-12.654-11.982-12.654h-63.383c-6.884 0-12.356 5.78-11.981 12.654z"/></svg>
            {{ __('Obriši korisnika - ') }}{{ $name }}
        </x-slot>

        <x-slot name="content">
            {{ __('Da li ste sigurni da želite da obrišete ovog korisnika?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalConfirmDeleteVisible')" wire:loading.attr="disabled">
                {{ __('Otkaži') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
                {{ __('Obriši korisnika') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>