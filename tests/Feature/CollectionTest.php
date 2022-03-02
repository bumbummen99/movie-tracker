<?php

namespace Tests\Feature;

use App\Http\Livewire\Collectibles;
use App\Http\Livewire\CreateCollectible;
use App\Models\Collectible;
use App\Models\Movie;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CollectionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_user_can_access_his_collection()
    {
        $this->actingAs(self::createUser());

        $response = $this->get('/collection');

        $response->assertStatus(200);

        $response->assertSeeLivewire(CreateCollectible::class);
        $response->assertSeeLivewire(Collectibles::class);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_user_can_create_new_movies()
    {
        $this->actingAs(self::createUser());

        Livewire::test(CreateCollectible::class)
            ->set('name', 'Star Wars')
            ->set('releaseDate', Carbon::now()->format('Y-m-d'))
            ->call('addMovie');

        $this->assertTrue(Movie::whereName('Star Wars')->exists());
        $this->assertTrue(Collectible::query()->whereRelation('movie', 'name', 'Star Wars')->exists());
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_user_can_search_and_fetch_movies_from_omdb()
    {
        $this->actingAs(self::createUser());

        Livewire::test(CreateCollectible::class)
            ->set('name', 'Star Wars: The Force Awakens')
            ->call('searchTerm')
            ->assertNotSet('results', [])
            ->call('importMovie', 'tt2488496');

        $this->assertTrue(Movie::whereName('Star Wars: Episode VII - The Force Awakens')->exists());
        $this->assertTrue(Collectible::query()->whereRelation('movie', 'name', 'Star Wars: Episode VII - The Force Awakens')->exists());
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_user_can_see_his_collection()
    {
        $this->actingAs(self::createUser());

        Livewire::test(CreateCollectible::class)
            ->call('importMovie', 'tt2488496');

        $response = $this->get('/collection');

        $response->assertStatus(200);

        $response->assertSeeLivewire(CreateCollectible::class);
        $response->assertSeeLivewire(Collectibles::class);

        $response->assertSeeText('Star Wars: Episode VII - The Force Awakens');
    }

    private static function createUser(): User
    {
        return User::factory()->create();
    }
}
