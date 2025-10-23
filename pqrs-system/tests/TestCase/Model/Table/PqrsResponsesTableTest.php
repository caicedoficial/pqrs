<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PqrsResponsesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PqrsResponsesTable Test Case
 */
class PqrsResponsesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PqrsResponsesTable
     */
    protected $PqrsResponses;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.PqrsResponses',
        'app.Pqrs',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('PqrsResponses') ? [] : ['className' => PqrsResponsesTable::class];
        $this->PqrsResponses = $this->getTableLocator()->get('PqrsResponses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->PqrsResponses);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\PqrsResponsesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\PqrsResponsesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
