<?php

namespace Tests\Feature\Dashboard;

use Tests\TestCase;
use InitSoftBot\{App, User};
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class ViewAppListingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function user_can_view_an_apps_listing()
    {
        $cristian = factory(User::class)->create();

        $apps = new EloquentCollection([
            factory(App::class)->create(['user_id' => $cristian->id]),
            factory(App::class)->create(['user_id' => $cristian->id]),
            factory(App::class)->create(['user_id' => $cristian->id])
        ]);

        $response = $this->actingAs($cristian)->get(route('dashboard.apps.index'));

        $response->assertSuccessful();

        $this->assertCount(3, $response->data('apps')->items());
        $apps->assertEquals($response->data('apps')->items());
    }

    /** @test */
    function guest_cannot_view_an_apps_listing()
    {
        $cristian = factory(User::class)->create();

        factory(App::class)->times(3)->create(['user_id' => $cristian->id]);

        $this->withExceptionHandling()->get(route('dashboard.apps.index'))
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect(route('login'));
    }

    /** @test */
    function user_only_can_see_your_apps_listing()
    {
        $cristian = factory(User::class)->create();

        factory(App::class)->times(5)->create();

        $apps = new EloquentCollection([
            factory(App::class)->create(['user_id' => $cristian->id]),
            factory(App::class)->create(['user_id' => $cristian->id]),
            factory(App::class)->create(['user_id' => $cristian->id])
        ]);

        $response = $this->actingAs($cristian)->get(route('dashboard.apps.index'));

        $response->assertSuccessful();

        $this->assertCount(3, $response->data('apps')->items());
        $apps->assertEquals($response->data('apps')->items());
    }
}
