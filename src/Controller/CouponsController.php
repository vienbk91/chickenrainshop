<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Coupons Controller
 *
 * @property \App\Model\Table\CouponsTable $Coupons
 */
class CouponsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $coupons = $this->paginate($this->Coupons);

        $this->set(compact('coupons'));
        $this->set('_serialize', ['coupons']);
    }

    /**
     * View method
     *
     * @param string|null $id Coupon id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $coupon = $this->Coupons->get($id, [
            'contain' => []
        ]);

        $this->set('coupon', $coupon);
        $this->set('_serialize', ['coupon']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $coupon = $this->Coupons->newEntity();
        if ($this->request->is('post')) {
            $coupon = $this->Coupons->patchEntity($coupon, $this->request->data);
            if ($this->Coupons->save($coupon)) {
                $this->Flash->success(__('The coupon has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The coupon could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('coupon'));
        $this->set('_serialize', ['coupon']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Coupon id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $coupon = $this->Coupons->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $coupon = $this->Coupons->patchEntity($coupon, $this->request->data);
            if ($this->Coupons->save($coupon)) {
                $this->Flash->success(__('The coupon has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The coupon could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('coupon'));
        $this->set('_serialize', ['coupon']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Coupon id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $coupon = $this->Coupons->get($id);
        if ($this->Coupons->delete($coupon)) {
            $this->Flash->success(__('The coupon has been deleted.'));
        } else {
            $this->Flash->error(__('The coupon could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
