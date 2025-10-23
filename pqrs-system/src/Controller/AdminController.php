<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Admin Controller
 * 
 * Administrative functions for PQRS system
 */
class AdminController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        
        // Check if user is admin or agent
        $user = $this->Authentication->getIdentity();
        if (!$user || !in_array($user->role, ['admin', 'agent'])) {
            $this->Flash->error(__('No tiene permisos para acceder a esta área.'));
            return $this->redirect(['controller' => 'Pqrs', 'action' => 'index']);
        }
    }

    /**
     * Dashboard method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function dashboard()
    {
        $this->loadModel('Pqrs');
        $this->loadModel('Users');
        
        $user = $this->Authentication->getIdentity();
        
        // Get statistics
        $stats = [
            'total_pqrs' => $this->Pqrs->find()->count(),
            'pending_pqrs' => $this->Pqrs->find()->where(['status' => 'pending'])->count(),
            'in_progress_pqrs' => $this->Pqrs->find()->where(['status' => 'in_progress'])->count(),
            'resolved_pqrs' => $this->Pqrs->find()->where(['status' => 'resolved'])->count(),
            'overdue_pqrs' => $this->Pqrs->find()
                ->where([
                    'due_date <' => new \DateTime(),
                    'status NOT IN' => ['resolved', 'closed']
                ])->count(),
        ];
        
        // Get recent PQRS
        $recentPqrs = $this->Pqrs->find()
            ->contain(['Categories', 'Users', 'AssignedAgents'])
            ->order(['created' => 'DESC'])
            ->limit(10);
            
        // Filter for agents
        if ($user->role === 'agent') {
            $recentPqrs->where([
                'OR' => [
                    'assigned_agent_id' => $user->id,
                    'assigned_agent_id IS' => null
                ]
            ]);
        }
        
        $recentPqrs = $recentPqrs->all();
        
        $this->set(compact('stats', 'recentPqrs', 'user'));
    }

    /**
     * PQRS management for admins/agents
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function pqrs()
    {
        $this->loadModel('Pqrs');
        
        $user = $this->Authentication->getIdentity();
        
        $query = $this->Pqrs->find()
            ->contain(['Categories', 'Users', 'AssignedAgents']);
        
        // Filter for agents
        if ($user->role === 'agent') {
            $query->where([
                'OR' => [
                    'assigned_agent_id' => $user->id,
                    'assigned_agent_id IS' => null
                ]
            ]);
        }
        
        // Apply filters
        if ($this->request->getQuery('status')) {
            $query->where(['status' => $this->request->getQuery('status')]);
        }
        
        if ($this->request->getQuery('priority')) {
            $query->where(['priority' => $this->request->getQuery('priority')]);
        }
        
        if ($this->request->getQuery('type')) {
            $query->where(['type' => $this->request->getQuery('type')]);
        }
        
        $pqrs = $this->paginate($query);
        
        $this->set(compact('pqrs', 'user'));
    }

    /**
     * Users management (admin only)
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function users()
    {
        $user = $this->Authentication->getIdentity();
        
        // Only admins can manage users
        if ($user->role !== 'admin') {
            $this->Flash->error(__('No tiene permisos para gestionar usuarios.'));
            return $this->redirect(['action' => 'dashboard']);
        }
        
        $this->loadModel('Users');
        
        $query = $this->Users->find();
        
        // Apply filters
        if ($this->request->getQuery('role')) {
            $query->where(['role' => $this->request->getQuery('role')]);
        }
        
        if ($this->request->getQuery('is_active')) {
            $query->where(['is_active' => $this->request->getQuery('is_active')]);
        }
        
        $users = $this->paginate($query);
        
        $this->set(compact('users'));
    }

    /**
     * Categories management (admin only)
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function categories()
    {
        $user = $this->Authentication->getIdentity();
        
        // Only admins can manage categories
        if ($user->role !== 'admin') {
            $this->Flash->error(__('No tiene permisos para gestionar categorías.'));
            return $this->redirect(['action' => 'dashboard']);
        }
        
        $this->loadModel('Categories');
        
        $categories = $this->paginate($this->Categories);
        
        $this->set(compact('categories'));
    }
}