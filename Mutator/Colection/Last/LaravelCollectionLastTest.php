<?php

namespace Mutator\Colection\Last;

use Infection\Testing\BaseMutatorTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;

#[CoversClass(LaravelCollectionLast::class)]
final class LaravelCollectionLastTest extends BaseMutatorTestCase
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

                $a->last();
                PHP
            ,
            <<<'PHP'
                <?php

                $a->first();
                PHP
            ,
        ];
    }

    protected function getTestedMutatorClassName(): string
    {
        return LaravelCollectionLast::class;
    }
}
