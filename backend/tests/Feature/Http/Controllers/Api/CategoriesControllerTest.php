<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoriesControllerTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $category = factory(Category::class)->create();
        $response = $this->get(route('categories.index'));

        $response->assertStatus(200)
                 ->assertJson([$category->toArray()]);

    }

    public function testShow()
    {
        $category = factory(Category::class)->create();
        $response = $this->get(route('categories.show', [$category->id]));

        $response
            ->assertStatus(200)
            ->assertJson($category->toArray());

    }

    public function testInvalidationData()
    {
        $response = $this->json('POST', route('categories.store', []));
        $this->assertInvalidationRequired($response);

        $response = $this->json('POST', route('categories.store', [
            'name' => str_repeat('a', 256),
            'is_active' => 'a'
        ]));
        $this->assertInvalidationMax($response);
        $category = factory(Category::class)->create();
        $response = $this->json('PUT', route('categories.update', ['category' => $category->id]),
        [
            'name' => str_repeat('a', 256),
            'is_active' => 'a'
        ]);
        $this->assertInvalidationMax($response);
        $response = $this->json('PUT', route('categories.update', ['category' => $category->id] ,[]));
        $this->assertInvalidationRequired($response);
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
        $response = $this->json('POST' ,route('categories.store', [
            'name' => 'test',
            'description' => 'description'
        ]));

        $id = $response->json('id');
        $category = Category::find($id);
        $this->assertEquals(36, strlen($id));
        $response
            ->assertStatus(201)
            ->assertJson($category->toArray());
    }

    public function testUpdate()
    {
        $category = factory(Category::class)->create([
            'name' => 'test',
            'description' => 'description',
            'is_active' => false
        ]);

        $response = $this->json('PUT', route('categories.update',
            ['category' => $category->id]), [
            'name' => 'test',
            'description' => 'teste',
            'is_active' => true
        ]);

        $id = $response->json('id');
        $category = Category::find($id);
        $response
            ->assertStatus(200)
            ->assertJson($category->toArray())
            ->assertJsonFragment([
                'description' => 'teste',
                'is_active' => true
            ]);
    }

    public function testDelete()
    {
        $category = factory(Category::class)->create([
            'name' => 'test',
            'description' => 'description',
            'is_active' => false
        ]);

        $response = $this->delete(route('categories.destroy',
            ['category' => $category->id]));
        $response
            ->assertStatus(204);
        $this->assertNull(Category::find($category->id));

    }

}
