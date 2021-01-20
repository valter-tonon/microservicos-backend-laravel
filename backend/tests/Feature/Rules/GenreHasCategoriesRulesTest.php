<?php

namespace Tests\Feature\Rules;


use App\Models\Category;
use App\Models\Genero;
use App\Rules\GeneroHasCategoriesRule;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class GenreHasCategoriesRulesTest extends \Tests\TestCase
{
    use DatabaseMigrations;

    private $categories;
    private $genres;

    protected function setUp(): void
    {
        parent::setUp();
        $this->categories = factory(Category::class, 4)->create();
        $this->genres = factory(Genero::class, 2)->create();

        $this->genres[0]->categories()->sync([
            $this->categories[0]->id,
            $this->categories[1]->id
        ]);
        $this->genres[1]->categories()->sync([
            $this->categories[2]->id
        ]);
    }

    public function testPassesIsValid()
    {
        $rule = new GeneroHasCategoriesRule([
            $this->categories[2]->id
        ]);
        $isValid = $rule->passes('',[
            $this->genres[1]->id
        ]);
        $this->assertTrue($isValid);

        $rule = new GeneroHasCategoriesRule([
           $this->categories[0]->id,
           $this->categories[2]->id
        ]);
        $isValid = $rule->passes('', [
            $this->genres[0]->id,
            $this->genres[1]->id
        ]);
        $this->assertTrue($isValid);
        $rule = new GeneroHasCategoriesRule([
            $this->categories[0]->id,
            $this->categories[2]->id,
            $this->categories[1]->id
        ]);
        $isValid = $rule->passes('', [
            $this->genres[0]->id,
            $this->genres[1]->id,
        ]);
        $this->assertTrue($isValid);

    }

    public function testPassesIsNotValid()
    {
        $rule = new GeneroHasCategoriesRule([
            $this->categories[0]->id
        ]);
        $isValid = $rule->passes('', [
            $this->genres[0]->id,
            $this->genres[1]->id
        ]);
        $this->assertFalse($isValid);
    }

}
