<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Genero;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Traits\TestSaves;
use Tests\Traits\TestValidtions;

class GeneroControllerTest extends TestCase
{
    use DatabaseMigrations, TestValidtions, TestSaves;

    protected $genero;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->genero = factory(Genero::class)->create([
            'name' => "Genero Teste"
        ]);

    }

    public function testIndex()
    {

        $response = $this->get(route('generos.index'));
        $response
            ->assertStatus(200)
            ->assertJson([$this->genero->toArray()]);
    }

    public function testShow()
    {
        $response = $this->get(route('generos.show', ['genero' => $this->genero->id]));

        $response
            ->assertStatus(200)
            ->assertJson($this->genero->toArray());
    }

    public function testInvalidationData()
    {
        $data = [
            'name' => ''
        ];
        $this->assertInvalidationInStoreAction($data, 'required');
        $this->assertInvalidationInUpdateAction($data, 'required');

        $data = [
            'name' => str_repeat('a', 256)
        ];
        $this->assertInvalidationInStoreAction($data, 'max.string', ['max'=> 255]);
        $this->assertInvalidationInUpdateAction($data, 'max.string', ['max'=> 255]);
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
        $response = $this->delete(route('generos.destroy',
            ['genero' => $this->genero->id]));
        $response
            ->assertStatus(204);
        $this->assertNull(Genero::find($this->genero->id));
    }

    protected function routeStore()
    {
        return route('generos.store');
    }
    protected function routeUpdate()
    {
        return route( 'generos.update', ['genero' => $this->genero->id]);
    }

    protected function model()
    {
        return Genero::class;
    }
}