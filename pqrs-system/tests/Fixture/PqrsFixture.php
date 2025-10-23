<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PqrsFixture
 */
class PqrsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'ticket_number' => 'Lorem ipsum dolor ',
                'type' => 'Lorem ipsum dolor sit amet',
                'subject' => 'Lorem ipsum dolor sit amet',
                'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'requester_name' => 'Lorem ipsum dolor sit amet',
                'requester_email' => 'Lorem ipsum dolor sit amet',
                'requester_phone' => 'Lorem ipsum dolor ',
                'requester_id_number' => 'Lorem ipsum dolor sit amet',
                'category_id' => 1,
                'user_id' => 1,
                'assigned_agent_id' => 1,
                'status' => 'Lorem ipsum dolor sit amet',
                'priority' => 'Lorem ipsum dolor sit amet',
                'due_date' => '2025-10-23 21:37:26',
                'resolved_at' => '2025-10-23 21:37:26',
                'created' => '2025-10-23 21:37:26',
                'modified' => '2025-10-23 21:37:26',
            ],
        ];
        parent::init();
    }
}
