<?php

namespace Mutator\Colection\FirstOrFail;

use Infection\Mutator\Definition;
use Infection\Mutator\Mutator;
use Infection\Mutator\MutatorCategory;
use PhpParser\Node;

class LaravelCollectionFirstOrFail implements Mutator
{
    public static function getDefinition(): Definition
    {
        return new Definition(
            <<<'TXT'
                replace laravel collection firstOrFail to first
                TXT
            ,
            MutatorCategory::ORTHOGONAL_REPLACEMENT,
            null,
            <<<'DIFF'
                - ->firstOrFail
                + ->first
                DIFF,
        );
    }

    public function canMutate(Node $node): bool
    {
        if (
            ! $node instanceof Node\Expr\MethodCall &&
            ! $node instanceof Node\Expr\NullsafeMethodCall
        ) {
            return false;
        }
        return $node->name->name === 'firstOrFail';
    }

    /**
     * @psalm-mutation-free
     *
     * @return iterable<Node\Expr\MethodCall>
     */
    public function mutate(Node $node): iterable
    {
        yield new Node\Expr\MethodCall($node->var, 'first', $node->args, $node->getAttributes());
    }

    public function getName(): string
    {
        return self::class;
    }
}
