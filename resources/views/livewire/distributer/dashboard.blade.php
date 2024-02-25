<div class="p-6">
   <div class="my-2">

      <div class="mx-2 my-2">
         <div class="bg-slate-50 border-t-4 border-slate-500 rounded-b text-sky-900 shadow-md mb-6">
                <div>
                  <div class="bg-slate-200 text-lg font-bold uppercase px-4 py-3 mb-4">
                     <svg class="float-left fill-current w-6 h-6 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M373.1,134.6L253.4,15.3C243.5,5.5,230.2,0,216.3,0H59C26.5,0,0,26.5,0,59v394c0,32.5,26.5,59,59,59h266 c32.5,0,59-26.5,59-59V160.9C384,151.1,380.1,141.6,373.1,134.6z M354.9,151.8h-61.5c-35.8,0-65-29.2-65-65v-59 c2.7,1.3,5.1,3.1,7.3,5.2L354.9,151.8z M359,453c0,9-3.6,17.5-10,24c-6.5,6.5-15,10-24,10H59c-9,0-17.5-3.6-24-10 c-6.5-6.5-10-15-10-24V59c0-9,3.6-17.5,10-24c6.5-6.5,15-10,24-10h144.4v61.8c0,49.6,40.4,90,90,90H359V453z"/><g><path d="M159.9,391.1h111.3v26.3h-141V197.8h29.7V391.1z"/></g></svg>
                     Dodeljene licence:
                     
                     @if($is_user_zeta)
                        <div class="float-right">
                           <x-jet-secondary-button class="btn btn-blue" wire:click="promeniDistirbuteraShowModal()" title="">
                                 DIST
                           </x-jet-secondary-button>
                        </div>
                     @endif
                  
                  </div>
                  
                     <div class="shadow overflow-hidden border-b border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200" style="width: 100% !important">
                           <thead>
                              <tr class="bg-gray-100">
                                 <th class="px-6 py-3 text-left text-xs leading-4 font-medium text-gray-500 uppercase">Naziv</th>
                                 <th class="px-6 py-3 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Opis</th>
                                 <th class="px-6 py-3 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Cena Zeta</th>
                                 <th class="px-6 py-3 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Cena prodaja</th>
                                 <th class="px-6 py-3 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"></th>
                              </tr>
                           </thead>

                           <tbody class="divide-y divide-gray-200">                           
                              @if ($licenceData->count())
                                 @foreach ($licenceData as $item)
                                       <tr>
                                          <td class="px-2 py-2 font-bold">{{ $item->licenca_naziv }}</td>
                                          <td class="px-2 py-2">{{ $item->licenca_opis }}</td>
                                          <td class="px-2 py-2">{{ $item->licenca_zeta_cena }} EUR</td> 
                                          <td class="px-2 py-2">{{ $item->licenca_dist_cena }} EUR</td>
                                          <td class="px-4 py-2">
                                             <x-jet-secondary-button class="btn btn-blue" wire:click="updateCenuLicenceShowModal({{ $item->id }}, '{{ $item->licenca_naziv }}')" title="Izmeni podatke">
                                                <svg class="fill-current w-4 h-4 mr-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M373.1 24.97C401.2-3.147 446.8-3.147 474.9 24.97L487 37.09C515.1 65.21 515.1 110.8 487 138.9L289.8 336.2C281.1 344.8 270.4 351.1 258.6 354.5L158.6 383.1C150.2 385.5 141.2 383.1 135 376.1C128.9 370.8 126.5 361.8 128.9 353.4L157.5 253.4C160.9 241.6 167.2 230.9 175.8 222.2L373.1 24.97zM440.1 58.91C431.6 49.54 416.4 49.54 407 58.91L377.9 88L424 134.1L453.1 104.1C462.5 95.6 462.5 80.4 453.1 71.03L440.1 58.91zM203.7 266.6L186.9 325.1L245.4 308.3C249.4 307.2 252.9 305.1 255.8 302.2L390.1 168L344 121.9L209.8 256.2C206.9 259.1 204.8 262.6 203.7 266.6zM200 64C213.3 64 224 74.75 224 88C224 101.3 213.3 112 200 112H88C65.91 112 48 129.9 48 152V424C48 446.1 65.91 464 88 464H360C382.1 464 400 446.1 400 424V312C400 298.7 410.7 288 424 288C437.3 288 448 298.7 448 312V424C448 472.6 408.6 512 360 512H88C39.4 512 0 472.6 0 424V152C0 103.4 39.4 64 88 64H200z"/></svg>
                                             </x-jet-secondary-button>
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

   </div>

   <div class="flex my-2">

      <div class="w-1/2 flex-initial mx-2 my-2">
         <div class="border-t-4 border-sky-500 rounded-b text-sky-900 shadow-md mb-6">
            <div class="bg-sky-100 px-4 py-2 flex justify-between">
               <div class="text-lg font-bold  uppercase">
                  <svg class="float-left fill-current w-6 h-6 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M0 48C0 21.5 21.5 0 48 0H336c26.5 0 48 21.5 48 48V232.2c-39.1 32.3-64 81.1-64 135.8c0 49.5 20.4 94.2 53.3 126.2C364.5 505.1 351.1 512 336 512H240V432c0-26.5-21.5-48-48-48s-48 21.5-48 48v80H48c-26.5 0-48-21.5-48-48V48zM80 224c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V240c0-8.8-7.2-16-16-16H80zm80 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V240c0-8.8-7.2-16-16-16H176c-8.8 0-16 7.2-16 16zm112-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V240c0-8.8-7.2-16-16-16H272zM64 112v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V112c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zM176 96c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V112c0-8.8-7.2-16-16-16H176zm80 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V112c0-8.8-7.2-16-16-16H272c-8.8 0-16 7.2-16 16zm96 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm140.7-67.3c-6.2 6.2-6.2 16.4 0 22.6L521.4 352H432c-8.8 0-16 7.2-16 16s7.2 16 16 16h89.4l-28.7 28.7c-6.2 6.2-6.2 16.4 0 22.6s16.4 6.2 22.6 0l56-56c6.2-6.2 6.2-16.4 0-22.6l-56-56c-6.2-6.2-16.4-6.2-22.6 0z"/></svg>
                  Podaci o kompaniji:
               </div>
               <div>
                  <x-jet-secondary-button class="btn btn-blue" wire:click="editDistributerInfoShowModal" title="Izmeni podatke">
                     <svg class="fill-current w-4 h-4 mr-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M373.1 24.97C401.2-3.147 446.8-3.147 474.9 24.97L487 37.09C515.1 65.21 515.1 110.8 487 138.9L289.8 336.2C281.1 344.8 270.4 351.1 258.6 354.5L158.6 383.1C150.2 385.5 141.2 383.1 135 376.1C128.9 370.8 126.5 361.8 128.9 353.4L157.5 253.4C160.9 241.6 167.2 230.9 175.8 222.2L373.1 24.97zM440.1 58.91C431.6 49.54 416.4 49.54 407 58.91L377.9 88L424 134.1L453.1 104.1C462.5 95.6 462.5 80.4 453.1 71.03L440.1 58.91zM203.7 266.6L186.9 325.1L245.4 308.3C249.4 307.2 252.9 305.1 255.8 302.2L390.1 168L344 121.9L209.8 256.2C206.9 259.1 204.8 262.6 203.7 266.6zM200 64C213.3 64 224 74.75 224 88C224 101.3 213.3 112 200 112H88C65.91 112 48 129.9 48 152V424C48 446.1 65.91 464 88 464H360C382.1 464 400 446.1 400 424V312C400 298.7 410.7 288 424 288C437.3 288 448 298.7 448 312V424C448 472.6 408.6 512 360 512H88C39.4 512 0 472.6 0 424V152C0 103.4 39.4 64 88 64H200z"/></svg>
                  </x-jet-secondary-button>
               </div>
            </div>
            <div class="shadow overflow-hidden border-b border-gray-200 px-4 py-2">
               <table class="min-w-full" style="width: 100% !important">
                  <tbody class="divide-y divide-gray-200">
                     <tr>
                        <td class="px-2 py-2">Naziv: </td>
                        <td class="px-2 py-2 font-bold">{{ $ditributerData->distributer_naziv }}</td>
                     </tr>
                     <tr>
                        <td class="px-2 py-2">Adresa: </td>
                        <td class="px-2 py-2 font-bold">{{ $ditributerData->distributer_adresa }}</td>
                     </tr>
                     <tr>
                        <td class="px-2 py-2">Mesto: </td>
                        <td class="px-2 py-2 font-bold">{{ $ditributerData->distributer_zip }} {{ $ditributerData->distributer_mesto }}</td>
                     </tr>
                     <tr>
                        <td class="px-2 py-2">PIB: </td>
                        <td class="px-2 py-2 font-bold">{{ $ditributerData->distributer_pib }}</td>
                     </tr>
                     <tr>
                        <td class="px-2 py-2">Matični broj: </td>
                        <td class="px-2 py-2 font-bold">{{ $ditributerData->distributer_mb }}</td>
                     </tr>
                     <tr>
                        <td class="px-2 py-2">Tekući račun: </td>
                        <td class="px-2 py-2 font-bold">{{ $ditributerData->distributer_tr }}</td>
                     </tr>
                     <tr>
                        <td class="px-2 py-2">Banka: </td>
                        <td class="px-2 py-2 font-bold">{{ $ditributerData->distributer_banka }}</td>
                     </tr>
                     <tr>
                        <td class="px-2 py-2">Kontakt telefon: </td>
                        <td class="px-2 py-2 font-bold">{{ $ditributerData->distributer_tel }}</td>
                     </tr>
                     <tr>
                        <td class="px-2 py-2">Email: </td>
                        <td class="px-2 py-2 font-bold">{{ $ditributerData->distributer_email }}</td>
                     </tr>
                  
                  <tbody>
               </table>
            </div>         
         </div>
      </div>

      <div class="w-1/2 flex-initial mx-2 my-2">
         <div class="border-t-4 border-green-500 rounded-b text-green-900 shadow-md mb-6">
            <div class="bg-green-100 px-4 py-2 flex justify-between">
               <div class="text-lg font-bold  uppercase">
                  <svg class="float-left fill-current w-6 h-6 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M288 0C305.7 0 320 14.33 320 32V96C320 113.7 305.7 128 288 128H208V160H424.1C456.6 160 483.5 183.1 488.2 214.4L510.9 364.1C511.6 368.8 512 373.6 512 378.4V448C512 483.3 483.3 512 448 512H64C28.65 512 0 483.3 0 448V378.4C0 373.6 .3622 368.8 1.083 364.1L23.76 214.4C28.5 183.1 55.39 160 87.03 160H143.1V128H63.1C46.33 128 31.1 113.7 31.1 96V32C31.1 14.33 46.33 0 63.1 0L288 0zM96 48C87.16 48 80 55.16 80 64C80 72.84 87.16 80 96 80H256C264.8 80 272 72.84 272 64C272 55.16 264.8 48 256 48H96zM80 448H432C440.8 448 448 440.8 448 432C448 423.2 440.8 416 432 416H80C71.16 416 64 423.2 64 432C64 440.8 71.16 448 80 448zM112 216C98.75 216 88 226.7 88 240C88 253.3 98.75 264 112 264C125.3 264 136 253.3 136 240C136 226.7 125.3 216 112 216zM208 264C221.3 264 232 253.3 232 240C232 226.7 221.3 216 208 216C194.7 216 184 226.7 184 240C184 253.3 194.7 264 208 264zM160 296C146.7 296 136 306.7 136 320C136 333.3 146.7 344 160 344C173.3 344 184 333.3 184 320C184 306.7 173.3 296 160 296zM304 264C317.3 264 328 253.3 328 240C328 226.7 317.3 216 304 216C290.7 216 280 226.7 280 240C280 253.3 290.7 264 304 264zM256 296C242.7 296 232 306.7 232 320C232 333.3 242.7 344 256 344C269.3 344 280 333.3 280 320C280 306.7 269.3 296 256 296zM400 264C413.3 264 424 253.3 424 240C424 226.7 413.3 216 400 216C386.7 216 376 226.7 376 240C376 253.3 386.7 264 400 264zM352 296C338.7 296 328 306.7 328 320C328 333.3 338.7 344 352 344C365.3 344 376 333.3 376 320C376 306.7 365.3 296 352 296z"/></svg>
                  Podaci o terminalima:
               </div>
               <div>
                  [ ]
               </div>
            </div>
            <div class="shadow overflow-hidden border-b border-gray-200 px-4 py-2">
               <table class="min-w-full" style="width: 100% !important">
                  <tbody class="divide-y divide-gray-200">
                     <tr>
                        <td class="px-2 py-2">Broj terminala: </td>
                        <td class="px-2 py-2 font-bold">{{ $licence_terminali['br_terminala'] }}</td>
                     </tr>
                     <tr>
                        <td class="px-2 py-2">Broj licenci: </td>
                        <td class="px-2 py-2 font-bold">{{ $licence_terminali['br_licenci'] }}</td>
                     </tr>
                     <tr>
                        <td class="px-2 py-2">Broj dana prekoračenja licence: </td>
                        <td class="px-2 py-2 font-bold">{{ $ditributerData->dani_prekoracenja_licence }}</td>
                     </tr>
                     <tr>
                        <td class="px-2 py-2">Datum ugovora za Zeta system DOO: </td>
                        <td class="px-2 py-2 font-bold">{{ App\Http\Helpers::datumFormatDanFullYear($ditributerData->datum_ugovora) }}</td>
                     </tr>
                     <tr>
                        <td class="px-2 py-2">Datum isteka ugovora: </td>
                        <td class="px-2 py-2 font-bold">{{ App\Http\Helpers::datumFormatDanFullYear($ditributerData->datum_kraj_ugovora) }}</td>
                     </tr>
                     
                  
                  <tbody>
               </table>
            </div>         
         </div>
      </div>

   </div>

   {{-- Modal Form --}}
    <x-jet-dialog-modal wire:model="modalLicencaFormVisible">
    <x-slot name="title">
            Cena licence
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <div class="">Licenca: <span class="font-bold">{{ $l_naziv }}</span></div>
            </div>
            <div class="mt-4">
                <div class="">Cena licence prema Zetasystem: <span class="font-bold">{{ $licenca_zeta_cena }} EUR</span></div>
            </div>
            <div class="mt-4 flex">
                <div>
                    <x-jet-label for="licenca_dist_cena" value="{{ __('Cena licence') }}" />
                    <x-jet-input wire:model="licenca_dist_cena" id="" class="block mt-1 w-48" type="text" />
                    @error('licenca_dist_cena') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="font-bold px-6 pt-8">EUR</div>
            </div>
            <div class="mt-4">Unete cene su orjentacione i služe kao preporuka prilikom izdavanja licence krajnjem korisniku. Cenu svake pojedinačne licence određujete prilikom dodavanja licence terminalu.</div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalLicencaFormVisible')" wire:loading.attr="disabled">
                {{ __('Otkaži') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="updateCenaLicence" wire:loading.attr="disabled">
               {{ __('Izmeni') }}
            </x-jet-danger-button>         
        </x-slot>
    </x-jet-dialog-modal>

    {{-- EDIT DISTRIBUTER INFO Modal Form --}}
    <x-jet-dialog-modal wire:model="modalDistributerInfoFormVisible">
    <x-slot name="title">
           Izmeni podatke:
        </x-slot>

        <x-slot name="content">
        <div class="mt-4">
                <x-jet-label for="distributer_naziv" value="{{ __('Naziv') }}" />
                <x-jet-input wire:model="distributer_naziv" class="block mt-1 w-full" type="text" />
                @error('distributer_naziv') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="distributer_adresa" value="{{ __('Adresa') }}" />
                <x-jet-input wire:model="distributer_adresa" id="" class="block mt-1 w-full" type="text" />
                @error('distributer_adresa') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="distributer_zip" value="{{ __('Poštanski broj') }}" />
                <x-jet-input wire:model="distributer_zip" id="" class="block mt-1 w-full" type="text" />
                @error('distributer_zip') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="distributer_mesto" value="{{ __('Mesto') }}" />
                <x-jet-input wire:model="distributer_mesto" id="" class="block mt-1 w-full" type="text" />
                @error('distributer_mesto') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="distributer_email" value="{{ __('E-mail adresa') }}" />
                <x-jet-input wire:model="distributer_email" id="" class="block mt-1 w-full" type="text" />
                @error('distributer_email') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="distributer_pib" value="{{ __('PIB') }}" />
                <x-jet-input wire:model="distributer_pib" id="" class="block mt-1 w-full" type="text" />
                @error('distributer_pib') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="distributer_mb" value="{{ __('Matični broj') }}" />
                <x-jet-input wire:model="distributer_mb" id="" class="block mt-1 w-full" type="text" />
                @error('distributer_mb') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="distributer_tr" value="{{ __('Tekući račun') }}" />
                <x-jet-input wire:model="distributer_tr" id="" class="block mt-1 w-full" type="text" />
                @error('distributer_tr') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="distributer_banka" value="{{ __('Banka') }}" />
                <x-jet-input wire:model="distributer_banka" id="" class="block mt-1 w-full" type="text" />
                @error('distributer_banka') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="distributer_tel" value="{{ __('Telefon') }}" />
                <x-jet-input wire:model="distributer_tel" id="" class="block mt-1 w-full" type="text" />
                @error('distributer_tel') <span class="error">{{ $message }}</span> @enderror
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalDistributerInfoFormVisible')" wire:loading.attr="disabled">
                {{ __('Otkaži') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="distributerInfoSave" wire:loading.attr="disabled">
               {{ __('Izmeni') }}
            </x-jet-danger-button>         
        </x-slot>
    </x-jet-dialog-modal>

    {{-- Promeni DISTRIDUTERA test useru --}}
    <x-jet-dialog-modal wire:model="promeniDitributeraModalVisible">
        <x-slot name="title">
        </x-slot>
        <x-slot name="content">
            <div class="mt-4">
                <x-jet-label for="testUserDistributer" value="{{ __('Radni status') }}" />
                <select wire:model="testUserDistributer" id="" class="block appearance-none w-full bg-gray-100 border border-gray-200 text-gray-700 py-3 px-4 pr-8 round leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                    @foreach (App\Models\LicencaDistributerTip::testUserDistributerList() as $key => $value)    
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
                @error('testUserDistributer') <span class="error">{{ $message }}</span> @enderror
            </div>      
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('promeniDitributeraModalVisible')" wire:loading.attr="disabled">
                {{ __('Otkaži') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="promeniDistributera" wire:loading.attr="disabled">
                {{ __('Promeni') }}
            </x-jet-danger-button>    
        </x-slot>
    </x-jet-dialog-modal>


</div>
