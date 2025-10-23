<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateUsers extends BaseMigration
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
        $table = $this->table('users');
        $table->addColumn('email', 'string', ['limit' => 255, 'null' => false])
              ->addColumn('password', 'string', ['limit' => 255, 'null' => false])
              ->addColumn('first_name', 'string', ['limit' => 100, 'null' => false])
              ->addColumn('last_name', 'string', ['limit' => 100, 'null' => false])
              ->addColumn('phone', 'string', ['limit' => 20, 'null' => true])
              ->addColumn('role', 'enum', ['values' => ['requester', 'agent', 'admin'], 'default' => 'requester', 'null' => false])
              ->addColumn('is_active', 'boolean', ['default' => true, 'null' => false])
              ->addColumn('created', 'datetime', ['null' => false])
              ->addColumn('modified', 'datetime', ['null' => false])
              ->addIndex(['email'], ['unique' => true])
              ->create();
    }
}
