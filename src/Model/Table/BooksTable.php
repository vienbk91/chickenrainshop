<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Books Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Categories
 * @property \Cake\ORM\Association\HasMany $Comments
 * @property \Cake\ORM\Association\BelongsToMany $Writers
 *
 * @method \App\Model\Entity\Book get($primaryKey, $options = [])
 * @method \App\Model\Entity\Book newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Book[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Book|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Book patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Book[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Book findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BooksTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('books');
        $this->displayField('title');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Categories', [
            'foreignKey' => 'category_id'
        ]);
        $this->hasMany('Comments', [
            'foreignKey' => 'book_id'
        ]);
        $this->belongsToMany('Writers', [
            'foreignKey' => 'book_id',
            'targetForeignKey' => 'writer_id',
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
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->requirePresence('slug', 'create')
            ->notEmpty('slug');

        $validator
            ->allowEmpty('image');

        $validator
            ->requirePresence('info', 'create')
            ->notEmpty('info');

        $validator
            ->integer('price')
            ->requirePresence('price', 'create')
            ->notEmpty('price');

        $validator
            ->integer('sale_price')
            ->requirePresence('sale_price', 'create')
            ->notEmpty('sale_price');

        $validator
            ->integer('pages')
            ->requirePresence('pages', 'create')
            ->notEmpty('pages');

        $validator
            ->requirePresence('publisher', 'create')
            ->notEmpty('publisher');

        $validator
            ->date('publish_date')
            ->requirePresence('publish_date', 'create')
            ->notEmpty('publish_date');

        $validator
            ->requirePresence('link_download', 'create')
            ->notEmpty('link_download');

        $validator
            ->boolean('published')
            ->allowEmpty('published');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['category_id'], 'Categories'));

        return $rules;
    }
    
    /**
     * latest method
     * Lấy ra 5 trường mới nhất trong bảng books
     * @return \Cake\Datasource\ResultSetInterface
     */
    public function latest() {
    	return $this->find()
    			->select(['id' ,'title' , 'image' , 'sale_price' , 'slug'])
    			->where(['published' => 1])
    			->order(['created' => 'desc'])
    			->limit(5)
    			->contain([
    					'Writers' => function($q) {
    						return $q->select(['name']);
    					}
    			])
    			->all();
    }
}
