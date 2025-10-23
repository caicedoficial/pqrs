<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Pqrs Model
 *
 * @property \App\Model\Table\CategoriesTable&\Cake\ORM\Association\BelongsTo $Categories
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $AssignedAgents
 *
 * @method \App\Model\Entity\Pqr newEmptyEntity()
 * @method \App\Model\Entity\Pqr newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Pqr> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Pqr get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Pqr findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Pqr patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Pqr> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Pqr|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Pqr saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Pqr>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Pqr>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Pqr>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Pqr> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Pqr>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Pqr>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Pqr>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Pqr> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PqrsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('pqrs');
        $this->setDisplayField('ticket_number');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Categories', [
            'foreignKey' => 'category_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        $this->belongsTo('AssignedAgents', [
            'foreignKey' => 'assigned_agent_id',
            'className' => 'Users',
        ]);
        $this->hasMany('PqrsResponses', [
            'foreignKey' => 'pqrs_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('ticket_number')
            ->maxLength('ticket_number', 20)
            ->requirePresence('ticket_number', 'create')
            ->notEmptyString('ticket_number')
            ->add('ticket_number', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('type')
            ->requirePresence('type', 'create')
            ->notEmptyString('type');

        $validator
            ->scalar('subject')
            ->maxLength('subject', 255)
            ->requirePresence('subject', 'create')
            ->notEmptyString('subject');

        $validator
            ->scalar('description')
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        $validator
            ->scalar('requester_name')
            ->maxLength('requester_name', 200)
            ->requirePresence('requester_name', 'create')
            ->notEmptyString('requester_name');

        $validator
            ->scalar('requester_email')
            ->maxLength('requester_email', 255)
            ->requirePresence('requester_email', 'create')
            ->notEmptyString('requester_email');

        $validator
            ->scalar('requester_phone')
            ->maxLength('requester_phone', 20)
            ->allowEmptyString('requester_phone');

        $validator
            ->scalar('requester_id_number')
            ->maxLength('requester_id_number', 50)
            ->allowEmptyString('requester_id_number');

        $validator
            ->integer('category_id')
            ->notEmptyString('category_id');

        $validator
            ->integer('user_id')
            ->allowEmptyString('user_id');

        $validator
            ->integer('assigned_agent_id')
            ->allowEmptyString('assigned_agent_id');

        $validator
            ->scalar('status')
            ->notEmptyString('status');

        $validator
            ->scalar('priority')
            ->notEmptyString('priority');

        $validator
            ->dateTime('due_date')
            ->allowEmptyDateTime('due_date');

        $validator
            ->dateTime('resolved_at')
            ->allowEmptyDateTime('resolved_at');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['ticket_number']), ['errorField' => 'ticket_number']);
        $rules->add($rules->existsIn(['category_id'], 'Categories'), ['errorField' => 'category_id']);
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn(['assigned_agent_id'], 'AssignedAgents'), ['errorField' => 'assigned_agent_id']);

        return $rules;
    }

    /**
     * Generate unique ticket number
     *
     * @return string
     */
    public function generateTicketNumber(): string
    {
        $prefix = 'PQRS';
        $year = date('Y');
        
        do {
            $number = $prefix . $year . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $exists = $this->exists(['ticket_number' => $number]);
        } while ($exists);
        
        return $number;
    }

    /**
     * Before save callback to generate ticket number
     */
    public function beforeSave($event, $entity, $options)
    {
        if ($entity->isNew() && empty($entity->ticket_number)) {
            $entity->ticket_number = $this->generateTicketNumber();
        }
        
        // Set due date based on priority if not set
        if ($entity->isNew() && empty($entity->due_date)) {
            $days = [
                'urgent' => 1,
                'high' => 3,
                'medium' => 7,
                'low' => 15
            ];
            
            $daysToAdd = $days[$entity->priority] ?? 7;
            $entity->due_date = new \DateTime("+{$daysToAdd} days");
        }
        
        return true;
    }
}
