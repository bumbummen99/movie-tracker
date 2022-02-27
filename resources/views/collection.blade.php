<x-app-layout x-data="{ open: false }">
    <x-slot name="header">
        <div class="flex">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex-1">
                {{ __('Your movie collection') }}
            </h2>
    
            <x-button x-data="{}" x-on:click="window.livewire.emitTo('create-collectible', 'show')">
                Add movie
            </x-button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <livewire:collectibles :user="User::current()" />
                </div>
            </div>
        </div>
    </div>

    <livewire:create-collectible />
</x-app-layout>