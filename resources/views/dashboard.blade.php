<x-app-layout>
    <x-slot name="header">
        <h3 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h3>
        <div class="ml-3 relative">
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
                                    <!-- Team Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Manage Team') }}
                                    </div>
                                    <!-- Team Settings -->
                                    <x-jet-dropdown-link href="#">
                                            {{ __('Team Settings') }}
                                    </x-jet-dropdown-link>
                                    <x-jet-dropdown-link href="{{ route('profile.show') }}">
                                    {{ __('Profile') }}
                                    </x-jet-dropdown-link>
                                </div>
                            </x-slot>
                        </x-jet-dropdown>
                    </div>
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
