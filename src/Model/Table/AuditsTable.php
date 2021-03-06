<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Audits Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $ChangedUsers
 * @method \App\Model\Entity\Audit get($primaryKey, $options = [])
 * @method \App\Model\Entity\Audit newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Audit[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Audit|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Audit saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Audit patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Audit[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Audit findOrCreate($search, callable $callback = null, $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Muffin\Footprint\Model\Behavior\FootprintBehavior
 * @method \App\Model\Entity\Audit[]|\Cake\Datasource\ResultSetInterface|false saveMany($entities, $options = [])
 * @property \App\Model\Table\RolesTable&\Cake\ORM\Association\BelongsTo $ChangedRoles
 * @property \App\Model\Table\ScoutGroupsTable&\Cake\ORM\Association\BelongsTo $ChangedScoutGroups
 * @property \App\Model\Table\UserContactsTable&\Cake\ORM\Association\BelongsTo $ChangedUserContacts
 */
class AuditsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('audits');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'change_date' => 'new',
                ],
            ],
        ]);

        $this->addBehavior('Muffin/Footprint.Footprint', [
            'events' => [
                'Model.afterSave' => [
                    'user_id' => 'always',
                ],
                'Model.beforeSave' => [
                    'user_id' => 'always',
                ],
            ],
            'propertiesMap' => [
                'user_id' => '_footprint.id',
            ],
        ]);

        $this->belongsTo('ChangedUsers', [
            'className' => 'Users',
            'foreignKey' => 'audit_record_id',
            'strategy' => 'join',
            'conditions' => [
                'audit_table' => 'Users',
            ],
            'finder' => 'withTrashed',
        ]);

        $this->belongsTo('ChangedRoles', [
            'className' => 'Roles',
            'foreignKey' => 'audit_record_id',
            'strategy' => 'join',
            'conditions' => [
                'audit_table' => 'Roles',
            ],
            'finder' => 'withTrashed',
        ]);

        $this->belongsTo('ChangedUserContacts', [
            'className' => 'UserContacts',
            'foreignKey' => 'audit_record_id',
            'strategy' => 'join',
            'conditions' => [
                'audit_table' => 'UserContacts',
            ],
            'finder' => 'withTrashed',
        ]);

        $this->belongsTo('ChangedScoutGroups', [
            'className' => 'ScoutGroups',
            'foreignKey' => 'audit_record_id',
            'strategy' => 'join',
            'conditions' => [
                'audit_table' => 'ScoutGroups',
            ],
            'finder' => 'withTrashed',
        ]);

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
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
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('audit_field')
            ->maxLength('audit_field', 255)
            ->requirePresence('audit_field', 'create')
            ->notEmptyString('audit_field');

        $validator
            ->scalar('audit_table')
            ->maxLength('audit_table', 255)
            ->requirePresence('audit_table', 'create')
            ->notEmptyString('audit_table');

        $validator
            ->integer('audit_record_id')
            ->requirePresence('audit_record_id', 'create')
            ->notEmptyString('audit_record_id');

        $validator
            ->scalar('original_value')
            ->maxLength('original_value', 255)
            ->allowEmptyString('original_value');

        $validator
            ->scalar('modified_value')
            ->maxLength('modified_value', 255)
            ->requirePresence('modified_value', 'create')
            ->notEmptyString('modified_value');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }

    /**
     * @param \Cake\ORM\Query $query The Query to be modified.
     * @return \Cake\ORM\Query
     */
    public function findUsers($query)
    {
        $query->where(['audit_table' => 'Users']);

        return $query;
    }

    /**
     * @param \Cake\ORM\Query $query The Query to be modified.
     * @return \Cake\ORM\Query
     */
    public function findRoles($query)
    {
        $query->where(['audit_table' => 'Roles']);

        return $query;
    }

    /**
     * @param \Cake\ORM\Query $query The Query to be modified.
     * @return \Cake\ORM\Query
     */
    public function findScoutGroups($query)
    {
        $query->where(['audit_table' => 'ScoutGroups']);

        return $query;
    }

    /**
     * @param \Cake\ORM\Query $query The Query to be modified.
     * @return \Cake\ORM\Query
     */
    public function findContacts($query)
    {
        $query->where(['audit_table' => 'UserContacts']);

        return $query;
    }
}
