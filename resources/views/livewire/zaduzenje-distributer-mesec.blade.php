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
                                <th class="px-2 py-2 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Serijski broj</th>
                                <th class="px-2 py-2 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Lokacija</th>
                                <th class="px-2 py-2 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Licenca</th>
                                <th class="px-2 py-2 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"></th>
                                <th class="px-2 py-2 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Početak</th>
                                <th class="px-2 py-2 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Kraj</th>
                                <th colspan=3 class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Ukupno licenci: {{ $data->total() }}<br /> Ukupno terminala {{$br_terminala}}</th>
                                <th class="px-2 py-2 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"></th>
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
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @php
                                $olditem = new stdClass();
                                $olditem->id = '';
                            @endphp

                        {{-- DATA TABLE --}}    
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
                                        <td> 
                                            <a wire:click="changeDatesVisible({{$item->ldtid}})" title="Promeni datume">
                                                <svg class="fill-cyan-500 w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M128 0c17.7 0 32 14.3 32 32V64H288V32c0-17.7 14.3-32 32-32s32 14.3 32 32V64h48c26.5 0 48 21.5 48 48v48H0V112C0 85.5 21.5 64 48 64H96V32c0-17.7 14.3-32 32-32zM0 192H448V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V192zm64 80v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zm128 0v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H208c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H336zM64 400v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H208zm112 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H336c-8.8 0-16 7.2-16 16z"/></svg>
                                            </a>
                                        </td>  
                                        <td class="px-2 py-2">
                                            @if($item->datum_pocetak != '')
                                                @if($item->markPocetak == 'errGt' || $item->markPocetak == 'errLt')
                                                    <svg class="float-left fill-red-400 w-4 h-4 mr-2 mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) --><path d="M569.517 440.013C587.975 472.007 564.806 512 527.94 512H48.054c-36.937 0-59.999-40.055-41.577-71.987L246.423 23.985c18.467-32.009 64.72-31.951 83.154 0l239.94 416.028zM288 354c-25.405 0-46 20.595-46 46s20.595 46 46 46 46-20.595 46-46-20.595-46-46-46zm-43.673-165.346l7.418 136c.347 6.364 5.609 11.346 11.982 11.346h48.546c6.373 0 11.635-4.982 11.982-11.346l7.418-136c.375-6.874-5.098-12.654-11.982-12.654h-63.383c-6.884 0-12.356 5.78-11.981 12.654z"/></svg>
                                                @endif
                                                {{ App\Http\Helpers::datumFormatDan($item->datum_pocetak) }} 
                                            @endif</td>
                                        <td class="px-2 py-2">
                                            @if($item->datum_kraj != '') 
                                                @if($item->markKraj == 'errGt' || $item->markKraj == 'errLt')
                                                    <svg class="float-left fill-red-400 w-4 h-4 mr-2 mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) --><path d="M569.517 440.013C587.975 472.007 564.806 512 527.94 512H48.054c-36.937 0-59.999-40.055-41.577-71.987L246.423 23.985c18.467-32.009 64.72-31.951 83.154 0l239.94 416.028zM288 354c-25.405 0-46 20.595-46 46s20.595 46 46 46 46-20.595 46-46-20.595-46-46-46zm-43.673-165.346l7.418 136c.347 6.364 5.609 11.346 11.982 11.346h48.546c6.373 0 11.635-4.982 11.982-11.346l7.418-136c.375-6.874-5.098-12.654-11.982-12.654h-63.383c-6.884 0-12.356 5.78-11.981 12.654z"/></svg>
                                                @endif
                                                {{ App\Http\Helpers::datumFormatDan($item->datum_kraj) }} 
                                            @endif</td>                                       
                                        <td>
                                            @if($item->iskljucen || $item->cenaLicence == 0)
                                                <svg class="fill-red-400 w-4 h-4 mt-0.5 pr-1 float-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm79 143c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z"/></svg>
                                            @endif
                                            <span class="font-bold">@money($item->cenaLicence) </span>RSD
                                        </td>
                                        <td class="px-2 py-2">
                                            @if($item->licenca_broj_dana > $mesecRow->m_broj_dana)
                                                <svg class="fill-red-400 w-4 h-4 mt-0.5 float-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M184 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H96c-35.3 0-64 28.7-64 64v16 48V448c0 35.3 28.7 64 64 64H416c35.3 0 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H376V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H184V24zM80 192H432V448c0 8.8-7.2 16-16 16H96c-8.8 0-16-7.2-16-16V192zm176 40c-13.3 0-24 10.7-24 24v48H184c-13.3 0-24 10.7-24 24s10.7 24 24 24h48v48c0 13.3 10.7 24 24 24s24-10.7 24-24V352h48c13.3 0 24-10.7 24-24s-10.7-24-24-24H280V256c0-13.3-10.7-24-24-24z"/></svg>
                                            @elseif($item->licenca_broj_dana < $mesecRow->m_broj_dana)
                                                <svg class="fill-green-400 w-4 h-4 mt-0.5 float-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M160 0c13.3 0 24 10.7 24 24V64H328V24c0-13.3 10.7-24 24-24s24 10.7 24 24V64h40c35.3 0 64 28.7 64 64v16 48V448c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V192 144 128c0-35.3 28.7-64 64-64h40V24c0-13.3 10.7-24 24-24zM432 192H80V448c0 8.8 7.2 16 16 16H416c8.8 0 16-7.2 16-16V192zM328 352H184c-13.3 0-24-10.7-24-24s10.7-24 24-24H328c13.3 0 24 10.7 24 24s-10.7 24-24 24z"/></svg>
                                            @endif
                                            {{ $item->licenca_broj_dana }} 
                                        </td>
                                        <td class="px-2 py-2">
                                            <!-- class="text-red-600 bg-gray-100 border-gray-300 rounded focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 form-checkbox h-6 w-6" -->
                                            <input type="checkbox" value="{{ $item->ldtid }}" wire:model="ne_zaduzuju_se"> 
                                        </td>
                                        <td class="px-1">
                                            <a wire:click="nenaplativShovModal({{ $item }})" title="Nenaplativ">
                                                <svg class="fill-red-300 w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">	<path class="st1" d="M320,464c8.8,0,16-7.2,16-16V160h-80c-17.7,0-32-14.3-32-32V48H64c-8.8,0-16,7.2-16,16v384 c0,8.8,7.2,16,16,16H320z M0,64C0,28.7,28.7,0,64,0h165.5c17,0,33.3,6.7,45.3,18.7l90.5,90.5c12,12,18.7,28.3,18.7,45.3V448 c0,35.3-28.7,64-64,64H64c-35.3,0-64-28.7-64-64V64z"/> <path class="st1" d="M48,238c0,39.8,21.1,75.3,54,98.4c0,0.2,0,0.4,0,0.6v36c0,14.9,12.1,27,27,27h27v-27c0-5,4-9,9-9s9,4,9,9v27 h36v-27c0-5,4-9,9-9s9,4,9,9v27h27c14.9,0,27-12.1,27-27v-36c0-0.2,0-0.4,0-0.6c32.9-23.1,54-58.6,54-98.4	c0-22.2-6.6-43.1-18.1-61.2h-24.5c-40.6,0-75-27.1-86.2-64.1c-5-0.5-10.1-0.7-15.2-0.7C112.5,112,48,168.4,48,238z M138,292	c-19.9,0-36-16.1-36-36s16.1-36,36-36s36,16.1,36,36S157.9,292,138,292z M246,220c19.9,0,36,16.1,36,36s-16.1,36-36,36 s-36-16.1-36-36S226.1,220,246,220z"/></svg>
                                            </a>
                                        </td>
                                    </tr>
                                    @php
                                        $olditem = $item;
                                    @endphp
                                @endforeach
                            @else 
                                <tr>
                                    <td class="px-6 py-4 text-sm whitespace-no-wrap" colspan="4">Nisu pronađeni terminali sa aktivnom licencom</td>
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
        <div class="bg-sky-100 border-t-4 border-sky-500 rounded-b text-sky-900 px-4 pt-6 shadow-md mb-6 pb-8" role="alert">
            <div class="flex justify-between">
                <div class="py-1">
                    <p>Distributer: <span class="font-bold">{{ $distributer_info->distributer_naziv }} </span></p>
                        @if(count($ne_zaduzuju_se))
                        <p>Broj licenci koje se ne zadužuju: <span class="font-bold">{{ count($ne_zaduzuju_se) }} </span></p>
                    @endif
                </div>
                <div class="py-1">
                    <p>Ukupna suma zaduženja: <span class="font-bold">@money($ukupno_zaduzenje) </span> RSD</p>
                    <p class="text-sm">Srednji kurs evra: @money($srednjiKurs)</p>
                </div>
                <div class="py-1">
                    <button wire:click="showZaduzenjeConfirmModal" class="flex border border-green-600 bg-green-400 hover:bg-green-200 text-white hover:text-green-600 font-bold uppercase py-2 px-4 rounded mx-2">
                        <svg class="fill-current w-6 h-6 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM64 80c0-8.8 7.2-16 16-16h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16zm0 64c0-8.8 7.2-16 16-16h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16zm128 72c8.8 0 16 7.2 16 16v17.3c8.5 1.2 16.7 3.1 24.1 5.1c8.5 2.3 13.6 11 11.3 19.6s-11 13.6-19.6 11.3c-11.1-3-22-5.2-32.1-5.3c-8.4-.1-17.4 1.8-23.6 5.5c-5.7 3.4-8.1 7.3-8.1 12.8c0 3.7 1.3 6.5 7.3 10.1c6.9 4.1 16.6 7.1 29.2 10.9l.5 .1 0 0 0 0c11.3 3.4 25.3 7.6 36.3 14.6c12.1 7.6 22.4 19.7 22.7 38.2c.3 19.3-9.6 33.3-22.9 41.6c-7.7 4.8-16.4 7.6-25.1 9.1V440c0 8.8-7.2 16-16 16s-16-7.2-16-16V422.2c-11.2-2.1-21.7-5.7-30.9-8.9l0 0c-2.1-.7-4.2-1.4-6.2-2.1c-8.4-2.8-12.9-11.9-10.1-20.2s11.9-12.9 20.2-10.1c2.5 .8 4.8 1.6 7.1 2.4l0 0 0 0 0 0c13.6 4.6 24.6 8.4 36.3 8.7c9.1 .3 17.9-1.7 23.7-5.3c5.1-3.2 7.9-7.3 7.8-14c-.1-4.6-1.8-7.8-7.7-11.6c-6.8-4.3-16.5-7.4-29-11.2l-1.6-.5 0 0c-11-3.3-24.3-7.3-34.8-13.7c-12-7.2-22.6-18.9-22.7-37.3c-.1-19.4 10.8-32.8 23.8-40.5c7.5-4.4 15.8-7.2 24.1-8.7V232c0-8.8 7.2-16 16-16z"/></svg>
                        {{ __('Zaduži distributera') }}
                    </button>
                </div>
            </div>
        </div> 
    </div>

    {{-- The NENAPLATIVI table --}}
    <div class="px-4 py-3 flex sm:px-6 mt-20">
        <div class="ml-2 pr-2">
            <svg class="fill-red-600 w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">	<path class="st1" d="M320,464c8.8,0,16-7.2,16-16V160h-80c-17.7,0-32-14.3-32-32V48H64c-8.8,0-16,7.2-16,16v384 c0,8.8,7.2,16,16,16H320z M0,64C0,28.7,28.7,0,64,0h165.5c17,0,33.3,6.7,45.3,18.7l90.5,90.5c12,12,18.7,28.3,18.7,45.3V448 c0,35.3-28.7,64-64,64H64c-35.3,0-64-28.7-64-64V64z"/> <path class="st1" d="M48,238c0,39.8,21.1,75.3,54,98.4c0,0.2,0,0.4,0,0.6v36c0,14.9,12.1,27,27,27h27v-27c0-5,4-9,9-9s9,4,9,9v27 h36v-27c0-5,4-9,9-9s9,4,9,9v27h27c14.9,0,27-12.1,27-27v-36c0-0.2,0-0.4,0-0.6c32.9-23.1,54-58.6,54-98.4	c0-22.2-6.6-43.1-18.1-61.2h-24.5c-40.6,0-75-27.1-86.2-64.1c-5-0.5-10.1-0.7-15.2-0.7C112.5,112,48,168.4,48,238z M138,292	c-19.9,0-36-16.1-36-36s16.1-36,36-36s36,16.1,36,36S157.9,292,138,292z M246,220c19.9,0,36,16.1,36,36s-16.1,36-36,36 s-36-16.1-36-36S226.1,220,246,220z"/></svg>
        </div>
        <div class="font-bold"> NENAPLATIVE LICENCE</div>
    </div>
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200" style="width: 100% !important">
                        <thead>
                            <tr>
                                <th class="py-2 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"></th>
                                <th class="px-2 py-2 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Serijski broj</th>
                                <th class="px-2 py-2 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Lokacija</th>
                                <th class="px-2 py-2 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Licenca</th>
                                <th class="px-2 py-2 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"></th>
                                <th class="px-2 py-2 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Početak</th>
                                <th class="px-2 py-2 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Kraj</th>
                                
                                <th colspan=2 class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Ukupno licenci: {{ $ndata->total() }}</th>
                                <th class="px-2 py-2 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">  
                        {{-- SEARCH ROW --}}
                            <tr class="bg-orange-50">
                                <td></td>
                                <td>
                                    <x-jet-input wire:model="searchTerminalSnNpl" id="" class="block bg-orange-50 w-48" type="text" placeholder="Serijski broj" />
                                </td>
                                <td>
                                    <x-jet-input wire:model="searchMestoNpl" id="" class="block bg-orange-50 w-fit" type="text" placeholder="Pretraži mesto" />
                                </td>
                                <td>
                                    <select wire:model="searchTipLicenceNpl" id="" class="block appearance-none bg-orange-50 w-full border border-0 text-gray-700 py-3 px-4 pr-8 round leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
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
                                <td></td>
                                <td></td>
                            </tr>
                            @php
                                $olditem = new stdClass();
                                $olditem->id = '';
                            @endphp

                        {{-- DATA TABLE --}}    
                            @if ($ndata->count())
                                @foreach ($ndata as $item)

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
                                        <td class="px-1 py-2">
                                            
                                        </td>
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
                                        <td> 
                                            <a wire:click="changeDatesVisible({{$item->ldtid}})" title="Promeni datume">
                                                <svg class="fill-cyan-500 w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M128 0c17.7 0 32 14.3 32 32V64H288V32c0-17.7 14.3-32 32-32s32 14.3 32 32V64h48c26.5 0 48 21.5 48 48v48H0V112C0 85.5 21.5 64 48 64H96V32c0-17.7 14.3-32 32-32zM0 192H448V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V192zm64 80v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zm128 0v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H208c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H336zM64 400v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H208zm112 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H336c-8.8 0-16 7.2-16 16z"/></svg>
                                            </a>
                                        </td>  
                                        <td class="px-2 py-2">
                                            @if($item->datum_pocetak != '')
                                                @if($item->markPocetak == 'errGt' || $item->markPocetak == 'errLt')
                                                    <svg class="float-left fill-red-400 w-4 h-4 mr-2 mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) --><path d="M569.517 440.013C587.975 472.007 564.806 512 527.94 512H48.054c-36.937 0-59.999-40.055-41.577-71.987L246.423 23.985c18.467-32.009 64.72-31.951 83.154 0l239.94 416.028zM288 354c-25.405 0-46 20.595-46 46s20.595 46 46 46 46-20.595 46-46-20.595-46-46-46zm-43.673-165.346l7.418 136c.347 6.364 5.609 11.346 11.982 11.346h48.546c6.373 0 11.635-4.982 11.982-11.346l7.418-136c.375-6.874-5.098-12.654-11.982-12.654h-63.383c-6.884 0-12.356 5.78-11.981 12.654z"/></svg>
                                                @endif
                                                {{ App\Http\Helpers::datumFormatDan($item->datum_pocetak) }} 
                                            @endif</td>
                                        <td class="px-2 py-2">
                                            @if($item->datum_kraj != '') 
                                                @if($item->markKraj == 'errGt' || $item->markKraj == 'errLt')
                                                    <svg class="float-left fill-red-400 w-4 h-4 mr-2 mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) --><path d="M569.517 440.013C587.975 472.007 564.806 512 527.94 512H48.054c-36.937 0-59.999-40.055-41.577-71.987L246.423 23.985c18.467-32.009 64.72-31.951 83.154 0l239.94 416.028zM288 354c-25.405 0-46 20.595-46 46s20.595 46 46 46 46-20.595 46-46-20.595-46-46-46zm-43.673-165.346l7.418 136c.347 6.364 5.609 11.346 11.982 11.346h48.546c6.373 0 11.635-4.982 11.982-11.346l7.418-136c.375-6.874-5.098-12.654-11.982-12.654h-63.383c-6.884 0-12.356 5.78-11.981 12.654z"/></svg>
                                                @endif
                                                {{ App\Http\Helpers::datumFormatDan($item->datum_kraj) }} 
                                            @endif</td>                                       
                                        <td>
                                            @if($item->iskljucen || $item->cenaLicence == 0)
                                                <svg class="fill-red-400 w-4 h-4 mt-0.5 pr-1 float-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm79 143c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z"/></svg>
                                            @endif
                                            <span class="font-bold">@money($item->cenaLicence) </span>RSD
                                        </td>
                                        <td class="px-2 py-2">
                                            
                                        </td>
                                        <td class="px-2 py-2">
                                            <x-jet-button wire:click="nenaplativShovModal({{ $item }})">
                                                <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M373.1,134.6L253.4,15.3C243.5,5.5,230.2,0,216.3,0H59C26.5,0,0,26.5,0,59v394c0,32.5,26.5,59,59,59h266 c32.5,0,59-26.5,59-59V160.9C384,151.1,380.1,141.6,373.1,134.6z M354.9,151.8h-61.5c-35.8,0-65-29.2-65-65v-59 c2.7,1.3,5.1,3.1,7.3,5.2L354.9,151.8z M359,453c0,9-3.6,17.5-10,24c-6.5,6.5-15,10-24,10H59c-9,0-17.5-3.6-24-10 c-6.5-6.5-10-15-10-24V59c0-9,3.6-17.5,10-24c6.5-6.5,15-10,24-10h144.4v61.8c0,49.6,40.4,90,90,90H359V453z"/><g><path d="M159.9,391.1h111.3v26.3h-141V197.8h29.7V391.1z"/></g></svg>
                                                {{ __('izmeni') }}
                                            </x-jet-button>
                                        </td>
                                    </tr>
                                    @php
                                        $olditem = $item;
                                    @endphp
                                @endforeach
                            @else 
                                <tr>
                                    <td class="px-6 py-4 text-sm whitespace-no-wrap" colspan="4">Nisu pronađeni nenaplativi terminali</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-5">
    {{ $ndata->links() }}
    </div>

    {{-- The Zaduzenje Modal --}}
    <x-jet-dialog-modal wire:model="zaduzenjeConfirmVisible">
        <x-slot name="title">
            {{ __('Zaduži distributera') }}
        </x-slot>

        <x-slot name="content">
            Da li ste sigurni da želite da zadužite distributera:<br/>
            <span class="font-bold">{{ $distributer_info->distributer_naziv }}</span><br/> 
            za mesec: <br/>
            <span class="font-bold">{{ $mesecRow->mesec_naziv }}, {{ App\Http\Helpers::yearNumber($mesecRow->mesec_datum) }}</span><br/>
            za iznos:<br/>
            <span class="font-bold">@money($ukupno_zaduzenje) RSD</span><br/> 
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('zaduzenjeConfirmVisible')" wire:loading.attr="disabled">
                {{ __('Otkaži') }}
            </x-jet-secondary-button>

            <button wire:click="zaduziDistributera" class="flex border border-green-600 bg-green-400 hover:bg-green-200 text-white hover:text-green-600 font-bold uppercase py-2 px-4 rounded mx-2">
                <svg class="fill-current w-6 h-6 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM64 80c0-8.8 7.2-16 16-16h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16zm0 64c0-8.8 7.2-16 16-16h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16zm128 72c8.8 0 16 7.2 16 16v17.3c8.5 1.2 16.7 3.1 24.1 5.1c8.5 2.3 13.6 11 11.3 19.6s-11 13.6-19.6 11.3c-11.1-3-22-5.2-32.1-5.3c-8.4-.1-17.4 1.8-23.6 5.5c-5.7 3.4-8.1 7.3-8.1 12.8c0 3.7 1.3 6.5 7.3 10.1c6.9 4.1 16.6 7.1 29.2 10.9l.5 .1 0 0 0 0c11.3 3.4 25.3 7.6 36.3 14.6c12.1 7.6 22.4 19.7 22.7 38.2c.3 19.3-9.6 33.3-22.9 41.6c-7.7 4.8-16.4 7.6-25.1 9.1V440c0 8.8-7.2 16-16 16s-16-7.2-16-16V422.2c-11.2-2.1-21.7-5.7-30.9-8.9l0 0c-2.1-.7-4.2-1.4-6.2-2.1c-8.4-2.8-12.9-11.9-10.1-20.2s11.9-12.9 20.2-10.1c2.5 .8 4.8 1.6 7.1 2.4l0 0 0 0 0 0c13.6 4.6 24.6 8.4 36.3 8.7c9.1 .3 17.9-1.7 23.7-5.3c5.1-3.2 7.9-7.3 7.8-14c-.1-4.6-1.8-7.8-7.7-11.6c-6.8-4.3-16.5-7.4-29-11.2l-1.6-.5 0 0c-11-3.3-24.3-7.3-34.8-13.7c-12-7.2-22.6-18.9-22.7-37.3c-.1-19.4 10.8-32.8 23.8-40.5c7.5-4.4 15.8-7.2 24.1-8.7V232c0-8.8 7.2-16 16-16z"/></svg>
                {{ __('Zaduži distributera') }}
            </button>
        </x-slot>
    </x-jet-dialog-modal>

    {{-- Promeni Datume Modal --}}
    <x-jet-dialog-modal wire:model="changeDatesShowModal">
        <x-slot name="title">
            {{ __('Izmena datume licence') }}
        </x-slot>
        <x-slot name="content">
            <div class="flex justify-between">
                <div class="pl-4 my-4 flex">
                    <div class="mt-4 px-4">
                        <svg class="fill-blue-500 w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M32 0C14.3 0 0 14.3 0 32S14.3 64 32 64V75c0 42.4 16.9 83.1 46.9 113.1L146.7 256 78.9 323.9C48.9 353.9 32 394.6 32 437v11c-17.7 0-32 14.3-32 32s14.3 32 32 32H64 320h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V437c0-42.4-16.9-83.1-46.9-113.1L237.3 256l67.9-67.9c30-30 46.9-70.7 46.9-113.1V64c17.7 0 32-14.3 32-32s-14.3-32-32-32H320 64 32zM288 437v11H96V437c0-25.5 10.1-49.9 28.1-67.9L192 301.3l67.9 67.9c18 18 28.1 42.4 28.1 67.9z"/></svg>
                    </div>
                    <div>
                        <x-jet-label for="p_datumPocetak" value="Datum početka licence" />
                        <x-jet-input id="p_datumPocetak" type="date" class="mt-1 block" value="{{ $p_datumPocetak }}" wire:model.defer="p_datumPocetak" />
                        @error('p_datumPocetak') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="pr-4 mt-4 flex">
                    <div class="mt-4 px-4">
                        <svg class="fill-blue-500 w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M32 0C14.3 0 0 14.3 0 32S14.3 64 32 64V75c0 42.4 16.9 83.1 46.9 113.1L146.7 256 78.9 323.9C48.9 353.9 32 394.6 32 437v11c-17.7 0-32 14.3-32 32s14.3 32 32 32H64 320h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V437c0-42.4-16.9-83.1-46.9-113.1L237.3 256l67.9-67.9c30-30 46.9-70.7 46.9-113.1V64c17.7 0 32-14.3 32-32s-14.3-32-32-32H320 64 32zM96 75V64H288V75c0 25.5-10.1 49.9-28.1 67.9L192 210.7l-67.9-67.9C106.1 124.9 96 100.4 96 75z"/></svg>
                    </div>
                    <div>
                        <x-jet-label for="p_datumKraj" value="Datum isteka licence" />
                        <x-jet-input id="p_datumKraj" type="date" class="mt-1 block" value="{{ $p_datumKraj }}" wire:model="p_datumKraj" />
                        @error('p_datumKraj') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <div class="my-4">
                @if(!$brojDana)
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
            <x-jet-secondary-button wire:click="$toggle('changeDatesShowModal')" wire:loading.attr="disabled">
                {{ __('Otkaži') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="changeDates" wire:loading.attr="disabled">
                <svg class="fill-current w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M128 0c17.7 0 32 14.3 32 32V64H288V32c0-17.7 14.3-32 32-32s32 14.3 32 32V64h48c26.5 0 48 21.5 48 48v48H0V112C0 85.5 21.5 64 48 64H96V32c0-17.7 14.3-32 32-32zM0 192H448V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V192zm64 80v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zm128 0v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H208c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H336zM64 400v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H208zm112 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H336c-8.8 0-16 7.2-16 16z"/></svg>
                {{ __('Izmeni datume licence') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>

    {{-- The Nenaplativ Modal --}}
    <x-jet-dialog-modal wire:model="neModalVisible">
        <x-slot name="title">
            Promeni status licence
        </x-slot>
        <x-slot name="content">
            <div class="pl-4 my-4">
                @if($neModalVisible)
                    <p>Da li ste sigurni da želite da promenite status licence za terminal SN:</p>
                    <p class="font-bold">{{ $nenaplativRow['sn'] }}</p>
                    <p>{{ $nenaplativRow['l_naziv'] }} <br /> {{ $nenaplativRow['adresa'] }} <br /> {{ $nenaplativRow['mesto'] }}</p>
                    <p>Licenca: <span class="font-bold">{{ $nenaplativRow['licenca_naziv'] }}</span>
                @endif
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('neModalVisible')" wire:loading.attr="disabled">
                {{ __('Otkaži') }}
            </x-jet-secondary-button>
            <x-jet-danger-button class="ml-2" wire:click="promeniStatusNenaplativojLicenci" wire:loading.attr="disabled">
                <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M373.1,134.6L253.4,15.3C243.5,5.5,230.2,0,216.3,0H59C26.5,0,0,26.5,0,59v394c0,32.5,26.5,59,59,59h266 c32.5,0,59-26.5,59-59V160.9C384,151.1,380.1,141.6,373.1,134.6z M354.9,151.8h-61.5c-35.8,0-65-29.2-65-65v-59 c2.7,1.3,5.1,3.1,7.3,5.2L354.9,151.8z M359,453c0,9-3.6,17.5-10,24c-6.5,6.5-15,10-24,10H59c-9,0-17.5-3.6-24-10 c-6.5-6.5-10-15-10-24V59c0-9,3.6-17.5,10-24c6.5-6.5,15-10,24-10h144.4v61.8c0,49.6,40.4,90,90,90H359V453z"/><g><path d="M159.9,391.1h111.3v26.3h-141V197.8h29.7V391.1z"/></g></svg>
                {{ __('Promeni status licence') }}
            </x-jet-danger-button>
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
