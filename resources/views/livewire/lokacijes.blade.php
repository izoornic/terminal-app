<div class="p-6">
    <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6">
        <x-jet-button wire:click="createShowModal">
        <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM256 368C269.3 368 280 357.3 280 344V280H344C357.3 280 368 269.3 368 256C368 242.7 357.3 232 344 232H280V168C280 154.7 269.3 144 256 144C242.7 144 232 154.7 232 168V232H168C154.7 232 144 242.7 144 256C144 269.3 154.7 280 168 280H232V344C232 357.3 242.7 368 256 368z"/></svg>
        {{ __('Nova Lokacija') }}
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
                                        <button wire:click="$set('orderBy', 'uid')"><svg class="@if ($orderBy == 'uid') {{ 'fill-orange-600' }}  @else {{ 'fill-current' }} @endif w-4 h-4 mr-0 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M320 224H416c17.67 0 32-14.33 32-32s-14.33-32-32-32h-95.1c-17.67 0-32 14.33-32 32S302.3 224 320 224zM320 352H480c17.67 0 32-14.33 32-32s-14.33-32-32-32h-159.1c-17.67 0-32 14.33-32 32S302.3 352 320 352zM320 96h32c17.67 0 31.1-14.33 31.1-32s-14.33-32-31.1-32h-32c-17.67 0-32 14.33-32 32S302.3 96 320 96zM544 416h-223.1c-17.67 0-32 14.33-32 32s14.33 32 32 32H544c17.67 0 32-14.33 32-32S561.7 416 544 416zM192.4 330.7L160 366.1V64.03C160 46.33 145.7 32 128 32S96 46.33 96 64.03v302L63.6 330.7c-6.312-6.883-14.94-10.38-23.61-10.38c-7.719 0-15.47 2.781-21.61 8.414c-13.03 11.95-13.9 32.22-1.969 45.27l87.1 96.09c12.12 13.26 35.06 13.26 47.19 0l87.1-96.09c11.94-13.05 11.06-33.31-1.969-45.27C224.6 316.8 204.4 317.7 192.4 330.7z"/></svg></button>
                                </th>
                                <th class="bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase"></th>
                                <th class="bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase"></th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    <button wire:click="$set('orderBy', 'name')">NAZIV <svg class="@if ($orderBy == 'name') {{ 'fill-orange-600' }}  @else {{ 'fill-current' }} @endif float-right w-4 h-4 mr-0 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M320 224H416c17.67 0 32-14.33 32-32s-14.33-32-32-32h-95.1c-17.67 0-32 14.33-32 32S302.3 224 320 224zM320 352H480c17.67 0 32-14.33 32-32s-14.33-32-32-32h-159.1c-17.67 0-32 14.33-32 32S302.3 352 320 352zM320 96h32c17.67 0 31.1-14.33 31.1-32s-14.33-32-31.1-32h-32c-17.67 0-32 14.33-32 32S302.3 96 320 96zM544 416h-223.1c-17.67 0-32 14.33-32 32s14.33 32 32 32H544c17.67 0 32-14.33 32-32S561.7 416 544 416zM192.4 330.7L160 366.1V64.03C160 46.33 145.7 32 128 32S96 46.33 96 64.03v302L63.6 330.7c-6.312-6.883-14.94-10.38-23.61-10.38c-7.719 0-15.47 2.781-21.61 8.414c-13.03 11.95-13.9 32.22-1.969 45.27l87.1 96.09c12.12 13.26 35.06 13.26 47.19 0l87.1-96.09c11.94-13.05 11.06-33.31-1.969-45.27C224.6 316.8 204.4 317.7 192.4 330.7z"/></svg></button>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    <button wire:click="$set('orderBy', 'mesto')">MESTO <svg class="@if ($orderBy == 'mesto') {{ 'fill-orange-600' }}  @else {{ 'fill-current' }} @endif float-right w-4 h-4 mr-0 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M320 224H416c17.67 0 32-14.33 32-32s-14.33-32-32-32h-95.1c-17.67 0-32 14.33-32 32S302.3 224 320 224zM320 352H480c17.67 0 32-14.33 32-32s-14.33-32-32-32h-159.1c-17.67 0-32 14.33-32 32S302.3 352 320 352zM320 96h32c17.67 0 31.1-14.33 31.1-32s-14.33-32-31.1-32h-32c-17.67 0-32 14.33-32 32S302.3 96 320 96zM544 416h-223.1c-17.67 0-32 14.33-32 32s14.33 32 32 32H544c17.67 0 32-14.33 32-32S561.7 416 544 416zM192.4 330.7L160 366.1V64.03C160 46.33 145.7 32 128 32S96 46.33 96 64.03v302L63.6 330.7c-6.312-6.883-14.94-10.38-23.61-10.38c-7.719 0-15.47 2.781-21.61 8.414c-13.03 11.95-13.9 32.22-1.969 45.27l87.1 96.09c12.12 13.26 35.06 13.26 47.19 0l87.1-96.09c11.94-13.05 11.06-33.31-1.969-45.27C224.6 316.8 204.4 317.7 192.4 330.7z"/></svg></button>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"> 
                                    <button wire:click="$set('orderBy', 'region')">REGION <svg class="@if ($orderBy == 'region') {{ 'fill-orange-600' }}  @else {{ 'fill-current' }} @endif float-right w-4 h-4 mr-0 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M320 224H416c17.67 0 32-14.33 32-32s-14.33-32-32-32h-95.1c-17.67 0-32 14.33-32 32S302.3 224 320 224zM320 352H480c17.67 0 32-14.33 32-32s-14.33-32-32-32h-159.1c-17.67 0-32 14.33-32 32S302.3 352 320 352zM320 96h32c17.67 0 31.1-14.33 31.1-32s-14.33-32-31.1-32h-32c-17.67 0-32 14.33-32 32S302.3 96 320 96zM544 416h-223.1c-17.67 0-32 14.33-32 32s14.33 32 32 32H544c17.67 0 32-14.33 32-32S561.7 416 544 416zM192.4 330.7L160 366.1V64.03C160 46.33 145.7 32 128 32S96 46.33 96 64.03v302L63.6 330.7c-6.312-6.883-14.94-10.38-23.61-10.38c-7.719 0-15.47 2.781-21.61 8.414c-13.03 11.95-13.9 32.22-1.969 45.27l87.1 96.09c12.12 13.26 35.06 13.26 47.19 0l87.1-96.09c11.94-13.05 11.06-33.31-1.969-45.27C224.6 316.8 204.4 317.7 192.4 330.7z"/></svg></button>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    <button wire:click="$set('orderBy', 'tip')">TIP <svg class="@if ($orderBy == 'tip') {{ 'fill-orange-600' }}  @else {{ 'fill-current' }} @endif float-right w-4 h-4 mr-0 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M320 224H416c17.67 0 32-14.33 32-32s-14.33-32-32-32h-95.1c-17.67 0-32 14.33-32 32S302.3 224 320 224zM320 352H480c17.67 0 32-14.33 32-32s-14.33-32-32-32h-159.1c-17.67 0-32 14.33-32 32S302.3 352 320 352zM320 96h32c17.67 0 31.1-14.33 31.1-32s-14.33-32-31.1-32h-32c-17.67 0-32 14.33-32 32S302.3 96 320 96zM544 416h-223.1c-17.67 0-32 14.33-32 32s14.33 32 32 32H544c17.67 0 32-14.33 32-32S561.7 416 544 416zM192.4 330.7L160 366.1V64.03C160 46.33 145.7 32 128 32S96 46.33 96 64.03v302L63.6 330.7c-6.312-6.883-14.94-10.38-23.61-10.38c-7.719 0-15.47 2.781-21.61 8.414c-13.03 11.95-13.9 32.22-1.969 45.27l87.1 96.09c12.12 13.26 35.06 13.26 47.19 0l87.1-96.09c11.94-13.05 11.06-33.31-1.969-45.27C224.6 316.8 204.4 317.7 192.4 330.7z"/></svg></button>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"></th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"></th>
                                <th class="bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase"></th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">  
                            {{-- SEARCH ROW --}}
                            <tr class="bg-orange-50">
                                <td><svg class="mx-auto fill-orange-600 w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M3.853 54.87C10.47 40.9 24.54 32 40 32H472C487.5 32 501.5 40.9 508.1 54.87C514.8 68.84 512.7 85.37 502.1 97.33L320 320.9V448C320 460.1 313.2 471.2 302.3 476.6C291.5 482 278.5 480.9 268.8 473.6L204.8 425.6C196.7 419.6 192 410.1 192 400V320.9L9.042 97.33C-.745 85.37-2.765 68.84 3.854 54.87L3.853 54.87z"/></svg></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <x-jet-input wire:model="searchName" id="" class="block bg-orange-50 w-full" type="text" placeholder="Pretrazi ime" />
                                </td>
                                <td>
                                    <x-jet-input wire:model="searchMesto" id="" class="block bg-orange-50 w-full" type="text" placeholder="Pretrazi mesto" />
                                </td>
                                <td>
                                    <select wire:model="searchRegion" id="" class="block appearance-none bg-orange-50 w-full border border-0 text-gray-700 py-3 px-4 pr-8 round leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                                <option value="">---</option>
                                            @foreach (App\Models\Region::regioni() as $key => $value)    
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select wire:model="searchTip" id="" class="block appearance-none bg-orange-50 w-full border border-0 text-gray-700 py-3 px-4 pr-8 round leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                        <option value="">---</option>
                                        @foreach (App\Models\LokacijaTip::tipoviList() as $key => $value)    
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @if ($data->count())
                                @foreach ($data as $item)
                                    <tr>
                                        <td class="px-4 py-2">
                                            <x-jet-secondary-button class="btn btn-blue" wire:click="updateShowModal({{ $item->id }})">
                                            <svg class="fill-current w-4 h-4 mr-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M373.1 24.97C401.2-3.147 446.8-3.147 474.9 24.97L487 37.09C515.1 65.21 515.1 110.8 487 138.9L289.8 336.2C281.1 344.8 270.4 351.1 258.6 354.5L158.6 383.1C150.2 385.5 141.2 383.1 135 376.1C128.9 370.8 126.5 361.8 128.9 353.4L157.5 253.4C160.9 241.6 167.2 230.9 175.8 222.2L373.1 24.97zM440.1 58.91C431.6 49.54 416.4 49.54 407 58.91L377.9 88L424 134.1L453.1 104.1C462.5 95.6 462.5 80.4 453.1 71.03L440.1 58.91zM203.7 266.6L186.9 325.1L245.4 308.3C249.4 307.2 252.9 305.1 255.8 302.2L390.1 168L344 121.9L209.8 256.2C206.9 259.1 204.8 262.6 203.7 266.6zM200 64C213.3 64 224 74.75 224 88C224 101.3 213.3 112 200 112H88C65.91 112 48 129.9 48 152V424C48 446.1 65.91 464 88 464H360C382.1 464 400 446.1 400 424V312C400 298.7 410.7 288 424 288C437.3 288 448 298.7 448 312V424C448 472.6 408.6 512 360 512H88C39.4 512 0 472.6 0 424V152C0 103.4 39.4 64 88 64H200z"/></svg>
                                            </x-jet-button>
                                        </td> 
                                        <td>@if($item->ima_user) <svg class="fill-gray-500 w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M224 256c70.7 0 128-57.31 128-128s-57.3-128-128-128C153.3 0 96 57.31 96 128S153.3 256 224 256zM274.7 304H173.3C77.61 304 0 381.6 0 477.3c0 19.14 15.52 34.67 34.66 34.67h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304z"/></svg> @endif</td>

                                        <td>@if($item->ima_terminala) <svg class="fill-gray-500 w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M288 0C305.7 0 320 14.33 320 32V96C320 113.7 305.7 128 288 128H208V160H424.1C456.6 160 483.5 183.1 488.2 214.4L510.9 364.1C511.6 368.8 512 373.6 512 378.4V448C512 483.3 483.3 512 448 512H64C28.65 512 0 483.3 0 448V378.4C0 373.6 .3622 368.8 1.083 364.1L23.76 214.4C28.5 183.1 55.39 160 87.03 160H143.1V128H63.1C46.33 128 31.1 113.7 31.1 96V32C31.1 14.33 46.33 0 63.1 0L288 0zM96 48C87.16 48 80 55.16 80 64C80 72.84 87.16 80 96 80H256C264.8 80 272 72.84 272 64C272 55.16 264.8 48 256 48H96zM80 448H432C440.8 448 448 440.8 448 432C448 423.2 440.8 416 432 416H80C71.16 416 64 423.2 64 432C64 440.8 71.16 448 80 448zM112 216C98.75 216 88 226.7 88 240C88 253.3 98.75 264 112 264C125.3 264 136 253.3 136 240C136 226.7 125.3 216 112 216zM208 264C221.3 264 232 253.3 232 240C232 226.7 221.3 216 208 216C194.7 216 184 226.7 184 240C184 253.3 194.7 264 208 264zM160 296C146.7 296 136 306.7 136 320C136 333.3 146.7 344 160 344C173.3 344 184 333.3 184 320C184 306.7 173.3 296 160 296zM304 264C317.3 264 328 253.3 328 240C328 226.7 317.3 216 304 216C290.7 216 280 226.7 280 240C280 253.3 290.7 264 304 264zM256 296C242.7 296 232 306.7 232 320C232 333.3 242.7 344 256 344C269.3 344 280 333.3 280 320C280 306.7 269.3 296 256 296zM400 264C413.3 264 424 253.3 424 240C424 226.7 413.3 216 400 216C386.7 216 376 226.7 376 240C376 253.3 386.7 264 400 264zM352 296C338.7 296 328 306.7 328 320C328 333.3 338.7 344 352 344C365.3 344 376 333.3 376 320C376 306.7 365.3 296 352 296z"/></svg> @endif</td>
                                        <td class="px-4 py-2">{{ $item->l_naziv }}</td>
                                        <td class="px-4 py-2">{{ $item->mesto }}</td>
                                        <td class="px-4 py-2">{{ $item->r_naziv }}</td> 
                                        <td class="px-4 py-2">{{ $item->lt_naziv }}</td> 
                                        <td class="px-2 py-2">
                                            @if($item->kontakt)
                                            <x-jet-secondary-button wire:click="showKontaktOsobaModal({{ $item->id }})" title="Kontakt osoba">
                                                <svg class="fill-current w-6 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 448"><defs><style>.a{fill:#fff;}</style></defs><path d="M512,0H64A64,64,0,0,0,0,64V384a64,64,0,0,0,64,64H512a64,64,0,0,0,64-64V64A64,64,0,0,0,512,0Z"/><circle class="a" cx="186.65" cy="137.79" r="86.21"/><path class="a" d="M382.28,317.58h133a25,25,0,0,0,24.94-24.94V76.51a25,25,0,0,0-24.94-24.94h-133a24.94,24.94,0,0,0-24.93,24.94V292.64A24.94,24.94,0,0,0,382.28,317.58Zm83.13-24.94H431.69c-4.1,0-7.84-3.74-7.84-8.31a8.34,8.34,0,0,1,8.31-8.32h33.25c4.57,0,8.31,3.74,8.31,7.85A8.45,8.45,0,0,1,465.41,292.64ZM390.6,84.82H507V251.08H390.6Z"/><path class="a" d="M57.33,396.43H316a21.61,21.61,0,0,0,21.55-21.55A107.77,107.77,0,0,0,229.76,267.11H143.54A107.76,107.76,0,0,0,35.77,374.88,21.59,21.59,0,0,0,57.33,396.43Z"/></svg>
                                            </x-jet-button>
                                            @endif
                                        </td>

                                        <td class="px-2 py-2">@if($item->latitude != '' && $item->longitude != '') <a href="{{ app\Http\Livewire\Lokacijes::createGmapLink($item->latitude, $item->longitude) }}" target="_blank"> <svg class="fill-sky-800 w-4 h-4 mx-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M408 120C408 174.6 334.9 271.9 302.8 311.1C295.1 321.6 280.9 321.6 273.2 311.1C241.1 271.9 168 174.6 168 120C168 53.73 221.7 0 288 0C354.3 0 408 53.73 408 120zM288 152C310.1 152 328 134.1 328 112C328 89.91 310.1 72 288 72C265.9 72 248 89.91 248 112C248 134.1 265.9 152 288 152zM425.6 179.8C426.1 178.6 426.6 177.4 427.1 176.1L543.1 129.7C558.9 123.4 576 135 576 152V422.8C576 432.6 570 441.4 560.9 445.1L416 503V200.4C419.5 193.5 422.7 186.7 425.6 179.8zM150.4 179.8C153.3 186.7 156.5 193.5 160 200.4V451.8L32.91 502.7C17.15 508.1 0 497.4 0 480.4V209.6C0 199.8 5.975 190.1 15.09 187.3L137.6 138.3C140 152.5 144.9 166.6 150.4 179.8H150.4zM327.8 331.1C341.7 314.6 363.5 286.3 384 255V504.3L192 449.4V255C212.5 286.3 234.3 314.6 248.2 331.1C268.7 357.6 307.3 357.6 327.8 331.1L327.8 331.1z"/></svg></a> @endif</td>  
                                        <td>
                                            <x-jet-secondary-button wire:click="addTerminalShowModal({{ $item->id }})" title="Dodaj terminale na lokaciju">
                                            <svg class="fill-current w-4 h-4" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 512 512"><g><path d="M422.4,254.5c-4.1-27.1-27.3-47.1-55.5-47.1H180v-27.7h69.2c15.3,0,27.7-12.4,27.7-27.7V96.7c0-15.3-12.4-27.7-27.7-27.7 H54.6c-14.5,0-27.7,12.4-27.7,27.7v55.4c0,15.3,13.2,27.7,27.7,27.7h69.2v27.7H75.3c-27.4,0-50.6,20-54.7,47.1L0.9,384 c-0.6,4.1-0.9,8.2-0.9,12.4v60.2C0,487.2,24.8,512,55.4,512h332.3c30.5,0,55.4-24.8,55.4-55.4v-60.2c0-4.2-0.3-8.3-1-12.4 L422.4,254.5z M346.1,255.9c11.5,0,20.8,9.3,20.8,20.8c0,11.5-9.3,20.8-20.8,20.8s-20.8-9.3-20.8-20.8 C325.3,265.1,334.6,255.9,346.1,255.9z M304.6,325.1c11.5,0,20.8,9.3,20.8,20.8c0,11.5-9.3,20.8-20.8,20.8s-20.8-9.3-20.8-20.8 C283.8,334.4,293.1,325.1,304.6,325.1z M263,255.9c11.5,0,20.8,9.3,20.8,20.8c0,11.5-9.3,20.8-20.8,20.8s-20.8-9.3-20.8-20.8 C242.3,265.1,251.5,255.9,263,255.9z M221.5,325.1c11.5,0,20.8,9.3,20.8,20.8c0,11.5-9.3,20.8-20.8,20.8s-20.8-9.3-20.8-20.8 C200.7,334.4,210,325.1,221.5,325.1z M200.7,276.7c0,11.5-9.3,20.8-20.8,20.8s-20.8-9.3-20.8-20.8c0-11.5,9.3-20.8,20.8-20.8 S200.7,265.1,200.7,276.7z M83.1,138.2c-7.6,0-13.8-6.2-13.8-13.8c0-7.6,6.2-13.8,13.8-13.8h138.4c7.6,0,13.8,6.2,13.8,13.8 c0,7.6-6.2,13.8-13.8,13.8H83.1z M138.4,325.1c11.5,0,20.8,9.3,20.8,20.8c0,11.5-9.3,20.8-20.8,20.8s-20.8-9.3-20.8-20.8 C117.7,334.4,126.9,325.1,138.4,325.1z M96.9,255.9c11.5,0,20.8,9.3,20.8,20.8c0,11.5-9.3,20.8-20.8,20.8 c-11.5,0-20.8-9.3-20.8-20.8C76.1,265.1,85.4,255.9,96.9,255.9z M373.8,456.6H69.2c-7.6,0-13.8-6.2-13.8-13.8 c0-7.6,6.2-13.8,13.8-13.8h304.6c7.6,0,13.8,6.2,13.8,13.8C387.6,450.4,381.4,456.6,373.8,456.6z"/><polygon points="437.3,75.2 437.3,0 386.8,0 386.8,75.2 311.6,75.2 311.6,125.7 386.8,125.7 386.8,200.9 437.3,200.9 437.3,125.7 512.5,125.7 512.5,75.2 "/></g></svg>
                                            </x-jet-button>
                                        </td>                                     
                                        <td>
                                            @if($item->ima_user || $item->ima_terminala)
                                                <x-jet-secondary-button class="mx-2" wire:click="deleteShowModal({{ $item->id }})" title="Info">
                                                    <svg class="fill-red-500 w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 128c17.67 0 32 14.33 32 32c0 17.67-14.33 32-32 32S224 177.7 224 160C224 142.3 238.3 128 256 128zM296 384h-80C202.8 384 192 373.3 192 360s10.75-24 24-24h16v-64H224c-13.25 0-24-10.75-24-24S210.8 224 224 224h32c13.25 0 24 10.75 24 24v88h16c13.25 0 24 10.75 24 24S309.3 384 296 384z"/></svg>
                                                </x-jet-button>
                                            @else
                                                <x-jet-danger-button class="mx-2" wire:click="deleteShowModal({{ $item->id }})" title="Obriši lokaciju">
                                                <svg class="fill-current w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69zM31.1 128H416V448C416 483.3 387.3 512 352 512H95.1C60.65 512 31.1 483.3 31.1 448V128zM111.1 208V432C111.1 440.8 119.2 448 127.1 448C136.8 448 143.1 440.8 143.1 432V208C143.1 199.2 136.8 192 127.1 192C119.2 192 111.1 199.2 111.1 208zM207.1 208V432C207.1 440.8 215.2 448 223.1 448C232.8 448 240 440.8 240 432V208C240 199.2 232.8 192 223.1 192C215.2 192 207.1 199.2 207.1 208zM304 208V432C304 440.8 311.2 448 320 448C328.8 448 336 440.8 336 432V208C336 199.2 328.8 192 320 192C311.2 192 304 199.2 304 208z"/></svg>
                                                </x-jet-button>
                                            @endif
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
            @if ($isUpdate) {{ __('Izmeni podatke - ') }}{{ $l_naziv }}
            @else {{ __('Nova lokacija') }} @endif
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <x-jet-label for="l_naziv" value="{{ __('Naziv lokacije') }}" />
                <x-jet-input wire:model="l_naziv" id="" class="block mt-1 w-full" type="text" />
                @error('l_naziv') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="lokacija_tipId" value="{{ __('Vrsta lokacije') }}" />
                <select wire:model="lokacija_tipId" id="" class="block appearance-none w-full bg-gray-100 border border-gray-200 text-gray-700 py-3 px-4 pr-8 round leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                    <option value="">Izaberi vrstu</option>
                    @foreach (App\Models\LokacijaTip::tipoviList() as $key => $value)    
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
                @error('lokacija_tipId') <span class="error">{{ $message }}</span> @enderror
            </div>  
            <div class="mt-4">
                <x-jet-label for="mesto" value="{{ __('Mesto') }}" />
                <x-jet-input wire:model="mesto" id="" class="block mt-1 w-full" type="text" />
                @error('mesto') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="adresa" value="{{ __('Adresa') }}" />
                <x-jet-input wire:model="adresa" id="" class="block mt-1 w-full" type="text" />
                @error('adresa') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="latitude" value="{{ __('Latitude') }}" />
                <x-jet-input wire:model="latitude" id="" class="block mt-1 w-full" type="text" />
                @error('latitude') <span class="error">{{ $message }}</span> @enderror
            </div>  
            <div class="mt-4">
                <x-jet-label for="longitude" value="{{ __('Longitude') }}" />
                <x-jet-input wire:model="longitude" id="" class="block mt-1 w-full" type="text" />
                @error('longitude') <span class="error">{{ $message }}</span> @enderror
            </div>      
            <div class="mt-4">
                <x-jet-label for="regionId" value="{{ __('Region') }}" />
                <select wire:model="regionId" id="" class="block appearance-none w-full bg-gray-100 border border-gray-200 text-gray-700 py-3 px-4 pr-8 round leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                  <option value="">Odaberi region</option>
                    @foreach (App\Models\Region::regioni() as $key => $value)    
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
                @error('regionId') <span class="error">{{ $message }}</span> @enderror
            </div> 
            {{-- Kontakt osoba --}}
            @if($lokacija_tipId == 3)
                <div class="mt-6">
                    <hr />
                    <p>
                        <svg class="float-left fill-current w-4 h-4 mr-2 mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 448"><defs><style>.a{fill:#fff;}</style></defs><path d="M512,0H64A64,64,0,0,0,0,64V384a64,64,0,0,0,64,64H512a64,64,0,0,0,64-64V64A64,64,0,0,0,512,0Z"/><circle class="a" cx="186.65" cy="137.79" r="86.21"/><path class="a" d="M382.28,317.58h133a25,25,0,0,0,24.94-24.94V76.51a25,25,0,0,0-24.94-24.94h-133a24.94,24.94,0,0,0-24.93,24.94V292.64A24.94,24.94,0,0,0,382.28,317.58Zm83.13-24.94H431.69c-4.1,0-7.84-3.74-7.84-8.31a8.34,8.34,0,0,1,8.31-8.32h33.25c4.57,0,8.31,3.74,8.31,7.85A8.45,8.45,0,0,1,465.41,292.64ZM390.6,84.82H507V251.08H390.6Z"/><path class="a" d="M57.33,396.43H316a21.61,21.61,0,0,0,21.55-21.55A107.77,107.77,0,0,0,229.76,267.11H143.54A107.76,107.76,0,0,0,35.77,374.88,21.59,21.59,0,0,0,57.33,396.43Z"/></svg>
                        Kontakt osoba:
                    </p>
                    <div class="mt-4">
                        <x-jet-label for="nameKo" value="{{ __('Ime') }}" />
                        <x-jet-input wire:model="nameKo" id="" class="block mt-1 w-full" type="text" />
                        @error('nameKo') <span class="error">{{ $message }}</span> @enderror
                    </div> 
                    <div class="mt-4">
                        <x-jet-label for="telKo" value="{{ __('Broj telefona') }}" />
                        <div class="mt-4 flex rounded-md shadow-sm mb-4">
                    
							<span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-m">
								+381
							</span>
							<input wire:model="telKo" class="form-input flex-1 block w-full rounded-none rounded-r-md transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
							@error('telKo') <span class="error">{{ $message }}</span>@enderror
						</div> 
					</div>
				</div>
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                {{ __('Otkaži') }}
            </x-jet-secondary-button>

            @if ($isUpdate)
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

    {{-- The Delete or INFO Modal --}}
    <x-jet-dialog-modal wire:model="modalConfirmDeleteVisible">
        <x-slot name="title">
            @if($deletePosible)
                <svg class="float-left fill-red-700 w-4 h-4 mr-2 mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) --><path d="M569.517 440.013C587.975 472.007 564.806 512 527.94 512H48.054c-36.937 0-59.999-40.055-41.577-71.987L246.423 23.985c18.467-32.009 64.72-31.951 83.154 0l239.94 416.028zM288 354c-25.405 0-46 20.595-46 46s20.595 46 46 46 46-20.595 46-46-20.595-46-46-46zm-43.673-165.346l7.418 136c.347 6.364 5.609 11.346 11.982 11.346h48.546c6.373 0 11.635-4.982 11.982-11.346l7.418-136c.375-6.874-5.098-12.654-11.982-12.654h-63.383c-6.884 0-12.356 5.78-11.981 12.654z"/></svg>
                Brisanje
            @else
                <svg class="float-left fill-red-500 w-4 h-4 mr-2 mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 128c17.67 0 32 14.33 32 32c0 17.67-14.33 32-32 32S224 177.7 224 160C224 142.3 238.3 128 256 128zM296 384h-80C202.8 384 192 373.3 192 360s10.75-24 24-24h16v-64H224c-13.25 0-24-10.75-24-24S210.8 224 224 224h32c13.25 0 24 10.75 24 24v88h16c13.25 0 24 10.75 24 24S309.3 384 296 384z"/></svg>
                Info
            @endif
        </x-slot>

        <x-slot name="content">
            @if($modalConfirmDeleteVisible)
                <div class="bg-sky-100 border-t-4 border-sky-500 rounded-b text-sky-900 px-4 py-3 shadow-md mb-6" role="alert">
                    <div class="flex">
                        <div class="py-1"><svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2H168.3zM192 256C227.3 256 256 227.3 256 192C256 156.7 227.3 128 192 128C156.7 128 128 156.7 128 192C128 227.3 156.7 256 192 256z"/></svg></div>
                            <div>
                                <p><span class="font-bold">{{ $odabranaLokacija->l_naziv}}</span>, Adreasa: <span class="font-bold">{{ $odabranaLokacija->adresa}}</span></p>
                                <p>Mesto: <span class="font-bold">{{ $odabranaLokacija->mesto }}</span>, Region: <span class="font-bold">{{ $odabranaLokacija->r_naziv }}</span></p>
                            </div>
                    </div>
                </div> 
            @endif
            @if($deletePosible)
                {{ __('Da li ste sigurni da želite da obrišete lokaciju?') }}
            @else 
                <p>Lokacija je povezana sa:</p>
                @foreach ($this->locationUsers($modelId) as $key => $value) 
                    @switch($key)
                        @case('users')
                            @if(count($value))
                                <p>Korisnicima:</p>
                            @endif
                        @break
                        @case('terminal')
                            <p>Ukupno terminala:</p>
                        @break
                        
                        @case('sparepart')
                            <p>Rezervnim delovima:</p>
                        @break
                        
                        @case('tiket')
                            <p>Tiketima:</p>
                        @break
                    @endswitch
                

                    @foreach($value as $name)
                         <span class="ml-6 font-bold">{{ $name }} </span><br/>
                    @endforeach
                @endforeach
            @endif
            @if($modalConfirmDeleteVisible)
                @if($odabranaLokacija->lokacija_tipId == 3)
                    @if(!$deletePosible)
                        <p>Terminali:</p>
                    @endif
                    @foreach($terminaliList as $termin)
                        <div class="bg-sky-100 border-t-4 border-sky-500 rounded-b text-sky-900 px-4 py-3 shadow-md mb-6" role="alert">
                            <div class="flex">
                                <div class="py-1">
                                    <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M288 0C305.7 0 320 14.33 320 32V96C320 113.7 305.7 128 288 128H208V160H424.1C456.6 160 483.5 183.1 488.2 214.4L510.9 364.1C511.6 368.8 512 373.6 512 378.4V448C512 483.3 483.3 512 448 512H64C28.65 512 0 483.3 0 448V378.4C0 373.6 .3622 368.8 1.083 364.1L23.76 214.4C28.5 183.1 55.39 160 87.03 160H143.1V128H63.1C46.33 128 31.1 113.7 31.1 96V32C31.1 14.33 46.33 0 63.1 0L288 0zM96 48C87.16 48 80 55.16 80 64C80 72.84 87.16 80 96 80H256C264.8 80 272 72.84 272 64C272 55.16 264.8 48 256 48H96zM80 448H432C440.8 448 448 440.8 448 432C448 423.2 440.8 416 432 416H80C71.16 416 64 423.2 64 432C64 440.8 71.16 448 80 448zM112 216C98.75 216 88 226.7 88 240C88 253.3 98.75 264 112 264C125.3 264 136 253.3 136 240C136 226.7 125.3 216 112 216zM208 264C221.3 264 232 253.3 232 240C232 226.7 221.3 216 208 216C194.7 216 184 226.7 184 240C184 253.3 194.7 264 208 264zM160 296C146.7 296 136 306.7 136 320C136 333.3 146.7 344 160 344C173.3 344 184 333.3 184 320C184 306.7 173.3 296 160 296zM304 264C317.3 264 328 253.3 328 240C328 226.7 317.3 216 304 216C290.7 216 280 226.7 280 240C280 253.3 290.7 264 304 264zM256 296C242.7 296 232 306.7 232 320C232 333.3 242.7 344 256 344C269.3 344 280 333.3 280 320C280 306.7 269.3 296 256 296zM400 264C413.3 264 424 253.3 424 240C424 226.7 413.3 216 400 216C386.7 216 376 226.7 376 240C376 253.3 386.7 264 400 264zM352 296C338.7 296 328 306.7 328 320C328 333.3 338.7 344 352 344C365.3 344 376 333.3 376 320C376 306.7 365.3 296 352 296z"/></svg>
                                </div>
                                    <div>
                                        <p>Serijski broj: <span class="font-bold"> {{ $termin->sn }}</span>, Kutija: {{ $termin->broj_kutije }}</p>
                                        <p class="text-sm">Status: <span class="font-bold">{{ $termin->ts_naziv }}</span></p>
                                    </div>
                            </div>
                        </div> 
                    @endforeach
                @endif
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalConfirmDeleteVisible')" wire:loading.attr="disabled">
                {{ __('Otkaži') }}
            </x-jet-secondary-button>
            @if($deletePosible)
                <x-jet-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
                    {{ __('Obriši lokaciju') }}
                </x-jet-danger-button>
            @endif
        </x-slot>
    </x-jet-dialog-modal>


    {{-- Add Terminal Modal --}}
    <x-jet-dialog-modal wire:model="modalAddTerminalVisible" id="adTer">
        <x-slot name="title">
          Dodaj / premesti terminal
        </x-slot>
        
        <x-slot name="content">
            @if($modalAddTerminalVisible)
                <div>Lokacija na koju se dodaju terminali:</div>
                    <div class="bg-sky-100 border-t-4 border-sky-500 rounded-b text-sky-900 px-4 py-3 shadow-md mb-6" role="alert">
                        <div class="flex">
                            <div class="py-1"><svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2H168.3zM192 256C227.3 256 256 227.3 256 192C256 156.7 227.3 128 192 128C156.7 128 128 156.7 128 192C128 227.3 156.7 256 192 256z"/></svg></div>
                            <div>
                                <p class="font-bold">{{ $odabranaLokacija->l_naziv}}, {{ $odabranaLokacija->mesto }}</p>
                                <p class="text-sm">Region: {{ $odabranaLokacija->r_naziv }}</p>
                            </div>
                    </div>
                </div> 
            @endif 

            {{-- RADIO BUTTONS  --}}
            <div  class="flex justify-between mb-6">
                <div class="form-check mx-4">
                    <input wire:model="addingType" class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="flexRadioDefault" id="flexRadioDefault1" value="location">
                    <label class="form-check-label inline-block text-gray-800" for="flexRadioDefault1">
                        Premesti sa druge lokacije
                    </label>
                </div>
                <div class="form-check mx-4">
                    <input wire:model="addingType" class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                    <label class="form-check-label inline-block text-gray-800" for="flexRadioDefault2" value="new">
                        Dodaj novi terminal
                    </label>
                </div>
            </div>

                @if($addingType == 'location') 
                {{-- DODAVANJE SA LOKACIJE --}}
                    @if(!$p_lokacijaId)
                        <div class="mb-6"> 
                            <select wire:model="p_lokacija_tipId" id="" class="block appearance-none w-full bg-gray-100 border border-gray-200 text-gray-700 py-3 px-4 pr-8 round leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                <option value="">Izaberi vrstu lokacije</option>
                                @foreach (App\Models\LokacijaTip::tipoviList() as $key => $value)    
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if ($p_lokacija_tipId)
                            <div>Izaberi lokaciju:</div>
                            @if($p_lokacija_tipId == 3)
                                {{-- Korsnik terminala search by name --}}
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
                                    @foreach ($this->lokacijeTipa($p_lokacija_tipId) as $value)
                                    <tr class="hover:bg-gray-100" wire:click="$set('p_lokacijaId', {{ $value->id }})" >    
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
                                    {{ $this->lokacijeTipa($p_lokacija_tipId)->links() }}
                                </div>
                            @else
                                {{-- MAGACIN ILI SEVIS --}}
                                <div class="mb-6">
                                    <select wire:model="p_lokacijaId" id="" class="block appearance-none w-full bg-gray-100 border border-gray-200 text-gray-700 py-3 px-4 pr-8 round leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                        <option value="">Izaberi lokaciju</option>
                                        @foreach (App\Models\Lokacija::lokacijeTipa( $p_lokacija_tipId ) as $key => $value)    
                                            @if($key != $modelId) <option value="{{ $key }}">{{ $value }}</option> @endif
                                        @endforeach
                                    </select>
                                </div>

                            @endif
                        @endif
                    @else
                    {{-- IZABRAO Je LOKACIJU --}}
                        @if($this->terminaliZaLokaciju($p_lokacijaId)->count())
                            {{-- IZABRAO dobru LOKACIJU MENJAM PRIKAZ --}}
                            <div>Lokacija sa koje se uzimaju terminali:</div>
                            <div class="bg-sky-100 border-t-4 border-sky-500 rounded-b text-sky-900 px-4 py-3 shadow-md mb-6" role="alert">
                                <div class="flex">
                                    <div class="py-1"><svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2H168.3zM192 256C227.3 256 256 227.3 256 192C256 156.7 227.3 128 192 128C156.7 128 128 156.7 128 192C128 227.3 156.7 256 192 256z"/></svg></div>
                                        <div>
                                            <p class="font-bold">{{ $lokacijaSaKojeUzima->l_naziv}}, {{ $lokacijaSaKojeUzima->mesto }}</p>
                                            <p class="text-sm">Region: {{ $lokacijaSaKojeUzima->r_naziv }}</p>
                                        </div>
                                </div>
                            </div> 
                            
                            <table class="min-w-full divide-y divide-gray-200 mb-6" style="width: 100% !important">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        <input type="checkbox" value="{{ $selectAllValue }}" wire:model="selectAll.{{ $this->modelId }}"  class="form-checkbox h-6 w-6 text-blue-500">
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Serijski broj</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Broj kutije</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Model</tr>
                            </thead>
                            <tr>
                                <td></td>
                                <td><x-jet-input wire:model="searchSN" id="" class="block bg-orange-50 w-full" type="text" placeholder="Seriski broj" /></td>
                                <td><x-jet-input wire:model="searchBK" id="" class="block bg-orange-50 w-full" type="text" placeholder="Seriski broj" /></td>
                                <td></td>
                            </tr>
                            <tbody>
                                @foreach($this->terminaliZaLokaciju($p_lokacijaId, $searchSN, $searchBK) as $item)
                                    <tr>
                                        <td><input type="checkbox" value="{{ $item->tid }}" wire:model="selsectedTerminals"  class="form-checkbox h-6 w-6 text-blue-500"></td>
                                        <td> {{ $item->sn }}</td>
                                        <td> {{ $item->broj_kutije }}</td>
                                        <td>{{ $item->model }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mb-6">
                            {{ $this->terminaliZaLokaciju($p_lokacijaId, $searchSN, $searchBK)->links() }} 
                        </div>
                        <div class="mb-6">
                            <select wire:model="t_status" id="" class="block appearance-none w-full bg-gray-100 border border-gray-200 text-gray-700 py-3 px-4 pr-8 round leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                <option value="">Status terminala</option>
                                @foreach ( App\Models\TerminalStatusTip::tipoviList() as $key => $value)    
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3" role="alert">
                            <p class="text-sm">Ukupno terminala: <span class="font-bold"> {{ count($selsectedTerminals) }}</span></p>
                        </div>

                        @else
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                <strong class="font-bold">Greška!</strong>
                                <span class="block sm:inline">Na izabranoj lokaciji nema terminala.</span>
                                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                                    <svg class="fill-current h-6 w-6 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M506.3 417l-213.3-364c-16.33-28-57.54-28-73.98 0l-213.2 364C-10.59 444.9 9.849 480 42.74 480h426.6C502.1 480 522.6 445 506.3 417zM232 168c0-13.25 10.75-24 24-24S280 154.8 280 168v128c0 13.25-10.75 24-23.1 24S232 309.3 232 296V168zM256 416c-17.36 0-31.44-14.08-31.44-31.44c0-17.36 14.07-31.44 31.44-31.44s31.44 14.08 31.44 31.44C287.4 401.9 273.4 416 256 416z"/></svg>
                                </span>
                            </div>
                        @endif
                    @endif
                @else
                {{-- DODAVANJE NOVOG TERMINALA NA LOKACIJU --}}
                        <p>Novi terminal</p>
                @endif
            @if($errAddMsg != '')
            {{-- PRIKAZ GRESKE --}}
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative my-4" role="alert">
                    <strong class="font-bold">Greška!</strong>
                    <span class="block sm:inline">{{ $errAddMsg }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg class="fill-current h-6 w-6 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M506.3 417l-213.3-364c-16.33-28-57.54-28-73.98 0l-213.2 364C-10.59 444.9 9.849 480 42.74 480h426.6C502.1 480 522.6 445 506.3 417zM232 168c0-13.25 10.75-24 24-24S280 154.8 280 168v128c0 13.25-10.75 24-23.1 24S232 309.3 232 296V168zM256 416c-17.36 0-31.44-14.08-31.44-31.44c0-17.36 14.07-31.44 31.44-31.44s31.44 14.08 31.44 31.44C287.4 401.9 273.4 416 256 416z"/></svg>
                    </span>
                </div>
            @endif
        </x-slot>
        
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalAddTerminalVisible')" wire:loading.attr="disabled">
                    {{ __('Otkaži') }}
            </x-jet-secondary-button>
            <x-jet-danger-button class="ml-2" wire:click="addTerminal" wire:loading.attr="disabled">
                    {{ __('Dodaj terminal') }}
            </x-jet-danger-button>
        </x-slot>
     </x-jet-dialog-modal>

     {{-- KONTAKT OSOBA MODAL --}}
     <x-jet-dialog-modal wire:model="kontaktOsobaVisible">
        <x-slot name="title">
        <svg class="float-left fill-gray-500 w-6 h-6 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 448"><defs><style>.a{fill:#fff;}</style></defs><path d="M512,0H64A64,64,0,0,0,0,64V384a64,64,0,0,0,64,64H512a64,64,0,0,0,64-64V64A64,64,0,0,0,512,0Z"/><circle class="a" cx="186.65" cy="137.79" r="86.21"/><path class="a" d="M382.28,317.58h133a25,25,0,0,0,24.94-24.94V76.51a25,25,0,0,0-24.94-24.94h-133a24.94,24.94,0,0,0-24.93,24.94V292.64A24.94,24.94,0,0,0,382.28,317.58Zm83.13-24.94H431.69c-4.1,0-7.84-3.74-7.84-8.31a8.34,8.34,0,0,1,8.31-8.32h33.25c4.57,0,8.31,3.74,8.31,7.85A8.45,8.45,0,0,1,465.41,292.64ZM390.6,84.82H507V251.08H390.6Z"/><path class="a" d="M57.33,396.43H316a21.61,21.61,0,0,0,21.55-21.55A107.77,107.77,0,0,0,229.76,267.11H143.54A107.76,107.76,0,0,0,35.77,374.88,21.59,21.59,0,0,0,57.33,396.43Z"/></svg>
            {{ __('Kontakt osoba') }}
        </x-slot>

        <x-slot name="content">
            @if($kontaktOsobaVisible)
                <div>Lokacija:</div>
                    <div class="bg-sky-100 border-t-4 border-sky-500 rounded-b text-sky-900 px-4 py-3 shadow-md mb-6" role="alert">
                        <div class="flex">
                            <div class="py-1"><svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2H168.3zM192 256C227.3 256 256 227.3 256 192C256 156.7 227.3 128 192 128C156.7 128 128 156.7 128 192C128 227.3 156.7 256 192 256z"/></svg></div>
                            <div>
                                <p class="font-bold">{{ $odabranaLokacija->l_naziv}}, {{ $odabranaLokacija->mesto }}</p>
                                <p class="text-sm">Region: {{ $odabranaLokacija->r_naziv }}</p>
                            </div>
                    </div>
                </div> 
                <div>Kontakt osoba:</div>
                    <div class="bg-sky-100 border-t-4 border-sky-500 rounded-b text-sky-900 px-4 py-3 shadow-md mb-6" role="alert">
                        <div class="flex">
                            <div class="py-1">
                            <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 448"><defs><style>.a{fill:#fff;}</style></defs><path d="M512,0H64A64,64,0,0,0,0,64V384a64,64,0,0,0,64,64H512a64,64,0,0,0,64-64V64A64,64,0,0,0,512,0Z"/><circle class="a" cx="186.65" cy="137.79" r="86.21"/><path class="a" d="M382.28,317.58h133a25,25,0,0,0,24.94-24.94V76.51a25,25,0,0,0-24.94-24.94h-133a24.94,24.94,0,0,0-24.93,24.94V292.64A24.94,24.94,0,0,0,382.28,317.58Zm83.13-24.94H431.69c-4.1,0-7.84-3.74-7.84-8.31a8.34,8.34,0,0,1,8.31-8.32h33.25c4.57,0,8.31,3.74,8.31,7.85A8.45,8.45,0,0,1,465.41,292.64ZM390.6,84.82H507V251.08H390.6Z"/><path class="a" d="M57.33,396.43H316a21.61,21.61,0,0,0,21.55-21.55A107.77,107.77,0,0,0,229.76,267.11H143.54A107.76,107.76,0,0,0,35.77,374.88,21.59,21.59,0,0,0,57.33,396.43Z"/></svg>
                            </div>
                            <div>
                                <p class="font-bold">{{ $kontaktOsobaInfo->name }}</p>
                                <p class="text-sm"> {{ $kontaktOsobaInfo->tel }}</p>
                            </div>
                    </div>
                </div> 

            @endif 
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('kontaktOsobaVisible')" wire:loading.attr="disabled">
                    {{ __('Otkaži') }}
            </x-jet-secondary-button>
        </x-slot>
     </x-jet-dialog-modal>
</div>
