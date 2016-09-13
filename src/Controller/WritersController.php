<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Writers Controller
 *
 * @property \App\Model\Table\WritersTable $Writers
 */
class WritersController extends AppController {

    /**
     * Index method
     * Hiển thị danh sách tác giả được phân trang
     * @return \Cake\Network\Response|null
     */
    public $paginate = array();
    public function index() {
        /* Khởi tạo biến $prigate  */
    	$this->paginate = array(
    			'fields' => ['id' , 'name'] ,
    			'order' => ['name' => 'asc'] ,
    			'limit' => 5
    	);
    	
    	$writers = $this->paginate();
    	$this->set(compact('writers'));
    	
    }

    /**
     * View method
     *
     * @param string|null $id Writer id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($slug = null) {

    	$writer = $this->Writers->find('all')
							->where(['Writers.slug' => $slug])
							->contain(['Books'])
							->autoFields(false)
							->first();

        $this->set('writer', $writer);
        $this->set('_serialize', ['writer']);

        $this->paginate = array(
            'books' => array(
                'fields' => ['id' , 'title' , 'slug' , 'sale_price' , 'image'] ,
                'order' => ['created' => 'desc'] ,
                'limit' => 5 , 
                'contain' => array(
                    'Writers' => function(\Cake\ORM\Query $q) {
                            return $q->select(['name' , 'slug']);
                    } 
                ) ,
                
               'joins' => array(
                    array('type' => 'LEFT', 'alias' => 'BooksWriters', 'table' => 'books_writers' , 'conditions' => 'BooksWriters.book_id = Books.id') ,
                    array('type' => 'LEFT', 'alias' => 'Writers', 'table' => 'writers' , 'conditions' => 'Writers.id = BooksWriters.writer_id')
                ) ,
                'conditions' => array(
                    'Books.published' => 1 , 
                    'Writers.slug' => $slug
                )
            )
        );
        
        // Nếu để trống thì nó mặc định lấy controller của model hiện tại
        // Nên cần khai báo model muốn sử dụng
        $books = $this->paginate('Books');
        $this->set(compact('books'));
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $writer = $this->Writers->newEntity();
        if ($this->request->is('post')) {
            $writer = $this->Writers->patchEntity($writer, $this->request->data);
            if ($this->Writers->save($writer)) {
                $this->Flash->success(__('The writer has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The writer could not be saved. Please, try again.'));
            }
        }
        $books = $this->Writers->Books->find('list', ['limit' => 200]);
        $this->set(compact('writer', 'books'));
        $this->set('_serialize', ['writer']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Writer id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $writer = $this->Writers->get($id, [
            'contain' => ['Books']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $writer = $this->Writers->patchEntity($writer, $this->request->data);
            if ($this->Writers->save($writer)) {
                $this->Flash->success(__('The writer has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The writer could not be saved. Please, try again.'));
            }
        }
        $books = $this->Writers->Books->find('list', ['limit' => 200]);
        $this->set(compact('writer', 'books'));
        $this->set('_serialize', ['writer']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Writer id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $writer = $this->Writers->get($id);
        if ($this->Writers->delete($writer)) {
            $this->Flash->success(__('The writer has been deleted.'));
        } else {
            $this->Flash->error(__('The writer could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
