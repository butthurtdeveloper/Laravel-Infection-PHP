<?php

namespace Mutator\Eloquent\OrderBy;

use Infection\Testing\BaseMutatorTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;

#[CoversClass(LaravelEloquentOrderBy::class)]
final class LaravelEloquentOrderByTest extends BaseMutatorTestCase
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
                $a->orderBy('some_fields');
                PHP
            ,
            <<<'PHP'
                <?php

                $a->orderByDesc('some_fields');
                PHP
            ,
        ];

        yield 'It mutates a string asc direction' => [
            <<<'PHP'
                <?php
                $a->orderBy('some_fields', 'asc');
                PHP
            ,
            <<<'PHP'
                <?php

                $a->orderBy('some_fields', 'desc');
                PHP
            ,
        ];

        yield 'It mutates a string desc direction' => [
            <<<'PHP'
                <?php
                $a->orderBy('some_fields', 'desc');
                PHP
            ,
            <<<'PHP'
                <?php

                $a->orderBy('some_fields', 'asc');
                PHP
            ,
        ];
    }

    protected function getTestedMutatorClassName(): string
    {
        return LaravelEloquentOrderBy::class;
    }
}
