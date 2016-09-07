<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Writers Controller
 *
 * @property \App\Model\Table\WritersTable $Writers
 */
class WritersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $writers = $this->paginate($this->Writers);

        $this->set(compact('writers'));
        $this->set('_serialize', ['writers']);
    }

    /**
     * View method
     *
     * @param string|null $id Writer id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $writer = $this->Writers->get($id, [
            'contain' => ['Books']
        ]);

        $this->set('writer', $writer);
        $this->set('_serialize', ['writer']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
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
