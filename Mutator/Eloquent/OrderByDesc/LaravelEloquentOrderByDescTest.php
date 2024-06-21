<?php

namespace Mutator\Eloquent\OrderByDesc;

use Infection\Testing\BaseMutatorTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;

#[CoversClass(LaravelEloquentOrderByDesc::class)]
final class LaravelEloquentOrderByDescTest extends BaseMutatorTestCase
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
                $a->orderByDesc('some_fields');
                PHP
            ,
            <<<'PHP'
                <?php

                $a->orderBy('some_fields');
                PHP
            ,
        ];
    }

    protected function getTestedMutatorClassName(): string
    {
        return LaravelEloquentOrderByDesc::class;
    }
}
