<div class="md:grid md:grid-cols-3 md:gap-6">
    <div class="md:col-span-1">
      <div class="px-4 sm:px-0 mx-4 my-4">
        <h3 class="font-bold text-sky-600 text-lg font-medium leading-6 text-gray-900">Online prijava kvara</h3>
        <p class="mt-2 text-gray-600">Prijava kvara se vrši u dva koraka:</p>
        <p class="mt-2 text-gray-600"><svg class="float-left fill-current w-4 h-4 mx-2 mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM232 152C232 138.8 242.8 128 256 128s24 10.75 24 24v128c0 13.25-10.75 24-24 24S232 293.3 232 280V152zM256 400c-17.36 0-31.44-14.08-31.44-31.44c0-17.36 14.07-31.44 31.44-31.44s31.44 14.08 31.44 31.44C287.4 385.9 273.4 400 256 400z"/></svg>
        Prvo je potrebno da unesete serijski broj terminala za koji prijavljujete kvar.</br>
        
        </p>
      </div>
    </div>
    <div class="mt-5 md:mt-0 md:col-span-2">
      
        <div class="shadow sm:rounded-md sm:overflow-hidden">
          <div class="px-4 py-5 bg-white space-y-6 sm:p-6">

            @if(!$terminal)
            <div class="grid grid-cols-2 gap-6">
                <div class="mt-4">
                    <x-jet-label for="serijskiBroj" value="{{ __('Serijski broj terminala:') }}" />
                    <x-jet-input wire:model.defer="serialNum" id="" class="block mt-1 w-full" type="text" />
                    @error('serijskiBroj') <span class="error">{{ $message }}</span> @enderror
                </div> 
                <div class="pt-10"><x-jet-secondary-button wire:click="SearchTerminal"><svg class="fill-current w-4 h-4 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M500.3 443.7l-119.7-119.7c27.22-40.41 40.65-90.9 33.46-144.7C401.8 87.79 326.8 13.32 235.2 1.723C99.01-15.51-15.51 99.01 1.724 235.2c11.6 91.64 86.08 166.7 177.6 178.9c53.8 7.189 104.3-6.236 144.7-33.46l119.7 119.7c15.62 15.62 40.95 15.62 56.57 0C515.9 484.7 515.9 459.3 500.3 443.7zM79.1 208c0-70.58 57.42-128 128-128s128 57.42 128 128c0 70.58-57.42 128-128 128S79.1 278.6 79.1 208z"/></svg>Pretrži</x-jet-button>
                </div>  
              </div>
            </div>
              @if($searchClick)
                  <div class="bg-red-100 border border-red-400 text-red-700 mx-4 px-4 py-3 rounded relative" role="alert">
                      <strong class="font-bold">Greška!</strong>
                      <span class="block sm:inline">U sistemu ne postoji terminala sa serijskim brojem: {{ $serialNum }}</span>
                      <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                          <svg class="fill-current h-6 w-6 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M506.3 417l-213.3-364c-16.33-28-57.54-28-73.98 0l-213.2 364C-10.59 444.9 9.849 480 42.74 480h426.6C502.1 480 522.6 445 506.3 417zM232 168c0-13.25 10.75-24 24-24S280 154.8 280 168v128c0 13.25-10.75 24-23.1 24S232 309.3 232 296V168zM256 416c-17.36 0-31.44-14.08-31.44-31.44c0-17.36 14.07-31.44 31.44-31.44s31.44 14.08 31.44 31.44C287.4 401.9 273.4 416 256 416z"/></svg>
                      </span>
                  </div>
              @endif
            @else
            <div class="bg-sky-100 border-t-4 border-sky-500 rounded-b text-sky-900 px-4 py-3 shadow-md mb-6" role="alert">
                <div class="flex">
                    <div class="py-1"><svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M288 0C305.7 0 320 14.33 320 32V96C320 113.7 305.7 128 288 128H208V160H424.1C456.6 160 483.5 183.1 488.2 214.4L510.9 364.1C511.6 368.8 512 373.6 512 378.4V448C512 483.3 483.3 512 448 512H64C28.65 512 0 483.3 0 448V378.4C0 373.6 .3622 368.8 1.083 364.1L23.76 214.4C28.5 183.1 55.39 160 87.03 160H143.1V128H63.1C46.33 128 31.1 113.7 31.1 96V32C31.1 14.33 46.33 0 63.1 0L288 0zM96 48C87.16 48 80 55.16 80 64C80 72.84 87.16 80 96 80H256C264.8 80 272 72.84 272 64C272 55.16 264.8 48 256 48H96zM80 448H432C440.8 448 448 440.8 448 432C448 423.2 440.8 416 432 416H80C71.16 416 64 423.2 64 432C64 440.8 71.16 448 80 448zM112 216C98.75 216 88 226.7 88 240C88 253.3 98.75 264 112 264C125.3 264 136 253.3 136 240C136 226.7 125.3 216 112 216zM208 264C221.3 264 232 253.3 232 240C232 226.7 221.3 216 208 216C194.7 216 184 226.7 184 240C184 253.3 194.7 264 208 264zM160 296C146.7 296 136 306.7 136 320C136 333.3 146.7 344 160 344C173.3 344 184 333.3 184 320C184 306.7 173.3 296 160 296zM304 264C317.3 264 328 253.3 328 240C328 226.7 317.3 216 304 216C290.7 216 280 226.7 280 240C280 253.3 290.7 264 304 264zM256 296C242.7 296 232 306.7 232 320C232 333.3 242.7 344 256 344C269.3 344 280 333.3 280 320C280 306.7 269.3 296 256 296zM400 264C413.3 264 424 253.3 424 240C424 226.7 413.3 216 400 216C386.7 216 376 226.7 376 240C376 253.3 386.7 264 400 264zM352 296C338.7 296 328 306.7 328 320C328 333.3 338.7 344 352 344C365.3 344 376 333.3 376 320C376 306.7 365.3 296 352 296z"/></svg></div>
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

            <div class="mt-4">
                    <x-jet-label for="opisKvaraList" value="{{ __('Izaberi kvar iz liste') }}" />
                    <select wire:model="opisKvaraList" id="" class="block appearance-none w-full border border-1 text-gray-700 py-3 px-4 pr-8 round leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                    <option value="0">---</option>    
                        @foreach (App\Models\TiketOpisKvaraTip::opisList($terminal->tid) as $key => $value)    
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

                @if($opisKvaraList != 0)
                <p>Ovde ide logika za telefon</p>
                @endif

            @endif
            

            

            <div>
              
            </div>
          </div>
          <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Save</button>
          </div>
        </div>
      
    </div>
  </div>