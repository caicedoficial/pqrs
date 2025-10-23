<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Pqrs Controller
 *
 * @property \App\Model\Table\PqrsTable $Pqrs
 */
class PqrsController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        
        // Allow anonymous PQRS creation
        $this->Authentication->addUnauthenticatedActions(['add', 'track']);
    }

    /**
     * Index method - Shows PQRS based on user role
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $user = $this->Authentication->getIdentity();
        
        $query = $this->Pqrs->find()
            ->contain(['Categories', 'Users', 'AssignedAgents']);
        
        // Filter based on user role
        if ($user && $user->role === 'requester') {
            // Requesters only see their own PQRS
            $query->where(['Pqrs.user_id' => $user->id]);
        } elseif ($user && $user->role === 'agent') {
            // Agents see PQRS assigned to them or unassigned
            $query->where([
                'OR' => [
                    'Pqrs.assigned_agent_id' => $user->id,
                    'Pqrs.assigned_agent_id IS' => null
                ]
            ]);
        }
        // Admins see all PQRS (no filter)
        
        $pqrs = $this->paginate($query);
        $this->set(compact('pqrs', 'user'));
    }

    /**
     * View method
     *
     * @param string|null $id Pqr id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $pqr = $this->Pqrs->get($id, contain: ['Categories', 'Users', 'AssignedAgents', 'PqrsResponses']);
        $this->set(compact('pqr'));
    }

    /**
     * Add method - Create new PQRS
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $pqr = $this->Pqrs->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            
            // Set user_id if logged in
            $user = $this->Authentication->getIdentity();
            if ($user) {
                $data['user_id'] = $user->id;
                // Auto-fill requester info from user profile
                $data['requester_name'] = $user->first_name . ' ' . $user->last_name;
                $data['requester_email'] = $user->email;
                $data['requester_phone'] = $user->phone;
            }
            
            $pqr = $this->Pqrs->patchEntity($pqr, $data);
            if ($this->Pqrs->save($pqr)) {
                $this->Flash->success(__('Su PQRS ha sido enviado exitosamente. Número de ticket: ' . $pqr->ticket_number));
                
                if ($user) {
                    return $this->redirect(['action' => 'index']);
                } else {
                    return $this->redirect(['action' => 'track', '?' => ['ticket' => $pqr->ticket_number]]);
                }
            }
            $this->Flash->error(__('No se pudo enviar el PQRS. Por favor, inténtelo de nuevo.'));
        }
        
        $categories = $this->Pqrs->Categories->find('list', [
            'conditions' => ['is_active' => true]
        ])->all();
        
        $this->set(compact('pqr', 'categories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Pqr id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $pqr = $this->Pqrs->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pqr = $this->Pqrs->patchEntity($pqr, $this->request->getData());
            if ($this->Pqrs->save($pqr)) {
                $this->Flash->success(__('The pqr has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The pqr could not be saved. Please, try again.'));
        }
        $categories = $this->Pqrs->Categories->find('list', limit: 200)->all();
        $users = $this->Pqrs->Users->find('list', limit: 200)->all();
        $assignedAgents = $this->Pqrs->AssignedAgents->find('list', limit: 200)->all();
        $this->set(compact('pqr', 'categories', 'users', 'assignedAgents'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Pqr id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pqr = $this->Pqrs->get($id);
        if ($this->Pqrs->delete($pqr)) {
            $this->Flash->success(__('The pqr has been deleted.'));
        } else {
            $this->Flash->error(__('The pqr could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Track method - Track PQRS by ticket number (public access)
     *
     * @return \Cake\Http\Response|null|void
     */
    public function track()
    {
        $pqr = null;
        $ticketNumber = $this->request->getQuery('ticket');
        
        if ($ticketNumber) {
            try {
                $pqr = $this->Pqrs->find()
                    ->contain(['Categories', 'PqrsResponses' => ['Users']])
                    ->where(['ticket_number' => $ticketNumber])
                    ->first();
                    
                if (!$pqr) {
                    $this->Flash->error(__('Número de ticket no encontrado.'));
                }
            } catch (\Exception $e) {
                $this->Flash->error(__('Error al buscar el ticket.'));
            }
        }
        
        $this->set(compact('pqr', 'ticketNumber'));
    }

    /**
     * Assign method - Assign PQRS to agent (agents and admins only)
     *
     * @param string|null $id Pqr id.
     * @return \Cake\Http\Response|null
     */
    public function assign($id = null)
    {
        $user = $this->Authentication->getIdentity();
        
        // Only agents and admins can assign
        if (!$user || !in_array($user->role, ['agent', 'admin'])) {
            $this->Flash->error(__('No tiene permisos para realizar esta acción.'));
            return $this->redirect(['action' => 'index']);
        }
        
        $pqr = $this->Pqrs->get($id);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            
            // If agent is assigning to themselves
            if ($user->role === 'agent' && empty($data['assigned_agent_id'])) {
                $data['assigned_agent_id'] = $user->id;
            }
            
            // Update status to in_progress when assigned
            if (!empty($data['assigned_agent_id']) && $pqr->status === 'pending') {
                $data['status'] = 'in_progress';
            }
            
            $pqr = $this->Pqrs->patchEntity($pqr, $data);
            if ($this->Pqrs->save($pqr)) {
                $this->Flash->success(__('PQRS asignado exitosamente.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('No se pudo asignar el PQRS.'));
        }
        
        // Get available agents
        $agents = $this->Pqrs->AssignedAgents->find('list', [
            'conditions' => ['role IN' => ['agent', 'admin'], 'is_active' => true]
        ])->all();
        
        $this->set(compact('pqr', 'agents'));
    }
}
