<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Network\Exception\NotFoundException;

/**
 * Categories Controller
 *
 * @property \App\Model\Table\CategoriesTable $Categories
 */
class CategoriesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {
        $categories = $this->paginate($this->Categories);

        $this->set(compact('categories'));
        $this->set('_serialize', ['categories']);
    }

    /**
     * View method
     *
     * @param string|null $id Category id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($slug = null) {
    	
        $options = array(
                'conditions' => array('Categories.slug' => $slug) ,
                'contain' => array('Books')
            );

        $category = $this->Categories->find('all' , $options)->first();

        if (empty($category)) {
            throw new NotFoundException(__('Danh mục này không tồn tại!'));
        }

        $this->set('category', $category);
        $this->set('_serialize', ['category']);


        // Phân trang dữ liệu book trong view categories
        // Do đều sử dụng dữ liệu để phân trang cho nên ta có thể sử dụng hàm phân trang của book trong books controller
        // Ta sẽ copy phần code phân trang của bookscontroller ra và sửa đổi.
        $this->paginate = array(
                'fields' => ['id' , 'title' , 'slug' , 'sale_price' , 'image'] ,
                'order' => ['created' => 'desc'] ,
                'limit' => 2 , 
                'contain' => [ 
                            'Categories'  => function($q) {
                                    return $q->select(['slug']);
                            } ,
                            'Writers' => function($q) {
                                    return $q->select(['name' , 'slug']);
                            } 
                        ] ,
                'conditions' => [
                    'published' => 1 ,
                    'Categories.slug' => $slug
                    ]
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
        $category = $this->Categories->newEntity();
        if ($this->request->is('post')) {
            $category = $this->Categories->patchEntity($category, $this->request->data);
            if ($this->Categories->save($category)) {
                $this->Flash->success(__('The category has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The category could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('category'));
        $this->set('_serialize', ['category']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Category id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $category = $this->Categories->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $category = $this->Categories->patchEntity($category, $this->request->data);
            if ($this->Categories->save($category)) {
                $this->Flash->success(__('The category has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The category could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('category'));
        $this->set('_serialize', ['category']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Category id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $category = $this->Categories->get($id);
        if ($this->Categories->delete($category)) {
            $this->Flash->success(__('The category has been deleted.'));
        } else {
            $this->Flash->error(__('The category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
