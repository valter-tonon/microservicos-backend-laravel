<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    protected $category;
    protected function setUp(): void
    {
        parent::setUp();
        $this->category = new Category();
    }

    public function testFillable()
    {
        $this->assertIsArray($this->category->getFillable());
        $this->assertEquals(['name', 'description', 'is_active'], $this->category->getFillable());
    }

    public function testIfUseTraits()
    {
        $categoriesTraits = array_keys(class_uses(Category::class));
        $traits = [
            SoftDeletes::class, Uuid::class
        ];
        $this->assertEquals($traits, $categoriesTraits);
    }

    public function testCasts()
    {
        $casts = ['id' => 'string'];
        $this->assertEquals($casts, $this->category->getCasts());
    }

    public function testDatesAttributes()
    {
        $dates = ['deleted_at', 'created_at', 'updated_at'];
        $this->assertEquals($dates, $this->category->getDates());
        $this->assertCount(sizeof($dates), $this->category->getDates());

    }
}
