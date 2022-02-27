<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Abstracts\Modal;
use App\Models\Movie;
use App\Models\User;
use aharen\OMDbAPI;
use App\Models\Collectible;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class CreateCollectible extends Modal
{
    use AuthorizesRequests;

    public string $name = '';
    public string $releaseDate = '';
    public array $results = [];
 
    protected $rules = [
        'name'        => 'required|string',
        'releaseDate' => 'required|date',
    ];

    public function render()
    {
        return view('livewire.create-collectible');
    }

    public function searchTerm(OMDbAPI $omdbApi)
    {
        /* Try to find the media */
        $result = $omdbApi->search($this->name, 'movie', $this->releaseDate);

        /* Make sure the request is OK and we found something */
        if (Arr::get($result, 'code') === 200 && ! Arr::has($result, 'data.Error')) {
            /* Set the results */
            $this->results = Arr::get($result, 'data.Search', []);
        } else {
            /* Nothing found, reset results */
            $this->reset('results');
        }
    }

    /**
     * Add a movie by importing data
     */
    public function importMovie(OMDbAPI $omdbApi, string $imdbID)
    { 
        /* Try to fetch the movie details */
        $result = $omdbApi->fetch('i', $imdbID);

        /* Check if we got a result */
        if (Arr::get($result, 'code') === 200 && ! Arr::has($result, 'data.Error')) {
            $releaseDate = ! Arr::has($result, 'data.Released') || Arr::get($result, 'data.Released') === 'N/A' ? null : Carbon::parse(Arr::get($result, 'data.Released'));
            $movie = $this->getOrCreateMovie(Arr::get($result, 'data.Title'), $releaseDate, Arr::get($result, 'data.Poster', null));

            $this->attachMovie($movie);
        }        
    }

    /**
     * Add a movie by manual data
     */
    public function addMovie()
    {
        $movie = $this->getOrCreateMovie($this->name, Carbon::parse($this->releaseDate));

        $this->attachMovie($movie);
    }

    /**
     * Get a movie from the database with the given data. If it does not exist already
     * it will be created.
     */
    private function getOrCreateMovie(string $name, ?Carbon $releaseDate, ?string $poster = null)
    {
        /* Find the movie in the DB and update, if not found create */
        $movie = Movie::updateOrCreate([
            'name'         => $name,
            'release_date' => $releaseDate,
        ], [
            'poster' => $poster,
        ]);

        return $movie;
    }

    /**
     * Attaches the given movie to the current users collection
     * creating a collectible in the process. Will check policy
     * for permission to do so.
     */
    private function attachMovie(Movie $movie)
    {
        /* Make sure we can attach / create collectibles first */
        $this->authorize('create', Collectible::class);

        /* Create the movie and add it to the users collection */
        User::current()->collection()->syncWithoutDetaching($movie);

        /* Reset the inputs */
        $this->reset();

        /* Signal collection updated */
        $this->emit('collectionUpdated');
    }
}