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
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
               User Landing page
            </div>
        </div>
    </div>
</x-app-layout>
