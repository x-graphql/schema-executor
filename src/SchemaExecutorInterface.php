<?php

declare(strict_types=1);

namespace XGraphQL\SchemaExecutor;

use GraphQL\Executor\ExecutionResult;
use GraphQL\Type\Schema;

interface SchemaExecutorInterface
{
    public function execute(Schema $schema, string $query, ?array $variables = null, ?string $operationName = null): ExecutionResult;
}
