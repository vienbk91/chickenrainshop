<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Network\Exception\NotFoundException;

use App\Model\Table\CommentsTable;

/**
 * Books Controller
 *
 * @property \App\Model\Table\BooksTable $Books
 */
class BooksController extends AppController {
	
    /**
     * Index method
     * Hiển thị 5 quyển sách mới nhất trên trang chủ
     * @return \Cake\Network\Response|null
     */
    public function index() {
    	
    	$books = $this->Books->latest();
    	$this->set(compact('books'));
    	
	}
	
	/**
	 * latestBooks method
	 * Hiển thị tất cả các quyển sách và sắp xếp theo thứ tự từ mới đến cũ
	 * Phân trang dữ liệu
	 */
	
	public $paginate = array(
			'order' => array('created' => 'desc') ,
			'limit' => 5
	);
	
	public function latestBooks() {
		$this->paginate = array(
				'fields' => ['id' , 'title' , 'slug' , 'sale_price' , 'image'] ,
				'order' => ['created' => 'desc'] ,
				'limit' => 5 , 
				'contain' => ['Writers' => function($q) {
    						return $q->select(['name' , 'slug']);
    					} ] ,
    			'conditions' => ['published' => 1]
		);
		
		$books = $this->paginate();
		$this->set(compact('books'));
	}

    /**
     * View method
     * Hiển thị nội dung của từng quyển sách kèm theo comment và thông tin tác giả
     * @param string|null $slug Book slug.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($slug = null) {
    	
//     	$options = array(
//     			'conditions' => [
//     					'Books.slug' => $slug
//     			] ,
//     			'contain' => [
//     					'Comments' => [] , 'Categories' => [] ,
//     					'Writers' => function(\Cake\ORM\Query $q) {
//     						return $q->select(['name' , 'slug']);
//     					}
//     			]
//     	);
//     	$book = $this->Books->find('all' , $options)->first();
    	
    	// Lấy thông tin của sách theo $slug nhận từ url
    	$book = $this->Books->find('all')
							->where(['Books.slug' => $slug])
    						->contain([
    								'Categories', 
    								'Writers', 
    								// Lấy thêm dữ liệu từ bảng Users
    								'Comments' => function(\Cake\ORM\Query $q) {
    									return $q->contain(['Users'])->select();
    								}
    						])
    						->first();
    	
        if (empty($book)) {
            throw new NotFoundException(__('Không tìm thấy cuốn sách này'));
        }
        
        // Lấy thông tin sách liên quan
        $bookInstance = TableRegistry::get('Books');
        $related_book = $bookInstance->find('all')
        					->select(['title' , 'image' , 'slug' , 'sale_price'])
        					->where([
        							'category_id' => $book->category_id ,
        							'Books.id <>' => $book->id ,
        							'published' => 1
        					])
        					->order(['created' => 'desc'])
        					->contain([
        							'Writers'
        					]);
        
        $this->set('related_book' , $related_book);
        
        $this->set('book', $book);
    }

    /**
     * Add method
     * Thêm sách
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $book = $this->Books->newEntity();
        if ($this->request->is('post')) {
            $book = $this->Books->patchEntity($book, $this->request->data);
            if ($this->Books->save($book)) {
                $this->Flash->success(__('The book has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The book could not be saved. Please, try again.'));
            }
        }
        $categories = $this->Books->Categories->find('list', ['limit' => 200]);
        $writers = $this->Books->Writers->find('list', ['limit' => 200]);
        $this->set(compact('book', 'categories', 'writers'));
        $this->set('_serialize', ['book']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Book id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $book = $this->Books->get($id, [
            'contain' => ['Writers']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $book = $this->Books->patchEntity($book, $this->request->data);
            if ($this->Books->save($book)) {
                $this->Flash->success(__('The book has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The book could not be saved. Please, try again.'));
            }
        }
        $categories = $this->Books->Categories->find('list', ['limit' => 200]);
        $writers = $this->Books->Writers->find('list', ['limit' => 200]);
        $this->set(compact('book', 'categories', 'writers'));
        $this->set('_serialize', ['book']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Book id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $book = $this->Books->get($id);
        if ($this->Books->delete($book)) {
            $this->Flash->success(__('The book has been deleted.'));
        } else {
            $this->Flash->error(__('The book could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    
    
}
