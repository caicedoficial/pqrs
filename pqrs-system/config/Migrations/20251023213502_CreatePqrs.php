<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreatePqrs extends BaseMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/4/en/migrations.html#the-change-method
     *
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('pqrs');
        $table->addColumn('ticket_number', 'string', ['limit' => 20, 'null' => false])
              ->addColumn('type', 'enum', ['values' => ['petition', 'complaint', 'claim', 'suggestion'], 'null' => false])
              ->addColumn('subject', 'string', ['limit' => 255, 'null' => false])
              ->addColumn('description', 'text', ['null' => false])
              ->addColumn('requester_name', 'string', ['limit' => 200, 'null' => false])
              ->addColumn('requester_email', 'string', ['limit' => 255, 'null' => false])
              ->addColumn('requester_phone', 'string', ['limit' => 20, 'null' => true])
              ->addColumn('requester_id_number', 'string', ['limit' => 50, 'null' => true])
              ->addColumn('category_id', 'integer', ['null' => false])
              ->addColumn('user_id', 'integer', ['null' => true, 'comment' => 'Registered user who created this PQRS'])
              ->addColumn('assigned_agent_id', 'integer', ['null' => true, 'comment' => 'Agent assigned to handle this PQRS'])
              ->addColumn('status', 'enum', ['values' => ['pending', 'in_progress', 'resolved', 'closed'], 'default' => 'pending', 'null' => false])
              ->addColumn('priority', 'enum', ['values' => ['low', 'medium', 'high', 'urgent'], 'default' => 'medium', 'null' => false])
              ->addColumn('due_date', 'datetime', ['null' => true])
              ->addColumn('resolved_at', 'datetime', ['null' => true])
              ->addColumn('created', 'datetime', ['null' => false])
              ->addColumn('modified', 'datetime', ['null' => false])
              ->addIndex(['ticket_number'], ['unique' => true])
              ->addIndex(['category_id'])
              ->addIndex(['user_id'])
              ->addIndex(['assigned_agent_id'])
              ->addIndex(['status'])
              ->addIndex(['type'])
              ->addForeignKey('category_id', 'categories', 'id', ['delete' => 'RESTRICT', 'update' => 'CASCADE'])
              ->addForeignKey('user_id', 'users', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
              ->addForeignKey('assigned_agent_id', 'users', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
              ->create();
    }
}
