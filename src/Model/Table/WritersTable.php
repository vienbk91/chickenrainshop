<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Writers Model
 *
 * @property \Cake\ORM\Association\BelongsToMany $Books
 *
 * @method \App\Model\Entity\Writer get($primaryKey, $options = [])
 * @method \App\Model\Entity\Writer newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Writer[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Writer|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Writer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Writer[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Writer findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class WritersTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('writers');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsToMany('Books', [
            'foreignKey' => 'writer_id',
            'targetForeignKey' => 'book_id',
            'joinTable' => 'books_writers' ,
        	'through' => 'BooksWriters'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator) {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->requirePresence('slug', 'create')
            ->notEmpty('slug');

        $validator
            ->allowEmpty('biography');

        return $validator;
    }

    /**
     * Lấy ra tất cả các tác giả
     */
    public function getWriters() {
        return $this->find()
                ->select(['id' , 'name' , 'slug'])
                ->order(['name' => 'asc'])
                ->all();
    }
}
