<div>
    <x-confirmation-modal wire:model="show">
        <x-slot name="title">
            Add new movie to your collection
        </x-slot>

        <x-slot name="content">
            <!-- Movie Name -->
            <div class="w-full">
                <x-label for="name" :value="__('Name')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" wire:model.debounce.500ms="name" wire:input.lazy="searchTerm" :value="old('name')" required autofocus autocomplete="off" />

                @if (count($results))
                    <div class="bg-slate-100 pt-3 mb-3">
                        <h2 class="text-xl font-bold mx-2 mb-2">Are you looking for one of the following movies?</h2>
                        @foreach ($results as $result)
                            <div class="flex odd:bg-slate-200 mb-2 last:mb-0">
                                @if (Arr::get($result, 'Poster'))
                                    <img class="object-contain max-w-16 max-h-24" src="{{ Arr::get($result, 'Poster') }}"  onerror="this.src='https://via.placeholder.com/195x288.png?text=X'" />
                                @endif

                                <div class="flex flex-1 flex-col p-2">
                                    <h3><span class="text-lg">{{ Arr::get($result, 'Title') }}</span> - {{ Arr::get($result, 'Year') }}</h3>
                                    <p>{{ Str::ucfirst(Arr::get($result, 'Type', 'N/A')) }}</p>
                                </div>

                                <x-button class="mt-auto mb-2 ml-2 mr-2" wire:click="importMovie('{{ Arr::get($result, 'imdbID') }}')" wire:loading.attr="disabled">
                                    Add
                                </x-button>
                            </div>
                        @endforeach

                    </div>
                @endif
            </div>

            <!-- Movie Release Date -->
            <div>
                <x-label for="release_date" :value="__('Release Date')" />

                <x-input id="release_date" class="block mt-1 w-full" type="date" name="release_date" wire:model="releaseDate" :value="old('release_date')" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="$toggle('show')" wire:loading.attr="disabled">
                Nevermind
            </x-button>
    
            <x-button class="ml-2" wire:click="addMovie" wire:loading.attr="disabled">
                Add
            </x-button>
        </x-slot>
    </x-confirmation-modal>
</div>
