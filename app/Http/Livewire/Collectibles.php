<?php

namespace App\Http\Livewire;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class Collectibles extends Component
{
    use AuthorizesRequests, WithPagination;

    public User $user;
    public int $size = 25;

    protected $listeners = ['collectionUpdated' => '$refresh'];

    public function render()
    {
        return view('livewire.collectibles', [
            'movies' => $this->user->collection()->paginate($this->size),
        ]);
    }

    public function removeCollectible(Movie $movie)
    {
        /* Get the correct collectible instance */
        $collectible = $this->user->collectibles()->where('movie_id', $movie->id)->firstOrFail();

        /* Make sure we can remove it */
        $this->authorize('delete', $collectible);

        /* Remove the movie from the users collection effectively removing the collectible */
        $this->user->collection()->detach($movie);
    }
}
