<?php

namespace Tests\Feature\Dashboard;

use Tests\TestCase;
use InitSoftBot\{App, User};
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateAppTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function user_can_update_your_apps()
    {
        $cristian = factory(User::class)->create();

        $app = factory(App::class)->create(['user_id' => $cristian->id]);

        $response = $this->actingAs($cristian)
            ->putJson(route('dashboard.apps.update', $app), [
                'name' => 'Mi first Botman app'
            ]);

        $response->assertStatus(200);
        $response->assertJson(['data' => [
            'name' => 'Mi First Botman App',
            'slug' => 'mi-first-botman-app'
        ]]);

        $this->assertDatabaseHas('apps', [
            'name' =>  "mi first botman app"
        ]);
    }

    /** @test */
    function user_cannot_update_other_apps_that_are_not_yours()
    {
        $cristian = factory(User::class)->create();

        $app = factory(App::class)->create();

        $response = $this->withExceptionHandling()->actingAs($cristian)
            ->putJson(route('dashboard.apps.update', $app), [
                'name' => 'Mi first Botman app'
            ]);

        $response->assertStatus(403);

        $this->assertDatabaseMissing('apps', [
            'name' =>  "mi first botman app"
        ]);
    }

    /** @test */
    function app_name_must_be_unique()
    {
        $cristian = factory(User::class)->create();

        factory(App::class)->create(['name' => 'Mi first Botman app']);
        $app = factory(App::class)->create(['user_id' => $cristian->id]);

        $response = $this->handleValidationExceptions()->actingAs($cristian)
            ->putJson(route('dashboard.apps.update', $app), [
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

    /** @test */
    function app_name_it_is_required()
    {
        $cristian = factory(User::class)->create();

        $app = factory(App::class)->create(['user_id' => $cristian->id]);

        $response = $this->handleValidationExceptions()->actingAs($cristian)
            ->putJson(route('dashboard.apps.update', $app), []);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => "The given data was invalid.",
            'errors' => [
                'name' => ["El campo name es obligatorio."]
            ]
        ]);
    }

    /** @test */
    function app_name_must_have_a_minimun_of_6_characters()
    {
        $cristian = factory(User::class)->create();

        $app = factory(App::class)->create(['user_id' => $cristian->id]);

        $response = $this->handleValidationExceptions()->actingAs($cristian)
            ->putJson(route('dashboard.apps.update', $app), [
                'name' => 'app'
            ]);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => "The given data was invalid.",
            'errors' => [
                'name' => ["El campo name debe contener al menos 6 caracteres."]
            ]
        ]);
    }

    /** @test */
    function app_name_must_have_a_maximun_of_80_characters()
    {
        $cristian = factory(User::class)->create();

        $app = factory(App::class)->create(['user_id' => $cristian->id]);

        $response = $this->handleValidationExceptions()->actingAs($cristian)
            ->putJson(route('dashboard.apps.update', $app), [
                'name' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean porta lacus amet.'
            ]);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => "The given data was invalid.",
            'errors' => [
                'name' => ["El campo name no debe contener más de 80 caracteres."]
            ]
        ]);
    }
}
