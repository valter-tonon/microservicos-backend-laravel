<?php

namespace Tests\Feature\Models;

use App\Models\Category;
use App\Models\Genero;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GeneroTest extends TestCase
{
    use DatabaseMigrations;

    public function testList()
    {
        Genero::create([
            "name" => "teste2"
        ]);
        $genre = Genero::all();
        $this->assertCount(1, $genre);
        $categoryKeys = array_keys($genre->first()->getAttributes());
        $this->assertEquals([
            'id', 'name','is_active', 'deleted_at', 'created_at', 'updated_at'
        ],$categoryKeys);
    }

    public function testCreate()
    {
        $genre = Genero::create([
            "name" => "test1",
            "is_active" => 1
        ]);

        $this->assertEquals('test1', $genre->name);
        $this->assertNull($genre->description);
        $this->assertTrue((bool)$genre->is_active);

    }

    public function testUpdate()
    {
        $genre = factory(Genero::class)->create([
            'name' => 'test_description'
        ])->first();
        $data = [
            "name" => 'test_name_updated',
            "is_active" => false
        ];

        $genre->update($data);

        foreach ($data as $key => $value) {
            $this->assertEquals($value, $genre->{$key});
        }

    }

}
