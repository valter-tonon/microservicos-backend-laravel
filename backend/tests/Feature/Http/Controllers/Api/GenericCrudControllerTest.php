<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Http\Controllers\Api\GenericCrudController;
use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Tests\Stubs\Controller\CategoryControllerStub;
use Tests\Stubs\Model\CategoryStub;
use Tests\TestCase;
use Tests\Traits\TestSaves;
use Tests\Traits\TestValidtions;

class GenericCrudControllerTest extends TestCase
{
    private $controller;
    protected function setUp(): void
    {
        parent::setUp();
        CategoryStub::dropTable();
        CategoryStub::createTable();
        $this->controller = new CategoryControllerStub();
    }

    protected function tearDown(): void
    {
        CategoryStub::dropTable();
        parent::tearDown();
    }

    public function testIndex()
    {
        $category = CategoryStub::create(['name' => 'test_name', 'description' => 'test_description']);
        $result = $this->controller->index()->toArray();
        $this->assertEquals([$category->toArray()], $result);
    }

    public function testInvalidationDataInStore()
    {
        $request = \Mockery::mock(Request::class);
        $request
            ->shouldReceive('all')
            ->once()
            ->andReturn(['name' => '']);
        $this->expectException(ValidationException::class);
        $this->controller->store($request);
    }

    public function testStore ()
    {
        $request = \Mockery::mock(Request::class);
        $request
            ->shouldReceive('all')
            ->once()
            ->andReturn(['name' => 'test_name', 'description' => 'test_description']);
        $obj = $this->controller->store($request);
        $this->assertEquals(
            CategoryStub::find(1)->toArray(),
            $obj->toArray()
        );
    }

    public function testIfFindOrFailFetchModel()
    {
        $category = CategoryStub::create(['name' => 'test_name', 'description' => 'test_description']);
        $reflectionclass = new \ReflectionClass(GenericCrudController::class);
        $reflectionMethod = $reflectionclass->getMethod('findOrFail');
        $reflectionMethod->setAccessible(true);

        $result = $reflectionMethod->invokeArgs($this->controller, [$category->id]);
        $this->assertInstanceOf(CategoryStub::class, $result);
    }


    public function testIfFindOrFailThrowExceptionWhenIdInvalid()
    {
        $reflectionclass = new \ReflectionClass(GenericCrudController::class);
        $reflectionMethod = $reflectionclass->getMethod('findOrFail');
        $reflectionMethod->setAccessible(true);

        $this->expectException(ModelNotFoundException::class);
        $reflectionMethod->invokeArgs($this->controller, [0]);
    }

//    public function testShow()
//    {
//        $category = CategoryStub::create(['name' => 'test_name', 'description' => 'test_description']);
//        $result = $this->controller->show($category->id);
//        $this->assertEquals($result->toArray(), CategoryStub::find(1)->toArray());
//    }
//
//    public function testUpdate()
//    {
//        $category = CategoryStub::create(['name' => 'test_name', 'description' => 'test_description']);
//        $request = \Mockery::mock(Request::class);
//        $request->shouldReceive('all')
//            ->once()
//            ->andReturn(['name' => 'test_changed', 'description' => 'test_description_changed']);
//        $result = $this->controller->update($request, $category->id);
//        $this->assertEquals($result->toArray(), CategoryStub::find(1)->toArray());
//    }
//
//    public function testDestroy()
//    {
//        $category = CategoryStub::create(['name' => 'test_name', 'description' => 'test_description']);
//        $response = $this->controller->destroy($category->id);
//        $this->createTestResponse($response)->assertStatus(204);
//        $this->assertCount(0, CategoryStub::all());
//    }
}
