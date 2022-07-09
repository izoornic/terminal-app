<div class="md:grid md:grid-cols-3 md:gap-6">
    <div class="md:col-span-1 bg-slate-200">
      <div class="px-4 sm:px-0 mx-4 my-4" >
        <h3 class="font-bold text-sky-600 text-lg font-medium leading-6 text-gray-900">Online prijava kvara</h3>
        @if(!$terminal)
          {{-- pretraga terminala --}}
            <p class="mt-2 text-gray-600"><svg class="float-left fill-current w-4 h-4 mx-2 mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM232 152C232 138.8 242.8 128 256 128s24 10.75 24 24v128c0 13.25-10.75 24-24 24S232 293.3 232 280V152zM256 400c-17.36 0-31.44-14.08-31.44-31.44c0-17.36 14.07-31.44 31.44-31.44s31.44 14.08 31.44 31.44C287.4 385.9 273.4 400 256 400z"/></svg>
            Unesete serijski broj terminala za koji prijavljujete kvar.</br>
            <span class="text-sm text-red-400">Nalepnica na poleđini terminala </span>
            <img src="img/NalepnicaTerminal.jpg" />
            </p>
            <p class="mt-2 text-gray-600">
            <span class="text-sm text-red-400">Nalepnica na kutiji terminala </span>
            <img src="img/NalepnicaKutija.jpg" />
            </p>
        @else
          @if($tiket_verifikovan)
            {{-- USPESNA VERIFIKACIJA --}}
            <p class="mt-4 text-gray-600"><svg class="float-left fill-current w-4 h-4 mx-2 mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM232 152C232 138.8 242.8 128 256 128s24 10.75 24 24v128c0 13.25-10.75 24-24 24S232 293.3 232 280V152zM256 400c-17.36 0-31.44-14.08-31.44-31.44c0-17.36 14.07-31.44 31.44-31.44s31.44 14.08 31.44 31.44C287.4 385.9 273.4 400 256 400z"/></svg>
              Uspešna prijava kvara.
            </p>
          @elseif(App\Models\Tiket::daliTerminalImaOtvorenTiket($terminal->id))
            {{-- GRESKA terminal ima tiket --}}
          @else
            {{-- PRIKAZAN TERMINAL INFO --}}
            @if(!$smsSended && !$verifikacijaSubmited)
              {{-- IZABERI KVAR IZ LISTe --}}
              <p class="mt-2 text-gray-600"><svg class="float-left fill-current w-4 h-4 mx-2 mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM232 152C232 138.8 242.8 128 256 128s24 10.75 24 24v128c0 13.25-10.75 24-24 24S232 293.3 232 280V152zM256 400c-17.36 0-31.44-14.08-31.44-31.44c0-17.36 14.07-31.44 31.44-31.44s31.44 14.08 31.44 31.44C287.4 385.9 273.4 400 256 400z"/></svg>
                Izaberite kvar iz liste.
              </p>
              @if($opisKvaraList != 0)
                {{-- UNESI ime i telefon --}}
                <p class="mt-2 text-gray-600"><svg class="float-left fill-current w-4 h-4 mx-2 mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM232 152C232 138.8 242.8 128 256 128s24 10.75 24 24v128c0 13.25-10.75 24-24 24S232 293.3 232 280V152zM256 400c-17.36 0-31.44-14.08-31.44-31.44c0-17.36 14.07-31.44 31.44-31.44s31.44 14.08 31.44 31.44C287.4 385.9 273.4 400 256 400z"/></svg>
                  Unesite ime i broj telefona.
                </p>
              @endif
            @elseif(!$verifikacijaSubmited)
              {{-- PRIJAVI KVAR --}}
              <p class="mt-2 text-gray-600"><svg class="float-left fill-current w-4 h-4 mx-2 mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM232 152C232 138.8 242.8 128 256 128s24 10.75 24 24v128c0 13.25-10.75 24-24 24S232 293.3 232 280V152zM256 400c-17.36 0-31.44-14.08-31.44-31.44c0-17.36 14.07-31.44 31.44-31.44s31.44 14.08 31.44 31.44C287.4 385.9 273.4 400 256 400z"/></svg>
                Unesite verifikacioni kod.
              </p>
            @else
              {{-- UNETA VERIFIKACIJA --}}
              @if(!$verifikacijaUspesna)
                {{-- NEUSPESNA VERIFIKACIJA --}}
                <p class="mt-2 text-gray-600"><svg class="float-left fill-current w-4 h-4 mx-2 mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM232 152C232 138.8 242.8 128 256 128s24 10.75 24 24v128c0 13.25-10.75 24-24 24S232 293.3 232 280V152zM256 400c-17.36 0-31.44-14.08-31.44-31.44c0-17.36 14.07-31.44 31.44-31.44s31.44 14.08 31.44 31.44C287.4 385.9 273.4 400 256 400z"/></svg>
                  Neuspešna verifikacija.
                </p>
              @endif
            @endif
          @endif
        @endif
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
              @if($tiket_verifikovan)
                  {{-- PRIKAZ USPESNE VERIFIKACIJE --}}
                  <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative my-4" role="alert">
                      <strong class="font-bold">USPEŠNO STE PRIJAVILI KVAR</strong>
                      <p><span class="block sm:inline">Vaša prijava je prosleđena. Uskoro ćemo Vas kontaktirati. <br /> Hvala na poverenju.</span></p>
                      <span class="absolute top-2 bottom-0 right-0 px-4 py-3">
                          <svg class="fill-current h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M384 32C419.3 32 448 60.65 448 96V416C448 451.3 419.3 480 384 480H64C28.65 480 0 451.3 0 416V96C0 60.65 28.65 32 64 32H384zM339.8 211.8C350.7 200.9 350.7 183.1 339.8 172.2C328.9 161.3 311.1 161.3 300.2 172.2L192 280.4L147.8 236.2C136.9 225.3 119.1 225.3 108.2 236.2C97.27 247.1 97.27 264.9 108.2 275.8L172.2 339.8C183.1 350.7 200.9 350.7 211.8 339.8L339.8 211.8z"/></svg>
                        </span>
                  </div>
              @elseif(App\Models\Tiket::daliTerminalImaOtvorenTiket($terminal->id))
                  {{-- PRIKAZ GRESKE --}}
                  <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative my-4" role="alert">
                      <strong class="font-bold">Greška!</strong>
                      <span class="block sm:inline">Terminal ima aktivan Tiket. Otvoren: {{ App\Http\Helpers::datumFormat(App\Models\Tiket::daliTerminalImaOtvorenTiket($terminal->id)->created_at) }}</span>
                      <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                          <svg class="fill-current h-6 w-6 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M506.3 417l-213.3-364c-16.33-28-57.54-28-73.98 0l-213.2 364C-10.59 444.9 9.849 480 42.74 480h426.6C502.1 480 522.6 445 506.3 417zM232 168c0-13.25 10.75-24 24-24S280 154.8 280 168v128c0 13.25-10.75 24-23.1 24S232 309.3 232 296V168zM256 416c-17.36 0-31.44-14.08-31.44-31.44c0-17.36 14.07-31.44 31.44-31.44s31.44 14.08 31.44 31.44C287.4 401.9 273.4 416 256 416z"/></svg>
                      </span>
                  </div>
              @else
                <div class="bg-sky-100 border-t-4 border-sky-500 rounded-b text-sky-900 px-4 py-3 shadow-md mb-6" role="alert">
                    <div class="flex">
                        <div class="py-1"><svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M288 0C305.7 0 320 14.33 320 32V96C320 113.7 305.7 128 288 128H208V160H424.1C456.6 160 483.5 183.1 488.2 214.4L510.9 364.1C511.6 368.8 512 373.6 512 378.4V448C512 483.3 483.3 512 448 512H64C28.65 512 0 483.3 0 448V378.4C0 373.6 .3622 368.8 1.083 364.1L23.76 214.4C28.5 183.1 55.39 160 87.03 160H143.1V128H63.1C46.33 128 31.1 113.7 31.1 96V32C31.1 14.33 46.33 0 63.1 0L288 0zM96 48C87.16 48 80 55.16 80 64C80 72.84 87.16 80 96 80H256C264.8 80 272 72.84 272 64C272 55.16 264.8 48 256 48H96zM80 448H432C440.8 448 448 440.8 448 432C448 423.2 440.8 416 432 416H80C71.16 416 64 423.2 64 432C64 440.8 71.16 448 80 448zM112 216C98.75 216 88 226.7 88 240C88 253.3 98.75 264 112 264C125.3 264 136 253.3 136 240C136 226.7 125.3 216 112 216zM208 264C221.3 264 232 253.3 232 240C232 226.7 221.3 216 208 216C194.7 216 184 226.7 184 240C184 253.3 194.7 264 208 264zM160 296C146.7 296 136 306.7 136 320C136 333.3 146.7 344 160 344C173.3 344 184 333.3 184 320C184 306.7 173.3 296 160 296zM304 264C317.3 264 328 253.3 328 240C328 226.7 317.3 216 304 216C290.7 216 280 226.7 280 240C280 253.3 290.7 264 304 264zM256 296C242.7 296 232 306.7 232 320C232 333.3 242.7 344 256 344C269.3 344 280 333.3 280 320C280 306.7 269.3 296 256 296zM400 264C413.3 264 424 253.3 424 240C424 226.7 413.3 216 400 216C386.7 216 376 226.7 376 240C376 253.3 386.7 264 400 264zM352 296C338.7 296 328 306.7 328 320C328 333.3 338.7 344 352 344C365.3 344 376 333.3 376 320C376 306.7 365.3 296 352 296z"/></svg></div>
                        <div>
                            <p>Terminal: <span class="font-bold">{{$terminal->sn}}</span> </p>
                            <p>Staus: <span class="font-bold">{{ $terminal->ts_naziv }}</span></p>
                            <p>Lokacija:  <span class="font-bold">{{ $terminal->l_naziv }}</span>, {{$terminal->mesto}}</p>
                            <p>Region:  <span class="font-bold">{{ $terminal->r_naziv }}</span></p>
                        </div>
                    </div>
                </div>

                @if(!$smsSended && !$verifikacijaSubmited)
                <div class="mt-4">
                        <x-jet-label for="opisKvaraList" value="{{ __('Izaberite kvar iz liste:') }}" />
                        <select wire:model="opisKvaraList" id="" class="block appearance-none w-full border border-1 text-gray-700 py-3 px-4 pr-8 round leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                        <option value="0">---</option>    
                            @foreach (App\Models\TiketOpisKvaraTip::opisList($terminal->tid) as $key => $value)    
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                        @error('opisKvaraList') <span class="error">{{ $message }}</span> @enderror
                    </div>  
                

                    <div class="mt-4">
                        <x-jet-label for="opis_kvara" value="{{ __('Opis kvara:') }}" />
                        <x-jet-textarea id="opis_kvara" type="textarea" class="mt-1 block w-full disabled:opacity-50" wire:model.defer="opisKvataTxt" />
                        @error('opis_kvara') <span class="error">{{ $message }}</span> @enderror
                    </div> 

                    @if($opisKvaraList != 0)
                    <div class="mt-4">
                      <p class="font-bold">Unesite ime i broj telefona na koji će Vam biti poslat verifikacioni kod.</p>
                    </div>
                    <div class="mt-4">
                        <x-jet-label for="prijavaIme" value="{{ __('Ime i prezime:') }}" />
                        <x-jet-input wire:model="prijavaIme" id="" class="block mt-1 w-full" type="text" />
                        @error('prijavaIme') <span class="error">{{ $message }}</span> @enderror
                    </div> 
                    <div class="mt-4">
                      <x-jet-label for="telefon" value="{{ __('Broj telefona:') }}" />
                      <div class="mt-4 flex rounded-md shadow-sm">
                      
                          <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-m">
                            +381
                          </span>
                          <input wire:model.difer="telefon" class="form-input flex-1 block w-full rounded-none rounded-r-md transition duration-150 ease-in-out sm:text-sm sm:leading-5" >
                          @error('telefon') &nbsp;<span class="error">{{ $message }}</span>@enderror
                      </div>
                    </div> 

                    </div>
                      <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <div class="float-left"><svg class="fill-sky-600 w-6 h-6 ml-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M256 32C114.6 32 .0137 125.1 .0137 240c0 49.59 21.39 95 56.99 130.7c-12.5 50.39-54.31 95.3-54.81 95.8C0 468.8-.5938 472.2 .6875 475.2C1.1 478.2 4.813 480 8 480c66.31 0 116-31.8 140.6-51.41C181.3 440.9 217.6 448 256 448C397.4 448 512 354.9 512 240S397.4 32 256 32zM167.3 271.9C163.9 291.1 146.3 304 121.1 304c-4.031 0-8.25-.3125-12.59-1C101.1 301.8 92.81 298.8 85.5 296.1c-8.312-3-14.06-12.66-11.09-20.97S85 261.1 93.38 264.9c6.979 2.498 14.53 5.449 20.88 6.438C125.7 273.1 135 271 135.8 266.4c1.053-5.912-10.84-8.396-24.56-12.34c-12.12-3.531-44.28-12.97-38.63-46c4.062-23.38 27.31-35.91 58-31.09c5.906 .9062 12.44 2.844 18.59 4.969c8.344 2.875 12.78 12 9.906 20.34C156.3 210.7 147.2 215.1 138.8 212.2c-4.344-1.5-8.938-2.938-13.09-3.594c-11.22-1.656-20.72 .4062-21.5 4.906C103.2 219.2 113.6 221.5 124.4 224.6C141.4 229.5 173.1 238.5 167.3 271.9zM320 288c0 8.844-7.156 16-16 16S288 296.8 288 288V240l-19.19 25.59c-6.062 8.062-19.55 8.062-25.62 0L224 240V288c0 8.844-7.156 16-16 16S192 296.8 192 288V192c0-6.875 4.406-12.1 10.94-15.18c6.5-2.094 13.71 .0586 17.87 5.59L256 229.3l35.19-46.93c4.156-5.531 11.4-7.652 17.87-5.59C315.6 179 320 185.1 320 192V288zM439.3 271.9C435.9 291.1 418.3 304 393.1 304c-4.031 0-8.25-.3125-12.59-1c-8.25-1.25-16.56-4.25-23.88-6.906c-8.312-3-14.06-12.66-11.09-20.97s10.59-13.16 18.97-10.19c6.979 2.498 14.53 5.449 20.88 6.438c11.44 1.719 20.78-.375 21.56-4.938c1.053-5.912-10.84-8.396-24.56-12.34c-12.12-3.531-44.28-12.97-38.63-46c4.031-23.38 27.25-35.91 58-31.09c5.906 .9062 12.44 2.844 18.59 4.969c8.344 2.875 12.78 12 9.906 20.34c-2.875 8.344-11.94 12.81-20.34 9.906c-4.344-1.5-8.938-2.938-13.09-3.594c-11.19-1.656-20.72 .4062-21.5 4.906C375.2 219.2 385.6 221.5 396.4 224.6C413.4 229.5 445.1 238.5 439.3 271.9z"/></svg></div>
                        <button wire:click="sendSMS" type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-sky-600 hover:bg-sky-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-200">
                        <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M256 64C256 46.33 270.3 32 288 32H415.1C415.1 32 415.1 32 415.1 32C420.3 32 424.5 32.86 428.2 34.43C431.1 35.98 435.5 38.27 438.6 41.3C438.6 41.35 438.6 41.4 438.7 41.44C444.9 47.66 447.1 55.78 448 63.9C448 63.94 448 63.97 448 64V192C448 209.7 433.7 224 416 224C398.3 224 384 209.7 384 192V141.3L214.6 310.6C202.1 323.1 181.9 323.1 169.4 310.6C156.9 298.1 156.9 277.9 169.4 265.4L338.7 96H288C270.3 96 256 81.67 256 64V64zM0 128C0 92.65 28.65 64 64 64H160C177.7 64 192 78.33 192 96C192 113.7 177.7 128 160 128H64V416H352V320C352 302.3 366.3 288 384 288C401.7 288 416 302.3 416 320V416C416 451.3 387.3 480 352 480H64C28.65 480 0 451.3 0 416V128z"/></svg> 
                        POŠALJI VERIFIKACIONI KOD</button>
                      </div>
                    </div>

                    @endif
                  @elseif(!$verifikacijaSubmited)
                  {{-- POSLAT SMS PROVERA VERIFIKACIONOG KODA --}}
                    <div class="mt-4">
                        <p class= "my-4">Na broj: <span class="font-bold">+381 {{ $telefon_display }} </span> je poslata SMS poruka sa verifikacinim kodom. {{ $telefon }} - {{ $verifikacioniKod }}</p>
                        <x-jet-label for="verifikacioniKodInput" value="{{ __('Unesite verifikacioni kod:') }}" />
                        <x-jet-input wire:model.defer="verifikacioniKodInput" id="" class="block mt-1 w-full" type="text" />
                        @error('verifikacioniKodInput') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    </div>
                      <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <button wire:click="checkVerificationCode" type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-sky-600 hover:bg-sky-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-200">
                        <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M384 32C419.3 32 448 60.65 448 96V416C448 451.3 419.3 480 384 480H64C28.65 480 0 451.3 0 416V96C0 60.65 28.65 32 64 32H384zM339.8 211.8C350.7 200.9 350.7 183.1 339.8 172.2C328.9 161.3 311.1 161.3 300.2 172.2L192 280.4L147.8 236.2C136.9 225.3 119.1 225.3 108.2 236.2C97.27 247.1 97.27 264.9 108.2 275.8L172.2 339.8C183.1 350.7 200.9 350.7 211.8 339.8L339.8 211.8z"/></svg> 
                        PRIJAVI KVAR</button>
                      </div>
                    </div> 
                  @else
                  {{-- UNET VERIFIKACIONI KOD  --}}
                      @if(!$verifikacijaUspesna) 
                      {{-- VERIFIKACIJA NIJE USPESNA   --}}
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative my-4" role="alert">
                            <strong class="font-bold">Greška!</strong>
                            <p><span class="block sm:inline">Verifikacioni kod koji ste uneli nije validan! <br />
                            Pokušajte ponovo za 15 minuta.</span></p>
                            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                                <svg class="fill-current h-6 w-6 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M506.3 417l-213.3-364c-16.33-28-57.54-28-73.98 0l-213.2 364C-10.59 444.9 9.849 480 42.74 480h426.6C502.1 480 522.6 445 506.3 417zM232 168c0-13.25 10.75-24 24-24S280 154.8 280 168v128c0 13.25-10.75 24-23.1 24S232 309.3 232 296V168zM256 416c-17.36 0-31.44-14.08-31.44-31.44c0-17.36 14.07-31.44 31.44-31.44s31.44 14.08 31.44 31.44C287.4 401.9 273.4 416 256 416z"/></svg>
                            </span>
                        </div>
                      @endif
                  @endif
               @endif
                
            @endif
      
    </div>
  </div>