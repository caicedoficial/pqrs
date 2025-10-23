<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pqr $pqr
 * @var array $agents
 */
$this->assign('title', 'Asignar PQRS');
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-user-plus"></i> Asignar PQRS</h4>
            </div>
            <div class="card-body">
                <!-- PQRS Info -->
                <div class="alert alert-info">
                    <h6><strong>PQRS:</strong> <?= h($pqr->ticket_number) ?> - <?= h($pqr->subject) ?></h6>
                    <p class="mb-0">
                        <strong>Tipo:</strong> <?= $pqr->getTypeDisplayName() ?> | 
                        <strong>Prioridad:</strong> 
                        <span class="badge <?= $pqr->getPriorityBadgeClass() ?>">
                            <?= ucfirst(h($pqr->priority)) ?>
                        </span> | 
                        <strong>Estado:</strong> 
                        <span class="badge <?= $pqr->getStatusBadgeClass() ?>">
                            <?= ucfirst(h($pqr->status)) ?>
                        </span>
                    </p>
                </div>
                
                <?= $this->Form->create($pqr) ?>
                
                <div class="form-floating mb-3">
                    <?= $this->Form->select('assigned_agent_id', $agents, [
                        'class' => 'form-select',
                        'required' => true,
                        'empty' => 'Seleccione un agente'
                    ]) ?>
                    <?= $this->Form->label('assigned_agent_id', 'Agente') ?>
                </div>
                
                <div class="form-floating mb-3">
                    <?= $this->Form->select('status', [
                        'pending' => 'Pendiente',
                        'in_progress' => 'En Proceso',
                        'resolved' => 'Resuelto',
                        'closed' => 'Cerrado'
                    ], [
                        'class' => 'form-select'
                    ]) ?>
                    <?= $this->Form->label('status', 'Estado') ?>
                </div>
                
                <div class="form-floating mb-3">
                    <?= $this->Form->select('priority', [
                        'low' => 'Baja',
                        'medium' => 'Media',
                        'high' => 'Alta',
                        'urgent' => 'Urgente'
                    ], [
                        'class' => 'form-select'
                    ]) ?>
                    <?= $this->Form->label('priority', 'Prioridad') ?>
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <?= $this->Html->link('Cancelar', ['action' => 'view', $pqr->id], [
                        'class' => 'btn btn-secondary'
                    ]) ?>
                    <?= $this->Form->button('Asignar', [
                        'class' => 'btn btn-primary'
                    ]) ?>
                </div>
                
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>