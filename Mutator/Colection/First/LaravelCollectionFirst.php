<?php

namespace Mutator\Colection\First;

use Infection\Mutator\Definition;
use Infection\Mutator\Mutator;
use Infection\Mutator\MutatorCategory;
use PhpParser\Node;

class LaravelCollectionFirst implements Mutator
{
    public static function getDefinition(): Definition
    {
        return new Definition(
            <<<'TXT'
                replace laravel collection first to last
                TXT
            ,
            MutatorCategory::ORTHOGONAL_REPLACEMENT,
            null,
            <<<'DIFF'
                - ->first
                + ->last
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
        return $node->name->name === 'first';
    }

    /**
     * @psalm-mutation-free
     *
     * @return iterable<Node\Expr\MethodCall>
     */
    public function mutate(Node $node): iterable
    {
        yield new Node\Expr\MethodCall($node->var, 'last', $node->args, $node->getAttributes());
    }

    public function getName(): string
    {
        return self::class;
    }
}
