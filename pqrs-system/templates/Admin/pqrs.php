<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Pqr> $pqrs
 * @var \App\Model\Entity\User $user
 */
$this->assign('title', 'Gestión de PQRS');
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-list-alt"></i> Gestión de PQRS</h2>
    <?= $this->Html->link('Dashboard', ['action' => 'dashboard'], [
        'class' => 'btn btn-outline-primary'
    ]) ?>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <?= $this->Form->create(null, ['type' => 'get', 'class' => 'row g-3']) ?>
        
        <div class="col-md-3">
            <?= $this->Form->select('status', [
                'pending' => 'Pendiente',
                'in_progress' => 'En Proceso',
                'resolved' => 'Resuelto',
                'closed' => 'Cerrado'
            ], [
                'class' => 'form-select',
                'empty' => 'Todos los estados',
                'value' => $this->request->getQuery('status')
            ]) ?>
        </div>
        
        <div class="col-md-3">
            <?= $this->Form->select('priority', [
                'low' => 'Baja',
                'medium' => 'Media',
                'high' => 'Alta',
                'urgent' => 'Urgente'
            ], [
                'class' => 'form-select',
                'empty' => 'Todas las prioridades',
                'value' => $this->request->getQuery('priority')
            ]) ?>
        </div>
        
        <div class="col-md-3">
            <?= $this->Form->select('type', [
                'petition' => 'Petición',
                'complaint' => 'Queja',
                'claim' => 'Reclamo',
                'suggestion' => 'Sugerencia'
            ], [
                'class' => 'form-select',
                'empty' => 'Todos los tipos',
                'value' => $this->request->getQuery('type')
            ]) ?>
        </div>
        
        <div class="col-md-3">
            <div class="d-grid">
                <?= $this->Form->button('Filtrar', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
        
        <?= $this->Form->end() ?>
    </div>
</div>

<!-- PQRS Table -->
<div class="card">
    <div class="card-body">
        <?php if ($pqrs->count() > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Ticket</th>
                            <th>Tipo</th>
                            <th>Asunto</th>
                            <th>Solicitante</th>
                            <th>Estado</th>
                            <th>Prioridad</th>
                            <th>Agente</th>
                            <th>Creado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pqrs as $pqr): ?>
                            <tr class="<?= $pqr->isOverdue() ? 'table-danger' : '' ?>">
                                <td>
                                    <code><?= h($pqr->ticket_number) ?></code>
                                    <?php if ($pqr->isOverdue()): ?>
                                        <i class="fas fa-exclamation-triangle text-danger ms-1" title="Vencido"></i>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <small><?= $pqr->getTypeDisplayName() ?></small>
                                </td>
                                <td>
                                    <?= $this->Text->truncate(h($pqr->subject), 30) ?>
                                    <br><small class="text-muted"><?= h($pqr->category->name) ?></small>
                                </td>
                                <td>
                                    <?= h($pqr->requester_name) ?>
                                    <br><small class="text-muted"><?= h($pqr->requester_email) ?></small>
                                </td>
                                <td>
                                    <span class="badge <?= $pqr->getStatusBadgeClass() ?>">
                                        <?= ucfirst(h($pqr->status)) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge <?= $pqr->getPriorityBadgeClass() ?>">
                                        <?= ucfirst(h($pqr->priority)) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($pqr->assigned_agent): ?>
                                        <small><?= h($pqr->assigned_agent->first_name . ' ' . $pqr->assigned_agent->last_name) ?></small>
                                    <?php else: ?>
                                        <span class="text-muted">Sin asignar</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <small><?= $pqr->created->format('d/m/Y') ?></small>
                                    <?php if ($pqr->due_date): ?>
                                        <br><small class="text-muted">Vence: <?= $pqr->due_date->format('d/m/Y') ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <?= $this->Html->link('<i class="fas fa-eye"></i>', 
                                            ['controller' => 'Pqrs', 'action' => 'view', $pqr->id], 
                                            ['class' => 'btn btn-sm btn-outline-primary', 'escape' => false, 'title' => 'Ver']) ?>
                                        
                                        <?php if (!$pqr->assigned_agent_id || $user->role === 'admin'): ?>
                                            <?= $this->Html->link('<i class="fas fa-user-plus"></i>', 
                                                ['controller' => 'Pqrs', 'action' => 'assign', $pqr->id], 
                                                ['class' => 'btn btn-sm btn-outline-success', 'escape' => false, 'title' => 'Asignar']) ?>
                                        <?php endif; ?>
                                        
                                        <?= $this->Html->link('<i class="fas fa-edit"></i>', 
                                            ['controller' => 'Pqrs', 'action' => 'edit', $pqr->id], 
                                            ['class' => 'btn btn-sm btn-outline-warning', 'escape' => false, 'title' => 'Editar']) ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center mt-3">
                <?= $this->Paginator->numbers([
                    'class' => 'pagination',
                    'prev' => 'Anterior',
                    'next' => 'Siguiente'
                ]) ?>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <h4>No hay PQRS que mostrar</h4>
                <p class="text-muted">No se encontraron PQRS con los filtros aplicados</p>
            </div>
        <?php endif; ?>
    </div>
</div>