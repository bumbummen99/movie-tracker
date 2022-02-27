<?php

namespace App\Http\Livewire;

use App\Models\Movie;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

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
        $collectible = User::current()->collectibles()->where('movie_id', $movie->id)->firstOrFail();

        /* Make sure we can remove it */
        $this->authorize('delete', $collectible);

        /* Remove the movie from the users collection effectively removing the collectible */
        User::current()->collection()->detach($movie);
    }
}