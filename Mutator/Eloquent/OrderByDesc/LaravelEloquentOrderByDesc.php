<?php

namespace Mutator\Eloquent\OrderByDesc;

use Infection\Mutator\Definition;
use Infection\Mutator\Mutator;
use Infection\Mutator\MutatorCategory;
use PhpParser\Node;

class LaravelEloquentOrderByDesc implements Mutator
{
    public static function getDefinition(): Definition
    {
        return new Definition(
            <<<'TXT'
                replace laravel collection orderByDesc to orderBy
                TXT
            ,
            MutatorCategory::ORTHOGONAL_REPLACEMENT,
            null,
            <<<'DIFF'
                - ->orderByDesc
                + ->orderBy
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
        return $node->name->name === 'orderByDesc';
    }

    /**
     * @psalm-mutation-free
     *
     * @return iterable<Node\Expr\MethodCall>
     */
    public function mutate(Node $node): iterable
    {
        yield new Node\Expr\MethodCall($node->var, 'orderBy', $node->args, $node->getAttributes());
    }

    public function getName(): string
    {
        return self::class;
    }
}
