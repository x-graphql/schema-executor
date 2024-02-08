<?php

declare(strict_types=1);

namespace XGraphQL\SchemaExecutor\Test;

use GraphQL\Executor\ExecutionResult;
use GraphQL\Executor\Promise\Adapter\SyncPromiseAdapter;
use GraphQL\Executor\Promise\Promise;
use PHPUnit\Framework\TestCase;
use XGraphQL\SchemaExecutor\DefaultSchemaExecutor;

final class DefaultSchemaExecutorTest extends TestCase
{
    use DummySchemaTrait;

    public function testConstructor(): void
    {
        $this->assertInstanceOf(DefaultSchemaExecutor::class, new DefaultSchemaExecutor());
    }

    public function testSyncExecution(): void
    {
        $executor = new DefaultSchemaExecutor();

        $result = $executor->execute($this->createDummySchema(), 'query { dummy }');

        $this->assertInstanceOf(ExecutionResult::class, $result);
        $this->assertEmpty($result->errors);
        $this->assertSame($result->toArray(), ['data' => ['dummy' => 'dummy query']]);
    }

    public function testAsyncExecution(): void
    {
        $adapter = new SyncPromiseAdapter();
        $executor = new DefaultSchemaExecutor();

        $promise = $executor->executeAsync($this->createDummySchema(), 'query { dummy }');

        $this->assertInstanceOf(Promise::class, $promise);

        $result = $adapter->wait($promise);

        $this->assertInstanceOf(ExecutionResult::class, $result);
        $this->assertEmpty($result->errors);
        $this->assertSame($result->toArray(), ['data' => ['dummy' => 'dummy query']]);
    }

    public function testExecutionWithVariables(): void
    {
        $executor = new DefaultSchemaExecutor();

        $result = $executor->execute(
            $this->createDummySchema(),
            'query test($include: Boolean!) { dummy @include(if: $include) }',
            ['include' => false]
        );

        $this->assertInstanceOf(ExecutionResult::class, $result);
        $this->assertEmpty($result->errors);
        $this->assertEquals(['data' => []], $result->toArray());
    }

    public function testExecutionWithSpecificOperationName(): void
    {
        $executor = new DefaultSchemaExecutor();

        $result = $executor->execute(
            $this->createDummySchema(),
            <<<'GQL'
query test2 { dummy }
query test($include: Boolean!) { dummy @include(if: $include) }
GQL,
            ['include' => false],
            'test'
        );

        $this->assertInstanceOf(ExecutionResult::class, $result);
        $this->assertEmpty($result->errors);
        $this->assertEquals(['data' => []], $result->toArray());
    }
}
