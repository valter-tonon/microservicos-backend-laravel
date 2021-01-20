<?php


namespace Tests\Unit;


use App\Rules\GeneroHasCategoriesRule;
use Mockery\MockInterface;
use Tests\TestCase;

class GenresHasCategoriesRuleUnitTest extends TestCase
{
    public function testCategoriesField()
    {
        $rule = new GeneroHasCategoriesRule([
            1,2,1,2
        ]);
        $reflectionClass = new \ReflectionClass(GeneroHasCategoriesRule::class);
        $reflectionProperty = $reflectionClass->getProperty('categoriesId');
        $reflectionProperty->setAccessible(true);

        $categoriesId = $reflectionProperty->getValue($rule);
        $this->assertEqualsCanonicalizing([1,2], $categoriesId);
    }

    public function testGenresIdValue()
    {
        $rule = new GeneroHasCategoriesRule([]);
        $rule->passes('', [1,2,1,2]);

        $reflectionClass = new \ReflectionClass(GeneroHasCategoriesRule::class);
        $reflectionProperty = $reflectionClass->getProperty('genresId');
        $reflectionProperty->setAccessible(true);

        $genresId = $reflectionProperty->getValue($rule);
        $this->assertEqualsCanonicalizing([1,2], $genresId);
    }

    public function testPassesReturnFalseWhenCategoriesGenresIsArrayEmpty()
    {
        $rule = $this->createRuleMock([1]);
        $this->assertFalse($rule->passes('', []));

        $rule = $this->createRuleMock([]);
        $this->assertFalse($rule->passes('', [1]));
    }

    public function testPassesReturnsFalseWhenGetRowwIsEmpty ()
    {
        $rule = $this->createRuleMock([]);
        $rule
            ->shouldReceive('getRows')
            ->withAnyArgs()
            ->andReturn(collect());
        $this->assertFalse($rule->passes('', [1]));
    }

    public function testPassesReturnsFalseWhenHasCategoriesWithoutGenres()
    {
        $rule = $this->createRuleMock([1, 2]);
        $rule
            ->shouldReceive('getRows')
            ->withAnyArgs()
            ->andReturn(collect(['category_id' => 1]));
        $this->assertFalse($rule->passes('', [1]));
    }

    public function testPassesIsValid()
    {
        $rule = $this->createRuleMock([1, 2]);
        $rule
            ->shouldReceive('getRows')
            ->withAnyArgs()
            ->andReturn(collect([
               ['category_id' => 1],
               ['category_id' => 2]
            ]));
        $this->assertTrue($rule->passes('', [1]));
    }

    protected function createRuleMock(array $categoriesId): MockInterface
    {
        return \Mockery::mock(GeneroHasCategoriesRule::class, [$categoriesId])
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();
    }
}
