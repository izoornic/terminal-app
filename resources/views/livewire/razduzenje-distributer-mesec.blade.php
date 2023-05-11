<div class="p-6">
    <div class="font-semibold text-xl flex items-center px-4 py-3 text-right">
        <div class="ml-2 pr-2"><svg class="fill-red-600 w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M0 48C0 21.5 21.5 0 48 0H336c26.5 0 48 21.5 48 48V232.2c-39.1 32.3-64 81.1-64 135.8c0 49.5 20.4 94.2 53.3 126.2C364.5 505.1 351.1 512 336 512H240V432c0-26.5-21.5-48-48-48s-48 21.5-48 48v80H48c-26.5 0-48-21.5-48-48V48zM80 224c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V240c0-8.8-7.2-16-16-16H80zm80 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V240c0-8.8-7.2-16-16-16H176c-8.8 0-16 7.2-16 16zm112-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V240c0-8.8-7.2-16-16-16H272zM64 112v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V112c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zM176 96c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V112c0-8.8-7.2-16-16-16H176zm80 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V112c0-8.8-7.2-16-16-16H272c-8.8 0-16 7.2-16 16zm96 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm140.7-67.3c-6.2 6.2-6.2 16.4 0 22.6L521.4 352H432c-8.8 0-16 7.2-16 16s7.2 16 16 16h89.4l-28.7 28.7c-6.2 6.2-6.2 16.4 0 22.6s16.4 6.2 22.6 0l56-56c6.2-6.2 6.2-16.4 0-22.6l-56-56c-6.2-6.2-16.4-6.2-22.6 0z"/></svg></div>
        <div class="text-red-600">{{ $distributer_info->distributer_naziv }}</div>
    </div>
    {{-- The data table --}}
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200" style="width: 100% !important">
                        <thead>
                            <tr>
                                <th class="px-2 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Serijski broj</th>
                                <th class="px-2 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Lokacija</th>
                                <th class="px-2 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Licenca</th>
                                <th class="px-2 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Početak</th>
                                <th class="px-2 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Kraj</th>
                                <th class="px-2 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Iznos</th>
                                <th class="px-2 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    <svg class="fill-red-400 w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm79 143c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z"/></svg>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">   
                        {{-- SEARCH ROW --}}
                            <tr class="bg-orange-50">
                                <td>
                                    <x-jet-input wire:model="searchTerminalSn" id="" class="block bg-orange-50 w-48" type="text" placeholder="Serijski broj" />
                                </td>
                                <td>
                                    <x-jet-input wire:model="searchMesto" id="" class="block bg-orange-50 w-fit" type="text" placeholder="Pretraži mesto" />
                                </td>
                                <td>
                                    <select wire:model="searchTipLicence" id="" class="block appearance-none bg-orange-50 w-full border border-0 text-gray-700 py-3 px-4 pr-8 round leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                        <option value="0">---</option>
                                        @foreach (App\Models\LicencaDistributerCena::LicenceDistributera($did) as $key => $value)    
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>  
                            @php
                                $olditem = new stdClass();
                                $olditem->terminal_lokacijaId = '';
                            @endphp

                            @if ($data->count())
                                @foreach ($data as $item)
                                    @if($olditem->terminal_lokacijaId == $item->terminal_lokacijaId)
                                        @php
                                            $item->isDuplicate = true;
                                        @endphp
                                    @else
                                        @php
                                            $item->isDuplicate = false;
                                        @endphp
                                    @endif

                                    @if(in_array($item->id, $ne_razduzuju_se))
                                        @php
                                            $bg_color = 'bg-red-50';
                                        @endphp
                                            <tr class="bg-red-50"><td class="px-6 py-0 whitespace-no-wrap text-red-500 font-bold" colspan="7">Izabrana licenca će biti označena kao "NENAPLATIVA".</td></tr>
                                    @else
                                        @php
                                            $bg_color = '';
                                        @endphp        
                                    @endif
                                    <tr class="{{ $bg_color }}">
                                        <td class="px-2 py-2"> @if($item->isDuplicate)
                                                <span class=""> <svg class="fill-red-400 w-5 h-5 ml-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 410.1 512"><path d="M401.3,327.3L270.8,196.8c-11.7-11.7-30.7-11.7-42.4,0c-11.7,11.7-11.7,30.7,0,42.4l78.3,78.3H117.1 c-0.8,0-1.6,0-2.5,0.1c-0.2,0-25.7,1.2-40.9-12.8c-9.2-8.5-13.7-21.7-13.7-40.3V31.7c0-16.6-13.4-30-30-30S0,15.1,0,31.7v232.9 c0,44.6,18,70.5,33.1,84.4c27.9,25.7,63.9,28.8,79.3,28.8c2.4,0,4.4-0.1,5.7-0.2h190.5l-80.2,80.2c-11.7,11.7-11.7,30.7,0,42.4 c5.9,5.9,13.5,8.8,21.2,8.8s15.4-2.9,21.2-8.8l130.5-130.5C413,358,413,339,401.3,327.3z"/></svg></span> 
                                            @else
                                                {{ $item->sn }}
                                            @endif 
                                        </td>
                                        <td class="px-2 py-2">
                                            @if($item->isDuplicate)
                                                <span class=""> <svg class="fill-red-400 w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M502.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l370.7 0-73.4 73.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l128-128z"/></svg></span> 
                                            @else
                                                {{ $item->l_naziv }}<br />{{ $item->adresa }}, {{ $item->mesto }}
                                            @endif   
                                        </td>
                                        <td class="px-2 py-2">
                                            @if($item->ltid > 1) 
                                                <span class="float-left pr-2"><svg class="fill-red-400 w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M240 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H32c-17.7 0-32 14.3-32 32s14.3 32 32 32H176V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H384c17.7 0 32-14.3 32-32s-14.3-32-32-32H240V80z"/></svg></span>
                                            @endif
                                            {{ $item->licenca_naziv }}
                                        </td>
                                        <td>{{ App\Http\Helpers::datumFormatDan($item->datum_pocetka_licence) }} </td> 
                                        <td>{{ App\Http\Helpers::datumFormatDan($item->datum_kraj_licence) }} </td>
                                        <td>
                                            @if(in_array($item->id, $ne_razduzuju_se))
                                            <svg class="float-left fill-red-400 w-4 h-4 mr-2 mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) --><path d="M569.517 440.013C587.975 472.007 564.806 512 527.94 512H48.054c-36.937 0-59.999-40.055-41.577-71.987L246.423 23.985c18.467-32.009 64.72-31.951 83.154 0l239.94 416.028zM288 354c-25.405 0-46 20.595-46 46s20.595 46 46 46 46-20.595 46-46-20.595-46-46-46zm-43.673-165.346l7.418 136c.347 6.364 5.609 11.346 11.982 11.346h48.546c6.373 0 11.635-4.982 11.982-11.346l7.418-136c.375-6.874-5.098-12.654-11.982-12.654h-63.383c-6.884 0-12.356 5.78-11.981 12.654z"/></svg>
                                            @endif
                                            @money($item->zaduzeno) RSD
                                        </td>                                     
                                        <td class="px-2 py-2">
                                            <input type="checkbox" value="{{ $item->id }}" wire:model="ne_razduzuju_se"> 
                                        </td>
                                    </tr>
                                    @php
                                        $olditem = $item;
                                    @endphp
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

    <div class="pt-8">
        <div class="bg-sky-100 border-t-4 border-sky-500 rounded-b text-sky-900 px-4 py-3 shadow-md" role="alert">
            <div class="flex justify-between">
                <div class="py-1">
                    <p>Distributer: <span class="font-bold">{{ $distributer_info->distributer_naziv }} </span></p>
                        @if(count($ne_razduzuju_se))
                        <p>Broj licenci koje se ne zadužuju: <span class="font-bold">{{ count($ne_razduzuju_se) }} </span></p>
                    @endif
                </div>
                <div class="py-1">
                    <p>Ukupna suma zaduženja: <span class="font-bold">@money($ukupno_zaduzenje) </span> RSD</p>
                    <p class="text-sm"><!-- Mozda jos neki info?!? --></p>
                </div>
                <div class="py-1">
                    <button wire:click="showRazduzenjeConfirmModal" class="flex border border-green-600 bg-green-400 hover:bg-green-200 text-white hover:text-green-600 font-bold uppercase py-2 px-4 rounded mx-2">
                        <svg class="fill-current w-6 h-6 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M326.7 403.7c-22.1 8-45.9 12.3-70.7 12.3s-48.7-4.4-70.7-12.3c-.3-.1-.5-.2-.8-.3c-30-11-56.8-28.7-78.6-51.4C70 314.6 48 263.9 48 208C48 93.1 141.1 0 256 0S464 93.1 464 208c0 55.9-22 106.6-57.9 144c-1 1-2 2.1-3 3.1c-21.4 21.4-47.4 38.1-76.3 48.6zM256 91.9c-11.1 0-20.1 9-20.1 20.1v6c-5.6 1.2-10.9 2.9-15.9 5.1c-15 6.8-27.9 19.4-31.1 37.7c-1.8 10.2-.8 20 3.4 29c4.2 8.8 10.7 15 17.3 19.5c11.6 7.9 26.9 12.5 38.6 16l2.2 .7c13.9 4.2 23.4 7.4 29.3 11.7c2.5 1.8 3.4 3.2 3.7 4c.3 .8 .9 2.6 .2 6.7c-.6 3.5-2.5 6.4-8 8.8c-6.1 2.6-16 3.9-28.8 1.9c-6-1-16.7-4.6-26.2-7.9l0 0 0 0 0 0c-2.2-.7-4.3-1.5-6.4-2.1c-10.5-3.5-21.8 2.2-25.3 12.7s2.2 21.8 12.7 25.3c1.2 .4 2.7 .9 4.4 1.5c7.9 2.7 20.3 6.9 29.8 9.1V304c0 11.1 9 20.1 20.1 20.1s20.1-9 20.1-20.1v-5.5c5.3-1 10.5-2.5 15.4-4.6c15.7-6.7 28.4-19.7 31.6-38.7c1.8-10.4 1-20.3-3-29.4c-3.9-9-10.2-15.6-16.9-20.5c-12.2-8.8-28.3-13.7-40.4-17.4l-.8-.2c-14.2-4.3-23.8-7.3-29.9-11.4c-2.6-1.8-3.4-3-3.6-3.5c-.2-.3-.7-1.6-.1-5c.3-1.9 1.9-5.2 8.2-8.1c6.4-2.9 16.4-4.5 28.6-2.6c4.3 .7 17.9 3.3 21.7 4.3c10.7 2.8 21.6-3.5 24.5-14.2s-3.5-21.6-14.2-24.5c-4.4-1.2-14.4-3.2-21-4.4V112c0-11.1-9-20.1-20.1-20.1zM48 352H64c19.5 25.9 44 47.7 72.2 64H64v32H256 448V416H375.8c28.2-16.3 52.8-38.1 72.2-64h16c26.5 0 48 21.5 48 48v64c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V400c0-26.5 21.5-48 48-48z"/></svg>
                        {{ __('Razaduži distributera') }}
                    </button>
                </div>
            </div>
        </div> 
        
    </div>

    {{-- The Razduzenje Modal --}}
    <x-jet-dialog-modal wire:model="razduzenjeModalVisible">
        <x-slot name="title">
            {{ __('Razduži distributera') }}
        </x-slot>

        <x-slot name="content">
            Da li ste sigurni da želite da razdužite distributera:<br/>
            <span class="font-bold">{{ $distributer_info->distributer_naziv }}</span><br/> 
            za mesec: <br/>
            <span class="font-bold">{{ $mesecRow->mesec_naziv }}, {{ App\Http\Helpers::yearNumber($mesecRow->mesec_datum) }}</span><br/>
            za iznos:<br/>
            <span class="font-bold">@money($ukupno_zaduzenje) </span>RSD<br/> 
            zaduženo<br />
            <span class="font-bold">@money($zaduzenjeMesecDistributerRow->sum_zaduzeno) </span>RSD<br/>

            <div>
                <x-jet-label for="datumUplate" value="Datum uplate:" />
                <x-jet-input id="datumUplate" type="date" class="mt-1 block" value="{{ $datumUplate }}" wire:model="datumUplate" />
                @error('datumUplate') <span class="error">{{ $message }}</span> @enderror
            </div>
            
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('razduzenjeModalVisible')" wire:loading.attr="disabled">
                {{ __('Otkaži') }}
            </x-jet-secondary-button>

            <button wire:click="razduziDistributera" class="flex border border-green-600 bg-green-400 hover:bg-green-200 text-white hover:text-green-600 font-bold uppercase py-2 px-4 rounded mx-2">
                <svg class="fill-current w-6 h-6 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M326.7 403.7c-22.1 8-45.9 12.3-70.7 12.3s-48.7-4.4-70.7-12.3c-.3-.1-.5-.2-.8-.3c-30-11-56.8-28.7-78.6-51.4C70 314.6 48 263.9 48 208C48 93.1 141.1 0 256 0S464 93.1 464 208c0 55.9-22 106.6-57.9 144c-1 1-2 2.1-3 3.1c-21.4 21.4-47.4 38.1-76.3 48.6zM256 91.9c-11.1 0-20.1 9-20.1 20.1v6c-5.6 1.2-10.9 2.9-15.9 5.1c-15 6.8-27.9 19.4-31.1 37.7c-1.8 10.2-.8 20 3.4 29c4.2 8.8 10.7 15 17.3 19.5c11.6 7.9 26.9 12.5 38.6 16l2.2 .7c13.9 4.2 23.4 7.4 29.3 11.7c2.5 1.8 3.4 3.2 3.7 4c.3 .8 .9 2.6 .2 6.7c-.6 3.5-2.5 6.4-8 8.8c-6.1 2.6-16 3.9-28.8 1.9c-6-1-16.7-4.6-26.2-7.9l0 0 0 0 0 0c-2.2-.7-4.3-1.5-6.4-2.1c-10.5-3.5-21.8 2.2-25.3 12.7s2.2 21.8 12.7 25.3c1.2 .4 2.7 .9 4.4 1.5c7.9 2.7 20.3 6.9 29.8 9.1V304c0 11.1 9 20.1 20.1 20.1s20.1-9 20.1-20.1v-5.5c5.3-1 10.5-2.5 15.4-4.6c15.7-6.7 28.4-19.7 31.6-38.7c1.8-10.4 1-20.3-3-29.4c-3.9-9-10.2-15.6-16.9-20.5c-12.2-8.8-28.3-13.7-40.4-17.4l-.8-.2c-14.2-4.3-23.8-7.3-29.9-11.4c-2.6-1.8-3.4-3-3.6-3.5c-.2-.3-.7-1.6-.1-5c.3-1.9 1.9-5.2 8.2-8.1c6.4-2.9 16.4-4.5 28.6-2.6c4.3 .7 17.9 3.3 21.7 4.3c10.7 2.8 21.6-3.5 24.5-14.2s-3.5-21.6-14.2-24.5c-4.4-1.2-14.4-3.2-21-4.4V112c0-11.1-9-20.1-20.1-20.1zM48 352H64c19.5 25.9 44 47.7 72.2 64H64v32H256 448V416H375.8c28.2-16.3 52.8-38.1 72.2-64h16c26.5 0 48 21.5 48 48v64c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V400c0-26.5 21.5-48 48-48z"/></svg>
                {{ __('Razduži distributera') }}
            </button>
        </x-slot>
    </x-jet-dialog-modal>

<style>
    input[type="checkbox"]{
        -webkit-appearance: initial;
        appearance: initial;
        background: #e6e6e6;
        border-radius: 5px;
        width: 30px;
        height: 30px;
        border: 1px solid #747474;
        position: relative;
    }
    input[type="checkbox"]:checked {
        background: #e25858;
    }

    input[type="checkbox"]:checked:after {
        /* Heres your symbol replacement */
        content: "X";
        color: #fff;
        /* The following positions my tick in the center, 
        * but you could just overlay the entire box
        * with a full after element with a background if you want to */
        position: absolute;
        left: 50%;
        top: 50%;
        -webkit-transform: translate(-50%,-50%);
        -moz-transform: translate(-50%,-50%);
        -ms-transform: translate(-50%,-50%);
        transform: translate(-50%,-50%);
    }
</style>
    
</div>