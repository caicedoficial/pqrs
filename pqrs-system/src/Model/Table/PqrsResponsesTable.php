<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PqrsResponses Model
 *
 * @property \App\Model\Table\PqrsTable&\Cake\ORM\Association\BelongsTo $Pqrs
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\PqrsResponse newEmptyEntity()
 * @method \App\Model\Entity\PqrsResponse newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\PqrsResponse> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PqrsResponse get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\PqrsResponse findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\PqrsResponse patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\PqrsResponse> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\PqrsResponse|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\PqrsResponse saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\PqrsResponse>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PqrsResponse>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\PqrsResponse>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PqrsResponse> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\PqrsResponse>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PqrsResponse>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\PqrsResponse>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PqrsResponse> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PqrsResponsesTable extends Table
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

        $this->setTable('pqrs_responses');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Pqrs', [
            'foreignKey' => 'pqrs_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
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
            ->integer('pqrs_id')
            ->notEmptyString('pqrs_id');

        $validator
            ->integer('user_id')
            ->notEmptyString('user_id');

        $validator
            ->scalar('response_text')
            ->requirePresence('response_text', 'create')
            ->notEmptyString('response_text');

        $validator
            ->boolean('is_internal')
            ->notEmptyString('is_internal');

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
        $rules->add($rules->existsIn(['pqrs_id'], 'Pqrs'), ['errorField' => 'pqrs_id']);
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }
}
