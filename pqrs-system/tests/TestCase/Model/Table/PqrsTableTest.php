<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PqrsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PqrsTable Test Case
 */
class PqrsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PqrsTable
     */
    protected $Pqrs;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Pqrs',
        'app.Categories',
        'app.Users',
        'app.AssignedAgents',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Pqrs') ? [] : ['className' => PqrsTable::class];
        $this->Pqrs = $this->getTableLocator()->get('Pqrs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Pqrs);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\PqrsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\PqrsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
