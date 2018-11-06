<?php

namespace Tests\Feature\Dashboard;

use Tests\TestCase;
use InitSoftBot\{App, User};
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateAppTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function user_can_create_an_app()
    {
        $cristian = factory(User::class)->create();

        $response = $this->actingAs($cristian)
            ->postJson(route('dashboard.apps.store'), [
                'name' => 'Mi first Botman app'
            ]);

        $response->assertStatus(201);
        $response->assertJson(['data' => [
            'name' => 'Mi First Botman App',
            'slug' => 'mi-first-botman-app'
        ]]);

        $this->assertDatabaseHas('apps', [
           'name' =>  "mi first botman app"
        ]);
    }

    /** @test */
    function app_name_must_be_unique()
    {
       $cristian = factory(User::class)->create();

       factory(App::class)->create(['name' => 'Mi first Botman app']);

        $response = $this->handleValidationExceptions()->actingAs($cristian)
            ->postJson(route('dashboard.apps.store'), [
                'name' => 'Mi first Botman app'
            ]);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => "The given data was invalid.",
            'errors' => [
                'name' => ["El valor del campo name ya está en uso."]
            ]
        ]);
    }
}
