<div class="p-6">
    <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6">
        <x-jet-button wire:click="newTiketShowModal">
        <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 384"><path d="M576,208V128a64,64,0,0,0-64-64H64A64,64,0,0,0,0,128v80a48,48,0,0,1,48,48A48,48,0,0,1,0,304v80a64,64,0,0,0,64,64H512a64.06,64.06,0,0,0,64-64V304a48,48,0,0,1,0-96ZM438,286.5H318.5V406h-61V286.5H138v-61H257.5V106h61V225.5H438Z" transform="translate(0 -64)"/></svg>
            {{ __('Novi tiket') }}
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
                                <th class="px-2 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase">Br:</th>
                                <th class="px-2 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase">Kreiran:</th>
                                <th class="px-2 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase">Poslednja promena:</th>
                                <th class="px-2 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase">Status:</th>
                                <th class="px-2 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase">Lokacija:</th>
                                <th class="px-2 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase">Mesto:</th>
                                <th class="px-2 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase"><svg class="fill-current w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M416 176C416 78.8 322.9 0 208 0S0 78.8 0 176c0 39.57 15.62 75.96 41.67 105.4c-16.39 32.76-39.23 57.32-39.59 57.68c-2.1 2.205-2.67 5.475-1.441 8.354C1.9 350.3 4.602 352 7.66 352c38.35 0 70.76-11.12 95.74-24.04C134.2 343.1 169.8 352 208 352C322.9 352 416 273.2 416 176zM599.6 443.7C624.8 413.9 640 376.6 640 336C640 238.8 554 160 448 160c-.3145 0-.6191 .041-.9336 .043C447.5 165.3 448 170.6 448 176c0 98.62-79.68 181.2-186.1 202.5C282.7 455.1 357.1 512 448 512c33.69 0 65.32-8.008 92.85-21.98C565.2 502 596.1 512 632.3 512c3.059 0 5.76-1.725 7.02-4.605c1.229-2.879 .6582-6.148-1.441-8.354C637.6 498.7 615.9 475.3 599.6 443.7z"/></svg></th>
                                <th class="px-2 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase">Prioritet:</th>
                                <th class="px-2 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">                           
                            @if ($data->count())
                                @foreach ($data as $item)
                                @php
                                    $dateCreate = explode('-', App\Http\Helpers::datumFormat($item->created_at));
                                    $dateUpdate = explode('-', App\Http\Helpers::datumFormat($item->updated_at));
                                @endphp
                                    <tr>
                                        <td class="px-2 py-2">{{ $item->tikid }}</td>
                                        <td class="px-2 py-2">{{ $dateCreate[0] }}<br />{{ $dateCreate[1] }}</td>
                                        <td class="px-2 py-2">{{ $dateUpdate[0] }}<br />{{ $dateUpdate[1] }}</td>
                                        <td class="px-2 py-2">{{ $item->tks_naziv }} <br /> {{ $item->name }}</td>  
                                        <td class="px-2 py-2">{{ $item->l_naziv }}</td>
                                        <td class="px-2 py-2">{{ $item->mesto }}</td>
                                        <td class="px-2 py-2">{{ $item->br_komentara }}</td>
                                        <td class="px-2 py-2"><span class="flex-none py-2 px-4 mx-2 font-bold rounded bg-{{$item->tr_bg_collor}} text-{{$item->btn_collor}}">{{ $item->tp_naziv }}</span></td>                                       
                                        <td class="px-2 py-2">
                                            <x-jet-secondary-button wire:click="#">
                                            <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M128 160H448V352H128V160zM512 64C547.3 64 576 92.65 576 128V208C549.5 208 528 229.5 528 256C528 282.5 549.5 304 576 304V384C576 419.3 547.3 448 512 448H64C28.65 448 0 419.3 0 384V304C26.51 304 48 282.5 48 256C48 229.5 26.51 208 0 208V128C0 92.65 28.65 64 64 64H512zM96 352C96 369.7 110.3 384 128 384H448C465.7 384 480 369.7 480 352V160C480 142.3 465.7 128 448 128H128C110.3 128 96 142.3 96 160V352z"/></svg>
                                                {{ __('Tiket') }}
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
 
    {{-- Novi Tiket Form --}}
    <x-jet-dialog-modal wire:model="modalNewTiketVisible">
        <x-slot name="title">
        <svg class="fill-current w-6 h-6 mr-2 mt-1 float-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 384"><path d="M576,208V128a64,64,0,0,0-64-64H64A64,64,0,0,0,0,128v80a48,48,0,0,1,48,48A48,48,0,0,1,0,304v80a64,64,0,0,0,64,64H512a64.06,64.06,0,0,0,64-64V304a48,48,0,0,1,0-96ZM438,286.5H318.5V406h-61V286.5H138v-61H257.5V106h61V225.5H438Z" transform="translate(0 -64)"/></svg>
            {{ __('Novi Tiket') }}
        </x-slot>

        <x-slot name="content">
        @if(!$newTerminalId)
            {{-- Nadji terminal --}}
            <table class="min-w-full divide-y divide-gray-200 mt-4" style="width: 100% !important">
                <thead>
                    <tr>
                        <th></th>
                        <th class="px-3 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">S. N.</th>
                        <th class="px-3 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Lokacija</th> 
                        <th class="px-3 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Mesto</th>   
                    </tr>
                    <tr class="bg-orange-50">
                        <td><svg class="mx-auto fill-orange-600 w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M3.853 54.87C10.47 40.9 24.54 32 40 32H472C487.5 32 501.5 40.9 508.1 54.87C514.8 68.84 512.7 85.37 502.1 97.33L320 320.9V448C320 460.1 313.2 471.2 302.3 476.6C291.5 482 278.5 480.9 268.8 473.6L204.8 425.6C196.7 419.6 192 410.1 192 400V320.9L9.042 97.33C-.745 85.37-2.765 68.84 3.854 54.87L3.853 54.87z"/></svg></td>
                        <td><x-jet-input wire:model="searchTerminalSn" id="" class="block bg-orange-50 w-full" type="text" placeholder="Serijski broj" /></td>
                        <td><x-jet-input wire:model="searchTerminalLokacijaNaziv" id="" class="block bg-orange-50 w-full" type="text" placeholder="Naziv" /></td>
                        <td><x-jet-input wire:model="searchTerminalMesto" id="" class="block bg-orange-50 w-full" type="text" placeholder="Mesto" /></td>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200"> 
                @foreach ($this->searchTerminal() as $value)
                    <tr class="hover:bg-gray-100" wire:click="$set('newTerminalId', {{ $value->id }})" >    
                            <td></td>
                            <td>{{ $value->sn }}</td>
                            <td>{{ $value->l_naziv}}</td>
                            <td>{{ $value->mesto}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="mt-5">
                {{ $this->searchTerminal() ->links() }}
            </div>
        @else
           {{-- Nasao terminal bira dalje --}}
           {{-- Sada proveravamo dali terminal ima otvoren tiket --}}
           @if(App\Models\Tiket::daliTerminalImaOtvorenTiket($newTerminalId))
                {{-- PRIKAZ GRESKE --}}
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative my-4" role="alert">
                    <strong class="font-bold">Greška!</strong>
                    <span class="block sm:inline">Terminal ima aktivan Tiket. Otvoren: {{ App\Http\Helpers::datumFormat(App\Models\Tiket::daliTerminalImaOtvorenTiket($newTerminalId)->created_at) }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg class="fill-current h-6 w-6 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M506.3 417l-213.3-364c-16.33-28-57.54-28-73.98 0l-213.2 364C-10.59 444.9 9.849 480 42.74 480h426.6C502.1 480 522.6 445 506.3 417zM232 168c0-13.25 10.75-24 24-24S280 154.8 280 168v128c0 13.25-10.75 24-23.1 24S232 309.3 232 296V168zM256 416c-17.36 0-31.44-14.08-31.44-31.44c0-17.36 14.07-31.44 31.44-31.44s31.44 14.08 31.44 31.44C287.4 401.9 273.4 416 256 416z"/></svg>
                    </span>
                </div>
           @else

                <div class="bg-sky-100 border-t-4 border-sky-500 rounded-b text-sky-900 px-4 py-3 shadow-md mb-6" role="alert">
                    <div class="flex">
                        <div class="py-1"><svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M288 0C305.7 0 320 14.33 320 32V96C320 113.7 305.7 128 288 128H208V160H424.1C456.6 160 483.5 183.1 488.2 214.4L510.9 364.1C511.6 368.8 512 373.6 512 378.4V448C512 483.3 483.3 512 448 512H64C28.65 512 0 483.3 0 448V378.4C0 373.6 .3622 368.8 1.083 364.1L23.76 214.4C28.5 183.1 55.39 160 87.03 160H143.1V128H63.1C46.33 128 31.1 113.7 31.1 96V32C31.1 14.33 46.33 0 63.1 0L288 0zM96 48C87.16 48 80 55.16 80 64C80 72.84 87.16 80 96 80H256C264.8 80 272 72.84 272 64C272 55.16 264.8 48 256 48H96zM80 448H432C440.8 448 448 440.8 448 432C448 423.2 440.8 416 432 416H80C71.16 416 64 423.2 64 432C64 440.8 71.16 448 80 448zM112 216C98.75 216 88 226.7 88 240C88 253.3 98.75 264 112 264C125.3 264 136 253.3 136 240C136 226.7 125.3 216 112 216zM208 264C221.3 264 232 253.3 232 240C232 226.7 221.3 216 208 216C194.7 216 184 226.7 184 240C184 253.3 194.7 264 208 264zM160 296C146.7 296 136 306.7 136 320C136 333.3 146.7 344 160 344C173.3 344 184 333.3 184 320C184 306.7 173.3 296 160 296zM304 264C317.3 264 328 253.3 328 240C328 226.7 317.3 216 304 216C290.7 216 280 226.7 280 240C280 253.3 290.7 264 304 264zM256 296C242.7 296 232 306.7 232 320C232 333.3 242.7 344 256 344C269.3 344 280 333.3 280 320C280 306.7 269.3 296 256 296zM400 264C413.3 264 424 253.3 424 240C424 226.7 413.3 216 400 216C386.7 216 376 226.7 376 240C376 253.3 386.7 264 400 264zM352 296C338.7 296 328 306.7 328 320C328 333.3 338.7 344 352 344C365.3 344 376 333.3 376 320C376 306.7 365.3 296 352 296z"/></svg></div>
                        <div>
                            <p>Terminal: <span class="font-bold">{{$newTerminalInfo->sn}}</span> &nbsp;&nbsp;&nbsp; Staus: <span class="font-bold">{{ $newTerminalInfo->ts_naziv }}</span></p>
                            <p class="text-sm">Lokacija: <span class="font-bold">{{ $newTerminalInfo->l_naziv }}, {{$newTerminalInfo->mesto}}</span></p>
                        </div>
                    </div>
                </div> 
                
                <div class="mt-4">
                    <x-jet-label for="opisKvaraList" value="{{ __('Izaberi kvar iz liste') }}" />
                    <select wire:model="opisKvaraList" id="" class="block appearance-none w-full border border-1 text-gray-700 py-3 px-4 pr-8 round leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                    <option value="0">---</option>    
                        @foreach (App\Models\TiketOpisKvaraTip::opisList($newTerminalInfo->tid) as $key => $value)    
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    @error('opisKvaraList') <span class="error">{{ $message }}</span> @enderror
                </div>  
                <div class="mt-4">
                    <x-jet-label for="opis_kvara" value="{{ __('Opis kvara') }}" />
                    <x-jet-textarea id="opis_kvara" type="textarea" class="mt-1 block w-full disabled:opacity-50" wire:model.defer="opisKvataTxt" />
                    @error('opis_kvara') <span class="error">{{ $message }}</span> @enderror
                </div> 
                
                @if(!$dodeljenUserId)
				<div class="mt-4">
                    <hr />
                    <p>Dodeli tiket korisniku:</p>
                    <table class="min-w-full divide-y divide-gray-200" style="width: 100% !important">
                        <thead>
                            <tr>
                                <th class="px-3 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"></th>
                                <th class="px-3 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Ime</th>
                                <th class="px-3 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Lokacija</th> 
                                <th class="px-3 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Pozicija</th>   
                            </tr>
                            <tr class="bg-orange-50">
                                <td><svg class="mx-auto fill-orange-600 w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M3.853 54.87C10.47 40.9 24.54 32 40 32H472C487.5 32 501.5 40.9 508.1 54.87C514.8 68.84 512.7 85.37 502.1 97.33L320 320.9V448C320 460.1 313.2 471.2 302.3 476.6C291.5 482 278.5 480.9 268.8 473.6L204.8 425.6C196.7 419.6 192 410.1 192 400V320.9L9.042 97.33C-.745 85.37-2.765 68.84 3.854 54.87L3.853 54.87z"/></svg></td>
                                <td><x-jet-input wire:model="searchUserName" id="" class="block bg-orange-50 w-full" type="text" placeholder="Ime" /></td>
                                <td><x-jet-input wire:model="searchUserLokacija" id="" class="block bg-orange-50 w-full" type="text" placeholder="Lokacija" /></td>
                                <td><x-jet-input wire:model="searchUserPozicija" id="" class="block bg-orange-50 w-full" type="text" placeholder="Pozicija" /></td>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200"> 
                        @foreach ($this->searchUser() as $value)
                            <tr class="hover:bg-gray-100" wire:click="$set('dodeljenUserId', {{ $value->id }})" >    
                                    <td></td>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $value->l_naziv}}</td>
                                    <td>{{ $value->naziv}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="mt-5">
                        {{ $this->searchUser() ->links() }}
                    </div>
                </div>

			    @else
                
				<div class="mt-4">Tiket dodeljen korisniku:</div>
				<div class="bg-sky-100 border-t-4 border-sky-500 rounded-b text-sky-900 px-4 py-3 shadow-md mb-6" role="alert">
					<div class="flex">
						<div class="py-1"><svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M224 256c70.7 0 128-57.31 128-128s-57.3-128-128-128C153.3 0 96 57.31 96 128S153.3 256 224 256zM274.7 304H173.3C77.61 304 0 381.6 0 477.3c0 19.14 15.52 34.67 34.66 34.67h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304z"/></svg></div>
						<div>
							<p>Korisnik: <span class="font-bold">{{ $dodeljenUserInfo->name }}</span> &nbsp;&nbsp;&nbsp; Pozicija: <span class="font-bold">{{ $dodeljenUserInfo->naziv }}</span></p>
							<p class="text-sm">Lokacija: <span class="font-bold">{{ $dodeljenUserInfo->l_naziv }}, {{$dodeljenUserInfo->mesto}}</span></p>
						</div>
					</div>
				</div> 
                @endif

                <p>Odredi prioritet tiketa:</p>
                <div class="flex mt-4">
                    @foreach (App\Models\TiketPrioritetTip::prList() as $value)
                        @if($prioritetTiketa == $value->id)
                            <span class="flex-none py-2 px-4 mx-2 font-bold rounded bg-{{$prioritetInfo->tr_bg_collor}} text-{{$prioritetInfo->btn_collor}}">{{ $value->tp_naziv }}</span>
                        @else
                            <button wire:click="$set('prioritetTiketa', {{ $value->id }})" class="flex-none bg-{{ $value->btn_collor }} hover:bg-{{$value->btn_hover_collor}} text-white font-bold py-2 px-4 rounded mx-2">
                                {{ $value->tp_naziv }}
                            </button>
                        @endif
                    @endforeach
                </div>
                <div class="flex mt-4" style="display:none">
                        <button class="flex-none bg-red-500 hover:bg-red-200 text-white font-bold py-2 px-4 rounded mx-2">
                            <span class="bg-red-100 border-red-500 fill-red-500 text-red-500">TEST</span>
                        </button>
                        <button class="flex-none bg-orange-500 hover:bg-orange-200 text-white font-bold py-2 px-4 rounded mx-2">
                            <span class="bg-orange-100 border-orange-500 fill-orange-500 text-orange-500">TEST</span>
                        </button>
                        <button class="flex-none bg-yellow-500 hover:bg-yellow-200 text-white font-bold py-2 px-4 rounded mx-2">
                            <span class="bg-yellow-100 border-yellow-500 fill-yellow-500 text-yellow-500">TEST</span>
                        </button>
                        <button class="flex-none bg-green-500 hover:bg-green-200 text-white font-bold py-2 px-4 rounded mx-2">
                            <span class="bg-green-100 border-green-500 fill-green-500 text-green-500">TEST</span>
                        </button>
                </div>
                <div>
                    @if($prioritetTiketa)
                        <div class="bg-{{$prioritetInfo->tr_bg_collor}} border border-{{$prioritetInfo->btn_collor}} text-{{$prioritetInfo->btn_collor}} px-4 py-3 rounded relative my-4" role="alert">
                            <p class="">Prioritet tiketa:
                            <span class="font-bold block sm:inline">{{ $prioritetInfo->tp_naziv }}</span><br /> {{ $prioritetInfo->tp_opis }}
                            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                                <svg class="fill-{{$prioritetInfo->btn_collor}} h-6 w-6 " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M506.3 417l-213.3-364c-16.33-28-57.54-28-73.98 0l-213.2 364C-10.59 444.9 9.849 480 42.74 480h426.6C502.1 480 522.6 445 506.3 417zM232 168c0-13.25 10.75-24 24-24S280 154.8 280 168v128c0 13.25-10.75 24-23.1 24S232 309.3 232 296V168zM256 416c-17.36 0-31.44-14.08-31.44-31.44c0-17.36 14.07-31.44 31.44-31.44s31.44 14.08 31.44 31.44C287.4 401.9 273.4 416 256 416z"/></svg>
                            </span>
                            </p>
                        </div>
                    @endif
                </div>  
            @endif
        @endif
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalNewTiketVisible')" wire:loading.attr="disabled">
                {{ __('Otkaži') }}
            </x-jet-secondary-button>
            @if($dodeljenUserId && $prioritetTiketa)
                <x-jet-danger-button class="ml-2" wire:click="create" wire:loading.attr="disabled">
                    {{ __('Sačuvaj') }}
                </x-jet-danger-button>     
            @endif      
        </x-slot>
    </x-jet-dialog-modal>

   
</div>