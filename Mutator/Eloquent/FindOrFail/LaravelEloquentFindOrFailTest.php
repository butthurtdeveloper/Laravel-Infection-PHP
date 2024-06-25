<?php

namespace Mutator\Eloquent\FindOrFail;

use Infection\Testing\BaseMutatorTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;

#[CoversClass(LaravelEloquentFindOrFail::class)]
final class LaravelEloquentFindOrFailTest extends BaseMutatorTestCase
{
    /**
     * @param string|array<string> $expected
     */
    #[DataProvider('mutationsProvider')]
    public function test_it_can_mutate(string $input, array|string $expected = []): void
    {
        $this->assertMutatesInput($input, $expected);
    }

    public static function mutationsProvider(): iterable
    {
        yield 'It mutates a simple case' => [
            <<<'PHP'
                <?php

                $a->findOrFail(1);
                PHP
            ,
            <<<'PHP'
                <?php

                $a->find(1);
                PHP
            ,
        ];
    }

    protected function getTestedMutatorClassName(): string
    {
        return LaravelEloquentFindOrFail::class;
    }
}
