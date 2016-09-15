<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use App\Model\Table\BooksTable;


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
        /* Khởi tạo gía trị mới cho biến toàn cục $prigate */
    	$this->paginate = array(
    			'fields' => ['id' , 'name' , 'slug'] ,
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

    	// Lấy toàn bộ thông tin của tác giả có slug tương ứng với param được truyền vào từ view
    	$writer = $this->Writers->find('all')
							->where(['Writers.slug' => $slug])
							->contain(['Books'])
							->autoFields(false)
							->first();

        $this->set('writer', $writer);

		
        // Lấy ra tất cả các cuốn sách có slug tác giả là $slug
        /**
         * Link tham khảo: http://stackoverflow.com/questions/29737422/conditions-to-paginate-for-belongstomany-cakephp-3
         */
        $booksInstance = TableRegistry::get('books');
        $books = $booksInstance->find()
        					->matching('Writers', function(\Cake\ORM\Query $q) use ( $slug ) {
        							return $q->where([
        									'Writers.slug' => $slug
        							]);
        						}
        					);
        
		// Thêm điều kiện phân trang
        $this->paginate = [
        		'fields' => ['id' , 'title' , 'slug' , 'sale_price' , 'image'] ,
        		'order' =>  ['created' => 'desc'] , // Từ mới nhất đến cũ dần
        		'limit'=>2
        ];
		$this->set('books' , $this->paginate($books));
		
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
    public function edit($id = null) {
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
