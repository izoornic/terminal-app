<div>
    <div class="mx-4 my-4">
        <div class="bg-{{$tiket->tr_bg_collor}} border-t-4 border-{{$tiket->btn_collor}} rounded-b text-slate-600 px-4 py-3 shadow-md mb-6 mx-2 my-2" role="alert">
			<div class="flex justify-between"> 
				<div class="flex">
					<div class="py-1"><svg class="fill-{{$tiket->btn_collor}} w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M128 160H448V352H128V160zM512 64C547.3 64 576 92.65 576 128V208C549.5 208 528 229.5 528 256C528 282.5 549.5 304 576 304V384C576 419.3 547.3 448 512 448H64C28.65 448 0 419.3 0 384V304C26.51 304 48 282.5 48 256C48 229.5 26.51 208 0 208V128C0 92.65 28.65 64 64 64H512zM96 352C96 369.7 110.3 384 128 384H448C465.7 384 480 369.7 480 352V160C480 142.3 465.7 128 448 128H128C110.3 128 96 142.3 96 160V352z"/></svg></div>
					<div>
						<div>Prioritet: <span class="font-bold text-{{$tiket->btn_collor}}">{{$tiket->tp_naziv}}</span> &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; Status: <span class="font-bold text-{{$tiket->btn_collor}}">{{$tiket->tks_naziv}}</span></div>
						<table class="min-w-full divide-y divide-gray-200" style="width: 100% !important">
							<tr>
								<td class="px-2">Kreiran:</td>
								<td><span class="font-bold">{{ App\Http\Helpers::datumFormat($tiket->created_at) }}</span></td>
								<td class="px-2 pl-4"><svg class="float-left fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M224 256c70.7 0 128-57.31 128-128s-57.3-128-128-128C153.3 0 96 57.31 96 128S153.3 256 224 256zM274.7 304H173.3C77.61 304 0 381.6 0 477.3c0 19.14 15.52 34.67 34.66 34.67h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304z"/></svg>otvorio:</td>
								<td><span class="font-bold">@if($userKreirao != '') {{$userKreirao->name}} @else {{ 'Kreiran online' }} @endif</span></td>
							</tr>
							<tr>
								<td class="px-2">Poslednja promena:</td>
								<td><span class="font-bold">{{ App\Http\Helpers::datumFormat($tiket->updated_at) }}</span></td>
								<td class="px-2 pl-4"><svg class="float-left fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M224 256c70.7 0 128-57.31 128-128s-57.3-128-128-128C153.3 0 96 57.31 96 128S153.3 256 224 256zM274.7 304H173.3C77.61 304 0 381.6 0 477.3c0 19.14 15.52 34.67 34.66 34.67h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304z"/></svg>dodeljen:</td>
								<td><span class="font-bold">{{$tiket->name}} </span>@if($tiket->tks_naziv != "Zatvoren") @if($tiketAkcija[3] != 'ne')<x-jet-secondary-button wire:click="dodeliTiketShowModal" title='dodeli'>@if($tiket->name == '') {{ 'Dodeli tiket' }} @else {{ 'promeni' }} @endif</x-jet-secondary-button>@endif @endif</td>
							</tr>
						</table>
                        <div>Kvar: <span class="font-bold text-{{$tiket->btn_collor}}">{{$tiket->tok_naziv}}</div>
                        <div>Opis: {{$tiket->opis}}</div>
                        <div class="mt-4 pr-4">
                            <p class="font-bold">Akcije:</p>
                            <ul class="list-disc">
                                @foreach($akcije as $akcija)
                                <li>{{ $akcija->tka_opis }}</li>
                                @endforeach
                            </ul>
                        </div>
					</div>
				</div>
        
				<div>@if($tiket->tks_naziv != "Zatvoren") <x-jet-danger-button wire:click="zatvoriTiketShowModal" title='promeni status'><svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M448 32C483.3 32 512 60.65 512 96V416C512 451.3 483.3 480 448 480H64C28.65 480 0 451.3 0 416V96C0 60.65 28.65 32 64 32H448zM175 208.1L222.1 255.1L175 303C165.7 312.4 165.7 327.6 175 336.1C184.4 346.3 199.6 346.3 208.1 336.1L255.1 289.9L303 336.1C312.4 346.3 327.6 346.3 336.1 336.1C346.3 327.6 346.3 312.4 336.1 303L289.9 255.1L336.1 208.1C346.3 199.6 346.3 184.4 336.1 175C327.6 165.7 312.4 165.7 303 175L255.1 222.1L208.1 175C199.6 165.7 184.4 165.7 175 175C165.7 184.4 165.7 199.6 175 208.1V208.1z"/></svg> zatvori tiket</x-jet-button> 
                    @else 
                    <a href="{{ route( 'tiket' ) }}"><span class="flex-none py-2 px-4 mx-2 font-bold rounded bg-{{$prioritetInfo->tr_bg_collor}} text-{{$prioritetInfo->btn_collor}}">TIKETI</span></a>
                    <br />
                    <p>Tiket zatvorio: <span class="font-bold">@if($zatvorioId > 0){{ $this->zatvorioInfo()->name }} @endif</span></p>
                    @endif
                    @if($curentUserPozicija == 1)<div class="py-4"><x-jet-button wire:click="obrisiTiketShowModal" title='promeni status'><svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69zM31.1 128H416V448C416 483.3 387.3 512 352 512H95.1C60.65 512 31.1 483.3 31.1 448V128zM111.1 208V432C111.1 440.8 119.2 448 127.1 448C136.8 448 143.1 440.8 143.1 432V208C143.1 199.2 136.8 192 127.1 192C119.2 192 111.1 199.2 111.1 208zM207.1 208V432C207.1 440.8 215.2 448 223.1 448C232.8 448 240 440.8 240 432V208C240 199.2 232.8 192 223.1 192C215.2 192 207.1 199.2 207.1 208zM304 208V432C304 440.8 311.2 448 320 448C328.8 448 336 440.8 336 432V208C336 199.2 328.8 192 320 192C311.2 192 304 199.2 304 208z"/></svg> obriši tiket</x-jet-button></div>
                        @endif
                    </div>
            </div> 
        </div> 
    </div>
    <div class="flex mx-4 my-4">
        <div class="w-2/5 flex-initial mx-2 my-2">
            <div class="bg-sky-100 border-t-4 border-sky-500 rounded-b text-sky-900 px-4 py-3 shadow-md mb-6" role="alert">
                <div class="flex">
                    <div class="py-1"><svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M288 0C305.7 0 320 14.33 320 32V96C320 113.7 305.7 128 288 128H208V160H424.1C456.6 160 483.5 183.1 488.2 214.4L510.9 364.1C511.6 368.8 512 373.6 512 378.4V448C512 483.3 483.3 512 448 512H64C28.65 512 0 483.3 0 448V378.4C0 373.6 .3622 368.8 1.083 364.1L23.76 214.4C28.5 183.1 55.39 160 87.03 160H143.1V128H63.1C46.33 128 31.1 113.7 31.1 96V32C31.1 14.33 46.33 0 63.1 0L288 0zM96 48C87.16 48 80 55.16 80 64C80 72.84 87.16 80 96 80H256C264.8 80 272 72.84 272 64C272 55.16 264.8 48 256 48H96zM80 448H432C440.8 448 448 440.8 448 432C448 423.2 440.8 416 432 416H80C71.16 416 64 423.2 64 432C64 440.8 71.16 448 80 448zM112 216C98.75 216 88 226.7 88 240C88 253.3 98.75 264 112 264C125.3 264 136 253.3 136 240C136 226.7 125.3 216 112 216zM208 264C221.3 264 232 253.3 232 240C232 226.7 221.3 216 208 216C194.7 216 184 226.7 184 240C184 253.3 194.7 264 208 264zM160 296C146.7 296 136 306.7 136 320C136 333.3 146.7 344 160 344C173.3 344 184 333.3 184 320C184 306.7 173.3 296 160 296zM304 264C317.3 264 328 253.3 328 240C328 226.7 317.3 216 304 216C290.7 216 280 226.7 280 240C280 253.3 290.7 264 304 264zM256 296C242.7 296 232 306.7 232 320C232 333.3 242.7 344 256 344C269.3 344 280 333.3 280 320C280 306.7 269.3 296 256 296zM400 264C413.3 264 424 253.3 424 240C424 226.7 413.3 216 400 216C386.7 216 376 226.7 376 240C376 253.3 386.7 264 400 264zM352 296C338.7 296 328 306.7 328 320C328 333.3 338.7 344 352 344C365.3 344 376 333.3 376 320C376 306.7 365.3 296 352 296z"/></svg></div>
                    <div>
                        <p>Terminal: <span class="font-bold">{{$terminal->sn}}</span> </p>
                        <p>Staus: <span class="font-bold">{{ $terminal->ts_naziv }}</span></p>
                        <p>Lokacija:  <span class="font-bold">{{ $terminal->l_naziv }}</span>, {{$terminal->mesto}}</p>
                        <p>Region:  <span class="font-bold">{{ $terminal->r_naziv }}</span></p>
                        <div class="mt-4">
                            <svg class="float-left fill-current w-6 h-4 mr-2 mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 448"><defs><style>.a{fill:#fff;}</style></defs><path d="M512,0H64A64,64,0,0,0,0,64V384a64,64,0,0,0,64,64H512a64,64,0,0,0,64-64V64A64,64,0,0,0,512,0Z"/><circle class="a" cx="186.65" cy="137.79" r="86.21"/><path class="a" d="M382.28,317.58h133a25,25,0,0,0,24.94-24.94V76.51a25,25,0,0,0-24.94-24.94h-133a24.94,24.94,0,0,0-24.93,24.94V292.64A24.94,24.94,0,0,0,382.28,317.58Zm83.13-24.94H431.69c-4.1,0-7.84-3.74-7.84-8.31a8.34,8.34,0,0,1,8.31-8.32h33.25c4.57,0,8.31,3.74,8.31,7.85A8.45,8.45,0,0,1,465.41,292.64ZM390.6,84.82H507V251.08H390.6Z"/><path class="a" d="M57.33,396.43H316a21.61,21.61,0,0,0,21.55-21.55A107.77,107.77,0,0,0,229.76,267.11H143.54A107.76,107.76,0,0,0,35.77,374.88,21.59,21.59,0,0,0,57.33,396.43Z"/></svg>
                            <span class='font-bold'>{{ $terminal->name }}<br/>
                            {{ $terminal->tel }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t-4 border-sky-500 rounded-b text-sky-900 px-4 py-3 shadow-md mb-6" role="alert">
                <div class="mt-2 mb-6"><svg class="float-left fill-current w-4 h-4 mb-4 mr-4 mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C201.7 512 151.2 495 109.7 466.1C95.2 455.1 91.64 436 101.8 421.5C111.9 407 131.8 403.5 146.3 413.6C177.4 435.3 215.2 448 256 448C362 448 448 362 448 256C448 149.1 362 64 256 64C202.1 64 155 85.46 120.2 120.2L151 151C166.1 166.1 155.4 192 134.1 192H24C10.75 192 0 181.3 0 168V57.94C0 36.56 25.85 25.85 40.97 40.97L74.98 74.98C121.3 28.69 185.3 0 255.1 0L256 0zM256 128C269.3 128 280 138.7 280 152V246.1L344.1 311C354.3 320.4 354.3 335.6 344.1 344.1C335.6 354.3 320.4 354.3 311 344.1L239 272.1C234.5 268.5 232 262.4 232 256V152C232 138.7 242.7 128 256 128V128z"/></svg>
                    <span class="font-bold">Istorija terminala:</span>
                </div>
                @if($historyData->count())
                    <ol class="relative border-l border-gray-200 dark:border-gray-700">
                        @foreach($historyData as $item)                 
                        <li class="mb-4 ml-6">            
                            <span class="flex absolute -left-3 justify-center items-center w-6 h-6 bg-sky-100 rounded-full ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
                                <svg class="w-3 h-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                            </span>
                            <h3 class="flex items-center mb-1 text-lg font-semibold text-gray-900 dark:text-white"> - <span class="bg-sky-100 text-sky-900 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800 ml-3">{{ App\Http\Helpers::datumFormat($item->updated_at) }}</span></h3>
                            <p class="mb-0 text-base font-normal text-gray-500 dark:text-gray-400">Status: <span class="font-bold">{{ $item->ts_naziv }}</span></p>
                            <p class="mb-2 text-base font-normal text-gray-500 dark:text-gray-400">Lokacija: <span class="font-bold">{{ $item->l_naziv }} , {{ $item->mesto }}</span></p>
                        </li>
                        @endforeach
                    </ol>
                @endif
            </div>
        </div>
        
        <div class="bg-slate-100 border-t-4 border-slate-500 rounded-b text-slate-900 px-4 py-3 shadow-md mb-6 w-3/5 flex-initial mx-2 my-2" role="alert">
            <div class="flex">
                <div class="py-1"><svg class="fill-slate-500 w-6 h-6 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M416 176C416 78.8 322.9 0 208 0S0 78.8 0 176c0 39.57 15.62 75.96 41.67 105.4c-16.39 32.76-39.23 57.32-39.59 57.68c-2.1 2.205-2.67 5.475-1.441 8.354C1.9 350.3 4.602 352 7.66 352c38.35 0 70.76-11.12 95.74-24.04C134.2 343.1 169.8 352 208 352C322.9 352 416 273.2 416 176zM599.6 443.7C624.8 413.9 640 376.6 640 336C640 238.8 554 160 448 160c-.3145 0-.6191 .041-.9336 .043C447.5 165.3 448 170.6 448 176c0 98.62-79.68 181.2-186.1 202.5C282.7 455.1 357.1 512 448 512c33.69 0 65.32-8.008 92.85-21.98C565.2 502 596.1 512 632.3 512c3.059 0 5.76-1.725 7.02-4.605c1.229-2.879 .6582-6.148-1.441-8.354C637.6 498.7 615.9 475.3 599.6 443.7z"/></svg></div> 
                <div class="w-full">
                    <div class="flex justify-between">
                        <div class="mt-2 font-bold">Komentari:</div>
                        <div class="font-light">{{$tiket->br_komentara}}</div>
                    </div>
                    @if($komentari->count())
                        @foreach($komentari as $komentar)
                            <div class="py-2">
                                <div><svg class="float-left fill-slate-600 w-4 h-4 mr-2 mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M224 256c70.7 0 128-57.31 128-128s-57.3-128-128-128C153.3 0 96 57.31 96 128S153.3 256 224 256zM274.7 304H173.3C77.61 304 0 381.6 0 477.3c0 19.14 15.52 34.67 34.66 34.67h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304z"/></svg>
                                <span class="font-bold">{{ $komentar->name }}</span> <span class="text-sm ml-4">{{ App\Http\Helpers::datumFormat($komentar->created_at) }}</span>
                                    <div class="border border-slate-500 bg-slate-50 px-2 py-2 ml-10">{{ $komentar->komentar }}</div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    
                    <div class="mt-4">
                    @if($tiket->tks_naziv != "Zatvoren")
                        <x-jet-label for="novi_komentar" value="{{ __('Dodaj komentar:') }}" />
                        <x-jet-textarea id="novi_komentar" type="textarea" class="mt-1 block w-full disabled:opacity-50" wire:model.defer="newKoment" />
                        @error('novi_komentar') <span class="error">{{ $message }}</span> @enderror
                        <x-jet-secondary-button wire:click="posaljiKomentar" wire:loading.attr="disabled" class="mt-2">
                            {{ __('Posalji komentar') }}
                        </x-jet-secondary-button>
                    @endif
                    </div> 
                </div>
            </div>
        </div> 
    </div>
    
    {{-- Promeni dodeljenog MODAL --}}
    <x-jet-dialog-modal wire:model="modalDodeliTiketVisible">
        <x-slot name="title">
        <svg class="float-left fill-current w-4 h-4 mr-0 mt-1 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M224 256c70.7 0 128-57.31 128-128s-57.3-128-128-128C153.3 0 96 57.31 96 128S153.3 256 224 256zM274.7 304H173.3C77.61 304 0 381.6 0 477.3c0 19.14 15.52 34.67 34.66 34.67h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304z"/></svg>
        Dodeli tiket korisniku
        </x-slot>

        <x-slot name="content">
            @if($curentUserPozicija != 2)
                @if(!$noviDodeljenUserId)
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
                            <tr class="hover:bg-gray-100" wire:click="$set('noviDodeljenUserId', {{ $value->id }})" >    
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
							<p>Korisnik: <span class="font-bold">{{ $noviDodeljenUserInfo->name }}</span> &nbsp;&nbsp;&nbsp; Pozicija: <span class="font-bold">{{ $noviDodeljenUserInfo->naziv }}</span></p>
							<p class="text-sm">Lokacija: <span class="font-bold">{{ $noviDodeljenUserInfo->l_naziv }}, {{$noviDodeljenUserInfo->mesto}}</span></p>
						</div>
					</div>
				</div> 
                @endif
            @else

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
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalDodeliTiketVisible')" wire:loading.attr="disabled">
                {{ __('Otkaži') }}
            </x-jet-secondary-button>
            @if($noviDodeljenUserId && $prioritetTiketa)
                <x-jet-danger-button class="ml-2" wire:click="changeUser" wire:loading.attr="disabled">
                    {{ __('Sačuvaj') }}
                </x-jet-danger-button>     
            @elseIf($curentUserPozicija == 2 && $dodeljenUserInfo == null)
                <x-jet-danger-button class="ml-2" wire:click="changeToServis" wire:loading.attr="disabled">
                <svg class="float-left fill-current w-4 h-4 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M331.8 224.1c28.29 0 54.88 10.99 74.86 30.97l19.59 19.59c40.01-17.74 71.25-53.3 81.62-96.65c5.725-23.92 5.34-47.08 .2148-68.4c-2.613-10.88-16.43-14.51-24.34-6.604l-68.9 68.9h-75.6V97.2l68.9-68.9c7.912-7.912 4.275-21.73-6.604-24.34c-21.32-5.125-44.48-5.51-68.4 .2148c-55.3 13.23-98.39 60.22-107.2 116.4C224.5 128.9 224.2 137 224.3 145l82.78 82.86C315.2 225.1 323.5 224.1 331.8 224.1zM384 278.6c-23.16-23.16-57.57-27.57-85.39-13.9L191.1 158L191.1 95.99l-127.1-95.99L0 63.1l96 127.1l62.04 .0077l106.7 106.6c-13.67 27.82-9.251 62.23 13.91 85.39l117 117.1c14.62 14.5 38.21 14.5 52.71-.0016l52.75-52.75c14.5-14.5 14.5-38.08-.0016-52.71L384 278.6zM227.9 307L168.7 247.9l-148.9 148.9c-26.37 26.37-26.37 69.08 0 95.45C32.96 505.4 50.21 512 67.5 512s34.54-6.592 47.72-19.78l119.1-119.1C225.5 352.3 222.6 329.4 227.9 307zM64 472c-13.25 0-24-10.75-24-24c0-13.26 10.75-24 24-24S88 434.7 88 448C88 461.3 77.25 472 64 472z"/></svg>
                    {{ __('Dodeli servisu') }}
                </x-jet-danger-button>
            @endif
        </x-slot>
    </x-jet-dialog-modal>

    {{-- Zatvori tiket MODAL --}}
    <x-jet-dialog-modal wire:model="modalZatvoriTiketVisible">
        <x-slot name="title">
        <svg class="fill-current float-left w-6 h-4 mr-4 mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 384"><path d="M576,208V128a64,64,0,0,0-64-64H64A64,64,0,0,0,0,128v80a48,48,0,0,1,48,48A48,48,0,0,1,0,304v80a64,64,0,0,0,64,64H512a64.06,64.06,0,0,0,64-64V304a48,48,0,0,1,0-96ZM446.78,370.78l-44,44L288,300,173.22,414.78l-44-44L244,256,129.22,141.22l44-44L288,212,402.78,97.22l44,44L332,256Z" transform="translate(0 -64)"/></svg>
        Zatvori tiket
    </x-slot>

        <x-slot name="content">
            <p class="font-bold my-4">Da li ste sigurni da želite da zatvorite tiket #{{ $tikid }} ?</p>
            <hr/>
            <x-jet-label for="zatvori_komentar" value="{{ __('Dodaj komentar:') }}" />
            <x-jet-textarea id="zatvori_komentar" type="textarea" class="mt-1 block w-full disabled:opacity-50" wire:model.defer="newKoment" />
            @error('zatvori_komentar') <span class="error">{{ $message }}</span> @enderror
        </x-slot>

        <x-slot name="footer">
        <x-jet-secondary-button wire:click="$toggle('modalZatvoriTiketVisible')" wire:loading.attr="disabled">
                {{ __('Otkaži') }}
            </x-jet-secondary-button>
                <x-jet-danger-button class="ml-2" wire:click="closeTiket" wire:loading.attr="disabled">
                    {{ __('Zatvori tiket') }}
                </x-jet-danger-button>         
        </x-slot>
    </x-jet-dialog-modal>

    {{-- Obrisi tiket MODAL --}}
    <x-jet-dialog-modal wire:model="obrisiTiketModalVisible">
        <x-slot name="title">
        <svg class="fill-current float-left w-6 h-4 mr-4 mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69zM31.1 128H416V448C416 483.3 387.3 512 352 512H95.1C60.65 512 31.1 483.3 31.1 448V128zM111.1 208V432C111.1 440.8 119.2 448 127.1 448C136.8 448 143.1 440.8 143.1 432V208C143.1 199.2 136.8 192 127.1 192C119.2 192 111.1 199.2 111.1 208zM207.1 208V432C207.1 440.8 215.2 448 223.1 448C232.8 448 240 440.8 240 432V208C240 199.2 232.8 192 223.1 192C215.2 192 207.1 199.2 207.1 208zM304 208V432C304 440.8 311.2 448 320 448C328.8 448 336 440.8 336 432V208C336 199.2 328.8 192 320 192C311.2 192 304 199.2 304 208z"/></svg> 
        Obriši tiket
    </x-slot>

        <x-slot name="content">
            <p class="font-bold my-4">Da li ste sigurni da želite da obrišete tiket #{{ $tikid }} ?</p>
            <hr/>
            <p class="py-4"><svg class="fill-red-600 float-left w-4 h-4 mr-4 mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM232 152C232 138.8 242.8 128 256 128s24 10.75 24 24v128c0 13.25-10.75 24-24 24S232 293.3 232 280V152zM256 400c-17.36 0-31.44-14.08-31.44-31.44c0-17.36 14.07-31.44 31.44-31.44s31.44 14.08 31.44 31.44C287.4 385.9 273.4 400 256 400z"/></svg>Brisanjem tiketa brišete sve dodate komentare.</p> 
            <p><svg class="fill-red-600 float-left w-4 h-4 mr-4 mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM232 152C232 138.8 242.8 128 256 128s24 10.75 24 24v128c0 13.25-10.75 24-24 24S232 293.3 232 280V152zM256 400c-17.36 0-31.44-14.08-31.44-31.44c0-17.36 14.07-31.44 31.44-31.44s31.44 14.08 31.44 31.44C287.4 385.9 273.4 400 256 400z"/></svg>Tiket neće biti vidljiv u istoriji terminala!</p>
        </x-slot>

        <x-slot name="footer">
        <x-jet-secondary-button wire:click="$toggle('obrisiTiketModalVisible')" wire:loading.attr="disabled">
                {{ __('Otkaži') }}
            </x-jet-secondary-button>
                <x-jet-danger-button class="ml-2" wire:click="deleteTiket" wire:loading.attr="disabled">
                    {{ __('Obriši tiket') }}
                </x-jet-danger-button>         
        </x-slot>
    </x-jet-dialog-modal>

</div>
