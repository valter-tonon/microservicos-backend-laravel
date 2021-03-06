<?php

namespace Tests\Feature\Models;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;

    public function testList()
    {
        Category::create([
            "name" => "teste2"
        ]);
        $categories = Category::all();
        $this->assertCount(1, $categories);
        $categoryKeys = array_keys($categories->first()->getAttributes());
        $this->assertEquals([
            'id', 'name', 'description', 'is_active', 'deleted_at', 'created_at', 'updated_at'
        ],$categoryKeys);
    }

    public function testCreate()
    {
        $category = Category::create([
            "name" => "test1",
            "is_active" => 1
        ]);

        $this->assertEquals('test1', $category->name);
        $this->assertNull($category->description);
        $this->assertTrue((bool)$category->is_active);

    }

    public function testUpdate()
    {
        $category = factory(Category::class)->create([
            'description' => 'test_description'
        ])->first();
        $data = [
            "name" => 'test_name_updated',
            "description" => "test_description_updated",
            "is_active" => false
        ];

        $category->update($data);

        foreach ($data as $key => $value) {
            $this->assertEquals($value, $category->{$key});
        }

    }

}
