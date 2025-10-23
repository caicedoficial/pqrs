<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Pqr Entity
 *
 * @property int $id
 * @property string $ticket_number
 * @property string $type
 * @property string $subject
 * @property string $description
 * @property string $requester_name
 * @property string $requester_email
 * @property string|null $requester_phone
 * @property string|null $requester_id_number
 * @property int $category_id
 * @property int|null $user_id
 * @property int|null $assigned_agent_id
 * @property string $status
 * @property string $priority
 * @property \Cake\I18n\DateTime|null $due_date
 * @property \Cake\I18n\DateTime|null $resolved_at
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Category $category
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\User $assigned_agent
 */
class Pqr extends Entity
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
        'ticket_number' => true,
        'type' => true,
        'subject' => true,
        'description' => true,
        'requester_name' => true,
        'requester_email' => true,
        'requester_phone' => true,
        'requester_id_number' => true,
        'category_id' => true,
        'user_id' => true,
        'assigned_agent_id' => true,
        'status' => true,
        'priority' => true,
        'due_date' => true,
        'resolved_at' => true,
        'created' => true,
        'modified' => true,
        'category' => true,
        'user' => true,
        'assigned_agent' => true,
    ];

    /**
     * Get status badge class for UI
     *
     * @return string
     */
    public function getStatusBadgeClass(): string
    {
        $classes = [
            'pending' => 'badge-warning',
            'in_progress' => 'badge-info',
            'resolved' => 'badge-success',
            'closed' => 'badge-secondary'
        ];
        
        return $classes[$this->status] ?? 'badge-secondary';
    }

    /**
     * Get priority badge class for UI
     *
     * @return string
     */
    public function getPriorityBadgeClass(): string
    {
        $classes = [
            'low' => 'badge-light',
            'medium' => 'badge-primary',
            'high' => 'badge-warning',
            'urgent' => 'badge-danger'
        ];
        
        return $classes[$this->priority] ?? 'badge-secondary';
    }

    /**
     * Check if PQRS is overdue
     *
     * @return bool
     */
    public function isOverdue(): bool
    {
        if (!$this->due_date || $this->status === 'resolved' || $this->status === 'closed') {
            return false;
        }
        
        return $this->due_date->isPast();
    }

    /**
     * Get type display name
     *
     * @return string
     */
    public function getTypeDisplayName(): string
    {
        $types = [
            'petition' => 'Petición',
            'complaint' => 'Queja',
            'claim' => 'Reclamo',
            'suggestion' => 'Sugerencia'
        ];
        
        return $types[$this->type] ?? ucfirst($this->type);
    }
}
