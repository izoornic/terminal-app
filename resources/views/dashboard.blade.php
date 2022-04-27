<x-app-layout>
    <x-slot name="header">
        <h3 class="font-semibold text-xl text-gray-800 leading-tight">
        <span class="float-left mr-2 pr-2"><svg class="fill-gray-500 w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M575.8 255.5C575.8 273.5 560.8 287.6 543.8 287.6H511.8L512.5 447.7C512.5 450.5 512.3 453.1 512 455.8V472C512 494.1 494.1 512 472 512H456C454.9 512 453.8 511.1 452.7 511.9C451.3 511.1 449.9 512 448.5 512H392C369.9 512 352 494.1 352 472V384C352 366.3 337.7 352 320 352H256C238.3 352 224 366.3 224 384V472C224 494.1 206.1 512 184 512H128.1C126.6 512 125.1 511.9 123.6 511.8C122.4 511.9 121.2 512 120 512H104C81.91 512 64 494.1 64 472V360C64 359.1 64.03 358.1 64.09 357.2V287.6H32.05C14.02 287.6 0 273.5 0 255.5C0 246.5 3.004 238.5 10.01 231.5L266.4 8.016C273.4 1.002 281.4 0 288.4 0C295.4 0 303.4 2.004 309.5 7.014L564.8 231.5C572.8 238.5 576.9 246.5 575.8 255.5L575.8 255.5z"/></svg></span>
            {{ __('Početna') }} 
        </h3>
        <!-- <div class="ml-3 relative">
                    <x-jet-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <x-jet-nav-link href="#">
                                        {{ __('Dashboard') }}
                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </x-jet-nav-link>
                                </span>
                            </x-slot>
                            <x-slot name="content">
                                <div class="w-60">
                                   
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Manage Team') }}
                                    </div>
                                   
                                    <x-jet-dropdown-link href="#">
                                            {{ __('Team Settings') }}
                                    </x-jet-dropdown-link>
                                    <x-jet-dropdown-link href="{{ route('profile.show') }}">
                                    {{ __('Profile') }}
                                    </x-jet-dropdown-link>
                                </div>
                            </x-slot>
                        </x-jet-dropdown>
                    </div> -->
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg h-96 w-96">
                    <div class="shadow-lg rounded-lg overflow-hidden">
                    <canvas class="p-1" id="chartPie"></canvas>
                </div>
            </div>
        </div>
    </div>
    @include('admin.footer')


    <!-- Required chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Chart pie -->
    <script>
    const dataPie = {
        labels: ["Magacin {{ 200 }}", "Instalirani", "Zamenski", "Neispravni"],
        datasets: [
        {
            label: "Terminali",
            data: [{{ 220 }}, 50, 100, 150],
            backgroundColor: [
            "rgb(255, 99, 132)",
            "rgb(225, 206, 86)",
            "rgb(153, 102, 255)",
            "rgb(120, 143, 241)",
            ],
            borderColor: "#333",
            borderWidth: 2,
            hoverOffset: 4,
        },
        ],
    };

    const configPie = {
        type: "pie",
        data: dataPie,
        options: {
            title:{
                display: true,
                text: "Grafik terminala",
            }
        }
    };

    var chartBar = new Chart(document.getElementById("chartPie"), configPie);
    </script>

</x-app-layout>
