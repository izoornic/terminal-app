<div class="p-6">
    <div class="flex items-center justify-between px-4 py-3 text-right sm:px-6">
        <div class="flex font-semibold text-xl">
        <div class="ml-2 pr-2"><svg class="fill-red-600 w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M0 48C0 21.5 21.5 0 48 0H336c26.5 0 48 21.5 48 48V232.2c-39.1 32.3-64 81.1-64 135.8c0 49.5 20.4 94.2 53.3 126.2C364.5 505.1 351.1 512 336 512H240V432c0-26.5-21.5-48-48-48s-48 21.5-48 48v80H48c-26.5 0-48-21.5-48-48V48zM80 224c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V240c0-8.8-7.2-16-16-16H80zm80 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V240c0-8.8-7.2-16-16-16H176c-8.8 0-16 7.2-16 16zm112-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V240c0-8.8-7.2-16-16-16H272zM64 112v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V112c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zM176 96c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V112c0-8.8-7.2-16-16-16H176zm80 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V112c0-8.8-7.2-16-16-16H272c-8.8 0-16 7.2-16 16zm96 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm140.7-67.3c-6.2 6.2-6.2 16.4 0 22.6L521.4 352H432c-8.8 0-16 7.2-16 16s7.2 16 16 16h89.4l-28.7 28.7c-6.2 6.2-6.2 16.4 0 22.6s16.4 6.2 22.6 0l56-56c6.2-6.2 6.2-16.4 0-22.6l-56-56c-6.2-6.2-16.4-6.2-22.6 0z"/></svg></div>
        <div class="text-red-600">{{ $dist_name }}</div>
        </div>

        <x-jet-button wire:click="createShowModal">
        <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM256 368C269.3 368 280 357.3 280 344V280H344C357.3 280 368 269.3 368 256C368 242.7 357.3 232 344 232H280V168C280 154.7 269.3 144 256 144C242.7 144 232 154.7 232 168V232H168C154.7 232 144 242.7 144 256C144 269.3 154.7 280 168 280H232V344C232 357.3 242.7 368 256 368z"/></svg>
            {{ __('Dodaj terminal') }}
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
                                <th class="px-2 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Serijski broj</th>
                                <th class="px-2 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Lokacija</th>
                                <th class="px-2 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Licenca</th>
                                <th class="px-2 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    <svg class="mx-auto fill-red-400 w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">	<path class="st1" d="M320,464c8.8,0,16-7.2,16-16V160h-80c-17.7,0-32-14.3-32-32V48H64c-8.8,0-16,7.2-16,16v384 c0,8.8,7.2,16,16,16H320z M0,64C0,28.7,28.7,0,64,0h165.5c17,0,33.3,6.7,45.3,18.7l90.5,90.5c12,12,18.7,28.3,18.7,45.3V448 c0,35.3-28.7,64-64,64H64c-35.3,0-64-28.7-64-64V64z"/> <path class="st1" d="M48,238c0,39.8,21.1,75.3,54,98.4c0,0.2,0,0.4,0,0.6v36c0,14.9,12.1,27,27,27h27v-27c0-5,4-9,9-9s9,4,9,9v27 h36v-27c0-5,4-9,9-9s9,4,9,9v27h27c14.9,0,27-12.1,27-27v-36c0-0.2,0-0.4,0-0.6c32.9-23.1,54-58.6,54-98.4	c0-22.2-6.6-43.1-18.1-61.2h-24.5c-40.6,0-75-27.1-86.2-64.1c-5-0.5-10.1-0.7-15.2-0.7C112.5,112,48,168.4,48,238z M138,292	c-19.9,0-36-16.1-36-36s16.1-36,36-36s36,16.1,36,36S157.9,292,138,292z M246,220c19.9,0,36,16.1,36,36s-16.1,36-36,36 s-36-16.1-36-36S226.1,220,246,220z"/></svg>
                                </th>
                                <th class="px-2 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Početak</th>
                                <th class="px-2 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Kraj</th>
                                <th colspan="4" class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Ukupno licenci: {{ $data->total() }}<br /> Ukupno terminala {{$br_terminala}}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">  
                        {{-- SEARCH ROW --}}
                            <tr class="bg-orange-50">
                                <td>
                                    <x-jet-input wire:model="searchTerminalSn" id="" class="block bg-orange-50 w-full" type="text" placeholder="Serijski broj" />
                                </td>
                                <td>
                                    <x-jet-input wire:model="searchMesto" id="" class="block bg-orange-50 w-full" type="text" placeholder="Pretraži mesto" />
                                </td>
                                <td>
                                    <select wire:model="searchTipLicence" id="" class="block appearance-none bg-orange-50 w-full border border-0 text-gray-700 py-3 px-4 pr-8 round leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                        <option value="0">---</option>
                                        @foreach (App\Models\LicencaDistributerCena::LicenceDistributera($distId) as $key => $value)    
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                        <option value="1000">Bez licence</option>
                                    </select>
                                </td>
                                <td>
                                    <select wire:model="searchNenaplativ" id="" class="block appearance-none bg-orange-50 w-full border border-0 text-gray-700 py-3 px-4 pr-8 round leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                        <option value="0">---</option>
                                        <option value="1">Da</option>
                                    </select>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @php
                                $olditem = new stdClass();
                                $olditem->id = '';
                            @endphp
                            @if ($data->count())
                                @foreach ($data as $item)

                                    @if($olditem->id == $item->id)
                                        @php
                                            $item->isDuplicate = true;
                                        @endphp
                                    @else
                                        @php
                                            $item->isDuplicate = false;
                                        @endphp
                                    @endif
                                    <tr>
                                        <td class="px-2 py-2">  
                                            @if($item->isDuplicate)
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
                                        <td td class="px-1 py-1">
                                            @if($item->nenaplativ > 0)
                                                <!-- <a class="cursor-pointer mx-auto text-red-600 hover:text-red-100" wire:click="nenaplativShowModal({{ $item->ldtid }})" title="Promeni status"> -->
                                                    <svg class="mx-auto fill-red-400 w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">	<path class="st1" d="M320,464c8.8,0,16-7.2,16-16V160h-80c-17.7,0-32-14.3-32-32V48H64c-8.8,0-16,7.2-16,16v384 c0,8.8,7.2,16,16,16H320z M0,64C0,28.7,28.7,0,64,0h165.5c17,0,33.3,6.7,45.3,18.7l90.5,90.5c12,12,18.7,28.3,18.7,45.3V448 c0,35.3-28.7,64-64,64H64c-35.3,0-64-28.7-64-64V64z"/> <path class="st1" d="M48,238c0,39.8,21.1,75.3,54,98.4c0,0.2,0,0.4,0,0.6v36c0,14.9,12.1,27,27,27h27v-27c0-5,4-9,9-9s9,4,9,9v27 h36v-27c0-5,4-9,9-9s9,4,9,9v27h27c14.9,0,27-12.1,27-27v-36c0-0.2,0-0.4,0-0.6c32.9-23.1,54-58.6,54-98.4	c0-22.2-6.6-43.1-18.1-61.2h-24.5c-40.6,0-75-27.1-86.2-64.1c-5-0.5-10.1-0.7-15.2-0.7C112.5,112,48,168.4,48,238z M138,292	c-19.9,0-36-16.1-36-36s16.1-36,36-36s36,16.1,36,36S157.9,292,138,292z M246,220c19.9,0,36,16.1,36,36s-16.1,36-36,36 s-36-16.1-36-36S226.1,220,246,220z"/></svg>
                                                <!-- </a> -->
                                            @endif
                                        </td> 
                                        <td class="px-2 py-2">@if($item->datum_pocetak != '') {{ App\Http\Helpers::datumFormatDan($item->datum_pocetak) }} @endif</td>
                                        <td class="px-2 py-2">@if($item->datum_kraj != '') {{ App\Http\Helpers::datumFormatDan($item->datum_kraj) }} @endif</td>                                       
                                        <td class="px-1 py-1">
                                            @if($osnovna_licenca_id > 0 && !$item->isDuplicate)
                                                <a class="cursor-pointer hover:text-green-400" wire:click="dodajLicencaShowModal('{{$item->id}}', '{{$item->ldtid}}')" title="Dodaj licencu">
                                                    <svg class="fill-current w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" enable-background="new 0 0 384 512"><g id="Layer_1_1_" display="none"><path display="inline" d="M320,464c8.8,0,16-7.2,16-16V160h-80c-17.7,0-32-14.3-32-32V48H64c-8.8,0-16,7.2-16,16v384c0,8.8,7.2,16,16,16H320z M0,64C0,28.7,28.7,0,64,0h165.5c17,0,33.3,6.7,45.3,18.7l90.5,90.5c12,12,18.7,28.3,18.7,45.3V448c0,35.3-28.7,64-64,64H64c-35.3,0-64-28.7-64-64V64z"/></g><g><path d="M373.1,134.6L253.4,15.3C243.5,5.5,230.2,0,216.3,0H59C26.5,0,0,26.5,0,59v394c0,32.5,26.5,59,59,59h266c32.5,0,59-26.5,59-59V160.9C384,151,380.1,141.5,373.1,134.6z M228.4,27.8c2.7,1.3,5.1,3,7.3,5.2l119.1,118.7h-61.4c-35.8,0-65-29.2-65-65V27.8z M359,453c0,9-3.6,17.5-10,24c-6.5,6.5-15,10-24,10H59c-9,0-17.5-3.6-24-10c-6.5-6.5-10-15-10-24V59c0-9,3.6-17.5,10-24c6.5-6.5,15-10,24-10h144.4v61.8c0,49.6,40.4,90,90,90H359V453z"/><polygon points="207,208.3 177,208.3 177,284.8 100.5,284.8 100.5,314.8 177,314.8 177,391.3 207,391.3 207,314.8 283.5,314.8 283.5,284.8 207,284.8"/></g></svg>
                                                </a>
                                            @endif
                                        </td>
                                        <td class="px-1 py-1">
                                            @if($item->licenca_naziv != '')
                                                <a class="cursor-pointer text-red-500 hover:text-red-800" wire:click="deleteLicencuShowModal('{{$item->id}}', '{{$item->ldtid}}')" title="Obriši licencu">
                                                    <svg class="fill-current w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><g display="none"><path display="inline" d="M320,464c8.8,0,16-7.2,16-16V160h-80c-17.7,0-32-14.3-32-32V48H64c-8.8,0-16,7.2-16,16v384 c0,8.8,7.2,16,16,16H320z M0,64C0,28.7,28.7,0,64,0h165.5c17,0,33.3,6.7,45.3,18.7l90.5,90.5c12,12,18.7,28.3,18.7,45.3V448 c0,35.3-28.7,64-64,64H64c-35.3,0-64-28.7-64-64V64z"/></g><path d="M373.1,134.6L253.4,15.3C243.5,5.5,230.2,0,216.3,0H59C26.5,0,0,26.5,0,59v394c0,32.5,26.5,59,59,59h266 c32.5,0,59-26.5,59-59V160.9C384,151,380.1,141.5,373.1,134.6z M354.8,151.7h-61.4c-35.8,0-65-29.2-65-65V27.8 c2.7,1.3,5.1,3,7.3,5.2L354.8,151.7z M359,453c0,9-3.6,17.5-10,24c-6.5,6.5-15,10-24,10H59c-9,0-17.5-3.6-24-10 c-6.5-6.5-10-15-10-24V59c0-9,3.6-17.5,10-24c6.5-6.5,15-10,24-10h144.4v61.8c0,49.6,40.4,90,90,90H359V453z"/><path d="M210.2,319l71.6-104c4.7-6.8,3-16.2-3.8-20.9c-6.8-4.7-16.2-3-20.9,3.8L192,292.6L126.9,198c-4.7-6.8-14-8.5-20.9-3.8 c-6.8,4.7-8.5,14-3.8,20.9l71.6,104l-71.6,104c-4.7,6.8-3,16.2,3.8,20.9c2.6,1.8,5.6,2.6,8.5,2.6c4.8,0,9.5-2.3,12.4-6.5l65.1-94.6 l65.1,94.6c2.9,4.2,7.6,6.5,12.4,6.5c2.9,0,5.9-0.9,8.5-2.6c6.8-4.7,8.5-14,3.8-20.9L210.2,319z"/></svg>
                                                </a>
                                            @endif
                                        </td>
                                        <td td class="px-1 py-1">
                                            @if($item->licenca_naziv != '' && $item->broj_parametara_licence > 0)
                                                <a class="cursor-pointer text-sky-500 hover:text-red-800" wire:click="parametriLicenceShowModal( '{{ $item->ldtid }}', '{{ $item->licenca_naziv }}')" title="Parametri licence">
                                                    <svg class="fill-current w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><g id="Layer_1_1_" display="none"><path display="inline" d="M320,464c8.8,0,16-7.2,16-16V160h-80c-17.7,0-32-14.3-32-32V48H64c-8.8,0-16,7.2-16,16v384 c0,8.8,7.2,16,16,16H320z M0,64C0,28.7,28.7,0,64,0h165.5c17,0,33.3,6.7,45.3,18.7l90.5,90.5c12,12,18.7,28.3,18.7,45.3V448 c0,35.3-28.7,64-64,64H64c-35.3,0-64-28.7-64-64V64z"/></g><g><path d="M373.1,134.6L253.4,15.3C243.5,5.5,230.2,0,216.3,0H59C26.5,0,0,26.5,0,59v394c0,32.5,26.5,59,59,59h266 c32.5,0,59-26.5,59-59V160.9C384,151,380.1,141.5,373.1,134.6z M228.4,27.8c2.7,1.3,5.1,3,7.3,5.2l119.1,118.7h-61.4 c-35.8,0-65-29.2-65-65V27.8z M359,453c0,9-3.6,17.5-10,24c-6.5,6.5-15,10-24,10H59c-9,0-17.5-3.6-24-10c-6.5-6.5-10-15-10-24V59 c0-9,3.6-17.5,10-24c6.5-6.5,15-10,24-10h144.4v61.8c0,21.2,7.4,40.8,19.8,56.2h-61.1v64h64v-60.5c8.6,9.7,19.2,17.5,31.2,22.8V207 h64v-30.2H359V453z"/><rect x="62.7" y="143" width="64" height="64"/><rect x="62.7" y="256" width="64" height="64"/><rect x="162.1" y="256" width="64" height="64"/><rect x="257.3" y="256" width="64" height="64"/><rect x="62.7" y="369" width="64" height="64"/><rect x="162.1" y="369" width="64" height="64"/><rect x="257.3" y="369" width="64" height="64"/></g></svg>
                                                </a>
                                            @endif
                                        </td>
                                        
                                        <td class="px-1 py-2">
                                             {{-- Da li terminal ima licencu --}}
                                            @if($item->licenca_naziv == '')
                                                <x-jet-danger-button class="ml-2" wire:click="deleteShowModal('{{$item->id}}', '{{$item->ldtid}}')" title="Obriši terminal">
                                                    <svg class="fill-current w-4 h-4 mr-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69zM31.1 128H416V448C416 483.3 387.3 512 352 512H95.1C60.65 512 31.1 483.3 31.1 448V128zM111.1 208V432C111.1 440.8 119.2 448 127.1 448C136.8 448 143.1 440.8 143.1 432V208C143.1 199.2 136.8 192 127.1 192C119.2 192 111.1 199.2 111.1 208zM207.1 208V432C207.1 440.8 215.2 448 223.1 448C232.8 448 240 440.8 240 432V208C240 199.2 232.8 192 223.1 192C215.2 192 207.1 199.2 207.1 208zM304 208V432C304 440.8 311.2 448 320 448C328.8 448 336 440.8 336 432V208C336 199.2 328.8 192 320 192C311.2 192 304 199.2 304 208z"/></svg>
                                                </x-jet-danger-button>
                                            @else
                                                {{-- Da li je prvi red za terminal --}}
                                                @if(!$item->isDuplicate)
                                                    <x-jet-secondary-button class="ml-2" wire:click="terminalInfoShowModal({{ $item->id }})" title="Info">
                                                    <svg class="fill-red-500 w-5 h-5 mr-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 128c17.67 0 32 14.33 32 32c0 17.67-14.33 32-32 32S224 177.7 224 160C224 142.3 238.3 128 256 128zM296 384h-80C202.8 384 192 373.3 192 360s10.75-24 24-24h16v-64H224c-13.25 0-24-10.75-24-24S210.8 224 224 224h32c13.25 0 24 10.75 24 24v88h16c13.25 0 24 10.75 24 24S309.3 384 296 384z"/></svg>
                                                    </x-jet-secondary-button>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                    @php
                                        $olditem = $item;
                                    @endphp
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

    {{-- Add / update Modal Form --}}
    <x-jet-dialog-modal wire:model="modalFormVisible">
        <x-slot name="title">
            @if ($isUpdate) {{ __('Izmeni podatke - ') }}{{ $d_naziv }}
            @else {{ __('Novi terminal') }} @endif
        </x-slot>

        <x-slot name="content">
            @if ($isUpdate)
                <!-- NEMA UPDATE :) -->
            @else
                <!-- DODAVANJE NOVOG TERMINALA -->
                <div class="my-4 pl-4">
                        <svg class="fill-current w-5 h-5 float-left mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M288 0C305.7 0 320 14.33 320 32V96C320 113.7 305.7 128 288 128H208V160H424.1C456.6 160 483.5 183.1 488.2 214.4L510.9 364.1C511.6 368.8 512 373.6 512 378.4V448C512 483.3 483.3 512 448 512H64C28.65 512 0 483.3 0 448V378.4C0 373.6 .3622 368.8 1.083 364.1L23.76 214.4C28.5 183.1 55.39 160 87.03 160H143.1V128H63.1C46.33 128 31.1 113.7 31.1 96V32C31.1 14.33 46.33 0 63.1 0L288 0zM96 48C87.16 48 80 55.16 80 64C80 72.84 87.16 80 96 80H256C264.8 80 272 72.84 272 64C272 55.16 264.8 48 256 48H96zM80 448H432C440.8 448 448 440.8 448 432C448 423.2 440.8 416 432 416H80C71.16 416 64 423.2 64 432C64 440.8 71.16 448 80 448zM112 216C98.75 216 88 226.7 88 240C88 253.3 98.75 264 112 264C125.3 264 136 253.3 136 240C136 226.7 125.3 216 112 216zM208 264C221.3 264 232 253.3 232 240C232 226.7 221.3 216 208 216C194.7 216 184 226.7 184 240C184 253.3 194.7 264 208 264zM160 296C146.7 296 136 306.7 136 320C136 333.3 146.7 344 160 344C173.3 344 184 333.3 184 320C184 306.7 173.3 296 160 296zM304 264C317.3 264 328 253.3 328 240C328 226.7 317.3 216 304 216C290.7 216 280 226.7 280 240C280 253.3 290.7 264 304 264zM256 296C242.7 296 232 306.7 232 320C232 333.3 242.7 344 256 344C269.3 344 280 333.3 280 320C280 306.7 269.3 296 256 296zM400 264C413.3 264 424 253.3 424 240C424 226.7 413.3 216 400 216C386.7 216 376 226.7 376 240C376 253.3 386.7 264 400 264zM352 296C338.7 296 328 306.7 328 320C328 333.3 338.7 344 352 344C365.3 344 376 333.3 376 320C376 306.7 365.3 296 352 296z"/></svg>
                        TERMINALI:
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
                        <td><x-jet-input wire:model="searchBK" id="" class="block bg-orange-50 w-full" type="text" placeholder="Broj kutije" /></td>
                        <td></td>
                    </tr>
                    <tbody>
                        @foreach($this->terminaliZaLokaciju( $searchSN, $searchBK) as $item)
                            <tr>
                                <td><input type="checkbox" value="{{ $item->id }}" wire:model="selsectedTerminals"  class="form-checkbox h-6 w-6 text-blue-500"></td>
                                <td> {{ $item->sn }}</td>
                                <td> {{ $item->broj_kutije }}</td>
                                <td> {{ $item->model }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mb-6">
                    {{ $this->terminaliZaLokaciju( $searchSN, $searchBK)->links() }} 
                </div>

                <div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3" role="alert">
                    <p class="text-sm">Ukupno terminala: <span class="font-bold"> {{ count($selsectedTerminals) }}</span></p>
                </div>
                
                <!-- DA LI DISTRIBUTER IMA OSNOVNU LICENCU -->
                @if($osnovna_licenca_id > 0)
                    <div class="my-4 pl-4">
                        <svg class="fill-current w-5 h-5 float-left mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M373.1,134.6L253.4,15.3C243.5,5.5,230.2,0,216.3,0H59C26.5,0,0,26.5,0,59v394c0,32.5,26.5,59,59,59h266 c32.5,0,59-26.5,59-59V160.9C384,151.1,380.1,141.6,373.1,134.6z M354.9,151.8h-61.5c-35.8,0-65-29.2-65-65v-59 c2.7,1.3,5.1,3.1,7.3,5.2L354.9,151.8z M359,453c0,9-3.6,17.5-10,24c-6.5,6.5-15,10-24,10H59c-9,0-17.5-3.6-24-10 c-6.5-6.5-10-15-10-24V59c0-9,3.6-17.5,10-24c6.5-6.5,15-10,24-10h144.4v61.8c0,49.6,40.4,90,90,90H359V453z"/><g><path d="M159.9,391.1h111.3v26.3h-141V197.8h29.7V391.1z"/></g></svg>
                        LICENCE:
                    </div>
                    @if(count($licence_za_dodavanje))
                        <div>
                            @foreach( App\Models\LicencaDistributerCena::naziviNeDodatihLicenci($licence_za_dodavanje, $distId) as $licenca_dodatak)
                            <div class="my-4 border-y py-2">
                                <input id="{{$licenca_dodatak->id}}" type="checkbox" value="{{ $licenca_dodatak->id }}" wire:model="licence_za_dodavanje"  class="form-checkbox h-6 w-6 text-blue-500">
                                <span class="font-bold pl-2">{{ $licenca_dodatak->licenca_naziv }}</span>
                            </div>
                            @endforeach
                        </div>
                        <div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3" role="alert">
                            <p>Dodate licence:</p>
                            @foreach( App\Models\LicencaDistributerCena::naziviDodatihLicenci($licence_za_dodavanje) as $licenca)
                                <div class="flex border-b border-blue-500 mt-2">
                                    <div class="inline-block align-middle text-sm mr-4">Licenca: <span class="font-bold"> {{ $licenca->licenca_naziv }}</span></div>
                                    <div class="max-w-2xl grid grid-cols-5 gap-2 mb-4 ml-4">
                                        @foreach(App\Models\LicencaParametar::parametriLicence($licenca->licenca_tipId) as $parametar)
                                            <div class="px-1 bg-white rounded-md text-center">
                                                <input id="{{$parametar->id}}" type="checkbox" value="{{$parametar->id}}" wire:model="parametri"  class="form-checkbox h-6 w-6 text-blue-500 my-2"><br />
                                                <label class="break-words" for="{{$parametar->id}}">{{$parametar->param_opis}}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="my-4 border-y py-2">
                            <input id="{{$osnovna_licenca_id}}" type="checkbox" value="{{ $osnovna_licenca_id }}" wire:model="licence_za_dodavanje"  class="form-checkbox h-6 w-6 text-blue-500">
                            <span class="font-bold pl-2">{{ $osnovna_licenca_naziv }}</span>
                        </div>
                    @endif
                @endif
                
                @if(count($licence_za_dodavanje))
                    <div class="flex justify-between">
                        <div class="pl-4 my-4 flex">
                            <div class="mt-4 px-4">
                                <svg class="fill-blue-500 w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M32 0C14.3 0 0 14.3 0 32S14.3 64 32 64V75c0 42.4 16.9 83.1 46.9 113.1L146.7 256 78.9 323.9C48.9 353.9 32 394.6 32 437v11c-17.7 0-32 14.3-32 32s14.3 32 32 32H64 320h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V437c0-42.4-16.9-83.1-46.9-113.1L237.3 256l67.9-67.9c30-30 46.9-70.7 46.9-113.1V64c17.7 0 32-14.3 32-32s-14.3-32-32-32H320 64 32zM288 437v11H96V437c0-25.5 10.1-49.9 28.1-67.9L192 301.3l67.9 67.9c18 18 28.1 42.4 28.1 67.9z"/></svg>
                            </div>
                            <div>
                                <x-jet-label for="datum_pocetka_licence" value="Datum početka licence" />
                                <x-jet-input id="datum_pocetka_licence" type="date" class="mt-1 block" value="{{ $datum_pocetka_licence }}" wire:model.defer="datum_pocetka_licence" />
                                @error('datum_pocetka_licence') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="pr-4 mt-4 flex">
                            <div class="mt-4 px-4">
                                <svg class="fill-blue-500 w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M32 0C14.3 0 0 14.3 0 32S14.3 64 32 64V75c0 42.4 16.9 83.1 46.9 113.1L146.7 256 78.9 323.9C48.9 353.9 32 394.6 32 437v11c-17.7 0-32 14.3-32 32s14.3 32 32 32H64 320h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V437c0-42.4-16.9-83.1-46.9-113.1L237.3 256l67.9-67.9c30-30 46.9-70.7 46.9-113.1V64c17.7 0 32-14.3 32-32s-14.3-32-32-32H320 64 32zM96 75V64H288V75c0 25.5-10.1 49.9-28.1 67.9L192 210.7l-67.9-67.9C106.1 124.9 96 100.4 96 75z"/></svg>
                            </div>
                            <div>
                                <x-jet-label for="datum_kraja_licence" value="Datum isteka licence" />
                                <x-jet-input id="datum_kraja_licence" type="date" class="mt-1 block" value="{{ $datum_kraja_licence }}" wire:model="datum_kraja_licence" />
                                @error('datum_kraja_licence') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    @if(!$dani_trajanja)
                        <div class="bg-red-50 border border-red-500 text-red-500 px-4 py-3 rounded relative my-4 " role="alert">
                            <p class="">Greška!<br />
                            <span class="font-bold block sm:inline">Datum isteka licence mora biti veći od datuma početka!</span>
                            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                                <svg class="fill-red-500 h-6 w-6 " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M506.3 417l-213.3-364c-16.33-28-57.54-28-73.98 0l-213.2 364C-10.59 444.9 9.849 480 42.74 480h426.6C502.1 480 522.6 445 506.3 417zM232 168c0-13.25 10.75-24 24-24S280 154.8 280 168v128c0 13.25-10.75 24-23.1 24S232 309.3 232 296V168zM256 416c-17.36 0-31.44-14.08-31.44-31.44c0-17.36 14.07-31.44 31.44-31.44s31.44 14.08 31.44 31.44C287.4 401.9 273.4 416 256 416z"/></svg>
                            </span>
                            </p>
                        </div>
                    @endif
                @endif
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
                @if(count($selsectedTerminals))
                    <x-jet-button class="ml-2" wire:click="create" wire:loading.attr="disabled">
                        {{ __('Doadj terminale') }}
                    </x-jet-danger-button>
                @endif
            @endif            
        </x-slot>
    </x-jet-dialog-modal>

    <!-- Dodaj licencu Modal -->
    <x-jet-dialog-modal wire:model="dodajLicencuModalVisible">
        <x-slot name="title">
            {{ __('Dodaj licence terminalu') }}
        </x-slot>
        <x-slot name="content">
            <div class="my-4">
                @if(count($licence_dodate_terminalu) || count($licence_za_dodavanje))
                    <div>
                        @foreach( App\Models\LicencaDistributerCena::naziviNeDodatihLicenci($licence_za_dodavanje, $distId, $licence_dodate_terminalu) as $licenca_dodatak)
                        <div class="my-4 border-y py-2">
                            <input id="{{ $licenca_dodatak->id }}" type="checkbox" value="{{ $licenca_dodatak->id }}" wire:model="licence_za_dodavanje"  class="form-checkbox h-6 w-6 text-blue-500">
                            <span class="font-bold pl-2">{{ $licenca_dodatak->licenca_naziv }}</span>
                        </div>
                        @endforeach
                    </div>
                    @if(count($licence_dodate_terminalu))
                    <div class="bg-blue-50 border-t border-b border-blue-200 text-blue-700 px-4 py-3" role="alert">
                        <p>Ranije dodate licence:</p>
                            @foreach( App\Models\LicencaDistributerCena::naziviDodatihLicenci($licence_dodate_terminalu) as $licenca)
                                <div class="flex border-b border-blue-500 mt-2">
                                    <div class="inline-block align-middle text-sm mr-4">Licenca: <span class="font-bold"> {{ $licenca->licenca_naziv }}</span></div>
                                </div>
                            @endforeach
                    </div>
                    @endif

                    @if(count($licence_za_dodavanje))
                    <div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3 mt-5" role="alert">
                        <p>Dodate licence:</p>
                            @foreach( App\Models\LicencaDistributerCena::naziviDodatihLicenci($licence_za_dodavanje) as $nova_licenca)
                                <div class="flex border-b border-blue-500 mt-2">
                                    <div class="inline-block align-middle text-sm mr-4">Licenca: <span class="font-bold"> {{ $nova_licenca->licenca_naziv }}</span></div>
                                    <div class="max-w-2xl grid grid-cols-5 gap-2 mb-4 ml-4">
                                        @foreach(App\Models\LicencaParametar::parametriLicence($nova_licenca->licenca_tipId) as $parametar)
                                            <div class="px-1 bg-white rounded-md text-center">
                                                <input id="{{$parametar->id}}" type="checkbox" value="{{$parametar->id}}" wire:model="parametri"  class="form-checkbox h-6 w-6 text-blue-500 my-2"><br />
                                                <label class="break-words" for="{{$parametar->id}}">{{$parametar->param_opis}}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                    </div>
                    @endif
                @else
                    <div class="my-4 border-y py-2">
                        <input type="checkbox" value="{{ $osnovna_licenca_id }}" wire:model="licence_za_dodavanje"  class="form-checkbox h-6 w-6 text-blue-500">
                        <span class="font-bold pl-2">{{ $osnovna_licenca_naziv }}</span>
                    </div>
                @endif

                @if(count($licence_za_dodavanje))
                    <div class="flex justify-between">
                        <div class="pl-4 my-4 flex">
                            <div class="mt-4 px-4">
                                <svg class="fill-blue-500 w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M32 0C14.3 0 0 14.3 0 32S14.3 64 32 64V75c0 42.4 16.9 83.1 46.9 113.1L146.7 256 78.9 323.9C48.9 353.9 32 394.6 32 437v11c-17.7 0-32 14.3-32 32s14.3 32 32 32H64 320h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V437c0-42.4-16.9-83.1-46.9-113.1L237.3 256l67.9-67.9c30-30 46.9-70.7 46.9-113.1V64c17.7 0 32-14.3 32-32s-14.3-32-32-32H320 64 32zM288 437v11H96V437c0-25.5 10.1-49.9 28.1-67.9L192 301.3l67.9 67.9c18 18 28.1 42.4 28.1 67.9z"/></svg>
                            </div>
                            <div>
                                <x-jet-label for="datum_pocetka_licence" value="Datum početka licence" />
                                <x-jet-input id="datum_pocetka_licence" type="date" class="mt-1 block" value="{{ $datum_pocetka_licence }}" wire:model.defer="datum_pocetka_licence" />
                                @error('datum_pocetka_licence') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="pr-4 mt-4 flex">
                            <div class="mt-4 px-4">
                                <svg class="fill-blue-500 w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M32 0C14.3 0 0 14.3 0 32S14.3 64 32 64V75c0 42.4 16.9 83.1 46.9 113.1L146.7 256 78.9 323.9C48.9 353.9 32 394.6 32 437v11c-17.7 0-32 14.3-32 32s14.3 32 32 32H64 320h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V437c0-42.4-16.9-83.1-46.9-113.1L237.3 256l67.9-67.9c30-30 46.9-70.7 46.9-113.1V64c17.7 0 32-14.3 32-32s-14.3-32-32-32H320 64 32zM96 75V64H288V75c0 25.5-10.1 49.9-28.1 67.9L192 210.7l-67.9-67.9C106.1 124.9 96 100.4 96 75z"/></svg>
                            </div>
                            <div>
                                <x-jet-label for="datum_kraja_licence" value="Datum isteka licence" />
                                <x-jet-input id="datum_kraja_licence" type="date" class="mt-1 block" value="{{ $datum_kraja_licence }}" wire:model="datum_kraja_licence" />
                                @error('datum_kraja_licence') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="my-4">
                @if(!$dani_trajanja)
                    <div class="bg-red-50 border border-red-500 text-red-500 px-4 py-3 rounded relative my-4 " role="alert">
                        <p class="">Greška!<br />
                        <span class="font-bold block sm:inline">Datum isteka licence mora biti veći od datuma početka!</span>
                        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                            <svg class="fill-red-500 h-6 w-6 " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M506.3 417l-213.3-364c-16.33-28-57.54-28-73.98 0l-213.2 364C-10.59 444.9 9.849 480 42.74 480h426.6C502.1 480 522.6 445 506.3 417zM232 168c0-13.25 10.75-24 24-24S280 154.8 280 168v128c0 13.25-10.75 24-23.1 24S232 309.3 232 296V168zM256 416c-17.36 0-31.44-14.08-31.44-31.44c0-17.36 14.07-31.44 31.44-31.44s31.44 14.08 31.44 31.44C287.4 401.9 273.4 416 256 416z"/></svg>
                        </span>
                        </p>
                    </div>
                @endif
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('dodajLicencuModalVisible')" wire:loading.attr="disabled">
                {{ __('Otkaži') }}
            </x-jet-secondary-button>
            @if(count($licence_za_dodavanje))
                <x-jet-button class="ml-2" wire:click="dodajLicenceTerminalu" wire:loading.attr="disabled">
                    {{ __('Dodaj licence') }}
                </x-jet-button>
            @endif
        </x-slot>
    </x-jet-dialog-modal>

    {{-- The Delete Modal --}}
    <x-jet-dialog-modal wire:model="modalConfirmDeleteVisible">
        <x-slot name="title">
            @if($deleteAction == 'licenca')
                {{ __('Brisanje licence') }}
            @else
                {{ __('Brisanje terminala') }}
            @endif
        </x-slot>

        <x-slot name="content">
            @if($deleteAction == 'licenca')
                <div my-4>
                    Da li ste sigurni da želite da obišete licencu!
                </div>
                @if($briseSe == 'osnovnaIdodatne')
                    <div class="bg-red-50 border border-red-500 text-red-500 px-4 py-3 rounded relative my-4 " role="alert">
                        <p class="">Upozorenje!<br />
                        <span class="font-bold block sm:inline">Brisanjem osnovne licence biće obrisane i sve ostale licence dodate terminalu!</span>
                        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                            <svg class="fill-red-500 h-6 w-6 " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M506.3 417l-213.3-364c-16.33-28-57.54-28-73.98 0l-213.2 364C-10.59 444.9 9.849 480 42.74 480h426.6C502.1 480 522.6 445 506.3 417zM232 168c0-13.25 10.75-24 24-24S280 154.8 280 168v128c0 13.25-10.75 24-23.1 24S232 309.3 232 296V168zM256 416c-17.36 0-31.44-14.08-31.44-31.44c0-17.36 14.07-31.44 31.44-31.44s31.44 14.08 31.44 31.44C287.4 401.9 273.4 416 256 416z"/></svg>
                        </span>
                        </p>
                    </div>
                @endif
            @else
                @if($modalConfirmDeleteVisible)
                    <div my-4>
                        Da li ste sigurni da želite da uklonite terminal!
                    </div>
                    <div class="bg-sky-100 border-t-4 border-sky-500 rounded-b text-sky-900 px-4 py-3 shadow-md mb-6" role="alert">
                        <div class="flex">
                            <div class="flex-none py-1">
                                <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M288 0C305.7 0 320 14.33 320 32V96C320 113.7 305.7 128 288 128H208V160H424.1C456.6 160 483.5 183.1 488.2 214.4L510.9 364.1C511.6 368.8 512 373.6 512 378.4V448C512 483.3 483.3 512 448 512H64C28.65 512 0 483.3 0 448V378.4C0 373.6 .3622 368.8 1.083 364.1L23.76 214.4C28.5 183.1 55.39 160 87.03 160H143.1V128H63.1C46.33 128 31.1 113.7 31.1 96V32C31.1 14.33 46.33 0 63.1 0L288 0zM96 48C87.16 48 80 55.16 80 64C80 72.84 87.16 80 96 80H256C264.8 80 272 72.84 272 64C272 55.16 264.8 48 256 48H96zM80 448H432C440.8 448 448 440.8 448 432C448 423.2 440.8 416 432 416H80C71.16 416 64 423.2 64 432C64 440.8 71.16 448 80 448zM112 216C98.75 216 88 226.7 88 240C88 253.3 98.75 264 112 264C125.3 264 136 253.3 136 240C136 226.7 125.3 216 112 216zM208 264C221.3 264 232 253.3 232 240C232 226.7 221.3 216 208 216C194.7 216 184 226.7 184 240C184 253.3 194.7 264 208 264zM160 296C146.7 296 136 306.7 136 320C136 333.3 146.7 344 160 344C173.3 344 184 333.3 184 320C184 306.7 173.3 296 160 296zM304 264C317.3 264 328 253.3 328 240C328 226.7 317.3 216 304 216C290.7 216 280 226.7 280 240C280 253.3 290.7 264 304 264zM256 296C242.7 296 232 306.7 232 320C232 333.3 242.7 344 256 344C269.3 344 280 333.3 280 320C280 306.7 269.3 296 256 296zM400 264C413.3 264 424 253.3 424 240C424 226.7 413.3 216 400 216C386.7 216 376 226.7 376 240C376 253.3 386.7 264 400 264zM352 296C338.7 296 328 306.7 328 320C328 333.3 338.7 344 352 344C365.3 344 376 333.3 376 320C376 306.7 365.3 296 352 296z"/></svg>
                            </div>
                            <div class="flex-auto">
                                <p>Serijski broj: <span class="font-bold"> {{ $terminalInfo->sn }}</span>, Kutija: {{ $terminalInfo->broj_kutije }}</p>
                                <p class="text-sm">Status: <span class="font-bold">{{ $terminalInfo->ts_naziv }}</span></p>
                            </div>
                            <div class="self-end w-8">
                                @if($terminalInfo->blacklist == 1)
                                    <svg class="fill-current w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">	<path class="st1" d="M320,464c8.8,0,16-7.2,16-16V160h-80c-17.7,0-32-14.3-32-32V48H64c-8.8,0-16,7.2-16,16v384 c0,8.8,7.2,16,16,16H320z M0,64C0,28.7,28.7,0,64,0h165.5c17,0,33.3,6.7,45.3,18.7l90.5,90.5c12,12,18.7,28.3,18.7,45.3V448 c0,35.3-28.7,64-64,64H64c-35.3,0-64-28.7-64-64V64z"/> <path class="st1" d="M48,238c0,39.8,21.1,75.3,54,98.4c0,0.2,0,0.4,0,0.6v36c0,14.9,12.1,27,27,27h27v-27c0-5,4-9,9-9s9,4,9,9v27 h36v-27c0-5,4-9,9-9s9,4,9,9v27h27c14.9,0,27-12.1,27-27v-36c0-0.2,0-0.4,0-0.6c32.9-23.1,54-58.6,54-98.4	c0-22.2-6.6-43.1-18.1-61.2h-24.5c-40.6,0-75-27.1-86.2-64.1c-5-0.5-10.1-0.7-15.2-0.7C112.5,112,48,168.4,48,238z M138,292	c-19.9,0-36-16.1-36-36s16.1-36,36-36s36,16.1,36,36S157.9,292,138,292z M246,220c19.9,0,36,16.1,36,36s-16.1,36-36,36 s-36-16.1-36-36S226.1,220,246,220z"/></svg>
                                @else
                                    <svg class="fill-current w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M373.1,134.6L253.4,15.3C243.5,5.5,230.2,0,216.3,0H59C26.5,0,0,26.5,0,59v394c0,32.5,26.5,59,59,59h266 c32.5,0,59-26.5,59-59V160.9C384,151.1,380.1,141.6,373.1,134.6z M354.9,151.8h-61.5c-35.8,0-65-29.2-65-65v-59 c2.7,1.3,5.1,3.1,7.3,5.2L354.9,151.8z M359,453c0,9-3.6,17.5-10,24c-6.5,6.5-15,10-24,10H59c-9,0-17.5-3.6-24-10 c-6.5-6.5-10-15-10-24V59c0-9,3.6-17.5,10-24c6.5-6.5,15-10,24-10h144.4v61.8c0,49.6,40.4,90,90,90H359V453z"/><g><path d="M159.9,391.1h111.3v26.3h-141V197.8h29.7V391.1z"/></g></svg>
                                @endif
                            </div>
                        </div>
                    </div> 
                @endif
            @endif
        </x-slot>

        <x-slot name="footer">
        
            <x-jet-secondary-button wire:click="$toggle('modalConfirmDeleteVisible')" wire:loading.attr="disabled">
                {{ __('Otkaži') }}
            </x-jet-secondary-button>
       

            @if($deleteAction == 'licenca')
                <x-jet-danger-button class="ml-2" wire:click="delteLicenca" wire:loading.attr="disabled">
                    {{ __('Obriši licencu') }}
                </x-jet-danger-button>
            @else
                <x-jet-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
                    {{ __('Obriši terminal') }}
                </x-jet-danger-button>
            @endif
        </x-slot>
    </x-jet-dialog-modal>

    {{-- The Terminal Info Modal --}}
    <x-jet-dialog-modal wire:model="modalTerminalInfoVisible">
        <x-slot name="title">
            <svg class="float-left fill-red-500 w-4 h-4 mr-2 mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 128c17.67 0 32 14.33 32 32c0 17.67-14.33 32-32 32S224 177.7 224 160C224 142.3 238.3 128 256 128zM296 384h-80C202.8 384 192 373.3 192 360s10.75-24 24-24h16v-64H224c-13.25 0-24-10.75-24-24S210.8 224 224 224h32c13.25 0 24 10.75 24 24v88h16c13.25 0 24 10.75 24 24S309.3 384 296 384z"/></svg>
                Info
        </x-slot>
        <x-slot name="content">
            @if($modalTerminalInfoVisible)
            <div class="bg-sky-100 border-t-4 border-sky-500 rounded-b text-sky-900 px-4 py-3 shadow-md mb-6" role="alert">
                <div class="flex">
                    <div class="flex-none py-1">
                        <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M288 0C305.7 0 320 14.33 320 32V96C320 113.7 305.7 128 288 128H208V160H424.1C456.6 160 483.5 183.1 488.2 214.4L510.9 364.1C511.6 368.8 512 373.6 512 378.4V448C512 483.3 483.3 512 448 512H64C28.65 512 0 483.3 0 448V378.4C0 373.6 .3622 368.8 1.083 364.1L23.76 214.4C28.5 183.1 55.39 160 87.03 160H143.1V128H63.1C46.33 128 31.1 113.7 31.1 96V32C31.1 14.33 46.33 0 63.1 0L288 0zM96 48C87.16 48 80 55.16 80 64C80 72.84 87.16 80 96 80H256C264.8 80 272 72.84 272 64C272 55.16 264.8 48 256 48H96zM80 448H432C440.8 448 448 440.8 448 432C448 423.2 440.8 416 432 416H80C71.16 416 64 423.2 64 432C64 440.8 71.16 448 80 448zM112 216C98.75 216 88 226.7 88 240C88 253.3 98.75 264 112 264C125.3 264 136 253.3 136 240C136 226.7 125.3 216 112 216zM208 264C221.3 264 232 253.3 232 240C232 226.7 221.3 216 208 216C194.7 216 184 226.7 184 240C184 253.3 194.7 264 208 264zM160 296C146.7 296 136 306.7 136 320C136 333.3 146.7 344 160 344C173.3 344 184 333.3 184 320C184 306.7 173.3 296 160 296zM304 264C317.3 264 328 253.3 328 240C328 226.7 317.3 216 304 216C290.7 216 280 226.7 280 240C280 253.3 290.7 264 304 264zM256 296C242.7 296 232 306.7 232 320C232 333.3 242.7 344 256 344C269.3 344 280 333.3 280 320C280 306.7 269.3 296 256 296zM400 264C413.3 264 424 253.3 424 240C424 226.7 413.3 216 400 216C386.7 216 376 226.7 376 240C376 253.3 386.7 264 400 264zM352 296C338.7 296 328 306.7 328 320C328 333.3 338.7 344 352 344C365.3 344 376 333.3 376 320C376 306.7 365.3 296 352 296z"/></svg>
                    </div>
                    <div class="flex-auto">
                        <p>Serijski broj: <span class="font-bold"> {{ $terminalInfo->sn }}</span>, Kutija: {{ $terminalInfo->broj_kutije }}</p>
                        <p class="text-sm">Status: <span class="font-bold">{{ $terminalInfo->ts_naziv }}</span></p>
                    </div>
                    <div class="self-end w-8">
                        @if($terminalInfo->blacklist == 1)
                            <svg class="fill-current w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">	<path class="st1" d="M320,464c8.8,0,16-7.2,16-16V160h-80c-17.7,0-32-14.3-32-32V48H64c-8.8,0-16,7.2-16,16v384 c0,8.8,7.2,16,16,16H320z M0,64C0,28.7,28.7,0,64,0h165.5c17,0,33.3,6.7,45.3,18.7l90.5,90.5c12,12,18.7,28.3,18.7,45.3V448 c0,35.3-28.7,64-64,64H64c-35.3,0-64-28.7-64-64V64z"/> <path class="st1" d="M48,238c0,39.8,21.1,75.3,54,98.4c0,0.2,0,0.4,0,0.6v36c0,14.9,12.1,27,27,27h27v-27c0-5,4-9,9-9s9,4,9,9v27 h36v-27c0-5,4-9,9-9s9,4,9,9v27h27c14.9,0,27-12.1,27-27v-36c0-0.2,0-0.4,0-0.6c32.9-23.1,54-58.6,54-98.4	c0-22.2-6.6-43.1-18.1-61.2h-24.5c-40.6,0-75-27.1-86.2-64.1c-5-0.5-10.1-0.7-15.2-0.7C112.5,112,48,168.4,48,238z M138,292	c-19.9,0-36-16.1-36-36s16.1-36,36-36s36,16.1,36,36S157.9,292,138,292z M246,220c19.9,0,36,16.1,36,36s-16.1,36-36,36 s-36-16.1-36-36S226.1,220,246,220z"/></svg>
                        @else
                            <svg class="fill-current w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M373.1,134.6L253.4,15.3C243.5,5.5,230.2,0,216.3,0H59C26.5,0,0,26.5,0,59v394c0,32.5,26.5,59,59,59h266 c32.5,0,59-26.5,59-59V160.9C384,151.1,380.1,141.6,373.1,134.6z M354.9,151.8h-61.5c-35.8,0-65-29.2-65-65v-59 c2.7,1.3,5.1,3.1,7.3,5.2L354.9,151.8z M359,453c0,9-3.6,17.5-10,24c-6.5,6.5-15,10-24,10H59c-9,0-17.5-3.6-24-10 c-6.5-6.5-10-15-10-24V59c0-9,3.6-17.5,10-24c6.5-6.5,15-10,24-10h144.4v61.8c0,49.6,40.4,90,90,90H359V453z"/><g><path d="M159.9,391.1h111.3v26.3h-141V197.8h29.7V391.1z"/></g></svg>
                        @endif
                    </div>
                </div>
            </div> 
                <div class="bg-sky-100 border-t-4 border-sky-500 rounded-b text-sky-900 px-4 py-3 shadow-md mb-6" role="alert">
                    <p class="font-bold">Licence:</p>   
                    @foreach($licenceNaziviInfo as $lice_inf)
                        <p class="pl-2">{{ $lice_inf->licenca_naziv }}</p>
                    @endforeach
                </div>
                <div class="bg-red-50 border border-red-500 text-red-500 px-4 py-3 rounded relative my-4 " role="alert">
                    <p class="">Ukljanjanje terminala<br />
                    <span class="font-bold block sm:inline">Da bi ste uklonili terminal, potrebno je obrisati sve licence.</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg class="fill-red-500 h-6 w-6 " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M506.3 417l-213.3-364c-16.33-28-57.54-28-73.98 0l-213.2 364C-10.59 444.9 9.849 480 42.74 480h426.6C502.1 480 522.6 445 506.3 417zM232 168c0-13.25 10.75-24 24-24S280 154.8 280 168v128c0 13.25-10.75 24-23.1 24S232 309.3 232 296V168zM256 416c-17.36 0-31.44-14.08-31.44-31.44c0-17.36 14.07-31.44 31.44-31.44s31.44 14.08 31.44 31.44C287.4 401.9 273.4 416 256 416z"/></svg>
                    </span>
                    </p>
                </div>
            @endif
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalTerminalInfoVisible')" wire:loading.attr="disabled">
                {{ __('Otkaži') }}
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
    
    {{-- The Parametri Modal --}}
    <x-jet-dialog-modal wire:model="parametriModalVisible">
        <x-slot name="title">
            <svg class="float-left fill-red-500 w-5 h-5 mr-2 mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><g id="Layer_1_1_" display="none"><path display="inline" d="M320,464c8.8,0,16-7.2,16-16V160h-80c-17.7,0-32-14.3-32-32V48H64c-8.8,0-16,7.2-16,16v384 c0,8.8,7.2,16,16,16H320z M0,64C0,28.7,28.7,0,64,0h165.5c17,0,33.3,6.7,45.3,18.7l90.5,90.5c12,12,18.7,28.3,18.7,45.3V448 c0,35.3-28.7,64-64,64H64c-35.3,0-64-28.7-64-64V64z"/></g><g><path d="M373.1,134.6L253.4,15.3C243.5,5.5,230.2,0,216.3,0H59C26.5,0,0,26.5,0,59v394c0,32.5,26.5,59,59,59h266 c32.5,0,59-26.5,59-59V160.9C384,151,380.1,141.5,373.1,134.6z M228.4,27.8c2.7,1.3,5.1,3,7.3,5.2l119.1,118.7h-61.4 c-35.8,0-65-29.2-65-65V27.8z M359,453c0,9-3.6,17.5-10,24c-6.5,6.5-15,10-24,10H59c-9,0-17.5-3.6-24-10c-6.5-6.5-10-15-10-24V59 c0-9,3.6-17.5,10-24c6.5-6.5,15-10,24-10h144.4v61.8c0,21.2,7.4,40.8,19.8,56.2h-61.1v64h64v-60.5c8.6,9.7,19.2,17.5,31.2,22.8V207 h64v-30.2H359V453z"/><rect x="62.7" y="143" width="64" height="64"/><rect x="62.7" y="256" width="64" height="64"/><rect x="162.1" y="256" width="64" height="64"/><rect x="257.3" y="256" width="64" height="64"/><rect x="62.7" y="369" width="64" height="64"/><rect x="162.1" y="369" width="64" height="64"/><rect x="257.3" y="369" width="64" height="64"/></g></svg>
                Parametri licence
        </x-slot>
        <x-slot name="content">
            @if($parametriModalVisible)
                <div class="flex border-b border-blue-500 mt-2">
                    <div class="inline-block align-middle text-sm mr-4">Licenca: <span class="font-bold">{{$pm_licenca_naziv}}</span></div>
                    <div class="max-w-2xl grid grid-cols-5 gap-2 mb-4 ml-4">
                        @foreach(App\Models\LicencaParametar::parametriLicence($pm_licenca_tip_id) as $parametar)
                            <div class="px-1 bg-white rounded-md text-center">
                                <input id="{{$parametar->id}}" type="checkbox" value="{{$parametar->id}}" wire:model="parametri"  class="form-checkbox h-6 w-6 text-blue-500 my-2"><br />
                                <label class="break-words" for="{{$parametar->id}}">{{$parametar->param_opis}}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('parametriModalVisible')" wire:loading.attr="disabled">
                {{ __('Otkaži') }}
            </x-jet-secondary-button>
            <x-jet-danger-button class="ml-2" wire:click="updateParametreLicence" wire:loading.attr="disabled">
                {{ __('Izmeni parametre') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>