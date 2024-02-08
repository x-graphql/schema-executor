<?php

declare(strict_types=1);

namespace XGraphQL\SchemaExecutor\Test;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Schema;

trait DummySchemaTrait
{
    private function createDummySchema(): Schema
    {
        return new Schema([
            'query' => new ObjectType([
                'name' => 'Query',
                'fields' => [
                    'dummy' => [
                        'type' => Type::string(),
                        'resolve' => fn() => 'dummy query'
                    ]
                ]
            ]),
            'mutation' => new ObjectType([
                'name' => 'Mutation',
                'fields' => [
                    'dummy' => [
                        'type' => Type::string(),
                        'resolve' => fn() => 'dummy mutation'
                    ]
                ]
            ])
        ]);
    }
}
