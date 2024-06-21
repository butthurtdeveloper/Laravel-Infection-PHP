<?php

namespace Mutator\Eloquent\OrderBy;

use Infection\Mutator\Definition;
use Infection\Mutator\Mutator;
use Infection\Mutator\MutatorCategory;
use PhpParser\Node;
use PhpParser\Node\Scalar\String_;

class LaravelEloquentOrderBy implements Mutator
{
    public static function getDefinition(): Definition
    {
        return new Definition(
            <<<'TXT'
                change orderBy direction
                TXT
            ,
            MutatorCategory::ORTHOGONAL_REPLACEMENT,
            null,
            <<<'DIFF'
                - ->orderBy
                + ->orderByDesc
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
        return $node->name->name === 'orderBy';
    }

    /**
     * @psalm-mutation-free
     *
     * @return iterable<Node\Expr\MethodCall>
     */
    public function mutate(Node $node): iterable
    {
        if (count($node->args) === 1) {
            yield new Node\Expr\MethodCall($node->var, 'orderByDesc', $node->args, $node->getAttributes());
        } else {
            /** @var String_  $oldDirection */
            $oldDirection = $node->args[1]->value;
            $direction = strtolower($oldDirection->value) === 'asc' ? 'desc' : 'asc';
            $node->args[1] = new String_($direction);
            yield new Node\Expr\MethodCall($node->var, 'orderBy', $node->args, $node->getAttributes());
        }
    }

    public function getName(): string
    {
        return self::class;
    }
}
