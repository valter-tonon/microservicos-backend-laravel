<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Genero;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GeneroControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testIndex()
    {
        factory(Genero::class)->create([
            'name' => "Genero Teste"
        ]);
        $genres = Genero::all();
        $this->assertCount(1, $genres);
        $this->assertEquals("Genero Teste", $genres[0]->name);

    }

    public function testInvalidationData()
    {
        $response = $this->json('POST', route('generos.store', []));
        $this->assertInvalidationRequired($response);

        $response = $this->json('POST', route('generos.store', [
            'name' => str_repeat('a', 256),
            'is_active' => 'a'
        ]));
        $this->assertInvalidationMax($response);

    }

    protected function assertInvalidationRequired(TestResponse $response)
    {
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name'])
            ->assertJsonFragment(
                [
                    \Lang::get( 'validation.required', ['attribute' => 'name'])
                ]
            );
    }

    protected function assertInvalidationMax(TestResponse $response)
    {
        $response
            ->assertJsonValidationErrors(['name', 'is_active'])
            ->assertJsonFragment([
                \Lang::get( 'validation.max.string', ['attribute' => 'name', 'max' => 255]),
            ])
            ->assertJsonFragment([
                \Lang::get( 'validation.boolean', ['attribute' => 'is active'])
            ]);
    }

    public function testStore()
    {
        $response = $this->json('POST' ,route('generos.store', [
            'name' => 'test',
        ]));

        $id = $response->json('id');
        $genero = Genero::find($id);
        $this->assertEquals(36, strlen($genero->id));
        $response
            ->assertStatus(201);
    }

    public function testUpdate()
    {
        $genero = factory(Genero::class)->create([
            'name' => 'test',
            'is_active' => false
        ]);
        $response = $this->json('PUT', route('generos.update',
            ['genero' => $genero->id]), [
            'name' => 'test',
            'is_active' => true
        ]);

        $id = $response->json('id');
        $genero = Genero::find($id);
        $response
            ->assertStatus(200)
            ->assertJson($genero->toArray())
            ->assertJsonFragment([
                'is_active' => true
            ]);
    }

    public function testDelete()
    {
        $genero = factory(Genero::class)->create([
            'name' => 'test',
            'is_active' => false
        ]);

        $response = $this->delete(route('generos.destroy',
            ['genero' => $genero->id]));
        $response
            ->assertStatus(204);
        $this->assertNull(Genero::find($genero->id));

    }
}
