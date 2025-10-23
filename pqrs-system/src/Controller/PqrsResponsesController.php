<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * PqrsResponses Controller
 *
 * @property \App\Model\Table\PqrsResponsesTable $PqrsResponses
 */
class PqrsResponsesController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        
        // Only authenticated users can manage responses
        $user = $this->Authentication->getIdentity();
        if (!$user || !in_array($user->role, ['agent', 'admin'])) {
            $this->Flash->error(__('No tiene permisos para gestionar respuestas.'));
            return $this->redirect(['controller' => 'Pqrs', 'action' => 'index']);
        }
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->PqrsResponses->find()
            ->contain(['Pqrs', 'Users']);
        $pqrsResponses = $this->paginate($query);

        $this->set(compact('pqrsResponses'));
    }

    /**
     * View method
     *
     * @param string|null $id Pqrs Response id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $pqrsResponse = $this->PqrsResponses->get($id, contain: ['Pqrs', 'Users']);
        $this->set(compact('pqrsResponse'));
    }

    /**
     * Add method - Add response to PQRS
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $pqrsId = $this->request->getQuery('pqrs_id');
        $user = $this->Authentication->getIdentity();
        
        if (!$pqrsId) {
            $this->Flash->error(__('ID de PQRS requerido.'));
            return $this->redirect(['controller' => 'Pqrs', 'action' => 'index']);
        }
        
        // Verify PQRS exists and user has permission
        $pqrs = $this->PqrsResponses->Pqrs->get($pqrsId);
        
        if ($user->role === 'agent' && $pqrs->assigned_agent_id !== $user->id) {
            $this->Flash->error(__('No tiene permisos para responder este PQRS.'));
            return $this->redirect(['controller' => 'Pqrs', 'action' => 'index']);
        }
        
        $pqrsResponse = $this->PqrsResponses->newEmptyEntity();
        
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['pqrs_id'] = $pqrsId;
            $data['user_id'] = $user->id;
            
            $pqrsResponse = $this->PqrsResponses->patchEntity($pqrsResponse, $data);
            
            if ($this->PqrsResponses->save($pqrsResponse)) {
                // Update PQRS status if this is a resolution
                if (!empty($data['resolve_pqrs'])) {
                    $pqrs->status = 'resolved';
                    $pqrs->resolved_at = new \DateTime();
                    $this->PqrsResponses->Pqrs->save($pqrs);
                }
                
                $this->Flash->success(__('La respuesta ha sido guardada exitosamente.'));
                return $this->redirect(['controller' => 'Pqrs', 'action' => 'view', $pqrsId]);
            }
            $this->Flash->error(__('No se pudo guardar la respuesta. Por favor, inténtelo de nuevo.'));
        }
        
        $this->set(compact('pqrsResponse', 'pqrs'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Pqrs Response id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $pqrsResponse = $this->PqrsResponses->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pqrsResponse = $this->PqrsResponses->patchEntity($pqrsResponse, $this->request->getData());
            if ($this->PqrsResponses->save($pqrsResponse)) {
                $this->Flash->success(__('The pqrs response has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The pqrs response could not be saved. Please, try again.'));
        }
        $pqrs = $this->PqrsResponses->Pqrs->find('list', limit: 200)->all();
        $users = $this->PqrsResponses->Users->find('list', limit: 200)->all();
        $this->set(compact('pqrsResponse', 'pqrs', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Pqrs Response id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pqrsResponse = $this->PqrsResponses->get($id);
        if ($this->PqrsResponses->delete($pqrsResponse)) {
            $this->Flash->success(__('The pqrs response has been deleted.'));
        } else {
            $this->Flash->error(__('The pqrs response could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
