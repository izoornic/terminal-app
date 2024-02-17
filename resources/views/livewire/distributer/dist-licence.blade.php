<div class="p-6">
    {{-- The data table --}}
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200" style="width: 100% !important">
                        <thead>
                            <tr>
                                <th class="bg-gray-50 px-2 py-3 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Z</th>
                                <th class="bg-gray-50 px-2 py-3 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Serijski broj</th>
                                <th class="bg-gray-50 px-2 py-3 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Lokacija</th>
                                <th class="bg-gray-50 px-2 py-3 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Licenca</th>
                                <th class="bg-gray-50 px-2 py-3 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Početak</th>
                                <th class="bg-gray-50 text-gray-500" ></th>
                                <th class="bg-gray-50 px-2 py-3 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Kraj</th>
                                <th colspan="3" class="bg-gray-50 px-6 py-3 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Ukupno licenci: {{ $br_licenci }}<br /> Ukupno terminala {{$br_terminala}}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">  
                        {{-- SEARCH ROW --}}
                            <tr class="bg-orange-50">
                                <td></td>
                                <td>
                                    <x-jet-input wire:model="searchTerminalSn" id="" class="block bg-orange-50 w-44" type="text" placeholder="Serijski broj" />
                                </td>
                                <td>
                                    <x-jet-input wire:model="searchMesto" id="" class="block bg-orange-50 w-48" type="text" placeholder="Pretraži mesto" />
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
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @php
                                $olditem = new stdClass();
                                $olditem->tmlokId = '';
                            @endphp
                            @if ($data->count())
                                @foreach ($data as $item)
                                    @if($olditem->tmlokId == $item->tmlokId)
                                        @php
                                            $item->isDuplicate = true;
                                        @endphp
                                    @else
                                        @php
                                            $item->isDuplicate = false;
                                        @endphp
                                    @endif

                                    @php
                                        $item->month_diff = App\Http\Helpers::monthDifference($item->datum_kraj);
                                    @endphp

                                    <tr>
                                        <td>
                                            @if($item->zaduzeno)
                                                @if($item->razduzeno && $item->razduzeno > 0)
                                                    <svg class="fill-green-500 w-5 h-5 mt-0.5 mx-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg>
                                                @elseif($item->nenaplativ)
                                                <svg class="mx-auto fill-red-400 w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">	<path class="st1" d="M320,464c8.8,0,16-7.2,16-16V160h-80c-17.7,0-32-14.3-32-32V48H64c-8.8,0-16,7.2-16,16v384 c0,8.8,7.2,16,16,16H320z M0,64C0,28.7,28.7,0,64,0h165.5c17,0,33.3,6.7,45.3,18.7l90.5,90.5c12,12,18.7,28.3,18.7,45.3V448 c0,35.3-28.7,64-64,64H64c-35.3,0-64-28.7-64-64V64z"/> <path class="st1" d="M48,238c0,39.8,21.1,75.3,54,98.4c0,0.2,0,0.4,0,0.6v36c0,14.9,12.1,27,27,27h27v-27c0-5,4-9,9-9s9,4,9,9v27 h36v-27c0-5,4-9,9-9s9,4,9,9v27h27c14.9,0,27-12.1,27-27v-36c0-0.2,0-0.4,0-0.6c32.9-23.1,54-58.6,54-98.4	c0-22.2-6.6-43.1-18.1-61.2h-24.5c-40.6,0-75-27.1-86.2-64.1c-5-0.5-10.1-0.7-15.2-0.7C112.5,112,48,168.4,48,238z M138,292	c-19.9,0-36-16.1-36-36s16.1-36,36-36s36,16.1,36,36S157.9,292,138,292z M246,220c19.9,0,36,16.1,36,36s-16.1,36-36,36 s-36-16.1-36-36S226.1,220,246,220z"/></svg>
                                                @else
                                                    <svg class="fill-red-500 h-4 w-4 mx-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M506.3 417l-213.3-364c-16.33-28-57.54-28-73.98 0l-213.2 364C-10.59 444.9 9.849 480 42.74 480h426.6C502.1 480 522.6 445 506.3 417zM232 168c0-13.25 10.75-24 24-24S280 154.8 280 168v128c0 13.25-10.75 24-23.1 24S232 309.3 232 296V168zM256 416c-17.36 0-31.44-14.08-31.44-31.44c0-17.36 14.07-31.44 31.44-31.44s31.44 14.08 31.44 31.44C287.4 401.9 273.4 416 256 416z"/></svg>
                                                @endif
                                            @endif
                                        </td>
                                        <td class="px-2 py-2">  
                                            @if($item->isDuplicate)
                                                <span class=""> <svg class="fill-sky-300 w-5 h-5 ml-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 410.1 512"><path d="M401.3,327.3L270.8,196.8c-11.7-11.7-30.7-11.7-42.4,0c-11.7,11.7-11.7,30.7,0,42.4l78.3,78.3H117.1 c-0.8,0-1.6,0-2.5,0.1c-0.2,0-25.7,1.2-40.9-12.8c-9.2-8.5-13.7-21.7-13.7-40.3V31.7c0-16.6-13.4-30-30-30S0,15.1,0,31.7v232.9 c0,44.6,18,70.5,33.1,84.4c27.9,25.7,63.9,28.8,79.3,28.8c2.4,0,4.4-0.1,5.7-0.2h190.5l-80.2,80.2c-11.7,11.7-11.7,30.7,0,42.4 c5.9,5.9,13.5,8.8,21.2,8.8s15.4-2.9,21.2-8.8l130.5-130.5C413,358,413,339,401.3,327.3z"/></svg></span> 
                                            @else
                                                {{ $item->sn }}
                                            @endif 
                                        </td>
                                        <td class="px-2 py-2">
                                            @if($item->isDuplicate)
                                                <span class=""> <svg class="fill-sky-300 w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M502.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l370.7 0-73.4 73.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l128-128z"/></svg></span> 
                                            @else
                                                {{ $item->l_naziv }}<br />{{ $item->adresa }}, {{ $item->mesto }}
                                            @endif   
                                        </td>
                                        <td class="px-2 py-2">
                                            @if($item->isDuplicate) 
                                                <span class="float-left pr-2"><svg class="fill-sky-300 w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M240 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H32c-17.7 0-32 14.3-32 32s14.3 32 32 32H176V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H384c17.7 0 32-14.3 32-32s-14.3-32-32-32H240V80z"/></svg></span>
                                            @endif
                                            {{ $item->licenca_naziv }} 
                                        </td>  
                                        <td class="px-2 py-2">@if($item->datum_pocetak != '') {{ App\Http\Helpers::datumFormatDan($item->datum_pocetak) }} @endif</td>
                                        <td>
                                            @if($item->month_diff !='')
                                                @if($item->month_diff == 0)
                                                    <svg class="fill-red-300 w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M32 0C14.3 0 0 14.3 0 32S14.3 64 32 64V75c0 42.4 16.9 83.1 46.9 113.1L146.7 256 78.9 323.9C48.9 353.9 32 394.6 32 437v11c-17.7 0-32 14.3-32 32s14.3 32 32 32H64 320h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V437c0-42.4-16.9-83.1-46.9-113.1L237.3 256l67.9-67.9c30-30 46.9-70.7 46.9-113.1V64c17.7 0 32-14.3 32-32s-14.3-32-32-32H320 64 32zM96 75V64H288V75c0 25.5-10.1 49.9-28.1 67.9L192 210.7l-67.9-67.9C106.1 124.9 96 100.4 96 75z"/></svg>
                                                @elseif($item->month_diff < 0)
                                                    <svg class="fill-red-600 w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M128 0c13.3 0 24 10.7 24 24V64H296V24c0-13.3 10.7-24 24-24s24 10.7 24 24V64h40c35.3 0 64 28.7 64 64v16 48V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V192 144 128C0 92.7 28.7 64 64 64h40V24c0-13.3 10.7-24 24-24zM400 192H48V448c0 8.8 7.2 16 16 16H384c8.8 0 16-7.2 16-16V192zm-95 89l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/></svg>
                                                @endif
                                            @endif
                                        </td>
                                        <td class="px-2 py-2">@if($item->datum_kraj != '') {{ App\Http\Helpers::datumFormatDan($item->datum_kraj) }} @endif</td>                                       
                                        <td class="px-1 py-1">
                                            @if($item->licenca_naziv != '')
                                                <a class="p-1 cursor-pointer flex border border-stone-500 bg-stone-50 hover:bg-stone-500 text-stone-700 hover:text-white rounded" title="Pregled licence" wire:click="pregledLicenceShovModal('{{$item->tmlokId}}', '{{$item->ldtid}}', {{$item->month_diff}})">
                                                    <svg class="fill-current w-6 h-8 pl-1 mx-1 my-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M373.1,134.6L253.4,15.3C243.5,5.5,230.2,0,216.3,0H59C26.5,0,0,26.5,0,59v394c0,32.5,26.5,59,59,59h266 c32.5,0,59-26.5,59-59V160.9C384,151.1,380.1,141.6,373.1,134.6z M354.9,151.8h-61.5c-35.8,0-65-29.2-65-65v-59 c2.7,1.3,5.1,3.1,7.3,5.2L354.9,151.8z M359,453c0,9-3.6,17.5-10,24c-6.5,6.5-15,10-24,10H59c-9,0-17.5-3.6-24-10 c-6.5-6.5-10-15-10-24V59c0-9,3.6-17.5,10-24c6.5-6.5,15-10,24-10h144.4v61.8c0,49.6,40.4,90,90,90H359V453z"/><g><path d="M159.9,391.1h111.3v26.3h-141V197.8h29.7V391.1z"/></g></svg>
                                                </a>
                                            @else
                                                <a class="p-1 cursor-pointer flex border border-stone-500 bg-stone-50 hover:bg-stone-500 text-stone-700 hover:text-white rounded" title="Dodaj licencu" wire:click="dodajLicencaShowModal('{{$item->tmlokId}}', '{{$item->ldtid}}')">
                                                    <svg class="fill-current w-6 h-8 pl-1 mx-1 my-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" enable-background="new 0 0 384 512"><g id="Layer_1_1_" display="none"><path display="inline" d="M320,464c8.8,0,16-7.2,16-16V160h-80c-17.7,0-32-14.3-32-32V48H64c-8.8,0-16,7.2-16,16v384c0,8.8,7.2,16,16,16H320z M0,64C0,28.7,28.7,0,64,0h165.5c17,0,33.3,6.7,45.3,18.7l90.5,90.5c12,12,18.7,28.3,18.7,45.3V448c0,35.3-28.7,64-64,64H64c-35.3,0-64-28.7-64-64V64z"/></g><g><path d="M373.1,134.6L253.4,15.3C243.5,5.5,230.2,0,216.3,0H59C26.5,0,0,26.5,0,59v394c0,32.5,26.5,59,59,59h266c32.5,0,59-26.5,59-59V160.9C384,151,380.1,141.5,373.1,134.6z M228.4,27.8c2.7,1.3,5.1,3,7.3,5.2l119.1,118.7h-61.4c-35.8,0-65-29.2-65-65V27.8z M359,453c0,9-3.6,17.5-10,24c-6.5,6.5-15,10-24,10H59c-9,0-17.5-3.6-24-10c-6.5-6.5-10-15-10-24V59c0-9,3.6-17.5,10-24c6.5-6.5,15-10,24-10h144.4v61.8c0,49.6,40.4,90,90,90H359V453z"/><polygon points="207,208.3 177,208.3 177,284.8 100.5,284.8 100.5,314.8 177,314.8 177,391.3 207,391.3 207,314.8 283.5,314.8 283.5,284.8 207,284.8"/></g></svg>
                                                </a>
                                            @endif
                                        </td>
                                        <td>@if(isset($item->dist_zaduzeno))
                                                @if($item->dist_razduzeno)
                                                    <svg class="fill-green-500 w-5 h-5 mt-0.5 mr-0.5 float-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 16"><path d="M19.94,10.45a.76.76,0,0,0-.69-.45H16.5V4a4,4,0,0,0-4-4H10A1,1,0,0,0,9,1V2a1,1,0,0,0,1,1h2.5a1,1,0,0,1,1,1v6H10.75a.75.75,0,0,0-.54,1.27l4.25,4.5a.75.75,0,0,0,1.08,0l4.25-4.5A.75.75,0,0,0,19.94,10.45Z" transform="translate(0)"/><path d="M10,13H7.5a1,1,0,0,1-1-1V6H9.25a.75.75,0,0,0,.54-1.27L5.54.23a.75.75,0,0,0-1.08,0L.21,4.73A.75.75,0,0,0,.75,6H3.5v6a4,4,0,0,0,4,4H10a1,1,0,0,0,1-1V14A1,1,0,0,0,10,13Z" transform="translate(0)"/></svg>
                                                    @money($item->dist_razduzeno) RSD
                                                @else
                                                    <svg class="fill-orange-400 w-4 h-4 mt-1 float-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M350 177.5c3.8-8.8 2-19-4.6-26l-136-144C204.9 2.7 198.6 0 192 0s-12.9 2.7-17.4 7.5l-136 144c-6.6 7-8.4 17.2-4.6 26s12.5 14.5 22 14.5h88l0 192c0 17.7-14.3 32-32 32H32c-17.7 0-32 14.3-32 32v32c0 17.7 14.3 32 32 32l80 0c70.7 0 128-57.3 128-128l0-192h88c9.6 0 18.2-5.7 22-14.5z"/></svg>
                                                    @money($item->dist_zaduzeno) RSD
                                                @endif
                                            @endif
                                        </td>  
                                        <td>
                                            @if(isset($item->dist_zaduzeno))
                                                @if($item->dist_razduzeno)
                                                <!-- RACUN -->
                                                    <a href="/dist-pdf-predracun?tip=r&ldtid={{$item->ldtid}}" target="_blank" class="flex border border-green-500 bg-green-100 hover:bg-green-600 text-stone-700 hover:text-white font-bold uppercase px-1 mr-2 rounded" title="Račun PDF">
                                                        <svg class="fill-current w-4 h-4 mr-1 mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M64 464H96v48H64c-35.3 0-64-28.7-64-64V64C0 28.7 28.7 0 64 0H229.5c17 0 33.3 6.7 45.3 18.7l90.5 90.5c12 12 18.7 28.3 18.7 45.3V288H336V160H256c-17.7 0-32-14.3-32-32V48H64c-8.8 0-16 7.2-16 16V448c0 8.8 7.2 16 16 16zM176 352h32c30.9 0 56 25.1 56 56s-25.1 56-56 56H192v32c0 8.8-7.2 16-16 16s-16-7.2-16-16V448 368c0-8.8 7.2-16 16-16zm32 80c13.3 0 24-10.7 24-24s-10.7-24-24-24H192v48h16zm96-80h32c26.5 0 48 21.5 48 48v64c0 26.5-21.5 48-48 48H304c-8.8 0-16-7.2-16-16V368c0-8.8 7.2-16 16-16zm32 128c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H320v96h16zm80-112c0-8.8 7.2-16 16-16h48c8.8 0 16 7.2 16 16s-7.2 16-16 16H448v32h32c8.8 0 16 7.2 16 16s-7.2 16-16 16H448v48c0 8.8-7.2 16-16 16s-16-7.2-16-16V432 368z"/></svg>
                                                        R
                                                    </a>
                                                @else
                                                <!-- PREDRACUN -->
                                                    <a href="/dist-pdf-predracun?tip=p&ldtid={{$item->ldtid}}" target="_blank" class="flex border border-orange-600 bg-orange-100 hover:bg-orange-600 text-stone-700 hover:text-white font-bold uppercase px-1 mr-2 rounded" title="Predračun PDF">
                                                        <svg class="fill-current w-4 h-4 mr-1 mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M64 464H96v48H64c-35.3 0-64-28.7-64-64V64C0 28.7 28.7 0 64 0H229.5c17 0 33.3 6.7 45.3 18.7l90.5 90.5c12 12 18.7 28.3 18.7 45.3V288H336V160H256c-17.7 0-32-14.3-32-32V48H64c-8.8 0-16 7.2-16 16V448c0 8.8 7.2 16 16 16zM176 352h32c30.9 0 56 25.1 56 56s-25.1 56-56 56H192v32c0 8.8-7.2 16-16 16s-16-7.2-16-16V448 368c0-8.8 7.2-16 16-16zm32 80c13.3 0 24-10.7 24-24s-10.7-24-24-24H192v48h16zm96-80h32c26.5 0 48 21.5 48 48v64c0 26.5-21.5 48-48 48H304c-8.8 0-16-7.2-16-16V368c0-8.8 7.2-16 16-16zm32 128c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H320v96h16zm80-112c0-8.8 7.2-16 16-16h48c8.8 0 16 7.2 16 16s-7.2 16-16 16H448v32h32c8.8 0 16 7.2 16 16s-7.2 16-16 16H448v48c0 8.8-7.2 16-16 16s-16-7.2-16-16V432 368z"/></svg>
                                                        P
                                                    </a>
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

    {{--  Dodaj licencu Modal --}}
    <x-jet-dialog-modal wire:model="dodajLicencuModalVisible">
        <x-slot name="title">
            {{ __('Dodaj licence terminalu') }}
        </x-slot>
        <x-slot name="content">
            <div class="my-4">
                @if(count($licence_dodate_terminalu))
                    <div class="bg-gray-50 border-t-4 border-gray-500 px-4 py-3">
                        <p>Ranije dodate licence:</p>
                            @foreach( App\Models\LicencaDistributerCena::naziviDodatihLicenci($licence_dodate_terminalu) as $licenca)
                                <div class="mt-2">
                                    <div class="inline-block align-middle text-sm mr-4">Licenca: <span class="font-bold"> {{ $licenca->licenca_naziv }}</span></div>
                                </div>
                            @endforeach
                    </div>
                @endif
            </div>
            <div class="px-4 py-2 bg-green-50 border-t-4 border-green-400">
                <p class="font-bold">Kurs evra:</p>
                <table class="min-w-full divide-y divide-gray-200">
                    <tr class="text-center">
                        <td>Datum preuzimanja</td>
                        <td class="border-x border-slate-500">Datum kursa</td>
                        <td>Prodajni</td>
                        <td class="border-x border-slate-500">Srednji</td>
                        <td>Kupovni</td>
                    </tr>
                    <tr class="text-center">
                        <td>{{ App\Http\Helpers::datumFormatDan($kurs_evra->datum_preuzimanja) }}</td>
                        <td class="border-x border-slate-500">{{ App\Http\Helpers::datumFormatDan($kurs_evra->datum_kursa) }}</td>
                        <td>{{$kurs_evra->kupovni_kurs}}</td>
                        <td class="border-x border-slate-500">{{$kurs_evra->srednji_kurs}}</td>
                        <td>{{$kurs_evra->prodajni_kurs}}</td>
                    </tr>
                </table>
            </div>
            <div class="my-4">
            @if(count($licence_za_dodavanje))
                <div class="border-y py-2 bg-gray-50">
                    <p class="ml-4 font-bold">Trajanje licence:</p>
                    <div class="flex justify-between">
                        <div class="pl-4 my-4 flex">
                            <div class="mt-4 px-4">
                                <svg class="fill-blue-500 w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M32 0C14.3 0 0 14.3 0 32S14.3 64 32 64V75c0 42.4 16.9 83.1 46.9 113.1L146.7 256 78.9 323.9C48.9 353.9 32 394.6 32 437v11c-17.7 0-32 14.3-32 32s14.3 32 32 32H64 320h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V437c0-42.4-16.9-83.1-46.9-113.1L237.3 256l67.9-67.9c30-30 46.9-70.7 46.9-113.1V64c17.7 0 32-14.3 32-32s-14.3-32-32-32H320 64 32zM288 437v11H96V437c0-25.5 10.1-49.9 28.1-67.9L192 301.3l67.9 67.9c18 18 28.1 42.4 28.1 67.9z"/></svg>
                            </div>
                            <div>
                                <x-jet-label for="datum_pocetka_licence" value="Datum početka licence" />
                                <x-jet-input id="datum_pocetka_licence" type="date" class="mt-1 block" value="{{ $datum_pocetka_licence }}" wire:model="datum_pocetka_licence" />
                                @error('datum_pocetka_licence') <span class="error">{{ $message }}</span> @enderror
                                <p class="p-2">{{ App\Http\Helpers::datumFormatDanFullYear($datum_pocetka_licence) }}</p>
                                @if($datum_pocetak_error != '')
                                    <p class="text-red-500"> {{$datum_pocetak_error}} </p>
                                @endif
                            </div>
                        </div>
                        <div class="pr-4 mt-4 flex">
                            <div class="mt-4 px-4">
                                <svg class="fill-blue-500 w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M32 0C14.3 0 0 14.3 0 32S14.3 64 32 64V75c0 42.4 16.9 83.1 46.9 113.1L146.7 256 78.9 323.9C48.9 353.9 32 394.6 32 437v11c-17.7 0-32 14.3-32 32s14.3 32 32 32H64 320h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V437c0-42.4-16.9-83.1-46.9-113.1L237.3 256l67.9-67.9c30-30 46.9-70.7 46.9-113.1V64c17.7 0 32-14.3 32-32s-14.3-32-32-32H320 64 32zM96 75V64H288V75c0 25.5-10.1 49.9-28.1 67.9L192 210.7l-67.9-67.9C106.1 124.9 96 100.4 96 75z"/></svg>
                            </div>
                            <div>
                                <x-jet-label for="datum_kraja_licence" value="Datum isteka licence" />
                                <x-jet-input id="datum_kraja_licence" type="date" class="mt-1 block" value="{{ $datum_kraja_licence }}" wire:model="datum_kraja_licence" />
                                @error('datum_kraja_licence') <span class="error">{{ $message }}</span> @enderror
                                <p class="p-2">{{ App\Http\Helpers::datumFormatDanFullYear($datum_kraja_licence) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            
            @if(!$dani_trajanja)
                <div class="my-4">
                    <div class="bg-red-50 border border-red-500 text-red-500 px-4 py-3 rounded relative my-4 " role="alert">
                        <p class="">Greška!<br />
                        <span class="font-bold block sm:inline">Datum isteka licence mora biti veći od datuma početka!</span>
                        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                            <svg class="fill-red-500 h-6 w-6 " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M506.3 417l-213.3-364c-16.33-28-57.54-28-73.98 0l-213.2 364C-10.59 444.9 9.849 480 42.74 480h426.6C502.1 480 522.6 445 506.3 417zM232 168c0-13.25 10.75-24 24-24S280 154.8 280 168v128c0 13.25-10.75 24-23.1 24S232 309.3 232 296V168zM256 416c-17.36 0-31.44-14.08-31.44-31.44c0-17.36 14.07-31.44 31.44-31.44s31.44 14.08 31.44 31.44C287.4 401.9 273.4 416 256 416z"/></svg>
                        </span>
                        </p>
                    </div>
                </div>
            @endif

            <div class="my-4">
                    <div>
                        @foreach( App\Models\LicencaDistributerCena::naziviNeDodatihLicenci($licence_za_dodavanje, $distId, $licence_dodate_terminalu) as $licenca_dodatak)
                        <div class="my-4 border-y py-2 bg-gray-50">
                            <input id="licAddM" type="checkbox" value="{{ $licenca_dodatak->id }}" wire:model="licence_za_dodavanje"  class="form-checkbox h-6 w-6 text-blue-500">
                            <span class="font-bold pl-2">{{ $licenca_dodatak->licenca_naziv }}</span>
                            @if(in_array($licenca_dodatak->id, $licence_za_dodavanje))
                                <div class="mt-2">
                                    <div class="max-w-2xl grid grid-cols-3 gap-2 mt-4 mb-4 ml-4">
                                        <div>Cena licence:
                                            <div class="px-1 flex bg-white text-center">
                                                <x-jet-input wire:model.defer="unete_cene_licenci.{{$licenca_dodatak->id}}" id="" class="block form-input rounded-none w-28" type="text" />
                                                <span class="flex-1 px-1 pt-3 border border-l-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">RSD</span>
                                            </div>
                                        </div>
                                        <div class="px-1 border-x text-center">
                                            <p>Preporučena cena:</p>
                                            @if($dodajLicencuModalVisible)
                                            <p><span class="font-bold">@money($cene_licenci[$licenca_dodatak->id]->dist_cena_din)</span> RSD</p>
                                            <p><span class="font-bold">@money($cene_licenci[$licenca_dodatak->id]->dist_cena_eur)</span> EUR</p>
                                            @endif
                                        </div>
                                        <div class="px-1 text-center">
                                        <p>Cena Zeta:</p>
                                            @if($dodajLicencuModalVisible)
                                            <p><span class="font-bold">@money($cene_licenci[$licenca_dodatak->id]->zeta_cena_din)</span> RSD</p>
                                            <p><span class="font-bold">@money($cene_licenci[$licenca_dodatak->id]->zeta_cena_eur)</span> EUR</p>
                                            @endif
                                        </div>
                                    </div>
                                    @if($unete_cene_error[$licenca_dodatak->id] != '')
                                    <div class="px-4 text-red-600">
                                        {{ $unete_cene_error[$licenca_dodatak->id] }}
                                    </div>
                                    @endif
                                </div>
                                
                                <div class="max-w-2xl grid grid-cols-5 gap-2 mt-4 mb-4 ml-10 border-t">
                                    @foreach(App\Models\LicencaParametar::parametriLicence($licenca_dodatak->licenca_tipId) as $parametar)
                                        <div class="px-1 rounded-md text-center">
                                            <input id="{{$parametar->id}}" type="checkbox" value="{{$parametar->id}}" wire:model="parametri"  class="form-checkbox h-6 w-6 text-blue-500 my-2"><br />
                                            <label class="break-words" for="{{$parametar->id}}">{{$parametar->param_opis}}</label>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
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

    {{-- The Delete LICENCU Modal --}}
    <x-jet-dialog-modal wire:model="modalConfirmDeleteVisible">
        <x-slot name="title">
            {{ __('Brisanje licence') }}
        </x-slot>

        <x-slot name="content">
            <div my-4>
                <p>Da li ste sigurni da želite da obišete licencu!<br />
                @if($licencaDeleteInfo)
                    <span class="font-bold">{{ $licencaDeleteInfo->licenca_naziv }}</span>
                @endif
                </p>
                @if(!$canDelete)
                    <div class="bg-red-50 border border-red-500 text-red-500 px-4 py-3 rounded relative my-4 " role="alert">
                        <p class="">Greška!<br />
                        <span class="font-bold block sm:inline">Zeta System DOO je napravio zaduženje za ovu licencu.</span>
                        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                            <svg class="fill-red-500 h-6 w-6 " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M506.3 417l-213.3-364c-16.33-28-57.54-28-73.98 0l-213.2 364C-10.59 444.9 9.849 480 42.74 480h426.6C502.1 480 522.6 445 506.3 417zM232 168c0-13.25 10.75-24 24-24S280 154.8 280 168v128c0 13.25-10.75 24-23.1 24S232 309.3 232 296V168zM256 416c-17.36 0-31.44-14.08-31.44-31.44c0-17.36 14.07-31.44 31.44-31.44s31.44 14.08 31.44 31.44C287.4 401.9 273.4 416 256 416z"/></svg>
                        </span>
                        </p>
                    </div>
                @endif
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalConfirmDeleteVisible')" wire:loading.attr="disabled">
                {{ __('Otkaži') }}
            </x-jet-secondary-button>
            @if($canDelete)
            <x-jet-danger-button class="ml-2" wire:click="delteLicenca" wire:loading.attr="disabled">
                {{ __('Obriši licencu') }}
            </x-jet-danger-button>
            @endif
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
                <div class="mr-4 mb-4">Licenca: <span class="font-bold">{{$pm_licenca_naziv}}</span></div>
                <div class="flex border-b border-blue-500 mt-2">
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

    {{-- Pregled licence modal --}}
    <x-jet-dialog-modal wire:model="pregledLicencaShowModal">
        <x-slot name="title">
            <svg class="float-left fill-current w-5 h-5 mr-2 mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M373.1,134.6L253.4,15.3C243.5,5.5,230.2,0,216.3,0H59C26.5,0,0,26.5,0,59v394c0,32.5,26.5,59,59,59h266 c32.5,0,59-26.5,59-59V160.9C384,151.1,380.1,141.6,373.1,134.6z M354.9,151.8h-61.5c-35.8,0-65-29.2-65-65v-59 c2.7,1.3,5.1,3.1,7.3,5.2L354.9,151.8z M359,453c0,9-3.6,17.5-10,24c-6.5,6.5-15,10-24,10H59c-9,0-17.5-3.6-24-10 c-6.5-6.5-10-15-10-24V59c0-9,3.6-17.5,10-24c6.5-6.5,15-10,24-10h144.4v61.8c0,49.6,40.4,90,90,90H359V453z"/><g><path d="M159.9,391.1h111.3v26.3h-141V197.8h29.7V391.1z"/></g></svg>
            @if($pregledLicencaShowModal)    
                Licenca: <span class="font-bold">{{$podaci_licence->licenca_naziv}}</span>
            @endif
        </x-slot>
        <x-slot name="content">
            @if($pregledLicencaShowModal)
                @if($mnth_diff < 1 || $lic_nenaplativa)
                    <div class="my-4 border-y py-2 bg-red-50 flex mx-4">
                        @if($lic_nenaplativa)
                            <svg class="fill-red-600 w-8 h-8 mx-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">	<path class="st1" d="M320,464c8.8,0,16-7.2,16-16V160h-80c-17.7,0-32-14.3-32-32V48H64c-8.8,0-16,7.2-16,16v384 c0,8.8,7.2,16,16,16H320z M0,64C0,28.7,28.7,0,64,0h165.5c17,0,33.3,6.7,45.3,18.7l90.5,90.5c12,12,18.7,28.3,18.7,45.3V448 c0,35.3-28.7,64-64,64H64c-35.3,0-64-28.7-64-64V64z"/> <path class="st1" d="M48,238c0,39.8,21.1,75.3,54,98.4c0,0.2,0,0.4,0,0.6v36c0,14.9,12.1,27,27,27h27v-27c0-5,4-9,9-9s9,4,9,9v27 h36v-27c0-5,4-9,9-9s9,4,9,9v27h27c14.9,0,27-12.1,27-27v-36c0-0.2,0-0.4,0-0.6c32.9-23.1,54-58.6,54-98.4	c0-22.2-6.6-43.1-18.1-61.2h-24.5c-40.6,0-75-27.1-86.2-64.1c-5-0.5-10.1-0.7-15.2-0.7C112.5,112,48,168.4,48,238z M138,292	c-19.9,0-36-16.1-36-36s16.1-36,36-36s36,16.1,36,36S157.9,292,138,292z M246,220c19.9,0,36,16.1,36,36s-16.1,36-36,36 s-36-16.1-36-36S226.1,220,246,220z"/></svg>
                            <p class="flex-1 mt-2 font-bold text-lg text-red-600 uppercase">Licenca je označena kao "Nenaplativa"</p>
                        @else
                            @if($mnth_diff < 0)
                                <svg class="fill-red-600 w-8 h-8 mx-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M128 0c13.3 0 24 10.7 24 24V64H296V24c0-13.3 10.7-24 24-24s24 10.7 24 24V64h40c35.3 0 64 28.7 64 64v16 48V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V192 144 128C0 92.7 28.7 64 64 64h40V24c0-13.3 10.7-24 24-24zM400 192H48V448c0 8.8 7.2 16 16 16H384c8.8 0 16-7.2 16-16V192zm-95 89l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/></svg>
                                <p class="flex-1 mt-2 font-bold text-lg text-red-600 uppercase">Licenca je istekla!</p>
                            @else
                                <svg class="fill-red-300 w-8 h-8 mx-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M32 0C14.3 0 0 14.3 0 32S14.3 64 32 64V75c0 42.4 16.9 83.1 46.9 113.1L146.7 256 78.9 323.9C48.9 353.9 32 394.6 32 437v11c-17.7 0-32 14.3-32 32s14.3 32 32 32H64 320h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V437c0-42.4-16.9-83.1-46.9-113.1L237.3 256l67.9-67.9c30-30 46.9-70.7 46.9-113.1V64c17.7 0 32-14.3 32-32s-14.3-32-32-32H320 64 32zM96 75V64H288V75c0 25.5-10.1 49.9-28.1 67.9L192 210.7l-67.9-67.9C106.1 124.9 96 100.4 96 75z"/></svg>
                                <p class="flex-1 mt-2 font-bold text-lg text-red-600 uppercase">Licenca uskoro ističe</p>
                            @endif
                        @endif
                    </div>
                @endif
                <div class="my-4 border-y py-2 bg-gray-50">
                    <p class="font-bold pl-2 mt-2">Trajanje:</p>
                    <div class="flex border-b pb-2">
                        <div class="pl-4 flex w-1/2">
                            <div class="mt-4 px-4">
                                <svg class="fill-blue-500 w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M32 0C14.3 0 0 14.3 0 32S14.3 64 32 64V75c0 42.4 16.9 83.1 46.9 113.1L146.7 256 78.9 323.9C48.9 353.9 32 394.6 32 437v11c-17.7 0-32 14.3-32 32s14.3 32 32 32H64 320h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V437c0-42.4-16.9-83.1-46.9-113.1L237.3 256l67.9-67.9c30-30 46.9-70.7 46.9-113.1V64c17.7 0 32-14.3 32-32s-14.3-32-32-32H320 64 32zM288 437v11H96V437c0-25.5 10.1-49.9 28.1-67.9L192 301.3l67.9 67.9c18 18 28.1 42.4 28.1 67.9z"/></svg>
                            </div>
                            <div>
                               <p>Datum početka licence: </p>
                               <p class="font-bold">{{App\Http\Helpers::datumFormatDanFullYear($naplata_podaci_licence->datum_pocetka_licence)}}</p>
                            </div>
                        </div>
                        <div class="pr-4 flex">
                            <div class="mt-4 px-4">
                                <svg class="fill-blue-500 w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M32 0C14.3 0 0 14.3 0 32S14.3 64 32 64V75c0 42.4 16.9 83.1 46.9 113.1L146.7 256 78.9 323.9C48.9 353.9 32 394.6 32 437v11c-17.7 0-32 14.3-32 32s14.3 32 32 32H64 320h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V437c0-42.4-16.9-83.1-46.9-113.1L237.3 256l67.9-67.9c30-30 46.9-70.7 46.9-113.1V64c17.7 0 32-14.3 32-32s-14.3-32-32-32H320 64 32zM96 75V64H288V75c0 25.5-10.1 49.9-28.1 67.9L192 210.7l-67.9-67.9C106.1 124.9 96 100.4 96 75z"/></svg>
                            </div>
                            <div>
                                <p>Datum isteka licence:</p>
                                <p class="font-bold">{{App\Http\Helpers::datumFormatDanFullYear($naplata_podaci_licence->datum_kraj_licence)}}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex pb-2 mt-4">
                        <div class="pl-2 w-1/2 border-r border-slate-500">
                            <p class="font-bold">
                                <svg class="float-left fill-orange-400 w-4 h-4 mt-1 float-left mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M350 177.5c3.8-8.8 2-19-4.6-26l-136-144C204.9 2.7 198.6 0 192 0s-12.9 2.7-17.4 7.5l-136 144c-6.6 7-8.4 17.2-4.6 26s12.5 14.5 22 14.5h88l0 192c0 17.7-14.3 32-32 32H32c-17.7 0-32 14.3-32 32v32c0 17.7 14.3 32 32 32l80 0c70.7 0 128-57.3 128-128l0-192h88c9.6 0 18.2-5.7 22-14.5z"/></svg>
                                Zaduženo:
                            </p>
                            <p class="pl-2">
                                <span class="font-bold">@money($naplata_podaci_licence->dist_zaduzeno)</span> RSD
                            </p>
                            <p>Datum zaduženja: {{ App\Http\Helpers::datumFormatDanFullYear($naplata_podaci_licence->dist_datum_zaduzenja) }}</p>
                        </div>
                        <div class="pl-4">
                            <p class="font-bold pl-2">
                                <svg class="float-left fill-green-500 w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 16"><path d="M19.94,10.45a.76.76,0,0,0-.69-.45H16.5V4a4,4,0,0,0-4-4H10A1,1,0,0,0,9,1V2a1,1,0,0,0,1,1h2.5a1,1,0,0,1,1,1v6H10.75a.75.75,0,0,0-.54,1.27l4.25,4.5a.75.75,0,0,0,1.08,0l4.25-4.5A.75.75,0,0,0,19.94,10.45Z" transform="translate(0)"/><path d="M10,13H7.5a1,1,0,0,1-1-1V6H9.25a.75.75,0,0,0,.54-1.27L5.54.23a.75.75,0,0,0-1.08,0L.21,4.73A.75.75,0,0,0,.75,6H3.5v6a4,4,0,0,0,4,4H10a1,1,0,0,0,1-1V14A1,1,0,0,0,10,13Z" transform="translate(0)"/></svg>
                                Razduženo:
                            </p>
                            @if($naplata_podaci_licence->dist_razduzeno)
                                <p class="pl-2">    
                                    <span class="font-bold">@money($naplata_podaci_licence->dist_zaduzeno)</span> RSD
                                </p>
                                <p>Datum razduženja: {{ App\Http\Helpers::datumFormatDanFullYear($naplata_podaci_licence->dist_datum_razduzenja) }}</p>
                            @else
                                <div class="flex ml-4">
                                    <x-jet-input wire:model.defer="razduzi_iznos" id="" class="block form-input rounded-none w-28" type="text" />
                                    <span class="flex-1 px-1 pt-3 border border-l-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">RSD</span>
                                    <x-jet-secondary-button wire:click="razduziUplatu" wire:loading.attr="disabled" class="flex-2 ml-4">
                                        {{ __('Razduži') }}
                                    </x-jet-secondary-button>
                                </div>
                                <div class="mt-2 pl-4">
                                    <p class="pl-2">Datum razduženja:</p>
                                    <x-jet-input wire:model.defer="razduzi_datum" id="" class="block form-input rounded-none" type="date" />
                                </div>
                                @if($razduzi_iznos_error != '')
                                <div class="px-4 text-red-600">
                                    {{ $razduzi_iznos_error }}
                                </div>
                                @endif
                            @endif
                        </div>
                    </div>

                </div>

                <div class="my-4 border-y py-2 bg-gray-50">
                    <div class="flex ml-2">
                        <svg class="w-8 h-8 mr-2" id="a3308727-d0fe-4d78-8b8e-bd5700a6f96d" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28.35 22.85"><defs><style>.a756deba-e948-48f4-9faf-c147ed77ba38{fill:#636465;}.a756deba-e948-48f4-9faf-c147ed77ba38,.b19c31e9-10f5-4334-a867-e1beb2574c09{fill-rule:evenodd;}.b19c31e9-10f5-4334-a867-e1beb2574c09{fill:#d10015;}</style></defs><path id="ba10f2a7-9b54-4ee9-8984-5eaa3793c26a" data-name="path14" class="a756deba-e948-48f4-9faf-c147ed77ba38" d="M21.88,14.56H15.54L20.37,3.79H8.51L10.2,0,28.35,0Z"/><path id="a12952de-3d27-42bc-9778-1a367bd66946" data-name="path16" class="b19c31e9-10f5-4334-a867-e1beb2574c09" d="M6.47,8.29h6.34L8,19.06H19.84l-1.69,3.76L0,22.85,6.47,8.29Z"/></svg>
                        <span class="flex-1 text-lg font-bold mt-1">Zeta System DOO</span>
                    </div>
                    <div class="flex pb-2 mt-4">
                        <div class="pl-2 w-1/2 border-r border-slate-500">
                            <p class="font-bold">
                            <svg class="float-left fill-orange-400 w-4 h-4 mt-1 float-left mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M350 177.5c3.8-8.8 2-19-4.6-26l-136-144C204.9 2.7 198.6 0 192 0s-12.9 2.7-17.4 7.5l-136 144c-6.6 7-8.4 17.2-4.6 26s12.5 14.5 22 14.5h88l0 192c0 17.7-14.3 32-32 32H32c-17.7 0-32 14.3-32 32v32c0 17.7 14.3 32 32 32l80 0c70.7 0 128-57.3 128-128l0-192h88c9.6 0 18.2-5.7 22-14.5z"/></svg>
                                Zaduženo:
                            </p>
                            <p class="pl-2"> 
                                <span class="font-bold">@money($naplata_podaci_licence->zaduzeno)</span> RSD
                            </p>
                            <p>Datum zaduženja:@if($naplata_podaci_licence->datum_zaduzenja) {{ App\Http\Helpers::datumFormatDanFullYear($naplata_podaci_licence->datum_zaduzenja) }}@endif</p>
                        </div>
                        <div class="pl-4 w-1/2 relative">
                            <p class="font-bold pl-2">
                                <svg class="float-left fill-green-500 w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 16"><path d="M19.94,10.45a.76.76,0,0,0-.69-.45H16.5V4a4,4,0,0,0-4-4H10A1,1,0,0,0,9,1V2a1,1,0,0,0,1,1h2.5a1,1,0,0,1,1,1v6H10.75a.75.75,0,0,0-.54,1.27l4.25,4.5a.75.75,0,0,0,1.08,0l4.25-4.5A.75.75,0,0,0,19.94,10.45Z" transform="translate(0)"/><path d="M10,13H7.5a1,1,0,0,1-1-1V6H9.25a.75.75,0,0,0,.54-1.27L5.54.23a.75.75,0,0,0-1.08,0L.21,4.73A.75.75,0,0,0,.75,6H3.5v6a4,4,0,0,0,4,4H10a1,1,0,0,0,1-1V14A1,1,0,0,0,10,13Z" transform="translate(0)"/></svg>
                                Razduženo:
                            </p>
                            <p class="pl-2"> 
                                <span class="font-bold">@money($naplata_podaci_licence->razduzeno)</span> RSD
                            </p>
                            <p>Datum razaduženja: @if($naplata_podaci_licence->datum_razduzenja){{ App\Http\Helpers::datumFormatDanFullYear($naplata_podaci_licence->datum_razduzenja) }}@endif</p>
                            @if($naplata_podaci_licence->zaduzeno && !$naplata_podaci_licence->razduzeno)
                                <span class="absolute top-0 bottom-0 right-0 px-4 py-4">
                                    <svg class="fill-red-500 h-6 w-6 " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M506.3 417l-213.3-364c-16.33-28-57.54-28-73.98 0l-213.2 364C-10.59 444.9 9.849 480 42.74 480h426.6C502.1 480 522.6 445 506.3 417zM232 168c0-13.25 10.75-24 24-24S280 154.8 280 168v128c0 13.25-10.75 24-23.1 24S232 309.3 232 296V168zM256 416c-17.36 0-31.44-14.08-31.44-31.44c0-17.36 14.07-31.44 31.44-31.44s31.44 14.08 31.44 31.44C287.4 401.9 273.4 416 256 416z"/></svg>
                                </span>
                            @elseif($naplata_podaci_licence->razduzeno)
                                <span class="absolute top-0 bottom-0 right-0 px-4 py-4">
                                    <svg class="fill-green-500 w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg>
                                </span>
                            @endif
                        </div>
                    </div>
                    @if(!$naplata_podaci_licence->razduzeno)
                        <div class="px-4 text-red-600"> Licenca je privremena dok se uplata prema Zeta System DOO ne razduži!</div>
                    @endif
                </div>
                @if($naplata_podaci_licence->razduzeno && !$lic_nenaplativa)
                <div class="my-4 border-y py-2 bg-gray-50">
                    <div class="flex mx-4">
                        <a class="cursor-pointer flex border border-green-500 bg-green-50 hover:bg-green-500 text-green-700 hover:text-white font-bold rounded w-min" wire:click="produziLicencuShovModal('{{$modelId}}', '{{$distrib_terminal_id}}')" title="Produži licencu">
                            <svg class="fill-current w-8 h-8 px-1 py-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M0 64C0 28.7 28.7 0 64 0H224V128c0 17.7 14.3 32 32 32H384V288H216c-13.3 0-24 10.7-24 24s10.7 24 24 24H384V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V64zM384 336V288H494.1l-39-39c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l80 80c9.4 9.4 9.4 24.6 0 33.9l-80 80c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l39-39H384zm0-208H256V0L384 128z"/></svg>
                        </a>
                        <p class="flex-1 mt-2 ml-2 font-bold">Produži licencu</p>
                    </div>
                </div>
                @endif
                <div class="my-4 border-y py-2 bg-gray-50">
                    <div class="flex mx-4">
                        <a class="cursor-pointer flex border border-stone-500 bg-stone-50 hover:bg-stone-500 text-stone-700 hover:text-white font-bold rounded w-min" wire:click="dodajIzPregledaLicenceShovModal('{{$modelId}}', '{{$distrib_terminal_id}}')" title="Dodaj licencu">
                            <svg class="fill-current w-8 h-8 px-1 py-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" enable-background="new 0 0 384 512"><g id="Layer_1_1_" display="none"><path display="inline" d="M320,464c8.8,0,16-7.2,16-16V160h-80c-17.7,0-32-14.3-32-32V48H64c-8.8,0-16,7.2-16,16v384c0,8.8,7.2,16,16,16H320z M0,64C0,28.7,28.7,0,64,0h165.5c17,0,33.3,6.7,45.3,18.7l90.5,90.5c12,12,18.7,28.3,18.7,45.3V448c0,35.3-28.7,64-64,64H64c-35.3,0-64-28.7-64-64V64z"/></g><g><path d="M373.1,134.6L253.4,15.3C243.5,5.5,230.2,0,216.3,0H59C26.5,0,0,26.5,0,59v394c0,32.5,26.5,59,59,59h266c32.5,0,59-26.5,59-59V160.9C384,151,380.1,141.5,373.1,134.6z M228.4,27.8c2.7,1.3,5.1,3,7.3,5.2l119.1,118.7h-61.4c-35.8,0-65-29.2-65-65V27.8z M359,453c0,9-3.6,17.5-10,24c-6.5,6.5-15,10-24,10H59c-9,0-17.5-3.6-24-10c-6.5-6.5-10-15-10-24V59c0-9,3.6-17.5,10-24c6.5-6.5,15-10,24-10h144.4v61.8c0,49.6,40.4,90,90,90H359V453z"/><polygon points="207,208.3 177,208.3 177,284.8 100.5,284.8 100.5,314.8 177,314.8 177,391.3 207,391.3 207,314.8 283.5,314.8 283.5,284.8 207,284.8"/></g></svg>
                        </a>
                        <p class="flex-1 mt-2 ml-2 font-bold">Dodaj licence terminalu</p>
                    </div>
                </div>
                @if($licenca_ima_parametre)
                    <div class="my-4 border-y py-2 bg-gray-50">
                        <div class="flex mx-4">
                             <a class="cursor-pointer flex border border-sky-500 text-sky-500 bg-stone-50 hover:bg-sky-500 hover:text-white font-bold rounded w-min" wire:click="parametriIzPregledaLicenceShovModal('{{$distrib_terminal_id}}')" title="Parametri licence">
                                <svg class="fill-current w-8 h-8 px-1 py-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><g id="Layer_1_1_" display="none"><path display="inline" d="M320,464c8.8,0,16-7.2,16-16V160h-80c-17.7,0-32-14.3-32-32V48H64c-8.8,0-16,7.2-16,16v384 c0,8.8,7.2,16,16,16H320z M0,64C0,28.7,28.7,0,64,0h165.5c17,0,33.3,6.7,45.3,18.7l90.5,90.5c12,12,18.7,28.3,18.7,45.3V448 c0,35.3-28.7,64-64,64H64c-35.3,0-64-28.7-64-64V64z"/></g><g><path d="M373.1,134.6L253.4,15.3C243.5,5.5,230.2,0,216.3,0H59C26.5,0,0,26.5,0,59v394c0,32.5,26.5,59,59,59h266 c32.5,0,59-26.5,59-59V160.9C384,151,380.1,141.5,373.1,134.6z M228.4,27.8c2.7,1.3,5.1,3,7.3,5.2l119.1,118.7h-61.4 c-35.8,0-65-29.2-65-65V27.8z M359,453c0,9-3.6,17.5-10,24c-6.5,6.5-15,10-24,10H59c-9,0-17.5-3.6-24-10c-6.5-6.5-10-15-10-24V59 c0-9,3.6-17.5,10-24c6.5-6.5,15-10,24-10h144.4v61.8c0,21.2,7.4,40.8,19.8,56.2h-61.1v64h64v-60.5c8.6,9.7,19.2,17.5,31.2,22.8V207 h64v-30.2H359V453z"/><rect x="62.7" y="143" width="64" height="64"/><rect x="62.7" y="256" width="64" height="64"/><rect x="162.1" y="256" width="64" height="64"/><rect x="257.3" y="256" width="64" height="64"/><rect x="62.7" y="369" width="64" height="64"/><rect x="162.1" y="369" width="64" height="64"/><rect x="257.3" y="369" width="64" height="64"/></g></svg>
                            </a>
                            <p class="flex-1 mt-2 ml-2 font-bold">Parametri licence</p>
                        </div>
                    </div>
                @endif
                @if($licenca_moze_da_se_brise)
                    <div class="my-4 border-y py-2 bg-gray-50">
                        <div class="flex mx-4">
                            <a class="cursor-pointer flex border border-red-500 text-red-500 bg-stone-50 hover:bg-red-500 hover:text-white font-bold uppercase rounded w-min" wire:click="deleteIzPregledaLicencuShowModal('{{$modelId}}', '{{$distrib_terminal_id}}')" title="Obriši licencu">
                                <svg class="fill-current w-8 h-8 px-1 py-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><g display="none"><path display="inline" d="M320,464c8.8,0,16-7.2,16-16V160h-80c-17.7,0-32-14.3-32-32V48H64c-8.8,0-16,7.2-16,16v384 c0,8.8,7.2,16,16,16H320z M0,64C0,28.7,28.7,0,64,0h165.5c17,0,33.3,6.7,45.3,18.7l90.5,90.5c12,12,18.7,28.3,18.7,45.3V448 c0,35.3-28.7,64-64,64H64c-35.3,0-64-28.7-64-64V64z"/></g><path d="M373.1,134.6L253.4,15.3C243.5,5.5,230.2,0,216.3,0H59C26.5,0,0,26.5,0,59v394c0,32.5,26.5,59,59,59h266 c32.5,0,59-26.5,59-59V160.9C384,151,380.1,141.5,373.1,134.6z M354.8,151.7h-61.4c-35.8,0-65-29.2-65-65V27.8 c2.7,1.3,5.1,3,7.3,5.2L354.8,151.7z M359,453c0,9-3.6,17.5-10,24c-6.5,6.5-15,10-24,10H59c-9,0-17.5-3.6-24-10 c-6.5-6.5-10-15-10-24V59c0-9,3.6-17.5,10-24c6.5-6.5,15-10,24-10h144.4v61.8c0,49.6,40.4,90,90,90H359V453z"/><path d="M210.2,319l71.6-104c4.7-6.8,3-16.2-3.8-20.9c-6.8-4.7-16.2-3-20.9,3.8L192,292.6L126.9,198c-4.7-6.8-14-8.5-20.9-3.8 c-6.8,4.7-8.5,14-3.8,20.9l71.6,104l-71.6,104c-4.7,6.8-3,16.2,3.8,20.9c2.6,1.8,5.6,2.6,8.5,2.6c4.8,0,9.5-2.3,12.4-6.5l65.1-94.6 l65.1,94.6c2.9,4.2,7.6,6.5,12.4,6.5c2.9,0,5.9-0.9,8.5-2.6c6.8-4.7,8.5-14,3.8-20.9L210.2,319z"/></svg>
                            </a>
                            <p class="flex-1 mt-2 ml-2 font-bold">Obriši licencu</p>
                        </div>
                    </div>
                @endif
            @endif
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('pregledLicencaShowModal')" wire:loading.attr="disabled">
                {{ __('Otkaži') }}
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>

    {{-- Produzi Licencu Modal --}}
    <x-jet-dialog-modal wire:model="produziLicModalVisible">
        <x-slot name="title">
            <svg class="float-left fill-green-500 w-5 h-5 mr-2 mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M0 64C0 28.7 28.7 0 64 0H224V128c0 17.7 14.3 32 32 32H384V288H216c-13.3 0-24 10.7-24 24s10.7 24 24 24H384V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V64zM384 336V288H494.1l-39-39c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l80 80c9.4 9.4 9.4 24.6 0 33.9l-80 80c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l39-39H384zm0-208H256V0L384 128z"/></svg>
            Produži licencu <span class="font-bold">@if($produziLicModalVisible){{$naziv_licence}}@endif</span>
        </x-slot>
        <x-slot name="content">
            <div class="px-4 py-2 bg-green-50 border-t-4 border-green-400">
                <p class="font-bold">Kurs evra:</p>
                <table class="min-w-full divide-y divide-gray-200">
                    <tr class="text-center">
                        <td>Datum preuzimanja</td>
                        <td class="border-x border-slate-500">Datum kursa</td>
                        <td>Prodajni</td>
                        <td class="border-x border-slate-500">Srednji</td>
                        <td>Kupovni</td>
                    </tr>
                    <tr class="text-center">
                        <td>{{ App\Http\Helpers::datumFormatDan($kurs_evra->datum_preuzimanja) }}</td>
                        <td class="border-x border-slate-500">{{ App\Http\Helpers::datumFormatDan($kurs_evra->datum_kursa) }}</td>
                        <td>{{$kurs_evra->kupovni_kurs}}</td>
                        <td class="border-x border-slate-500">{{$kurs_evra->srednji_kurs}}</td>
                        <td>{{$kurs_evra->prodajni_kurs}}</td>
                    </tr>
                </table>
            </div>
            <div class="my-4">
                <div class="border-y py-2 bg-gray-50">
                    <p class="ml-4 font-bold">Trajanje licence:</p>
                    <div class="flex justify-between">
                        <div class="pl-4 my-4 flex">
                            <div class="mt-4 px-4">
                                <svg class="fill-blue-500 w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M32 0C14.3 0 0 14.3 0 32S14.3 64 32 64V75c0 42.4 16.9 83.1 46.9 113.1L146.7 256 78.9 323.9C48.9 353.9 32 394.6 32 437v11c-17.7 0-32 14.3-32 32s14.3 32 32 32H64 320h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V437c0-42.4-16.9-83.1-46.9-113.1L237.3 256l67.9-67.9c30-30 46.9-70.7 46.9-113.1V64c17.7 0 32-14.3 32-32s-14.3-32-32-32H320 64 32zM288 437v11H96V437c0-25.5 10.1-49.9 28.1-67.9L192 301.3l67.9 67.9c18 18 28.1 42.4 28.1 67.9z"/></svg>
                            </div>
                            <div>
                                <p class="text-sm mb-1">Datum početka licence</p>
                                <div class="border border-gray-300 rounded p-2 text-center">{{ App\Http\Helpers::datumFormatDanFullYear($datum_pocetka_licence) }}</div>
                            </div>
                        </div>
                        <div class="pr-4 mt-4 flex">
                            <div class="mt-4 px-4">
                                <svg class="fill-blue-500 w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M32 0C14.3 0 0 14.3 0 32S14.3 64 32 64V75c0 42.4 16.9 83.1 46.9 113.1L146.7 256 78.9 323.9C48.9 353.9 32 394.6 32 437v11c-17.7 0-32 14.3-32 32s14.3 32 32 32H64 320h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V437c0-42.4-16.9-83.1-46.9-113.1L237.3 256l67.9-67.9c30-30 46.9-70.7 46.9-113.1V64c17.7 0 32-14.3 32-32s-14.3-32-32-32H320 64 32zM96 75V64H288V75c0 25.5-10.1 49.9-28.1 67.9L192 210.7l-67.9-67.9C106.1 124.9 96 100.4 96 75z"/></svg>
                            </div>
                            <div>
                                <x-jet-label for="datum_kraja_licence" value="Datum isteka licence" />
                                <x-jet-input id="datum_kraja_licence" type="date" class="mt-1 block" value="{{ $datum_kraja_licence }}" wire:model="datum_kraja_licence" />
                                @error('datum_kraja_licence') <span class="error">{{ $message }}</span> @enderror
                                <p class="p-2">{{ App\Http\Helpers::datumFormatDanFullYear($datum_kraja_licence) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            @if(!$dani_trajanja)
                <div class="my-4">
                    <div class="bg-red-50 border border-red-500 text-red-500 px-4 py-3 rounded relative my-4 " role="alert">
                        <p class="">Greška!<br />
                        <span class="font-bold block sm:inline">Datum isteka licence mora biti veći od datuma početka!</span>
                        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                            <svg class="fill-red-500 h-6 w-6 " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M506.3 417l-213.3-364c-16.33-28-57.54-28-73.98 0l-213.2 364C-10.59 444.9 9.849 480 42.74 480h426.6C502.1 480 522.6 445 506.3 417zM232 168c0-13.25 10.75-24 24-24S280 154.8 280 168v128c0 13.25-10.75 24-23.1 24S232 309.3 232 296V168zM256 416c-17.36 0-31.44-14.08-31.44-31.44c0-17.36 14.07-31.44 31.44-31.44s31.44 14.08 31.44 31.44C287.4 401.9 273.4 416 256 416z"/></svg>
                        </span>
                        </p>
                    </div>
                </div>
            @endif
            
            <div class="my-4">
                <div class="my-4 border-y py-2 bg-gray-50">
                    <div class="mt-2">
                        <div class="max-w-2xl grid grid-cols-3 gap-2 mt-4 mb-4 ml-4">
                            <div>Cena licence:
                                <div class="px-1 flex bg-white text-center">
                                    <x-jet-input wire:model.defer="produzenje_cena_licence" id="" class="block form-input rounded-none w-28" type="text" />
                                    <span class="flex-1 px-1 pt-3 border border-l-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">RSD</span>
                                </div>
                            </div>
                            <div class="px-1 border-x text-center">
                                <p>Preporučena cena:</p>
                                @if($produziLicModalVisible)
                                <p><span class="font-bold">@money($produzenje_cene[0]->dist_cena_din)</span> RSD</p>
                                <p><span class="font-bold">@money($produzenje_cene[0]->dist_cena_eur)</span> EUR</p>
                                @endif
                            </div>
                            <div class="px-1 text-center">
                            <p>Cena Zeta:</p>
                                @if($produziLicModalVisible)
                                <p><span class="font-bold">@money($produzenje_cene[0]->zeta_cena_din)</span> RSD</p>
                                <p><span class="font-bold">@money($produzenje_cene[0]->zeta_cena_eur)</span> EUR</p>
                                @endif
                            </div>
                        </div>
                        @if($produzenje_unete_cene_error != '')
                        <div class="px-4 text-red-600">
                            {{ $produzenje_unete_cene_error }}
                        </div>
                        @endif
                    </div>
                    
                   
                    <div class="max-w-2xl grid grid-cols-5 gap-2 mt-4 mb-4 ml-10 border-t">
                        @foreach(App\Models\LicencaParametar::parametriLicence($produzenje_tip_licence) as $parametar)
                            <div class="px-1 rounded-md text-center">
                                <input id="{{$parametar->id}}" type="checkbox" value="{{$parametar->id}}" wire:model="parametri"  class="form-checkbox h-6 w-6 text-blue-500 my-2"><br />
                                <label class="break-words" for="{{$parametar->id}}">{{$parametar->param_opis}}</label>
                            </div>
                        @endforeach
                    </div>
                   
                </div>
            </div>

        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('produziLicModalVisible')" wire:loading.attr="disabled">
                {{ __('Otkaži') }}
            </x-jet-secondary-button>
            <x-jet-danger-button class="ml-2" wire:click="produziLicencu" wire:loading.attr="disabled">
                {{ __('Produži licencu') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
