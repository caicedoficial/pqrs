<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PqrsResponse Entity
 *
 * @property int $id
 * @property int $pqrs_id
 * @property int $user_id
 * @property string $response_text
 * @property bool $is_internal
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Pqr $pqr
 * @property \App\Model\Entity\User $user
 */
class PqrsResponse extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'pqrs_id' => true,
        'user_id' => true,
        'response_text' => true,
        'is_internal' => true,
        'created' => true,
        'modified' => true,
        'pqr' => true,
        'user' => true,
    ];
}
