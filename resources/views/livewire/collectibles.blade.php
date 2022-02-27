<div>
    @if ($movies->count())
        @foreach($movies as $movie)
            <div x-data="{ open: false }" class="flex odd:bg-slate-200 mb-2 last:mb-0">
                <img class="object-contain max-w-16 max-h-24" src="{{ $movie->poster }}" onerror="this.src='https://via.placeholder.com/195x288.png?text=X'" />

                <div class="flex flex-1 flex-col p-2">
                    <h3 class="text-lg">{{ $movie->name }}</h3>
                    <p>{{ $movie->getReleaseDateFormatted() }}</p>
                </div>

                <x-button class="mt-auto mb-2 ml-2 mr-2" wire:click="removeCollectible('{{ $movie->id }}')" wire:loading.attr="disabled">
                    Remove
                </x-button>
            </div>
        @endforeach

        {{ $movies->links() }}
    @else
        <p>No movies in your collection.</p>
    @endif
</div>
