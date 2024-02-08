<?php

declare(strict_types=1);

namespace XGraphQL\SchemaExecutor;

use GraphQL\Executor\ExecutionResult;
use GraphQL\Executor\Promise\Adapter\SyncPromiseAdapter;
use GraphQL\Executor\Promise\Promise;
use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use GraphQL\Validator\DocumentValidator;

final class DefaultSchemaExecutor implements AsyncSchemaExecutorInterface, SchemaExecutorInterface
{
    public function execute(Schema $schema, string $query, ?array $variables = null, ?string $operationName = null): ExecutionResult
    {
        return GraphQL::executeQuery(
            $schema,
            $query,
            variableValues: $variables,
            operationName: $operationName,
            validationRules: DocumentValidator::defaultRules(),
        );
    }


    /**
     * @throws \Exception
     */
    public function executeAsync(Schema $schema, string $query, ?array $variables = null, ?string $operationName = null): Promise
    {
        return GraphQL::promiseToExecute(
            new SyncPromiseAdapter(),
            $schema,
            $query,
            variableValues: $variables,
            operationName: $operationName,
            validationRules: DocumentValidator::defaultRules(),
        );
    }
}
