<div class="p-6">
    
    {{-- The data table --}}
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200" style="width: 100% !important">
                        <thead>
                            <tr>
                                <th class="px-1 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"><input type="checkbox" value="1" wire:model="selectAll.1"  class="form-checkbox h-6 w-6 text-blue-500"></th>
                                <th class="px-1 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">L</th>
                                <th class="px-1 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Serijski broj</th>
                                <th class="px-1 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Kutija</th>
                                <th class="px-1 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Lokacija</th>
                                <th class="px-1 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Region</th>
                                <th class="px-1 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Tip lokacije</th>
                                <th class="px-1 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-1 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200"> 
                        {{-- SEARCH ROW --}}
                            <tr class="bg-orange-50">
                                <td><svg class="mx-auto fill-orange-600 w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M3.853 54.87C10.47 40.9 24.54 32 40 32H472C487.5 32 501.5 40.9 508.1 54.87C514.8 68.84 512.7 85.37 502.1 97.33L320 320.9V448C320 460.1 313.2 471.2 302.3 476.6C291.5 482 278.5 480.9 268.8 473.6L204.8 425.6C196.7 419.6 192 410.1 192 400V320.9L9.042 97.33C-.745 85.37-2.765 68.84 3.854 54.87L3.853 54.87z"/></svg></td>
                                <td></td>
                                <td><x-jet-input wire:model="searchSB" id="" class="block bg-orange-50 w-full" type="text" placeholder="Serijski broj" /></td>
                                <td><x-jet-input wire:model="searchKutija" id="" class="block bg-orange-50 w-full" type="text" placeholder="Broj kutije" /></td>
                                <td>
                                    <x-jet-input wire:model="searchName" id="" class="block bg-orange-50 w-full" type="text" placeholder="Lokacija" /> 
                                </td>
                                <td>
                                    <x-jet-input wire:model="searchPib" id="" class="block bg-orange-50 w-32" type="text" placeholder="PIB" /> 
                                </td>
                                <td>
                                    <select wire:model="searchTip" id="" class="block appearance-none bg-orange-50 w-full border border-0 text-gray-700 py-3 px-4 pr-8 round leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                        <option value="">---</option>
                                        @foreach (App\Models\LokacijaTip::tipoviList() as $key => $value)    
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select wire:model="searchStatus" id="" class="block appearance-none bg-orange-50 w-full border border-0 text-gray-700 py-3 px-4 pr-8 round leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                        <option value="">---</option>
                                        @foreach (App\Models\TerminalStatusTip::tipoviList() as $key => $value)    
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="text-right text-sm pr-4">Ukupno: <span class="font-bold">{{ $data->total() }}</span></td>    
                            </tr>                     
                            @if ($data->count())
                                @foreach ($data as $item)
                                    <tr @if($loop->even) class="bg-gray-50" @endif >
                                        <td class="px-1 py-1"><input type="checkbox" value="{{ $item->tid }}" wire:model="selsectedTerminals"  class="form-checkbox h-6 w-6 text-blue-500"></td>
                                        <td class="px-1 py-2">
                                            @if($item->blacklist == 1)
                                                <svg class="fill-current w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">	<path class="st1" d="M320,464c8.8,0,16-7.2,16-16V160h-80c-17.7,0-32-14.3-32-32V48H64c-8.8,0-16,7.2-16,16v384 c0,8.8,7.2,16,16,16H320z M0,64C0,28.7,28.7,0,64,0h165.5c17,0,33.3,6.7,45.3,18.7l90.5,90.5c12,12,18.7,28.3,18.7,45.3V448 c0,35.3-28.7,64-64,64H64c-35.3,0-64-28.7-64-64V64z"/> <path class="st1" d="M48,238c0,39.8,21.1,75.3,54,98.4c0,0.2,0,0.4,0,0.6v36c0,14.9,12.1,27,27,27h27v-27c0-5,4-9,9-9s9,4,9,9v27 h36v-27c0-5,4-9,9-9s9,4,9,9v27h27c14.9,0,27-12.1,27-27v-36c0-0.2,0-0.4,0-0.6c32.9-23.1,54-58.6,54-98.4	c0-22.2-6.6-43.1-18.1-61.2h-24.5c-40.6,0-75-27.1-86.2-64.1c-5-0.5-10.1-0.7-15.2-0.7C112.5,112,48,168.4,48,238z M138,292	c-19.9,0-36-16.1-36-36s16.1-36,36-36s36,16.1,36,36S157.9,292,138,292z M246,220c19.9,0,36,16.1,36,36s-16.1,36-36,36 s-36-16.1-36-36S226.1,220,246,220z"/></svg>
                                            @else
                                                <svg class="fill-current w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M373.1,134.6L253.4,15.3C243.5,5.5,230.2,0,216.3,0H59C26.5,0,0,26.5,0,59v394c0,32.5,26.5,59,59,59h266 c32.5,0,59-26.5,59-59V160.9C384,151.1,380.1,141.6,373.1,134.6z M354.9,151.8h-61.5c-35.8,0-65-29.2-65-65v-59 c2.7,1.3,5.1,3.1,7.3,5.2L354.9,151.8z M359,453c0,9-3.6,17.5-10,24c-6.5,6.5-15,10-24,10H59c-9,0-17.5-3.6-24-10 c-6.5-6.5-10-15-10-24V59c0-9,3.6-17.5,10-24c6.5-6.5,15-10,24-10h144.4v61.8c0,49.6,40.4,90,90,90H359V453z"/><g><path d="M159.9,391.1h111.3v26.3h-141V197.8h29.7V391.1z"/></g></svg>
                                            @endif
                                        </td>
                                        <td class="px-1 py-2">{{ $item->sn }}</td>
                                        <td class="px-1 py-2">{{ $item->broj_kutije }}</td>
                                        <td class="px-1 py-2">{{ $item->l_naziv }}</td>
                                        <td class="px-1 py-2">{{ $item->r_naziv }}</td> 
                                        <td class="px-1 py-2">{{ $item->lt_naziv }}</td>
                                        <td class="px-1 py-2">
                                            <x-jet-secondary-button wire:click="statusShowModal({{ $item->tid}}, {{ $item->statusid }})">
                                                {{ $item->ts_naziv }}
                                            </x-jet-button>
                                        </td>
                                        <td class="px-1 py-1">
                                            <x-jet-secondary-button class="ml-2" wire:click="premestiShowModal({{ $item->tid }}, {{ $item->statusid }})">
                                                {{ __('Premesti') }}
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

    <div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3 my-4 flex flex-row" role="alert">
        <div class="basis-1/2"><p class="text-sm">Ukupno izabranih terminala: <span class="font-bold"> {{ count($selsectedTerminals) }}</span></p></div>
        <div class="basis-1/4 text-right mr-6">
            
        </div>
        <div class="basis-1/4 text-right mr-6">
            @if(count($selsectedTerminals))
                <x-jet-button class="ml-2" wire:click="premestiSelectedShowModal()">
                    {{ __('Premesti') }}
                </x-jet-button>
            @endif
        </div>
    </div>

    {{-- PREMESTI Modal --}}
    <x-jet-dialog-modal wire:model="modalConfirmPremestiVisible">
        <x-slot name="title">
            {{ __('Premesti terminal') }}
        </x-slot>

        <x-slot name="content">
        @if($modalConfirmPremestiVisible)
            @if ($multiSelected)
                    <div class="bg-sky-100 border-t-4 border-sky-500 rounded-b text-sky-900 px-4 py-3 shadow-md mb-6" role="alert">
                        <div class="flex">
                        <div class="py-1"><svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M288 0C305.7 0 320 14.33 320 32V96C320 113.7 305.7 128 288 128H208V160H424.1C456.6 160 483.5 183.1 488.2 214.4L510.9 364.1C511.6 368.8 512 373.6 512 378.4V448C512 483.3 483.3 512 448 512H64C28.65 512 0 483.3 0 448V378.4C0 373.6 .3622 368.8 1.083 364.1L23.76 214.4C28.5 183.1 55.39 160 87.03 160H143.1V128H63.1C46.33 128 31.1 113.7 31.1 96V32C31.1 14.33 46.33 0 63.1 0L288 0zM96 48C87.16 48 80 55.16 80 64C80 72.84 87.16 80 96 80H256C264.8 80 272 72.84 272 64C272 55.16 264.8 48 256 48H96zM80 448H432C440.8 448 448 440.8 448 432C448 423.2 440.8 416 432 416H80C71.16 416 64 423.2 64 432C64 440.8 71.16 448 80 448zM112 216C98.75 216 88 226.7 88 240C88 253.3 98.75 264 112 264C125.3 264 136 253.3 136 240C136 226.7 125.3 216 112 216zM208 264C221.3 264 232 253.3 232 240C232 226.7 221.3 216 208 216C194.7 216 184 226.7 184 240C184 253.3 194.7 264 208 264zM160 296C146.7 296 136 306.7 136 320C136 333.3 146.7 344 160 344C173.3 344 184 333.3 184 320C184 306.7 173.3 296 160 296zM304 264C317.3 264 328 253.3 328 240C328 226.7 317.3 216 304 216C290.7 216 280 226.7 280 240C280 253.3 290.7 264 304 264zM256 296C242.7 296 232 306.7 232 320C232 333.3 242.7 344 256 344C269.3 344 280 333.3 280 320C280 306.7 269.3 296 256 296zM400 264C413.3 264 424 253.3 424 240C424 226.7 413.3 216 400 216C386.7 216 376 226.7 376 240C376 253.3 386.7 264 400 264zM352 296C338.7 296 328 306.7 328 320C328 333.3 338.7 344 352 344C365.3 344 376 333.3 376 320C376 306.7 365.3 296 352 296z"/></svg></div>
                            <div>
                                @foreach ($multiSelectedInfo as $item)
                                    <p>Terminal: <span class="font-bold">{{$item->sn}}</span> &nbsp;&nbsp;&nbsp; Staus: <span class="font-bold">{{ $item->ts_naziv }}</span></p>
                                    <p class="text-sm">Lokacija: {{ $item->l_naziv }}, {{$item->mesto}}</p><hr />
                                @endforeach
                            </div>
                        </div>
                    </div> 
                @else
                    <div class="bg-sky-100 border-t-4 border-sky-500 rounded-b text-sky-900 px-4 py-3 shadow-md mb-6" role="alert">
                        <div class="flex">
                            <div class="py-1"><svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M288 0C305.7 0 320 14.33 320 32V96C320 113.7 305.7 128 288 128H208V160H424.1C456.6 160 483.5 183.1 488.2 214.4L510.9 364.1C511.6 368.8 512 373.6 512 378.4V448C512 483.3 483.3 512 448 512H64C28.65 512 0 483.3 0 448V378.4C0 373.6 .3622 368.8 1.083 364.1L23.76 214.4C28.5 183.1 55.39 160 87.03 160H143.1V128H63.1C46.33 128 31.1 113.7 31.1 96V32C31.1 14.33 46.33 0 63.1 0L288 0zM96 48C87.16 48 80 55.16 80 64C80 72.84 87.16 80 96 80H256C264.8 80 272 72.84 272 64C272 55.16 264.8 48 256 48H96zM80 448H432C440.8 448 448 440.8 448 432C448 423.2 440.8 416 432 416H80C71.16 416 64 423.2 64 432C64 440.8 71.16 448 80 448zM112 216C98.75 216 88 226.7 88 240C88 253.3 98.75 264 112 264C125.3 264 136 253.3 136 240C136 226.7 125.3 216 112 216zM208 264C221.3 264 232 253.3 232 240C232 226.7 221.3 216 208 216C194.7 216 184 226.7 184 240C184 253.3 194.7 264 208 264zM160 296C146.7 296 136 306.7 136 320C136 333.3 146.7 344 160 344C173.3 344 184 333.3 184 320C184 306.7 173.3 296 160 296zM304 264C317.3 264 328 253.3 328 240C328 226.7 317.3 216 304 216C290.7 216 280 226.7 280 240C280 253.3 290.7 264 304 264zM256 296C242.7 296 232 306.7 232 320C232 333.3 242.7 344 256 344C269.3 344 280 333.3 280 320C280 306.7 269.3 296 256 296zM400 264C413.3 264 424 253.3 424 240C424 226.7 413.3 216 400 216C386.7 216 376 226.7 376 240C376 253.3 386.7 264 400 264zM352 296C338.7 296 328 306.7 328 320C328 333.3 338.7 344 352 344C365.3 344 376 333.3 376 320C376 306.7 365.3 296 352 296z"/></svg></div>
                            <div>
                                <p>Terminal: <span class="font-bold">{{$selectedTerminal->sn}}</span> &nbsp;&nbsp;&nbsp; Staus: <span class="font-bold">{{ $selectedTerminal->ts_naziv }}</span></p>
                                <p class="text-sm">Lokacija: {{ $selectedTerminal->l_naziv }}, {{$selectedTerminal->mesto}}</p>
                            </div>
                        </div>
                    </div> 
                @endif
                <div class="font-bold">Nova lokacija terminala:</div>
        @endif
        @if(!$plokacija)
            <x-jet-label for="tiplokacije" value="{{ __('Izaberi tip lokacije') }}" />
            <select wire:model="plokacijaTip" id="" class="block appearance-none bg-gray-50 w-full border border-1 text-gray-700 py-3 px-4 pr-8 round leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                <option value="">---</option>
                <option value="3">Korisnik terminala</option>
                <option value="4">Distributer</option>
            </select>
           
                @if($plokacijaTip == 3)
                    {{-- KORISNIK terminala search by name --}}
                    <table class="min-w-full divide-y divide-gray-200 mt-4" style="width: 100% !important">
                        <thead>
                            <tr>
                                <th class="px-3 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"></th>
                                <th class="px-3 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Naziv</th> 
                                <th class="px-3 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Mesto</th> 
                                <th class="px-3 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"></th> 
                                <th class="px-3 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"></th>  
                            </tr>
                            <tr class="bg-orange-50">
                                <td><svg class="mx-auto fill-orange-600 w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M3.853 54.87C10.47 40.9 24.54 32 40 32H472C487.5 32 501.5 40.9 508.1 54.87C514.8 68.84 512.7 85.37 502.1 97.33L320 320.9V448C320 460.1 313.2 471.2 302.3 476.6C291.5 482 278.5 480.9 268.8 473.6L204.8 425.6C196.7 419.6 192 410.1 192 400V320.9L9.042 97.33C-.745 85.37-2.765 68.84 3.854 54.87L3.853 54.87z"/></svg></td>
                                <td><x-jet-input wire:model="searchPLokacijaNaziv" id="" class="block bg-orange-50 w-full" type="text" placeholder="Naziv" /></td>
                                <td><x-jet-input wire:model="searchPlokacijaMesto" id="" class="block bg-orange-50 w-full" type="text" placeholder="Mesto" /></td>
                                <td><x-jet-input wire:model="searchPlokacijaPib" id="" class="block bg-orange-50 w-full" type="text" placeholder="PIB" /></td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200"> 
                        @foreach ($this->lokacijeTipa($plokacijaTip) as $value)
                        <tr class="hover:bg-gray-100" wire:click="$set('plokacija', {{ $value->id }})" >    
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
                        {{ $this->lokacijeTipa($plokacijaTip)->links() }}
                    </div>

                @elseif($plokacijaTip == 4)
                {{-- DISTRIBUTER --}}
                    <x-jet-label for="lokacija" value="{{ __('Izaberi lokaciju') }}" class="mt-4" />
                    <select wire:model="plokacija" id="" class="block appearance-none bg-gray-50 w-full border border-1 text-gray-700 py-3 px-4 pr-8 round leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                        <option value="">---</option>
                        @foreach (App\Models\Lokacija::lokacijeDistributera($distId) as $key => $value)    
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                @endif
        @else
            {{-- IZABRAO LOKACIJU MENJAM PRIKAZ --}}
            @php
                $canMoveTerminal = 1;
            @endphp
            <div class="bg-sky-100 border-t-4 border-sky-500 rounded-b text-sky-900 px-4 py-3 shadow-md mb-6" role="alert">
                <div class="flex">
                    <div class="py-1"><svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2H168.3zM192 256C227.3 256 256 227.3 256 192C256 156.7 227.3 128 192 128C156.7 128 128 156.7 128 192C128 227.3 156.7 256 192 256z"/></svg></div>
                    <div>
                    <p class="font-bold">{{ $this->novaLokacija()->l_naziv}}, {{ $this->novaLokacija()->mesto }}</p>
                    <p class="text-sm">Region: {{ $this->novaLokacija()->r_naziv }}</p>
                    </div>
                </div>
            </div>        
        @endif

            <div class="mt-4">
                <x-jet-label for="pterminalStatus" value="{{ __('Novi status terminala') }}" />
                    <select wire:model="modalStatusPremesti" id="" class="block appearance-none bg-gray-50 w-full border border-1 text-gray-700 py-3 px-4 pr-8 round leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                        @foreach (App\Models\TerminalStatusTip::tipoviList() as $key => $value)    
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    @error('pterminalStatus') <span class="error">{{ $message }}</span> @enderror
            </div> 
            
            <div class="mb-6 mt-4">
                <x-jet-label for="date_akcije" value="Datum promene:" />
                <x-jet-input id="date_akcije" type="date" class="mt-1 block" value="{{ $datum_premestanja_terminala }}" wire:model.defer="datum_premestanja_terminala" />
                <x-jet-input-error for="date_akcije" class="mt-2" />
            </div>

        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalConfirmPremestiVisible')" wire:loading.attr="disabled">
                {{ __('Otkaži') }}
            </x-jet-secondary-button>
            @if($canMoveTerminal)
                <x-jet-danger-button class="ml-2" wire:click="moveTerminal" wire:loading.attr="disabled">
                    {{ __('Premesti terminal') }}
                </x-jet-danger-button>
            @endif
        </x-slot>
    </x-jet-dialog-modal>

    {{-- STATUS MODAL--}}
    <x-jet-dialog-modal wire:model="modalFormVisible">
        <x-slot name="title">
            {{ __('Promeni status terminala') }}
        </x-slot>

        <x-slot name="content">
        @if($modalFormVisible)
            @if ($multiSelected)
                <div class="bg-sky-100 border-t-4 border-sky-500 rounded-b text-sky-900 px-4 py-3 shadow-md mb-6" role="alert">
                    <div class="flex">
                    <div class="py-1"><svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M288 0C305.7 0 320 14.33 320 32V96C320 113.7 305.7 128 288 128H208V160H424.1C456.6 160 483.5 183.1 488.2 214.4L510.9 364.1C511.6 368.8 512 373.6 512 378.4V448C512 483.3 483.3 512 448 512H64C28.65 512 0 483.3 0 448V378.4C0 373.6 .3622 368.8 1.083 364.1L23.76 214.4C28.5 183.1 55.39 160 87.03 160H143.1V128H63.1C46.33 128 31.1 113.7 31.1 96V32C31.1 14.33 46.33 0 63.1 0L288 0zM96 48C87.16 48 80 55.16 80 64C80 72.84 87.16 80 96 80H256C264.8 80 272 72.84 272 64C272 55.16 264.8 48 256 48H96zM80 448H432C440.8 448 448 440.8 448 432C448 423.2 440.8 416 432 416H80C71.16 416 64 423.2 64 432C64 440.8 71.16 448 80 448zM112 216C98.75 216 88 226.7 88 240C88 253.3 98.75 264 112 264C125.3 264 136 253.3 136 240C136 226.7 125.3 216 112 216zM208 264C221.3 264 232 253.3 232 240C232 226.7 221.3 216 208 216C194.7 216 184 226.7 184 240C184 253.3 194.7 264 208 264zM160 296C146.7 296 136 306.7 136 320C136 333.3 146.7 344 160 344C173.3 344 184 333.3 184 320C184 306.7 173.3 296 160 296zM304 264C317.3 264 328 253.3 328 240C328 226.7 317.3 216 304 216C290.7 216 280 226.7 280 240C280 253.3 290.7 264 304 264zM256 296C242.7 296 232 306.7 232 320C232 333.3 242.7 344 256 344C269.3 344 280 333.3 280 320C280 306.7 269.3 296 256 296zM400 264C413.3 264 424 253.3 424 240C424 226.7 413.3 216 400 216C386.7 216 376 226.7 376 240C376 253.3 386.7 264 400 264zM352 296C338.7 296 328 306.7 328 320C328 333.3 338.7 344 352 344C365.3 344 376 333.3 376 320C376 306.7 365.3 296 352 296z"/></svg></div>
                        <div>
                            @foreach ($multiSelectedInfo as $item)
                                <p>Terminal: <span class="font-bold">{{$item->sn}}</span> &nbsp;&nbsp;&nbsp; Staus: <span class="font-bold">{{ $item->ts_naziv }}</span></p>
                                <p class="text-sm">Lokacija: {{ $item->l_naziv }}, {{$item->mesto}}</p><hr />
                            @endforeach
                        </div>
                    </div>
                </div> 
            @else
                <div class="bg-sky-100 border-t-4 border-sky-500 rounded-b text-sky-900 px-4 py-3 shadow-md mb-6" role="alert">
                    <div class="flex">
                        <div class="py-1"><svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M288 0C305.7 0 320 14.33 320 32V96C320 113.7 305.7 128 288 128H208V160H424.1C456.6 160 483.5 183.1 488.2 214.4L510.9 364.1C511.6 368.8 512 373.6 512 378.4V448C512 483.3 483.3 512 448 512H64C28.65 512 0 483.3 0 448V378.4C0 373.6 .3622 368.8 1.083 364.1L23.76 214.4C28.5 183.1 55.39 160 87.03 160H143.1V128H63.1C46.33 128 31.1 113.7 31.1 96V32C31.1 14.33 46.33 0 63.1 0L288 0zM96 48C87.16 48 80 55.16 80 64C80 72.84 87.16 80 96 80H256C264.8 80 272 72.84 272 64C272 55.16 264.8 48 256 48H96zM80 448H432C440.8 448 448 440.8 448 432C448 423.2 440.8 416 432 416H80C71.16 416 64 423.2 64 432C64 440.8 71.16 448 80 448zM112 216C98.75 216 88 226.7 88 240C88 253.3 98.75 264 112 264C125.3 264 136 253.3 136 240C136 226.7 125.3 216 112 216zM208 264C221.3 264 232 253.3 232 240C232 226.7 221.3 216 208 216C194.7 216 184 226.7 184 240C184 253.3 194.7 264 208 264zM160 296C146.7 296 136 306.7 136 320C136 333.3 146.7 344 160 344C173.3 344 184 333.3 184 320C184 306.7 173.3 296 160 296zM304 264C317.3 264 328 253.3 328 240C328 226.7 317.3 216 304 216C290.7 216 280 226.7 280 240C280 253.3 290.7 264 304 264zM256 296C242.7 296 232 306.7 232 320C232 333.3 242.7 344 256 344C269.3 344 280 333.3 280 320C280 306.7 269.3 296 256 296zM400 264C413.3 264 424 253.3 424 240C424 226.7 413.3 216 400 216C386.7 216 376 226.7 376 240C376 253.3 386.7 264 400 264zM352 296C338.7 296 328 306.7 328 320C328 333.3 338.7 344 352 344C365.3 344 376 333.3 376 320C376 306.7 365.3 296 352 296z"/></svg></div>
                        <div>
                            <p>Terminal: <span class="font-bold">{{$selectedTerminal->sn}}</span> &nbsp;&nbsp;&nbsp; Staus: <span class="font-bold">{{ $selectedTerminal->ts_naziv }}</span></p>
                            <p class="text-sm">Lokacija: {{ $selectedTerminal->l_naziv }}, {{$selectedTerminal->mesto}}</p>
                        </div>
                    </div>
                </div> 
            @endif
            <div class="font-bold">Nova status terminala:</div>
        @endif
            <div class="mt-4">
            <x-jet-label for="terminalStatus" value="{{ __('Novi status terminala') }}" />
                <select wire:model="modalStatus" id="" class="block appearance-none w-full border border-1 text-gray-700 py-3 px-4 pr-8 round leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                    @foreach (App\Models\TerminalStatusTip::tipoviList() as $key => $value)    
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
                @error('terminalStatus') <span class="error">{{ $message }}</span> @enderror
            </div>  
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                {{ __('Otkaži') }}
            </x-jet-secondary-button>

            @if ($modelId || $multiSelected)
                <x-jet-button class="ml-2" wire:click="statusUpdate" wire:loading.attr="disabled">
                    {{ __('Update') }}
                </x-jet-danger-button>
            @else
               <div>Nešto nije u redu?!?</div>
            @endif            
        </x-slot>
    </x-jet-dialog-modal>

</div>
