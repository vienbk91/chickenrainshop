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
    	
    	$books = $this->Books->latest(); // Sử dụng latest là 1 thuộc tính được định nghĩa trong BooksTable Object
    	$this->set(compact('books')); // Có chức năng tương tự với $this->set('books' , $books)
    	
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

    	if ($this->request->is('post')) {
    		$commentInstance = TableRegistry::get('Comments');
    		$comment = $commentInstance->newEntity($this->request->data);
    		if ($commentInstance->save($comment)) {
    			$this->Flash->success(__('Thêm bình luận thành công.'));
    		} else {
    			$this->Flash->error(__('Thêm bình luận thất bại.'));
    		}
    	}
    	
    	// Lấy thông tin của sách theo $slug nhận từ url
    	$book = $this->Books->find('all')
							->where(['Books.slug' => $slug])
    						->contain([
    								'Categories', 
    								'Writers', 
    								// Lấy thêm dữ liệu từ bảng Users - là bảng có quan hệ với bảng Comments
    								'Comments' => function(\Cake\ORM\Query $q) {
    									return $q->contain(['Users'])->select();
    								}
    						])
    						->first();
    	
        if (empty($book)) {
            throw new NotFoundException(__('Không tìm thấy cuốn sách này'));
        }
        
        // Đưa thông tin sách đã được xử lý ra view
        $this->set('book', $book);
        
        // Lấy thông tin sách liên quan
        $bookInstance = TableRegistry::get('Books');
        $related_book = $bookInstance->find('all')
        					->select(['title' , 'image' , 'slug' , 'sale_price'])
        					->where([
        							'Books.category_id' => $book->category_id ,
        							'Books.id <>' => $book->id ,
        							'Books.published' => 1
        					])
        					->order(['created' => 'desc'])
        					->contain([
        							'Writers' => function(\Cake\ORM\Query $q) {
        								return $q->select(['name' , 'slug']);
        							}
        					]);
        
         
        // Hiển thị toàn bộ sách trong cùng categories
        // $this->set('related_book' , $related_book);
        
        // Phân trang sách trong cùng catogories
        $this->paginate = [
        		'fields' => ['id' , 'title' , 'slug' , 'sale_price' , 'image'] ,
        		'order' =>  ['created' => 'desc'] , // Từ mới nhất đến cũ dần
        		'limit'=>2
        ];
        $this->set('related_book' , $this->paginate($related_book));
        
        
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
    
    public function addComment() {
    	
    	
    	
    	$input = $this->request->data();
    	pr($input);
    	exit();
    }
    
}
