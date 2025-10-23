<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreatePqrsResponses extends BaseMigration
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
        $table = $this->table('pqrs_responses');
        $table->addColumn('pqrs_id', 'integer', ['null' => false])
              ->addColumn('user_id', 'integer', ['null' => false, 'comment' => 'Agent who created this response'])
              ->addColumn('response_text', 'text', ['null' => false])
              ->addColumn('is_internal', 'boolean', ['default' => false, 'null' => false, 'comment' => 'Internal notes vs public response'])
              ->addColumn('created', 'datetime', ['null' => false])
              ->addColumn('modified', 'datetime', ['null' => false])
              ->addIndex(['pqrs_id'])
              ->addIndex(['user_id'])
              ->addForeignKey('pqrs_id', 'pqrs', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
              ->addForeignKey('user_id', 'users', 'id', ['delete' => 'RESTRICT', 'update' => 'CASCADE'])
              ->create();
    }
}
