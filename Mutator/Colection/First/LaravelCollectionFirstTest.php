<?php

namespace Mutator\Colection\First;

use Infection\Testing\BaseMutatorTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;

#[CoversClass(LaravelCollectionFirst::class)]
final class LaravelCollectionFirstTest extends BaseMutatorTestCase
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
                $a->first();
                PHP
            ,
            <<<'PHP'
                <?php

                $a->last();
                PHP
            ,
        ];
    }

    protected function getTestedMutatorClassName(): string
    {
        return LaravelCollectionFirst::class;
    }
}
