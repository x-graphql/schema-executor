<?php

declare(strict_types=1);

namespace XGraphQL\SchemaExecutor;

use GraphQL\Executor\Promise\Promise;
use GraphQL\Type\Schema;

interface AsyncSchemaExecutorInterface
{
    public function executeAsync(Schema $schema, string $query, ?array $variables = null, ?string $operationName = null): Promise;
}
